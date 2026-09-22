<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Room;

class PaymentController extends Controller
{
    /**
     * Request Sesi Pembayaran Payment Gateway (QRIS & Virtual Account).
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

        $orderId = 'PG-KOS-' . strtoupper(Str::random(6)) . '-' . substr($reservation->id, 0, 4);
        $customerUser = $reservation->user ?? auth()->user();
        $rawPhone = $customerUser ? ($customerUser->phone ?: '081234567890') : '081234567890';
        $digitsOnly = preg_replace('/\D/', '', $rawPhone);
        if (strlen($digitsOnly) < 8) {
            $digitsOnly = '81234567890';
        }
        $suffix = substr($digitsOnly, -8);

        return response()->json([
            'success' => true,
            'mode' => 'gateway',
            'reservation_id' => $reservation->id,
            'room_number' => $reservation->room ? $reservation->room->room_number : '101',
            'room_type' => $reservation->room && $reservation->room->type ? $reservation->room->type->name : 'Standar',
            'duration_months' => $reservation->duration_months ?: 1,
            'amount' => (int) $reservation->total_price,
            'formatted_amount' => 'Rp ' . number_format($reservation->total_price, 0, ',', '.'),
            'customer_name' => $customerUser ? $customerUser->name : 'Penyewa',
            'customer_email' => $customerUser ? $customerUser->email : 'penyewa@kosify.id',
            'customer_phone' => $rawPhone,
            'order_id' => $orderId,
            'gateway_name' => 'Kosify Payment Gateway',
            'va_numbers' => [
                'BCA' => '8808 ' . substr($suffix, 0, 4) . ' ' . substr($suffix, 4),
                'Mandiri' => '8909 ' . substr($suffix, 0, 4) . ' ' . substr($suffix, 4),
                'BRI' => '1020 ' . substr($suffix, 0, 4) . ' ' . substr($suffix, 4),
                'BNI' => '9881 ' . substr($suffix, 0, 4) . ' ' . substr($suffix, 4),
            ],
            'qris' => [
                'merchant_name' => 'KOSIFY RESIDENCE INDONESIA',
                'nmid' => 'ID102498218' . rand(100, 999),
                'valid_until' => now()->addMinutes(15)->format('H:i'),
            ]
        ]);
    }

    /**
     * Konfirmasi pembayaran otomatis melalui Payment Gateway.
     */
    public function finishPayment(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Akses tidak diizinkan.'], 403);
        }

        $paymentMethod = $request->input('payment_method', 'Payment Gateway (Instant)');
        $transactionId = $request->input('transaction_id', 'PG-' . strtoupper(Str::random(10)));

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

        session()->flash('success', 'Pembayaran terverifikasi! Kamar ' . ($reservation->room ? $reservation->room->room_number : '') . ' Anda telah resmi aktif.');

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran terverifikasi! Kamar Anda telah resmi aktif.',
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
     * Webhook Payment Gateway HTTP Notification.
     */
    public function webhook(Request $request)
    {
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status ?? $request->status;
        $paymentType = $request->payment_type ?? 'QRIS';

        if (!$orderId) {
            return response()->json(['message' => 'No order ID provided'], 400);
        }

        // Support various orderId formats (e.g. PG-KOS-XXXX-UUID or KOSIFY-UUID-TIME)
        $reservationId = null;
        if (str_contains($orderId, 'PG-KOS-')) {
            $parts = explode('-', $orderId);
            $reservationId = end($parts);
        } elseif (str_contains($orderId, 'KOSIFY-')) {
            $parts = explode('-', $orderId);
            if (count($parts) >= 3) {
                $reservationId = $parts[1];
            }
        }

        if ($reservationId) {
            $reservation = Reservation::where('id', 'like', $reservationId . '%')->first();
            
            if ($reservation) {
                if (in_array($transactionStatus, ['capture', 'settlement', 'success', 'paid'])) {
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
                            'payment_method' => 'Payment Gateway (' . ucfirst($paymentType) . ')',
                            'status' => 'paid',
                            'verified_at' => now(),
                        ]
                    );
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire', 'failed'])) {
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

        return response()->json(['message' => 'Payment Gateway notification handled successfully']);
    }
}
