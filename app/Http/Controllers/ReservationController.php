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
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration_months' => 'required|integer|min:1',
        ]);

        $room = \App\Models\Room::findOrFail($request->room_id);

        // Hitung End Date (Tanggal Berakhir = Start Date + Duration Months)
        $requestedStartDate = \Carbon\Carbon::parse($request->start_date);
        $requestedEndDate = $requestedStartDate->copy()->addMonths($request->duration_months);

        // Cek apakah ada reservasi aktif yang bertabrakan tanggalnya
        $overlappingReservation = Reservation::where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'active', 'confirmed', 'paid', 'success'])
            ->get()
            ->filter(function ($reservation) use ($requestedStartDate, $requestedEndDate) {
                $existingStart = \Carbon\Carbon::parse($reservation->start_date);
                $existingEnd = $existingStart->copy()->addMonths($reservation->duration_months);

                // Cek Overlap: (StartA <= EndB) and (EndA >= StartB)
                return ($requestedStartDate < $existingEnd) && ($requestedEndDate > $existingStart);
            })->first();

        if ($overlappingReservation) {
            return back()->with('error', 'Kamar sudah dipesan atau sedang dihuni pada rentang tanggal tersebut. Silakan pilih tanggal atau kamar lain.');
        }

        // Cek jika status kamar sama sekali tidak available (misal under maintenance)
        if (!in_array($room->status, ['available', 'occupied', 'terisi'])) {
            return back()->with('error', 'Kamar saat ini tidak dapat disewa.');
        }

        $reservation = new Reservation($request->all());
        $reservation->id = Str::uuid()->toString();
        $reservation->user_id = Auth::id();
        $reservation->status = 'pending';
        // Menyimpan total price
        $reservation->total_price = $room->price_per_month * $request->duration_months;
        $reservation->save();

        return redirect()->route('bookings.my')->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
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
}
