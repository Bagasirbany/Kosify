<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Room;

class PaymentController extends Controller
{
    /**
     * Request Snap Token dari Midtrans atau fallback ke Interactive Gateway Modal.
     */
    public function getSnapToken($id)
    {
        $reservation = Reservation::with(['room', 'user'])->findOrFail($id);

        // Pastikan total_price terisi dengan benar
        if (!$reservation->total_price || $reservation->total_price <= 0) {
            $pricePerMonth = $reservation->room ? $reservation->room->price_per_month : 1500000;
            $reservation->total_price = $pricePerMonth * ($reservation->duration_months ?: 1);
            $reservation->save();
        }

        // Ambil Server Key & Environment dari Database WebSetting (atau fallback ke config/env)
        $dbServerKey = \App\Models\WebSetting::where('key', 'midtrans_server_key')->value('value');
        $dbIsProduction = \App\Models\WebSetting::where('key', 'midtrans_is_production')->value('value');
        
        $serverKey = !empty($dbServerKey) ? trim($dbServerKey) : config('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        $isProduction = ($dbIsProduction === '1' || $dbIsProduction === 1 || $dbIsProduction === true) ? true : config('midtrans.is_production', false);

        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'KOSIFY-' . $reservation->id . '-' . time();
        $customerUser = $reservation->user ?? auth()->user();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $reservation->total_price,
            ],
            'customer_details' => [
                'first_name' => $customerUser ? $customerUser->name : 'Penyewa',
                'email' => $customerUser ? $customerUser->email : 'penyewa@kosify.com',
                'phone' => $customerUser ? ($customerUser->phone ?: '081234567890') : '081234567890',
            ],
            'item_details' => [
                [
                    'id' => $reservation->room ? (string)$reservation->room->room_number : 'ROOM-1',
                    'price' => (int) $reservation->total_price,
                    'quantity' => 1,
                    'name' => 'Sewa Kamar ' . ($reservation->room ? $reservation->room->room_number : ''),
                ]
            ]
        ];

        try {
            // Cek apakah menggunakan dummy server key bawaan
            if (str_contains($serverKey, 'xxxx') || str_contains($serverKey, 'TOq1a2WVh_qS5_sI13N1VvG0')) {
                // Return simulation mode if dummy keys are detected
                return response()->json([
                    'mode' => 'simulator',
                    'reservation_id' => $reservation->id,
                    'room_number' => $reservation->room ? $reservation->room->room_number : '101',
                    'amount' => (int) $reservation->total_price,
                    'formatted_amount' => 'Rp ' . number_format($reservation->total_price, 0, ',', '.'),
                    'customer_name' => $customerUser ? $customerUser->name : 'Penyewa',
                    'customer_email' => $customerUser ? $customerUser->email : 'penyewa@kosify.com',
                    'customer_phone' => $customerUser ? ($customerUser->phone ?: '081234567890') : '081234567890',
                    'order_id' => $orderId,
                ]);
            }

            $snapToken = Snap::getSnapToken($params);
            return response()->json([
                'mode' => 'midtrans',
                'token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            // Fallback gracefully jika Midtrans API gagal / unauthorized
            return response()->json([
                'mode' => 'simulator',
                'reservation_id' => $reservation->id,
                'room_number' => $reservation->room ? $reservation->room->room_number : '101',
                'amount' => (int) $reservation->total_price,
                'formatted_amount' => 'Rp ' . number_format($reservation->total_price, 0, ',', '.'),
                'customer_name' => $customerUser ? $customerUser->name : 'Penyewa',
                'customer_email' => $customerUser ? $customerUser->email : 'penyewa@kosify.com',
                'customer_phone' => $customerUser ? ($customerUser->phone ?: '081234567890') : '081234567890',
                'order_id' => $orderId,
                'error_detail' => $e->getMessage()
            ]);
        }
    }

    /**
     * Konfirmasi pembayaran otomatis (dari Midtrans Callback atau Simulator).
     */
    public function finishPayment(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Akses tidak diizinkan.'], 403);
        }

        $paymentMethod = $request->input('payment_method', 'Midtrans Instant Payment');
        $transactionId = $request->input('transaction_id', 'TRX-' . strtoupper(Str::random(10)));

        // Update status reservasi menjadi aktif (lunas)
        $reservation->status = 'active';
        $reservation->save();

        // Update status kamar menjadi occupied (terisi)
        $room = Room::find($reservation->room_id);
        if ($room) {
            $room->status = 'occupied';
            $room->save();
        }

        // Simpan / update record pembayaran di tabel payments
        Payment::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'id' => (string) Str::uuid(),
                'user_id' => $reservation->user_id,
                'amount' => $reservation->total_price,
                'payment_method' => $paymentMethod . ' (' . $transactionId . ')',
                'due_date' => now()->addDays(3),
                'status' => 'paid',
                'verified_at' => now(),
            ]
        );

        // Invalidate all related caches immediately
        \Illuminate\Support\Facades\Cache::forget('admin_metrics_summary');
        \Illuminate\Support\Facades\Cache::forget('admin_revenue_12m');
        \Illuminate\Support\Facades\Cache::forget('admin_expiring_leases');
        \Illuminate\Support\Facades\Cache::forget('finance_summary_metrics');
        \Illuminate\Support\Facades\Cache::forget('catalog_rooms_list');
        \Illuminate\Support\Facades\Cache::forget('admin_rooms_list_all');

        // Kirim email konfirmasi ke penyewa (jika email & SMTP terkonfigurasi)
        try {
            $user = $reservation->user;
            if ($user && !empty($user->email)) {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\BookingConfirmedMail($reservation));
            }
        } catch (\Throwable $mailException) {
            \Illuminate\Support\Facades\Log::info('Email confirmation skipped: ' . $mailException->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi! Kamar Anda telah aktif.',
            'redirect' => route('bookings.my')
        ]);
    }

    /**
     * Konfirmasi transaksi gagal atau dibatalkan.
     */
    public function failPayment(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Akses tidak diizinkan.'], 403);
        }

        $paymentMethod = $request->input('payment_method', 'Transfer / Pembayaran Dibatalkan');

        // Update status reservasi menjadi cancelled (gagal)
        $reservation->status = 'cancelled';
        $reservation->save();

        // Pastikan status kamar kembali available jika tidak ada booking aktif lain
        $room = Room::find($reservation->room_id);
        if ($room) {
            $hasActiveOther = Reservation::where('room_id', $room->id)
                ->where('id', '!=', $reservation->id)
                ->whereIn('status', ['active', 'confirmed', 'paid'])
                ->exists();
            if (!$hasActiveOther) {
                $room->status = 'available';
                $room->save();
            }
        }

        // Catat di tabel payments sebagai failed
        Payment::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'id' => (string) Str::uuid(),
                'user_id' => $reservation->user_id,
                'amount' => $reservation->total_price,
                'payment_method' => $paymentMethod,
                'status' => 'failed',
                'verified_at' => null,
            ]
        );

        // Invalidate all related caches immediately
        \Illuminate\Support\Facades\Cache::forget('admin_metrics_summary');
        \Illuminate\Support\Facades\Cache::forget('admin_revenue_12m');
        \Illuminate\Support\Facades\Cache::forget('admin_expiring_leases');
        \Illuminate\Support\Facades\Cache::forget('finance_summary_metrics');
        \Illuminate\Support\Facades\Cache::forget('catalog_rooms_list');
        \Illuminate\Support\Facades\Cache::forget('admin_rooms_list_all');

        return response()->json([
            'success' => true,
            'message' => 'Transaksi gagal / dibatalkan. Status reservasi telah diperbarui.',
            'redirect' => route('bookings.my')
        ]);
    }

    /**
     * Webhook Midtrans HTTP POST Notification.
     */
    public function webhook(Request $request)
    {
        $dbServerKey = \App\Models\WebSetting::where('key', 'midtrans_server_key')->value('value');
        $serverKey = !empty($dbServerKey) ? trim($dbServerKey) : config('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;
        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type ?? 'Midtrans';

        // Validasi Signature Key
        $mySignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if ($mySignatureKey !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $parts = explode('-', $orderId);
        if (count($parts) >= 3 && $parts[0] === 'KOSIFY') {
            $reservationId = $parts[1];
            if (count($parts) > 3) {
                $uuidParts = array_slice($parts, 1, -1);
                $reservationId = implode('-', $uuidParts);
            }

            $reservation = Reservation::find($reservationId);
            
            if ($reservation) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $reservation->status = 'active';
                    
                    $room = Room::find($reservation->room_id);
                    if ($room) {
                        $room->status = 'occupied';
                        $room->save();
                    }

                    Payment::updateOrCreate(
                        ['reservation_id' => $reservation->id],
                        [
                            'id' => (string) Str::uuid(),
                            'user_id' => $reservation->user_id,
                            'amount' => $reservation->total_price,
                            'payment_method' => 'Midtrans ' . ucfirst($paymentType),
                            'status' => 'paid',
                            'verified_at' => now(),
                        ]
                    );
                } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                    $reservation->status = 'cancelled';
                }
                
                $reservation->save();

                // Invalidate caches
                \Illuminate\Support\Facades\Cache::forget('admin_metrics_summary');
                \Illuminate\Support\Facades\Cache::forget('admin_revenue_12m');
                \Illuminate\Support\Facades\Cache::forget('admin_expiring_leases');
                \Illuminate\Support\Facades\Cache::forget('finance_summary_metrics');
                \Illuminate\Support\Facades\Cache::forget('catalog_rooms_list');
                \Illuminate\Support\Facades\Cache::forget('admin_rooms_list_all');
            }
        }

        return response()->json(['message' => 'Notification handled']);
    }
}
