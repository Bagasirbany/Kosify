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
        $rawMessage = trim($request->input('message', ''));
        $message = strtolower($rawMessage);

        if (empty($message)) {
            return response()->json([
                'reply' => 'Halo! Ada yang bisa kami bantu seputar informasi kamar, harga, fasilitas, rekomendasi sewa, atau cara booking di Kosify?'
            ]);
        }

        // Fetch settings
        $settings = Cache::remember('web_settings_all', 300, function () {
            return WebSetting::pluck('value', 'key')->toArray();
        });

        $ownerName = $settings['owner_name'] ?? 'Bpk. Kosify Owner';
        $ownerPhone = $settings['owner_phone'] ?? '0812-3456-7890';
        $ownerEmail = $settings['owner_email'] ?? 'owner@kosify.com';
        $kosAddress = $settings['kos_address'] ?? 'Jl. Kosify Raya No. 88, Pusat Kota';

        try {
            // 1. CEK NOMOR KAMAR SPESIFIK (Misal: "kamar 101", "102", "info 203", "ada kamar 302?")
            if (preg_match('/\b(kamar\s*)?([0-9]{3})\b/', $message, $matches)) {
                $searchedNumber = $matches[2];
                $specificRoom = Room::where('room_number', $searchedNumber)->first();
                if ($specificRoom) {
                    $statusIndo = in_array(strtolower($specificRoom->status), ['available', 'tersedia']) 
                        ? '🟢 Tersedia (Siap Huni)' 
                        : (in_array(strtolower($specificRoom->status), ['occupied', 'terisi']) ? '🔴 Sudah Terisi' : '🟡 Dalam Perbaikan');
                    
                    return response()->json([
                        'reply' => "📌 Informasi Kamar " . $specificRoom->room_number . ":\n\n"
                                 . "• Tipe: " . ($specificRoom->room_type ?: 'Standard') . "\n"
                                 . "• Tarif: Rp " . number_format($specificRoom->price_per_month, 0, ',', '.') . " / bulan\n"
                                 . "• Status: " . $statusIndo . "\n"
                                 . "• Fasilitas: " . ($specificRoom->description ?: 'Kasur empuk, Lemari pakaian, Meja belajar & Kursi, WiFi 24 Jam') . "\n\n"
                                 . "💡 Ingin sewa kamar ini? Silakan buka menu 'Katalog' lalu klik tombol Booking!"
                    ]);
                }
            }

            // 2. REKOMENDASI UNTUK MAHASISWA / KULIAH / PELAJAR / PKL / MAGANG
            if (
                str_contains($message, 'mahasiswa') ||
                str_contains($message, 'kuliah') ||
                str_contains($message, 'pelajar') ||
                str_contains($message, 'siswa') ||
                str_contains($message, 'smk') ||
                str_contains($message, 'pkl') ||
                str_contains($message, 'magang') ||
                (str_contains($message, 'cocok') && (str_contains($message, 'paket') || str_contains($message, 'mana') || str_contains($message, 'tipe') || str_contains($message, 'kamar')))
            ) {
                $standardRooms = Room::where('room_type', 'Standard')->where('status', 'available')->pluck('room_number')->toArray();
                $standardExample = !empty($standardRooms) ? 'Kamar ' . implode(', ', array_slice($standardRooms, 0, 2)) : 'Kamar 102';

                $deluxeRooms = Room::where('room_type', 'Deluxe')->where('status', 'available')->pluck('room_number')->toArray();
                $deluxeExample = !empty($deluxeRooms) ? 'Kamar ' . implode(', ', array_slice($deluxeRooms, 0, 2)) : 'Kamar 101';

                $response = "🎓 Rekomendasi Kamar untuk Mahasiswa & Pelajar:\n\n"
                          . "Untuk kebutuhan kuliah yang hemat, nyaman, dan tenang untuk belajar, kami merekomendasikan:\n\n"
                          . "1. 🏷️ Tipe Standard (Paling Hemat & Favorit Mahasiswa)\n"
                          . "   • Tarif: Rp 1.200.000 – Rp 1.300.000 / bulan (" . $standardExample . ")\n"
                          . "   • Fasilitas: Kasur single, meja belajar & kursi ergonomis, lemari, WiFi Fiber Optic kencang.\n\n"
                          . "2. ✨ Tipe Deluxe (Lebih Luas & Nyaman)\n"
                          . "   • Tarif: Rp 1.500.000 – Rp 1.600.000 / bulan (" . $deluxeExample . ")\n"
                          . "   • Fasilitas: Ruangan lebih lega, ventilasi luas, meja kerja lapang, & AC.\n\n"
                          . "💡 Keuntungan Tambahan untuk Mahasiswa:\n"
                          . "• Bebas iuran WiFi kencang 24 jam untuk tugas & streaming kuliah.\n"
                          . "• Bebas pakai Dapur Bersama (bisa masak mandiri agar lebih hemat uang jajan).\n"
                          . "• Ada diskon spesial jika membayar langsung 6 bulan atau 1 tahun!\n\n"
                          . "👉 Anda bisa langsung melihat foto kamarnya di menu 'Katalog'.";
            }

            // 3. REKOMENDASI UNTUK KARYAWAN / PEKERJA / SUITE
            elseif (str_contains($message, 'karyawan') || str_contains($message, 'pekerja') || str_contains($message, 'kerja') || str_contains($message, 'kantor') || str_contains($message, 'eksekutif')) {
                $response = "💼 Rekomendasi Kamar untuk Karyawan & Profesional:\n\n"
                          . "Untuk kenyamanan istirahat maksimal setelah jam kerja, kami merekomendasikan:\n\n"
                          . "1. ✨ Tipe Deluxe (Rp 1.500.000 – Rp 1.600.000 / bulan)\n"
                          . "   • Kamar ber-AC, kasur springbed nyaman, meja laptop, dan lemari luas.\n\n"
                          . "2. 👑 Tipe Suite (Rp 2.100.000 / bulan)\n"
                          . "   • Unit paling premium, kamar mandi dalam, water heater, smart TV, dan ruangan ekstra lapang.\n\n"
                          . "Keamanan terjamin dengan pantauan CCTV 24 Jam & area parkir motor/mobil berpagar aman.";
            }

            // 4. SEWA BERDUA / 2 ORANG / PASUTRI / TEMAN
            elseif (str_contains($message, 'berdua') || str_contains($message, '2 orang') || str_contains($message, 'dua orang') || str_contains($message, 'pasutri') || str_contains($message, 'teman')) {
                $response = "👥 Informasi Sewa untuk 2 Orang:\n\n"
                          . "Untuk dihuni berdua (teman sekamar/pasutri sah), kami merekomendasikan **Tipe Deluxe** atau **Tipe Suite** yang memiliki kasur lebih besar dan ruang gerak yang luas.\n\n"
                          . "💡 Biaya sewa bisa dibagi berdua (patungan) sehingga jauh lebih hemat per orangnya! Hubungi Owner via WhatsApp (" . $ownerPhone . ") untuk ketentuan tambahan.";
            }

            // 5. TIPE-TIPE KAMAR YANG TERSEDIA
            elseif (str_contains($message, 'tipe') || str_contains($message, 'jenis kamar') || str_contains($message, 'kategori') || str_contains($message, 'pilihan kamar')) {
                $response = "🏠 Pilihan Tipe Kamar di Kosify:\n\n"
                          . "1. 🏷️ Standard Room (Rp 1.200.000 - Rp 1.300.000/bln)\n"
                          . "   • Kasur, lemari, meja belajar, WiFi 24 jam, kamar mandi luar bersih.\n\n"
                          . "2. ✨ Deluxe Room (Rp 1.500.000 - Rp 1.600.000/bln)\n"
                          . "   • Kamar ber-AC, springbed empuk, meja kerja, lemari pakaian, WiFi kencang.\n\n"
                          . "3. 👑 Suite Room (Rp 2.100.000/bln)\n"
                          . "   • Kamar paling luas, AC, kamar mandi dalam, water heater, smart storage.\n\n"
                          . "👉 Silakan cek foto lengkap tiap kamar di halaman 'Katalog'!";
            }

            // 6. ATURAN KOS, JAM MALAM, TAMU, LISTRIK, HEWAN
            elseif (
                str_contains($message, 'jam malam') || 
                str_contains($message, 'aturan') || 
                str_contains($message, 'peraturan') || 
                str_contains($message, 'tamu') || 
                str_contains($message, 'bebas') || 
                str_contains($message, 'kunci') || 
                str_contains($message, 'hewan') || 
                str_contains($message, 'pet') ||
                str_contains($message, 'listrik') ||
                str_contains($message, 'token')
            ) {
                $response = "📋 Aturan & Ketentuan Hunian Kosify:\n\n"
                          . "• 🕒 Jam Keluar Masuk: Bebas 24 Jam (Setiap penghuni memegang kunci gerbang sendiri + dipantau CCTV 24 Jam).\n"
                          . "• 👥 Tamu Berkunjung: Diterima di ruang tamu bersama hingga pukul 22.00 WIB demi kenyamanan sesama penghuni.\n"
                          . "• ⚡ Listrik: Menggunakan meteran token per kamar (bebas diisi sesuai pemakaian barang elektronik Anda).\n"
                          . "• 💧 Air & WiFi: Sudah GRATIS termasuk dalam biaya sewa bulanan.\n"
                          . "• 🐾 Hewan Peliharaan: Tidak diperkenankan demi menjaga kebersihan dan ketenangan lingkungan kos.";
            }

            // 7. DAFTAR HARGA & BIAYA SEWA
            elseif (str_contains($message, 'harga') || str_contains($message, 'biaya') || str_contains($message, 'tarif') || str_contains($message, 'murah') || str_contains($message, 'price') || str_contains($message, 'bayar sewa') || str_contains($message, 'termasuk apa')) {
                $rooms = Room::all();
                $minP = $rooms->min('price_per_month') ?: 1200000;
                $maxP = $rooms->max('price_per_month') ?: 2100000;
                $avail = $rooms->where('status', 'available')->count();

                $response = "💰 Rincian Tarif Sewa Kamar Kosify:\n\n"
                          . "• Standard Room: Rp 1.200.000 – Rp 1.300.000 / bulan\n"
                          . "• Deluxe Room  : Rp 1.500.000 – Rp 1.600.000 / bulan\n"
                          . "• Suite Room   : Rp 2.100.000 / bulan\n\n"
                          . "✅ Tarif di atas SUDAH TERMASUK:\n"
                          . "• Air bersih PDAM sepuasnya\n"
                          . "• Internet WiFi Fiber Optic 24 Jam\n"
                          . "• Bebas iuran sampah & kebersihan area bersama\n"
                          . "• Akses dapur umum & jemuran rooftop\n\n"
                          . "Saat ini terdapat " . $avail . " kamar siap huni yang tersedia!";
            }

            // 8. FASILITAS, WIFI, DAPUR, LAUNDRY, PARKIR
            elseif (str_contains($message, 'fasilitas') || str_contains($message, 'wifi') || str_contains($message, 'dapur') || str_contains($message, 'ac') || str_contains($message, 'laundry') || str_contains($message, 'cuci') || str_contains($message, 'jemur') || str_contains($message, 'masak') || str_contains($message, 'parkir') || str_contains($message, 'kasur') || str_contains($message, 'lemari')) {
                $response = "✨ Fasilitas Lengkap di Kosify:\n\n"
                          . "1. 🛏️ Kamar Tidur: Kasur springbed empuk, bantal, sprei, lemari pakaian 2 pintu, meja belajar & kursi ergonomis.\n"
                          . "2. 🌐 Internet: WiFi Fiber Optic kecepatan tinggi 24 Jam di setiap lantai.\n"
                          . "3. 🍳 Dapur Bersama: Kompor gas gratis, wastafel cuci piring, kulkas bersama, dan dispenser air minum galon.\n"
                          . "4. 🧺 Area Jemur & Cuci: Rooftop jemuran luas dan terlindung dari hujan.\n"
                          . "5. 🛵 Parkir & Keamanan: Parkir motor berpagar aman + pantauan kamera CCTV 24 Jam.";
            }

            // 9. CARA BOOKING & METODE PEMBAYARAN
            elseif (str_contains($message, 'booking') || str_contains($message, 'pesan') || str_contains($message, 'cara sewa') || str_contains($message, 'transfer') || str_contains($message, 'midtrans') || str_contains($message, 'qris') || str_contains($message, 'bayar') || str_contains($message, 'syarat')) {
                $response = "📝 Cara Booking & Pembayaran di Kosify:\n\n"
                          . "1. Buka menu 'Katalog' dan pilih kamar yang Anda minati.\n"
                          . "2. Klik 'Booking Sekarang', pilih tanggal mulai sewa & durasi (1–12 bulan).\n"
                          . "3. Pilih metode bayar:\n"
                          . "   • Otomatis via Midtrans (QRIS GoPay/OVO/Dana, Virtual Account BCA/Mandiri/BRI)\n"
                          . "   • ATAU Transfer Manual ke rekening bank pengelola (dengan upload struk).\n"
                          . "4. Setelah pembayaran terkonfirmasi, Kuitansi Resmi & Surat Perjanjian Sewa Digital (PDF) langsung terbit di akun Anda!";
            }

            // 10. KETERSEDIAAN / KAMAR KOSONG SAAT INI
            elseif (str_contains($message, 'kosong') || str_contains($message, 'sisa') || str_contains($message, 'tersedia') || str_contains($message, 'ready') || str_contains($message, 'penuh')) {
                $availableRooms = Room::where('status', 'available')->get();
                $availCount = $availableRooms->count();
                if ($availCount > 0) {
                    $roomList = $availableRooms->pluck('room_number')->take(5)->implode(', ');
                    $response = "🟢 Kabar Baik! Masih ada " . $availCount . " kamar yang berstatus TERSEDIA siap huni (antara lain Kamar: " . $roomList . ").\n\n"
                              . "Silakan langsung pilih dan booking nomor kamar pilihan Anda di menu 'Katalog' sebelum keduluan penyewa lain!";
                } else {
                    $response = "Mohon maaf, semua kamar saat ini sedang terisi penuh. Silakan hubungi Owner via WhatsApp di " . $ownerPhone . " untuk masuk ke daftar tunggu (waiting list).";
                }
            }

            // 11. PROMO / DISKON
            elseif (str_contains($message, 'promo') || str_contains($message, 'diskon') || str_contains($message, 'potongan') || str_contains($message, 'cashback')) {
                $response = "🎉 Promo & Diskon Sewa Kosify:\n\n"
                          . "• Diskon Sewa 6 Bulan : Potongan hemat 5% dari total sewa.\n"
                          . "• Diskon Sewa 1 Tahun : Bonus GRATIS sewa 1 bulan penuh!\n"
                          . "• Bebas Biaya Admin & Bebas Iuran WiFi/Air sepuasnya.\n\n"
                          . "Potongan harga otomatis berlaku saat Anda memilih durasi sewa di form booking!";
            }

            // 12. SURVEI / LIHAT LOKASI / ALAMAT KOS
            elseif (str_contains($message, 'survei') || str_contains($message, 'survey') || str_contains($message, 'lihat lokasi') || str_contains($message, 'alamat') || str_contains($message, 'lokasi') || str_contains($message, 'maps')) {
                $response = "📍 Ingin Survei Kamar Langsung?\n\n"
                          . "🏢 Alamat: " . $kosAddress . "\n"
                          . "🕒 Jam Kunjungan Survei: Setiap hari pukul 08.00 – 18.00 WIB.\n\n"
                          . "Agar kami bisa menyiapkan kunci kamar untuk Anda lihat, silakan buat janji temu terlebih dahulu dengan Owner via WhatsApp: " . $ownerPhone . ".";
            }

            // 13. KONTAK OWNER / PENGELOLA
            elseif (preg_match('/\b(owner|pemilik|kontak|wa|whatsapp|telepon|telp|hp|hubungi|admin)\b/', $message)) {
                $response = "📞 Kontak Resmi Pengelola Kosify:\n\n"
                          . "👤 Pengelola: " . $ownerName . "\n"
                          . "📱 WhatsApp : " . $ownerPhone . " (Fast Response)\n"
                          . "✉️ Email    : " . $ownerEmail . "\n"
                          . "🏢 Alamat   : " . $kosAddress . "\n\n"
                          . "Silakan hubungi WhatsApp kami untuk konsultasi sewa atau survei lokasi langsung!";
            }

            // 14. SAPAAN / BASA-BASI (Halo, Hai, Pagi, Siang, Malam, Makasih, Tes)
            elseif (preg_match('/\b(halo|hello|hi|hai|hei|pagi|siang|sore|malam|tes|test|permisi|assalamualaikum)\b/', $message)) {
                $response = "Halo! Selamat datang di layanan asisten virtual Kosify. 😊\n\n"
                          . "Ada yang bisa kami bantu? Anda bisa tanyakan seputar:\n"
                          . "1. Rekomendasi kamar (untuk mahasiswa, karyawan, atau berdua)\n"
                          . "2. Daftar harga & fasilitas kamar\n"
                          . "3. Kamar kosong yang siap huni\n"
                          . "4. Jam malam & aturan kos\n"
                          . "5. Cara booking & pembayaran online";
            }

            // 15. TERIMA KASIH
            elseif (str_contains($message, 'makasih') || str_contains($message, 'terima kasih') || str_contains($message, 'thanks') || str_contains($message, 'ok') || str_contains($message, 'oke')) {
                $response = "Sama-sama! Senang bisa membantu Anda. Jika ada hal lain yang ingin ditanyakan atau ingin survei kamar, jangan ragu untuk bertanya lagi ya! 😊✨";
            }

            // 16. DEFAULT FALLBACK
            else {
                $response = "Terima kasih atas pertanyaannya! Untuk informasi lebih lengkap mengenai \"" . htmlspecialchars($rawMessage) . "\", Anda dapat menanyakan seputar:\n\n"
                          . "• Rekomendasi kamar mahasiswa / karyawan\n"
                          . "• Rincian harga per tipe kamar & fasilitas\n"
                          . "• Ketersediaan kamar kosong saat ini\n"
                          . "• Aturan jam malam & tamu\n"
                          . "• Kontak WhatsApp Owner: " . $ownerPhone;
            }

        } catch (\Exception $e) {
            $response = "Halo! Silakan hubungi langsung Owner Kosify melalui WhatsApp di " . $ownerPhone . " untuk informasi seputar ketersediaan kamar dan sewa.";
        }

        return response()->json([
            'reply' => $response
        ]);
    }
}
