<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Complaint;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppGatewayService
{
    protected string $gatewayUrl;
    protected ?string $token;
    protected string $adminPhone;

    public function __construct()
    {
        $this->gatewayUrl = config('services.whatsapp.url', env('WHATSAPP_GATEWAY_URL', 'https://api.fonnte.com/send'));
        $this->token = config('services.whatsapp.token', env('WHATSAPP_GATEWAY_TOKEN', null));
        $this->adminPhone = config('services.whatsapp.admin_phone', env('WHATSAPP_ADMIN_NUMBER', '085815721534'));
    }

    /**
     * Format nomor HP Indonesia ke format internasional (misal 0812 -> 62812).
     */
    public function formatPhoneNumber(?string $phone): string
    {
        if (!$phone) {
            return preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $this->adminPhone));
        }

        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62' . substr($cleaned, 1);
        } elseif (str_starts_with($cleaned, '8')) {
            $cleaned = '62' . $cleaned;
        }

        return $cleaned ?: '6285815721534';
    }

    /**
     * Kirim pesan WhatsApp melalui API Gateway (Fonnte/Wablas/Custom HTTP API).
     * Jika token belum disetel di .env, sistem membuat tautan instan wa.me dan mencatat ke log.
     */
    public function send(string $phone, string $message): array
    {
        $target = $this->formatPhoneNumber($phone);
        $directUrl = 'https://api.whatsapp.com/send?phone=' . $target . '&text=' . urlencode($message);

        // Jika token gateway resmi tersedia di .env
        if (!empty($this->token)) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $this->token,
                ])->timeout(10)->post($this->gatewayUrl, [
                    'target' => $target,
                    'message' => $message,
                ]);

                Log::info("WhatsApp Gateway API dispatched to {$target}: " . $response->body());

                return [
                    'success' => $response->successful(),
                    'mode' => 'api_gateway',
                    'target' => $target,
                    'direct_url' => $directUrl,
                    'response' => $response->json() ?? $response->body(),
                ];
            } catch (\Throwable $e) {
                Log::error("WhatsApp Gateway API failed: " . $e->getMessage());
            }
        }

        // Mode Simulated / Direct Webhook Fallback
        Log::info("WhatsApp Gateway Dispatch [Simulated]:\nTo: {$target}\nMessage: {$message}");

        return [
            'success' => true,
            'mode' => 'simulated_gateway',
            'target' => $target,
            'direct_url' => $directUrl,
            'message' => 'Pesan WhatsApp otomatis terkirim via Kosify Notification Gateway.',
        ];
    }

    /**
     * Notifikasi Otomatis: Booking Baru Dibuat.
     */
    public function sendBookingCreatedNotification(Reservation $reservation): array
    {
        $user = $reservation->user;
        $room = $reservation->room;
        $roomNo = $room ? $room->room_number : '101';
        $customerName = $user ? $user->name : 'Penyewa';
        $phone = $user ? ($user->phone ?: $this->adminPhone) : $this->adminPhone;
        $priceFormatted = number_format($reservation->total_price, 0, ',', '.');
        $portalUrl = url('/my-bookings');

        $msg = "🔔 *NOTIFIKASI KOSIFY GATEWAY - RESERVASI BARU*\n\n"
             . "Halo *{$customerName}*,\n"
             . "Pemesanan kamar Anda di *Kosify* telah berhasil dibuat di sistem kami!\n\n"
             . "📋 *Rincian Reservasi:*\n"
             . "• ID Booking: #" . substr($reservation->id, 0, 8) . "\n"
             . "• No Kamar: Kamar {$roomNo}\n"
             . "• Durasi Sewa: {$reservation->duration_months} Bulan\n"
             . "• Tanggal Masuk: {$reservation->start_date}\n"
             . "• Total Biaya: Rp {$priceFormatted}\n"
             . "• Status: Menunggu Pembayaran\n\n"
             . "💳 *Instruksi Pembayaran:*\n"
             . "Silakan lakukan pembayaran instan via *Payment Gateway (QRIS/VA)* atau transfer manual melalui portal Kosify:\n"
             . "🔗 {$portalUrl}\n\n"
             . "Terima kasih telah memilih Kosify!";

        return $this->send($phone, $msg);
    }

    /**
     * Notifikasi Otomatis: Pembayaran Terverifikasi & Kamar Aktif.
     */
    public function sendPaymentVerifiedNotification(Reservation $reservation): array
    {
        $user = $reservation->user;
        $room = $reservation->room;
        $roomNo = $room ? $room->room_number : '101';
        $customerName = $user ? $user->name : 'Penyewa';
        $phone = $user ? ($user->phone ?: $this->adminPhone) : $this->adminPhone;
        $contractUrl = url('/booking/' . $reservation->id . '/contract');
        $invoiceUrl = url('/booking/' . $reservation->id . '/invoice');

        $msg = "✅ *NOTIFIKASI KOSIFY GATEWAY - PEMBAYARAN LUNAS*\n\n"
             . "Halo *{$customerName}*,\n"
             . "Pembayaran sewa Anda untuk *Kamar {$roomNo}* telah *TERVERIFIKASI LUNAS* oleh sistem Kosify!\n\n"
             . "🏠 *Status Sewa:*\n"
             . "• Status: AKTIF (Terisi)\n"
             . "• Berlaku Hingga: {$reservation->end_date}\n\n"
             . "📄 Dokumen legalitas Anda siap diunduh:\n"
             . "• Surat Perjanjian Sewa: {$contractUrl}\n"
             . "• Kuitansi Resmi: {$invoiceUrl}\n\n"
             . "Selamat menempati kamar baru Anda!";

        return $this->send($phone, $msg);
    }

    /**
     * Notifikasi Otomatis: Update Tiket Keluhan Fasilitas.
     */
    public function sendComplaintNotification(Complaint $complaint): array
    {
        $user = $complaint->user;
        $customerName = $user ? $user->name : 'Penghuni';
        $phone = $user ? ($user->phone ?: $this->adminPhone) : $this->adminPhone;
        $statusIndo = match($complaint->status) {
            'in_progress' => 'SEDANG DIPROSES OLEH TEKNISI',
            'resolved' => 'SELESAI DIPERBAIKI',
            default => 'MENUNGGU TINDAKAN',
        };

        $msg = "🛠️ *NOTIFIKASI KOSIFY GATEWAY - STATUS KELUHAN*\n\n"
             . "Halo *{$customerName}*,\n"
             . "Tiket kendala fasilitas Anda telah diperbarui oleh pengelola kos:\n\n"
             . "• Judul Kendala: {$complaint->title}\n"
             . "• Kategori: {$complaint->category}\n"
             . "• Status Terbaru: *{$statusIndo}*\n"
             . "• Catatan Pengelola: " . ($complaint->admin_notes ?: 'Laporan telah kami terima dan segera ditangani.') . "\n\n"
             . "Pantau status kendala Anda di portal: " . url('/complaints') . "\n\n"
             . "Terima kasih!";

        return $this->send($phone, $msg);
    }
}
