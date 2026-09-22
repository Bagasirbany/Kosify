<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // User: Riwayat Booking
    public function myBookings()
    {
        $bookings = Reservation::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('my-bookings', compact('bookings'));
    }

    // User: Form Booking
    public function create($roomId)
    {
        $room = \App\Models\Room::findOrFail($roomId);
        return view('bookings.create', compact('room'));
    }

    // User: Submit Booking
    public function store(Request $request)
    {
        $durationMonths = (int) $request->input('duration_months', $request->input('duration', 1));
        $request->merge(['duration_months' => $durationMonths]);

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration_months' => 'required|integer|min:1',
        ]);

        $room = \App\Models\Room::findOrFail($request->room_id);

        // Hitung End Date (Tanggal Berakhir = Start Date + Duration Months)
        $requestedStartDate = \Carbon\Carbon::parse($request->start_date);
        $requestedEndDate = $requestedStartDate->copy()->addMonths($durationMonths);

        // Cek apakah ada reservasi aktif yang bertabrakan tanggalnya
        $overlappingReservation = Reservation::where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'active', 'confirmed', 'paid', 'success'])
            ->get()
            ->filter(function ($reservation) use ($requestedStartDate, $requestedEndDate) {
                $existingStart = \Carbon\Carbon::parse($reservation->start_date);
                $existingEnd = $reservation->end_date ? \Carbon\Carbon::parse($reservation->end_date) : $existingStart->copy()->addMonths($reservation->duration_months ?: 1);

                // Cek Overlap: (StartA < EndB) and (EndA > StartB)
                return ($requestedStartDate < $existingEnd) && ($requestedEndDate > $existingStart);
            })->first();

        if ($overlappingReservation) {
            return back()->with('error', 'Kamar sudah dipesan atau sedang dihuni pada rentang tanggal tersebut. Silakan pilih tanggal atau kamar lain.');
        }

        // Cek jika status kamar sama sekali tidak available (misal under maintenance)
        if (!in_array($room->status, ['available', 'occupied', 'terisi'])) {
            return back()->with('error', 'Kamar saat ini tidak dapat disewa.');
        }

        $reservation = new Reservation();
        $reservation->id = Str::uuid()->toString();
        $reservation->room_id = $room->id;
        $reservation->user_id = Auth::id();
        $reservation->start_date = $requestedStartDate->toDateString();
        $reservation->end_date = $requestedEndDate->toDateString();
        $reservation->duration_months = $durationMonths;
        $reservation->status = 'pending';
        // Total price: harga kamar per bulan x durasi + biaya layanan
        $reservation->total_price = ($room->price_per_month * $durationMonths) + 50000;
        $reservation->save();

        \Illuminate\Support\Facades\Cache::forget('admin_dashboard_full_bundle');
        \Illuminate\Support\Facades\Cache::forget('admin_finance_bundle');

        return redirect()->route('bookings.my')
            ->with('auto_open_manual', $reservation->id)
            ->with('success', 'Reservasi berhasil dibuat! Silakan lakukan transfer ke rekening pengelola dan unggah bukti transfer.');
    }

    // Admin: List Bookings
    public function adminIndex()
    {
        $bookings = Reservation::with(['room', 'payments'])->orderBy('created_at', 'desc')->get();
        return view('bookings', compact('bookings'));
    }

    // Admin: Update Status Booking
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,waiting_verification,confirmed,active,cancelled,completed']);
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => $request->status]);

        // Jika dikonfirmasi atau aktif, tandai kamar terisi dan pembayaran lunas
        if (in_array($request->status, ['confirmed', 'active'])) {
            $room = \App\Models\Room::find($reservation->room_id);
            if ($room) {
                $room->status = 'occupied';
                $room->save();
            }
            \App\Models\Payment::where('reservation_id', $reservation->id)->update([
                'status' => 'paid',
                'verified_at' => now(),
            ]);
        }

        \Illuminate\Support\Facades\Cache::forget('admin_dashboard_full_bundle');
        \Illuminate\Support\Facades\Cache::forget('admin_finance_bundle');

        return back()->with('success', 'Status reservasi & pembayaran berhasil diperbarui.');
    }

    // User: Invoice / Kuitansi Pembayaran Resmi PDF
    public function invoice($id)
    {
        $reservation = Reservation::with(['room'])->findOrFail($id);
        
        // Cek otorisasi: hanya penyewa yang bersangkutan atau admin yang boleh melihat
        if (Auth::user()->role !== 'admin' && $reservation->user_id !== Auth::id()) {
            abort(403, 'Akses kuitansi ini tidak diizinkan.');
        }

        $user = \App\Models\User::find($reservation->user_id) ?? Auth::user();
        $settings = \App\Models\WebSetting::pluck('value', 'key')->toArray();

        return view('bookings.invoice', compact('reservation', 'user', 'settings'));
    }

    // User / Admin: Cetak Surat Perjanjian Sewa / Surat Kontrak PDF
    public function contract($id)
    {
        $reservation = Reservation::with(['room'])->findOrFail($id);
        
        // Cek otorisasi
        if (Auth::user()->role !== 'admin' && $reservation->user_id !== Auth::id()) {
            abort(403, 'Akses surat perjanjian sewa ini tidak diizinkan.');
        }

        $user = \App\Models\User::find($reservation->user_id) ?? Auth::user();
        $settings = \App\Models\WebSetting::pluck('value', 'key')->toArray();

        return view('bookings.contract', compact('reservation', 'user', 'settings'));
    }

    // User: Upload Bukti Transfer Manual
    public function uploadManualPayment(Request $request, $id)
    {
        $request->validate([
            'sender_name' => 'required|string|max:100',
            'bank_name' => 'required|string|max:50',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Simpan data payment
        $payment = \App\Models\Payment::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'id' => (string) Str::uuid(),
                'user_id' => Auth::id(),
                'amount' => $reservation->total_price,
                'payment_method' => 'Transfer Manual (' . $request->bank_name . ' - a.n ' . $request->sender_name . ')',
                'proof_of_payment_url' => $path,
                'status' => 'pending',
            ]
        );

        $reservation->status = 'waiting_verification';
        $reservation->save();

        return back()->with('success', 'Bukti transfer manual berhasil diunggah! Pengelola akan segera memverifikasi pembayaran Anda.');
    }

    // User: Ajukan Perpanjangan Sewa
    public function extend(Request $request, $id)
    {
        $currentReservation = Reservation::with('room')->findOrFail($id);

        if ($currentReservation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $durationMonths = (int) $request->input('duration_months', 1);
        if (!in_array($durationMonths, [1, 3, 6, 12])) {
            $durationMonths = 1;
        }

        // Tanggal mulai perpanjangan adalah tanggal checkout reservasi sebelumnya
        $startDate = \Carbon\Carbon::parse($currentReservation->end_date);
        $endDate = $startDate->copy()->addMonths($durationMonths);
        $room = $currentReservation->room;

        $newReservation = new Reservation();
        $newReservation->id = Str::uuid()->toString();
        $newReservation->room_id = $currentReservation->room_id;
        $newReservation->user_id = Auth::id();
        $newReservation->start_date = $startDate->toDateString();
        $newReservation->end_date = $endDate->toDateString();
        $newReservation->duration_months = $durationMonths;
        $newReservation->status = 'pending';
        $newReservation->total_price = ($room ? $room->price_per_month * $durationMonths : 1500000) + 50000;
        $newReservation->save();

        // Update status keputusan pada reservasi saat ini
        $currentReservation->extension_decision = 'extended';
        $currentReservation->extension_notes = 'Penyewa mengajukan perpanjangan sewa ' . $durationMonths . ' bulan (ID: ' . substr($newReservation->id, 0, 8) . ')';
        $currentReservation->save();

        return redirect()->route('bookings.my')
            ->with('auto_open_manual', $newReservation->id)
            ->with('success', 'Pengajuan perpanjangan sewa Kamar ' . ($room ? $room->room_number : '') . ' berhasil dibuat! Silakan lakukan transfer dan unggah bukti transfer.');
    }

    // User: Konfirmasi Tidak Memperpanjang (Checkout saat Jatuh Tempo)
    public function terminate(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $reservation->extension_decision = 'will_checkout';
        $reservation->extension_notes = $request->input('notes', 'Penyewa mengonfirmasi selesai sewa saat tenggat waktu tiba.');
        $reservation->save();

        $checkoutDate = \Carbon\Carbon::parse($reservation->end_date)->translatedFormat('d F Y');

        return back()->with('success', 'Konfirmasi selesai sewa berhasil dicatat. Anda dijadwalkan checkout pada tanggal ' . $checkoutDate . '. Terima kasih telah menjadi penghuni Kosify!');
    }

    // Alias untuk kompatibilitas terminateContract
    public function terminateContract(Request $request, $id)
    {
        return $this->terminate($request, $id);
    }

    // User: Batalkan Pesanan / Reservasi (Pending / Waiting Verification)
    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        if (!in_array($reservation->status, ['pending', 'waiting_verification'])) {
            return back()->with('error', 'Pesanan yang sudah aktif/lunas tidak dapat dibatalkan secara mandiri. Silakan hubungi pemilik kos.');
        }

        $reservation->status = 'cancelled';
        $reservation->save();

        $room = \App\Models\Room::find($reservation->room_id);
        if ($room) {
            $hasOtherActive = Reservation::where('room_id', $room->id)
                ->where('id', '!=', $reservation->id)
                ->whereIn('status', ['confirmed', 'active'])
                ->exists();
            if (!$hasOtherActive) {
                $room->status = 'available';
                $room->save();
            }
        }

        \Illuminate\Support\Facades\Cache::forget('admin_dashboard_full_bundle');
        \Illuminate\Support\Facades\Cache::forget('admin_finance_bundle');

        return redirect()->route('bookings.my')
            ->with('success', 'Pesanan Kamar ' . ($room ? $room->room_number : '') . ' berhasil dibatalkan.');
    }
}
