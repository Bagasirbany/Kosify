<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Cache;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = strtolower(trim($request->input('message', '')));
        $response = "";

        if (empty($message)) {
            return response()->json(['reply' => 'Halo! Silakan ketik pertanyaan Anda seputar kos, harga, ketersediaan, atau fasilitas.']);
        }

        // Fetch settings from cache or database
        $settings = Cache::remember('web_settings_all', 300, function () {
            return WebSetting::pluck('value', 'key')->toArray();
        });

        $ownerName = $settings['owner_name'] ?? 'Bpk. Kosify Owner';
        $ownerPhone = $settings['owner_phone'] ?? '0812-3456-7890';
        $ownerEmail = $settings['owner_email'] ?? 'owner@kosify.com';
        $kosAddress = $settings['kos_address'] ?? 'Jl. Kosify Raya No. 88, Pusat Kota';

        try {
            // 1. CEK NOMOR KAMAR SPESIFIK (Misal: "kamar 101", "102", "harga kamar 203")
            if (preg_match('/\b(kamar\s*)?([0-9]{2,4})\b/', $message, $matches)) {
                $searchedNumber = $matches[2];
                $specificRoom = Room::where('room_number', $searchedNumber)->first();
                if ($specificRoom) {
                    $statusIndo = in_array(strtolower($specificRoom->status), ['available', 'tersedia']) 
                        ? '🟢 Tersedia (Siap Huni)' 
                        : (in_array(strtolower($specificRoom->status), ['occupied', 'terisi']) ? '🔴 Sudah Terisi' : '🟡 Dalam Perbaikan');
                    
                    return response()->json([
                        'reply' => "📌 Informasi Kamar " . $specificRoom->room_number . ":\n\n"
                                 . "• Tipe: " . ($specificRoom->room_type ?: 'Standard') . "\n"
                                 . "• Harga: Rp " . number_format($specificRoom->price_per_month, 0, ',', '.') . " / bulan\n"
                                 . "• Status: " . $statusIndo . "\n"
                                 . "• Fasilitas: " . ($specificRoom->description ?: 'Kasur, Lemari, Meja Belajar, WiFi 24 Jam, Listrik Token') . "\n\n"
                                 . "💡 Anda dapat langsung memesan kamar ini melalui menu Katalog!"
                    ]);
                }
            }

            // 2. KHUSUS PROMO, MAHASISWA, PELAJAR & ANAK PKL / MAGANG
            if (str_contains($message, 'promo') || str_contains($message, 'pelajar') || str_contains($message, 'mahasiswa') || str_contains($message, 'pkl') || str_contains($message, 'magang') || str_contains($message, 'siswa') || str_contains($message, 'smk') || str_contains($message, 'kuliah') || str_contains($message, 'diskon') || str_contains($message, 'potongan')) {
                $cheapestRoom = Room::where('status', 'available')->orderBy('price_per_month', 'asc')->first() 
                             ?: Room::orderBy('price_per_month', 'asc')->first();
                
                $cheapestPriceText = $cheapestRoom ? "Rp " . number_format($cheapestRoom->price_per_month, 0, ',', '.') . "/bulan (Kamar " . $cheapestRoom->room_number . ")" : "Mulai Rp 1.200.000/bln";

                $response = "🎓 Promo Spesial Mahasiswa & Siswa PKL/Magang:\n\n"
                          . "✨ Paket Termurah: " . $cheapestPriceText . "\n"
                          . "✨ Diskon Sewa Jangka Panjang: Sewa 6 bulan hemat 5%, sewa 1 tahun dapat bonus potongan 1 bulan!\n"
                          . "✨ Fleksibilitas Magang: Menerima durasi sewa fleksibel sesuai periode PKL/kuliah.\n"
                          . "✨ Fasilitas Belajar: Meja belajar, kursi ergonomis, dan WiFi Fiber Optic kencang 24 jam.\n"
                          . "✨ Dapur Bersama: Bebas masak mandiri di dapur bersama gratis!";
            }
            // 3. DAFTAR HARGA & BIAYA SEWA
            elseif (str_contains($message, 'harga') || str_contains($message, 'biaya') || str_contains($message, 'tarif') || str_contains($message, 'murah') || str_contains($message, 'price') || str_contains($message, 'bayar sewa')) {
                $rooms = Room::orderBy('price_per_month', 'asc')->get();
                if ($rooms->count() > 0) {
                    $minP = $rooms->min('price_per_month');
                    $maxP = $rooms->max('price_per_month');
                    $avail = $rooms->where('status', 'available')->count();
                    $response = "💰 Daftar Harga Sewa Kamar Kosify:\n\n"
                              . "• Rentang Tarif: Rp " . number_format($minP, 0, ',', '.') . " s/d Rp " . number_format($maxP, 0, ',', '.') . " per bulan\n"
                              . "• Kamar Siap Huni: " . $avail . " unit tersedia saat ini\n\n"
                              . "Harga sudah termasuk air bersih sepuasnya, internet WiFi berkecepatan tinggi, dan bebas iuran kebersihan/sampah lingkungan!";
                } else {
                    $response = "💰 Harga sewa kamar kos mulai dari Rp 1.200.000 / bulan dengan fasilitas lengkap kasur, lemari, WiFi, dan kamar mandi.";
                }
            }
            // 4. FASILITAS, WIFI, DAPUR, LAUNDRY, AC
            elseif (str_contains($message, 'fasilitas') || str_contains($message, 'wifi') || str_contains($message, 'dapur') || str_contains($message, 'ac') || str_contains($message, 'laundry') || str_contains($message, 'cuci') || str_contains($message, 'jemur') || str_contains($message, 'masak') || str_contains($message, 'kasur') || str_contains($message, 'lemari')) {
                $response = "✨ Fasilitas Lengkap di Kosify:\n\n"
                          . "1. 🛏 Kamar: Kasur Springbed empuk, bantal, lemari pakaian, meja kerja/belajar & kursi ergonomis.\n"
                          . "2. 🌐 Internet: WiFi Fiber Optic kecepatan tinggi 24 Jam di setiap lantai.\n"
                          . "3. 🍳 Dapur Bersama: Kompor gas gratis, wastafel cuci piring, kulkas bersama, dan dispenser air galon.\n"
                          . "4. 🧺 Area Jemuran: Rooftop luas dan terlindung untuk jemur pakaian.\n"
                          . "5. 🛵 Parkir & Keamanan: Parkir motor berpagar aman + pantauan CCTV 24 Jam.";
            }
            // 5. CARA BOOKING & PEMBAYARAN
            elseif (str_contains($message, 'booking') || str_contains($message, 'pesan kamar') || str_contains($message, 'sewa kamar') || str_contains($message, 'transfer') || str_contains($message, 'midtrans') || str_contains($message, 'cara') || str_contains($message, 'syarat')) {
                $response = "📝 Cara Booking & Pembayaran di Kosify:\n\n"
                          . "1. Buka menu 'Katalog' dan pilih kamar yang diinginkan.\n"
                          . "2. Klik 'Booking Sekarang', tentukan tanggal masuk & durasi bulan sewa.\n"
                          . "3. Bayar secara otomatis melalui Midtrans (BCA, Mandiri, BRI, QRIS, GoPay, OVO), ATAU upload bukti transfer manual bank resmi kami.\n"
                          . "4. Setelah terkonfirmasi, Anda bisa langsung mengunduh Kuitansi Pembayaran dan Surat Kontrak Perjanjian Sewa (PDF)!";
            }
            // 7. KETERSEDIAAN / KAMAR KOSONG
            elseif (str_contains($message, 'kosong') || str_contains($message, 'sisa') || str_contains($message, 'tersedia') || str_contains($message, 'ready') || str_contains($message, 'penuh')) {
                $availCount = Room::where('status', 'available')->count();
                if ($availCount > 0) {
                    $response = "🟢 Masih ada " . $availCount . " kamar yang berstatus 'Tersedia' siap huni saat ini. Silakan buka menu Katalog untuk memilih nomor kamar favorit Anda!";
                } else {
                    $response = "Mohon maaf, semua kamar saat ini sedang penuh terisi. Silakan hubungi Owner di " . $ownerPhone . " untuk masuk daftar tunggu (waiting list).";
                }
            }
            // 8. KONTAK OWNER / PEMILIK KOS / WA ADMIN (Strict word boundary)
            elseif (preg_match('/\b(owner|pemilik|kontak|wa|whatsapp|telepon|telp|hp|hubungi|admin)\b/', $message)) {
                $response = "📞 Kontak Resmi Pemilik / Pengelola Kosify:\n\n"
                          . "👤 Pemilik (Owner): " . $ownerName . "\n"
                          . "📱 WhatsApp / Telp: " . $ownerPhone . " (Aktif)\n"
                          . "✉️ Email: " . $ownerEmail . "\n"
                          . "🏢 Alamat: " . $kosAddress . "\n\n"
                          . "Silakan klik nomor WhatsApp di atas atau hubungi melalui tautan di bagian footer untuk respon cepat!";
            }
            // 9. SURVEI / LIHAT LOKASI
            elseif (str_contains($message, 'survei') || str_contains($message, 'lihat') || str_contains($message, 'survey') || str_contains($message, 'lokasi') || str_contains($message, 'alamat')) {
                $response = "📍 Ingin survei kamar langsung?\n\n"
                          . "Lokasi Kosify beralamat di: " . $kosAddress . ".\n"
                          . "Anda bisa membuat janji temu survei langsung dengan Owner via WhatsApp: " . $ownerPhone . ".";
            }
            // DEFAULT
            else {
                $response = "Halo! KosifyBot siap membantu Anda. Silakan tanyakan hal seputar:\n\n"
                          . "• Daftar harga kamar & ketersediaan unit\n"
                          . "• Promo mahasiswa / pelajar PKL/magang\n"
                          . "• Fasilitas kamar, WiFi, dapur & parkir\n"
                          . "• Cara booking & pembayaran\n"
                          . "• Nomor kontak WhatsApp Owner Kos";
            }
        } catch (\Exception $e) {
            $response = "Halo! Silakan hubungi langsung Owner Kosify melalui WhatsApp di " . $ownerPhone . " untuk informasi ketersediaan kamar dan promo terbaru.";
        }

        return response()->json([
            'reply' => $response
        ]);
    }
}
