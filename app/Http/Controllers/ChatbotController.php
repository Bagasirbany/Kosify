<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $rawMessage = trim($request->input('message', ''));
        $message = strtolower($rawMessage);

        // Determine locale from request, session, or cookie
        $locale = $request->input('locale') 
            ?: $request->header('X-Locale') 
            ?: session('locale', $request->cookie('kosify_locale', config('app.locale', 'id')));

        if (!in_array($locale, ['id', 'en'])) {
            $locale = 'id';
        }

        App::setLocale($locale);
        $isEn = ($locale === 'en');

        if (empty($message)) {
            return response()->json([
                'reply' => $isEn 
                    ? 'Hello! How can we help you regarding room info, prices, facilities, rental recommendations, or booking at Kosify?' 
                    : 'Halo! Ada yang bisa kami bantu seputar informasi kamar, harga, fasilitas, rekomendasi sewa, atau cara booking di Kosify?'
            ]);
        }

        // Fetch settings
        $settings = Cache::remember('web_settings_all', 300, function () {
            return WebSetting::pluck('value', 'key')->toArray();
        });

        $ownerName = $settings['owner_name'] ?? 'Bagas Irbany';
        $ownerPhone = $settings['owner_phone'] ?? '0858-1572-1534';
        $ownerEmail = $settings['owner_email'] ?? 'owner@kosify.com';
        $kosAddress = $settings['kos_address'] ?? 'Jl. Kaliurang KM 5.2 No. 18, Caturtunggal, Sleman, D.I. Yogyakarta 55281';

        try {
            // 1. CEK NOMOR KAMAR SPESIFIK (Misal: "kamar 101", "room 101", "102", "info 203")
            if (preg_match('/\b(kamar|room\s*)?([0-9]{3})\b/', $message, $matches)) {
                $searchedNumber = $matches[2];
                $specificRoom = Room::where('room_number', $searchedNumber)->first();
                if ($specificRoom) {
                    $isAvail = in_array(strtolower($specificRoom->status), ['available', 'tersedia']);
                    $isOccupied = in_array(strtolower($specificRoom->status), ['occupied', 'terisi']);
                    
                    if ($isEn) {
                        $statusText = $isAvail ? 'Available (Ready to Move In)' : ($isOccupied ? 'Currently Occupied' : 'Under Maintenance');
                        $facilitiesDesc = $specificRoom->localized_description ?: 'Plush springbed, 2-door wardrobe, study desk & chair, 24/7 high-speed WiFi';
                        return response()->json([
                            'reply' => "Room " . $specificRoom->room_number . " Information:\n\n"
                                     . "• Type: " . ($specificRoom->room_type ?: 'Standard') . "\n"
                                     . "• Rate: Rp " . number_format($specificRoom->price_per_month, 0, ',', '.') . " / month\n"
                                     . "• Status: " . $statusText . "\n"
                                     . "• Facilities: " . $facilitiesDesc . "\n\n"
                                     . "Want to book this room? Open the 'Catalog' menu and click Book Now!"
                        ]);
                    } else {
                        $statusText = $isAvail ? 'Tersedia (Siap Huni)' : ($isOccupied ? 'Sudah Terisi' : 'Dalam Perbaikan');
                        $facilitiesDesc = $specificRoom->localized_description ?: 'Kasur empuk, Lemari pakaian, Meja belajar & Kursi, WiFi 24 Jam';
                        return response()->json([
                            'reply' => "Informasi Kamar " . $specificRoom->room_number . ":\n\n"
                                     . "• Tipe: " . ($specificRoom->room_type ?: 'Standard') . "\n"
                                     . "• Tarif: Rp " . number_format($specificRoom->price_per_month, 0, ',', '.') . " / bulan\n"
                                     . "• Status: " . $statusText . "\n"
                                     . "• Fasilitas: " . $facilitiesDesc . "\n\n"
                                     . "Ingin sewa kamar ini? Silakan buka menu 'Katalog' lalu klik tombol Booking!"
                        ]);
                    }
                }
            }

            // 2. REKOMENDASI UNTUK MAHASISWA / KULIAH / PELAJAR / PKL / MAGANG / STUDENT
            if (
                str_contains($message, 'mahasiswa') ||
                str_contains($message, 'kuliah') ||
                str_contains($message, 'pelajar') ||
                str_contains($message, 'siswa') ||
                str_contains($message, 'smk') ||
                str_contains($message, 'pkl') ||
                str_contains($message, 'magang') ||
                str_contains($message, 'student') ||
                str_contains($message, 'college') ||
                str_contains($message, 'university') ||
                str_contains($message, 'intern') ||
                (str_contains($message, 'cocok') && (str_contains($message, 'paket') || str_contains($message, 'mana') || str_contains($message, 'tipe') || str_contains($message, 'kamar'))) ||
                (str_contains($message, 'recommend') && str_contains($message, 'room'))
            ) {
                $standardRooms = Room::where('room_type', 'Standard')->where('status', 'available')->pluck('room_number')->toArray();
                $standardExample = !empty($standardRooms) ? ($isEn ? 'Room ' : 'Kamar ') . implode(', ', array_slice($standardRooms, 0, 2)) : ($isEn ? 'Room 102' : 'Kamar 102');

                $deluxeRooms = Room::where('room_type', 'Deluxe')->where('status', 'available')->pluck('room_number')->toArray();
                $deluxeExample = !empty($deluxeRooms) ? ($isEn ? 'Room ' : 'Kamar ') . implode(', ', array_slice($deluxeRooms, 0, 2)) : ($isEn ? 'Room 101' : 'Kamar 101');

                if ($isEn) {
                    $response = "Room Recommendations for Students & Interns:\n\n"
                              . "For affordable, comfortable, and peaceful study-friendly living, we recommend:\n\n"
                              . "1. Standard Room (Best Value & Student Favorite)\n"
                              . "   • Rate: Rp 1,200,000 – Rp 1,300,000 / month (" . $standardExample . ")\n"
                              . "   • Facilities: Single bed, study desk & ergonomic chair, wardrobe, high-speed Fiber Optic WiFi.\n\n"
                              . "2. Deluxe Room (More Spacious & Air-Conditioned)\n"
                              . "   • Rate: Rp 1,500,000 – Rp 1,600,000 / month (" . $deluxeExample . ")\n"
                              . "   • Facilities: Extra room space, large window ventilation, spacious workspace, & AC.\n\n"
                              . "Additional Student Benefits:\n"
                              . "• Free 24/7 high-speed WiFi for coursework & online lectures.\n"
                              . "• Free access to Shared Kitchen (cook your own meals to save budget).\n"
                              . "• Special discount for 6-month or 1-year advance payments!\n\n"
                              . "You can view full room photos in the 'Catalog' menu.";
                } else {
                    $response = "Rekomendasi Kamar untuk Mahasiswa & Pelajar:\n\n"
                              . "Untuk kebutuhan kuliah yang hemat, nyaman, dan tenang untuk belajar, kami merekomendasikan:\n\n"
                              . "1. Tipe Standard (Paling Hemat & Favorit Mahasiswa)\n"
                              . "   • Tarif: Rp 1.200.000 – Rp 1.300.000 / bulan (" . $standardExample . ")\n"
                              . "   • Fasilitas: Kasur single, meja belajar & kursi ergonomis, lemari, WiFi Fiber Optic kencang.\n\n"
                              . "2. Tipe Deluxe (Lebih Luas & Nyaman)\n"
                              . "   • Tarif: Rp 1.500.000 – Rp 1.600.000 / bulan (" . $deluxeExample . ")\n"
                              . "   • Fasilitas: Ruangan lebih lega, ventilasi luas, meja kerja lapang, & AC.\n\n"
                              . "Keuntungan Tambahan untuk Mahasiswa:\n"
                              . "• Bebas iuran WiFi kencang 24 jam untuk tugas & streaming kuliah.\n"
                              . "• Bebas pakai Dapur Bersama (bisa masak mandiri agar lebih hemat pengeluaran).\n"
                              . "• Ada diskon spesial jika membayar langsung 6 bulan atau 1 tahun!\n\n"
                              . "Anda bisa langsung melihat foto kamarnya di menu 'Katalog'.";
                }
            }

            // 3. REKOMENDASI UNTUK KARYAWAN / PEKERJA / SUITE
            elseif (str_contains($message, 'karyawan') || str_contains($message, 'pekerja') || str_contains($message, 'kerja') || str_contains($message, 'kantor') || str_contains($message, 'eksekutif') || str_contains($message, 'worker') || str_contains($message, 'employee') || str_contains($message, 'professional')) {
                if ($isEn) {
                    $response = "Room Recommendations for Professionals & Workers:\n\n"
                              . "For maximum rest and comfort after work hours, we recommend:\n\n"
                              . "1. Deluxe Room (Rp 1,500,000 – Rp 1,600,000 / month)\n"
                              . "   • AC-equipped, premium springbed, laptop work desk, and spacious wardrobe.\n\n"
                              . "2. Suite Room (Rp 2,100,000 / month)\n"
                              . "   • Most premium unit with private ensuite bathroom, water heater, smart TV, and extra spacious layout.\n\n"
                              . "Safe and secure with 24-hour CCTV monitoring & gated parking for motorcycles and cars.";
                } else {
                    $response = "Rekomendasi Kamar untuk Karyawan & Profesional:\n\n"
                              . "Untuk kenyamanan istirahat maksimal setelah jam kerja, kami merekomendasikan:\n\n"
                              . "1. Tipe Deluxe (Rp 1.500.000 – Rp 1.600.000 / bulan)\n"
                              . "   • Kamar ber-AC, kasur springbed nyaman, meja laptop, dan lemari luas.\n\n"
                              . "2. Tipe Suite (Rp 2.100.000 / bulan)\n"
                              . "   • Unit paling premium, kamar mandi dalam, water heater, smart TV, dan ruangan ekstra lapang.\n\n"
                              . "Keamanan terjamin dengan pantauan CCTV 24 Jam & area parkir motor/mobil berpagar aman.";
                }
            }

            // 4. SEWA BERDUA / 2 ORANG / PASUTRI / TEMAN / COUPLE
            elseif (str_contains($message, 'berdua') || str_contains($message, '2 orang') || str_contains($message, 'dua orang') || str_contains($message, 'pasutri') || str_contains($message, 'teman') || str_contains($message, 'couple') || str_contains($message, '2 people') || str_contains($message, 'two people') || str_contains($message, 'roommate')) {
                if ($isEn) {
                    $response = "Rental Information for 2 People:\n\n"
                              . "For double occupancy (roommates or legally married couples), we recommend the **Deluxe Room** or **Suite Room** with larger beds and ample space.\n\n"
                              . "Rental costs can be split between both occupants, making it much more economical. Contact the Owner via WhatsApp (" . $ownerPhone . ") for additional terms.";
                } else {
                    $response = "Informasi Sewa untuk 2 Orang:\n\n"
                              . "Untuk dihuni berdua (teman sekamar/pasutri sah), kami merekomendasikan **Tipe Deluxe** atau **Tipe Suite** yang memiliki kasur lebih besar dan ruang gerak yang luas.\n\n"
                              . "Biaya sewa bisa dibagi berdua (patungan) sehingga jauh lebih hemat per orangnya. Hubungi Owner via WhatsApp (" . $ownerPhone . ") untuk ketentuan tambahan.";
                }
            }

            // 4.5 TIPE PENGHUNI & ZONASI LANTAI (SEMI-CAMPUR / PUTRA / PUTRI / PASUTRI / GENDER)
            elseif (
                str_contains($message, 'campur') || str_contains($message, 'putra') || str_contains($message, 'putri') || 
                str_contains($message, 'cowok') || str_contains($message, 'cewek') || str_contains($message, 'gender') || 
                str_contains($message, 'zonasi') || str_contains($message, 'lantai 1') || str_contains($message, 'lantai 2') || 
                str_contains($message, 'lantai 3') || str_contains($message, 'mixed') || str_contains($message, 'male') || 
                str_contains($message, 'female') || str_contains($message, 'men') || str_contains($message, 'women') ||
                str_contains($message, 'zoning')
            ) {
                if ($isEn) {
                    $response = "Kosify Floor Zoning Policy (Orderly Semi-Mixed Boarding House):\n\n"
                              . "Kosify implements dedicated floor zoning so all residents enjoy safety, comfort, and optimal privacy:\n\n"
                              . "1. 1st Floor: Dedicated for Male residents or Legally Married Couples (direct gate & parking access).\n"
                              . "2. 2nd & 3rd Floors: Exclusively for Female residents (quiet, safe area with dedicated stairs access).\n"
                              . "3. Shared Areas: Living Room & Shared Kitchen located on the 1st Floor for receiving guests and socializing.\n"
                              . "4. Guest Policy: Opposite-gender guests are welcomed in the shared living room until 10:00 PM.\n\n"
                              . "Browse and book your preferred room in the 'Catalog' menu!";
                } else {
                    $response = "Aturan Zonasi Lantai Kosify (Semi-Campur Tertib):\n\n"
                              . "Kosify menerapkan sistem zonasi lantai agar seluruh penghuni merasa aman, nyaman, dan privasinya terjaga optimal:\n\n"
                              . "1. Lantai 1: Dikhususkan untuk Putra atau Pasutri Sah (akses gerbang mandiri & dekat parkir motor).\n"
                              . "2. Lantai 2 & 3: Dikhususkan Khusus Putri (area tenang, aman, dengan akses tangga khusus penghuni wanita).\n"
                              . "3. Area Bersama: Ruang Tamu & Dapur Umum berada di Lantai 1 sebagai tempat berkumpul dan menerima tamu.\n"
                              . "4. Aturan Tamu: Tamu lawan jenis diterima di ruang tamu bersama hingga pukul 22.00 WIB.\n\n"
                              . "Silakan pilih nomor kamar sesuai kebutuhan Anda di menu 'Katalog'!";
                }
            }

            // 5. TIPE-TIPE KAMAR YANG TERSEDIA / ROOM TYPES
            elseif (str_contains($message, 'tipe') || str_contains($message, 'jenis kamar') || str_contains($message, 'kategori') || str_contains($message, 'pilihan kamar') || str_contains($message, 'type') || str_contains($message, 'room type') || str_contains($message, 'categories')) {
                if ($isEn) {
                    $response = "Room Types Available at Kosify:\n\n"
                              . "1. Standard Room (Rp 1,200,000 - Rp 1,300,000/mo)\n"
                              . "   • Bed, wardrobe, study desk, 24/7 WiFi, clean shared bathroom.\n\n"
                              . "2. Deluxe Room (Rp 1,500,000 - Rp 1,600,000/mo)\n"
                              . "   • AC, plush springbed, work desk, wardrobe, high-speed WiFi.\n\n"
                              . "3. Suite Room (Rp 2,100,000/mo)\n"
                              . "   • Largest room, AC, private ensuite bathroom, water heater, smart storage.\n\n"
                              . "Check full photos for each room on the 'Catalog' page.";
                } else {
                    $response = "Pilihan Tipe Kamar di Kosify:\n\n"
                              . "1. Standard Room (Rp 1.200.000 - Rp 1.300.000/bln)\n"
                              . "   • Kasur, lemari, meja belajar, WiFi 24 jam, kamar mandi luar bersih.\n\n"
                              . "2. Deluxe Room (Rp 1.500.000 - Rp 1.600.000/bln)\n"
                              . "   • Kamar ber-AC, springbed empuk, meja kerja, lemari pakaian, WiFi kencang.\n\n"
                              . "3. Suite Room (Rp 2.100.000/bln)\n"
                              . "   • Kamar paling luas, AC, kamar mandi dalam, water heater, smart storage.\n\n"
                              . "Silakan cek foto lengkap tiap kamar di halaman 'Katalog'.";
                }
            }

            // 6. ATURAN KOS, JAM MALAM, TAMU, LISTRIK, HEWAN / RULES & CURFEW
            elseif (
                str_contains($message, 'jam malam') || 
                str_contains($message, 'aturan') || 
                str_contains($message, 'peraturan') || 
                str_contains($message, 'rule') || 
                str_contains($message, 'curfew') ||
                str_contains($message, 'tamu') || 
                str_contains($message, 'guest') ||
                str_contains($message, 'visitor') ||
                str_contains($message, 'bebas') || 
                str_contains($message, 'kunci') || 
                str_contains($message, 'key') ||
                str_contains($message, 'hewan') || 
                str_contains($message, 'pet') ||
                str_contains($message, 'animal') ||
                str_contains($message, 'listrik') ||
                str_contains($message, 'token') ||
                str_contains($message, 'electricity')
            ) {
                if ($isEn) {
                    $response = "Kosify House Rules & Living Guidelines:\n\n"
                              . "• Curfew & Access: 24-Hour Free Access (Each tenant holds their own main gate key + 24/7 CCTV security).\n"
                              . "• Visiting Guests: Welcomed in the shared ground-floor living room until 10:00 PM for residents' comfort.\n"
                              . "• Electricity: Individual prepaid token meter per room (pay according to personal electronic usage).\n"
                              . "• Water & WiFi: Included free in the monthly rental fee.\n"
                              . "• Pets: Not allowed to maintain cleanliness and quiet surroundings.";
                } else {
                    $response = "Aturan & Ketentuan Hunian Kosify:\n\n"
                              . "• Jam Keluar Masuk: Bebas 24 Jam (Setiap penghuni memegang kunci gerbang sendiri + dipantau CCTV 24 Jam).\n"
                              . "• Tamu Berkunjung: Diterima di ruang tamu bersama hingga pukul 22.00 WIB demi kenyamanan sesama penghuni.\n"
                              . "• Listrik: Menggunakan meteran token per kamar (diisi sesuai pemakaian barang elektronik masing-masing).\n"
                              . "• Air & WiFi: Sudah gratis termasuk dalam biaya sewa bulanan.\n"
                              . "• Hewan Peliharaan: Tidak diperkenankan demi menjaga kebersihan dan ketenangan lingkungan kos.";
                }
            }

            // 7. DAFTAR HARGA & BIAYA SEWA / PRICE LIST
            elseif (
                str_contains($message, 'harga') || str_contains($message, 'biaya') || str_contains($message, 'tarif') || 
                str_contains($message, 'murah') || str_contains($message, 'price') || str_contains($message, 'rate') || 
                str_contains($message, 'cost') || str_contains($message, 'fee') || str_contains($message, 'bayar sewa') || 
                str_contains($message, 'termasuk apa') || str_contains($message, 'how much') || str_contains($message, 'affordable')
            ) {
                $rooms = Room::all();
                $avail = $rooms->where('status', 'available')->count();

                if ($isEn) {
                    $response = "Kosify Rental Rates Breakdown:\n\n"
                              . "• Standard Room: Rp 1,200,000 – Rp 1,300,000 / month\n"
                              . "• Deluxe Room  : Rp 1,500,000 – Rp 1,600,000 / month\n"
                              . "• Suite Room   : Rp 2,100,000 / month\n\n"
                              . "Rates above include:\n"
                              . "• Clean tap water\n"
                              . "• 24/7 Fiber Optic WiFi\n"
                              . "• Free trash & shared area cleaning maintenance\n"
                              . "• Full access to shared kitchen & rooftop drying area\n\n"
                              . "Currently there are " . $avail . " rooms available ready to occupy.";
                } else {
                    $response = "Rincian Tarif Sewa Kamar Kosify:\n\n"
                              . "• Standard Room: Rp 1.200.000 – Rp 1.300.000 / bulan\n"
                              . "• Deluxe Room  : Rp 1.500.000 – Rp 1.600.000 / bulan\n"
                              . "• Suite Room   : Rp 2.100.000 / bulan\n\n"
                              . "Tarif di atas sudah termasuk:\n"
                              . "• Air bersih PDAM\n"
                              . "• Internet WiFi Fiber Optic 24 Jam\n"
                              . "• Bebas iuran sampah & kebersihan area bersama\n"
                              . "• Akses dapur umum & jemuran rooftop\n\n"
                              . "Saat ini terdapat " . $avail . " kamar siap huni yang tersedia.";
                }
            }

            // 8. FASILITAS, WIFI, DAPUR, LAUNDRY, PARKIR / FACILITIES & AMENITIES
            elseif (
                str_contains($message, 'fasilitas') || str_contains($message, 'facilit') || str_contains($message, 'amenit') || 
                str_contains($message, 'wifi') || str_contains($message, 'internet') || str_contains($message, 'dapur') || 
                str_contains($message, 'kitchen') || str_contains($message, 'ac') || str_contains($message, 'laundry') || 
                str_contains($message, 'cuci') || str_contains($message, 'jemur') || str_contains($message, 'masak') || 
                str_contains($message, 'parkir') || str_contains($message, 'parking') || str_contains($message, 'kasur') || 
                str_contains($message, 'bed') || str_contains($message, 'lemari') || str_contains($message, 'wardrobe')
            ) {
                if ($isEn) {
                    $response = "Complete Facilities at Kosify:\n\n"
                              . "1. Bedroom: Plush springbed, pillow, bedsheet, 2-door wardrobe, study desk & ergonomic chair.\n"
                              . "2. Internet: 24/7 high-speed Fiber Optic WiFi on every floor.\n"
                              . "3. Shared Kitchen: Gas stove, dishwashing sink, shared refrigerator, and gallon water dispenser.\n"
                              . "4. Laundry & Drying Area: Spacious rooftop drying area protected from rain.\n"
                              . "5. Parking & Security: Gated motorcycle parking + 24-hour CCTV surveillance camera monitoring.";
                } else {
                    $response = "Fasilitas Lengkap di Kosify:\n\n"
                              . "1. Kamar Tidur: Kasur springbed empuk, bantal, sprei, lemari pakaian 2 pintu, meja belajar & kursi ergonomis.\n"
                              . "2. Internet: WiFi Fiber Optic kecepatan tinggi 24 Jam di setiap lantai.\n"
                              . "3. Dapur Bersama: Kompor gas, wastafel cuci piring, kulkas bersama, dan dispenser air minum galon.\n"
                              . "4. Area Jemur & Cuci: Rooftop jemuran luas dan terlindung dari hujan.\n"
                              . "5. Parkir & Keamanan: Parkir motor berpagar aman + pantauan kamera CCTV 24 Jam.";
                }
            }

            // 9. PERSYARATAN AWAL SEWA KOS / REQUIREMENTS
            elseif (
                str_contains($message, 'syarat') || str_contains($message, 'persyaratan') || str_contains($message, 'ketentuan') || 
                str_contains($message, 'requirement') || str_contains($message, 'dokumen') || str_contains($message, 'document') || 
                str_contains($message, 'ktp') || str_contains($message, 'id card') || str_contains($message, 'passport') || 
                str_contains($message, 'paspor') || str_contains($message, 'deposit')
            ) {
                if ($isEn) {
                    $response = "Initial Rental Requirements at Kosify (Simple & Transparent):\n\n"
                              . "1. Official ID: Photo of ID Card (KTP) / Passport / Student Card (KTM) for guest registry record.\n"
                              . "2. Emergency Contact: Phone number of parents/guardian/relative for urgent situations.\n"
                              . "3. Initial Payment: First month's rent payment upon check-in (zero admin fee & includes water + WiFi).\n"
                              . "4. Married Couples: Valid Marriage Certificate copy required for opposite-gender couples renting 1 room together.\n"
                              . "5. House Rules Agreement: Agree to adhere to house rules (opposite-gender guests in shared living room & no pets allowed).\n\n"
                              . "You can view room details and book online directly through the 'Catalog' menu!";
                } else {
                    $response = "Persyaratan Awal Sewa di Kosify Sangat Mudah & Transparan:\n\n"
                              . "1. Identitas Resmi: Foto KTP / Paspor / KTM (Kartu Mahasiswa) yang masih berlaku untuk pendataan buku tamu warga kos.\n"
                              . "2. Kontak Darurat: Nomor HP orang tua/wali/kerabat yang bisa dihubungi dalam keadaan mendesak.\n"
                              . "3. Pembayaran Awal: Pembayaran sewa bulan pertama saat check-in (bebas biaya admin & sudah termasuk air + WiFi).\n"
                              . "4. Pasutri / Sewa Berdua: Wajib melampirkan fotokopi Buku Nikah sah bagi pasangan lawan jenis yang sewa 1 kamar.\n"
                              . "5. Ketertiban Bersama: Bersedia mematuhi tata tertib kos (tamu lawan jenis di ruang tamu bersama & dilarang membawa hewan peliharaan).\n\n"
                              . "Anda bisa langsung melihat detail kamar dan booking online lewat menu 'Katalog'!";
                }
            }

            // 10. CARA BOOKING & METODE PEMBAYARAN / BOOKING & PAYMENT
            elseif (
                str_contains($message, 'booking') || str_contains($message, 'book') || str_contains($message, 'pesan') || 
                str_contains($message, 'cara sewa') || str_contains($message, 'how to rent') || str_contains($message, 'how to book') || 
                str_contains($message, 'transfer') || str_contains($message, 'gateway') || str_contains($message, 'qris') || 
                str_contains($message, 'bayar') || str_contains($message, 'pay') || str_contains($message, 'payment')
            ) {
                if ($isEn) {
                    $response = "How to Book & Pay at Kosify:\n\n"
                              . "1. Open the 'Catalog' menu and choose your preferred room.\n"
                              . "2. Click 'Book Now', select your check-in date & duration (1–12 months).\n"
                              . "3. Transfer payment directly to the official Kosify bank account (BCA, Mandiri, or BRI) and upload your transfer receipt in 'My Bookings'.\n"
                              . "4. Once confirmed by the owner/management, your Official Digital Receipt & Rental Agreement (PDF) are immediately available in your account.";
                } else {
                    $response = "Cara Booking & Pembayaran di Kosify:\n\n"
                              . "1. Buka menu 'Katalog' dan pilih kamar yang Anda minati.\n"
                              . "2. Klik 'Booking Sekarang', pilih tanggal mulai sewa & durasi (1–12 bulan).\n"
                              . "3. Lakukan pembayaran via Transfer Bank Resmi (BCA, Mandiri, atau BRI) dan unggah bukti transfer di menu 'Booking Saya'.\n"
                              . "4. Setelah pembayaran diverifikasi oleh pengelola, Kuitansi Resmi & Surat Perjanjian Sewa Digital (PDF) langsung aktif di akun Anda.";
                }
            }

            // 11. KETERSEDIAAN / KAMAR KOSONG SAAT INI / VACANCY
            elseif (
                str_contains($message, 'kosong') || str_contains($message, 'sisa') || str_contains($message, 'tersedia') || 
                str_contains($message, 'ready') || str_contains($message, 'availab') || str_contains($message, 'penuh') || 
                str_contains($message, 'vacan') || str_contains($message, 'empty') || str_contains($message, 'full')
            ) {
                $availableRooms = Room::where('status', 'available')->get();
                $availCount = $availableRooms->count();
                if ($availCount > 0) {
                    $roomList = $availableRooms->pluck('room_number')->take(5)->implode(', ');
                    if ($isEn) {
                        $response = "Good News: There are currently " . $availCount . " available rooms ready to occupy (including Room: " . $roomList . ").\n\n"
                                  . "Feel free to browse and book your room in the 'Catalog' menu.";
                    } else {
                        $response = "Kabar Baik: Masih ada " . $availCount . " kamar yang berstatus TERSEDIA siap huni (antara lain Kamar: " . $roomList . ").\n\n"
                                  . "Silakan langsung pilih dan booking nomor kamar pilihan Anda di menu 'Katalog'.";
                    }
                } else {
                    if ($isEn) {
                        $response = "Sorry, all rooms are currently fully occupied. Please contact the Owner via WhatsApp at " . $ownerPhone . " to join the waiting list.";
                    } else {
                        $response = "Mohon maaf, semua kamar saat ini sedang terisi penuh. Silakan hubungi Owner via WhatsApp di " . $ownerPhone . " untuk masuk ke daftar tunggu (waiting list).";
                    }
                }
            }

            // 12. PROMO / DISKON / DISCOUNTS
            elseif (str_contains($message, 'promo') || str_contains($message, 'diskon') || str_contains($message, 'potongan') || str_contains($message, 'discount') || str_contains($message, 'cashback') || str_contains($message, 'special offer')) {
                if ($isEn) {
                    $response = "Kosify Rental Promos & Discounts:\n\n"
                              . "• 6-Month Rental: 5% discount on total rent.\n"
                              . "• 1-Year Rental: 1 full month FREE rental bonus!\n"
                              . "• Zero admin fees & unlimited free WiFi/Water.\n\n"
                              . "Discounts automatically apply when you choose the rental duration in the booking form.";
                } else {
                    $response = "Promo & Diskon Sewa Kosify:\n\n"
                              . "• Diskon Sewa 6 Bulan: Potongan hemat 5% dari total sewa.\n"
                              . "• Diskon Sewa 1 Tahun: Bonus gratis sewa 1 bulan penuh!\n"
                              . "• Bebas biaya admin & bebas iuran WiFi/Air sepuasnya.\n\n"
                              . "Potongan harga otomatis berlaku saat Anda memilih durasi sewa di form booking.";
                }
            }

            // 13. SURVEI / LIHAT LOKASI / ALAMAT KOS / LOCATION & SURVEY
            elseif (
                str_contains($message, 'survei') || str_contains($message, 'survey') || str_contains($message, 'lihat lokasi') || 
                str_contains($message, 'alamat') || str_contains($message, 'lokasi') || str_contains($message, 'maps') || 
                str_contains($message, 'location') || str_contains($message, 'address') || str_contains($message, 'visit') ||
                str_contains($message, 'where')
            ) {
                if ($isEn) {
                    $response = "Want to Visit & Inspect the Room in Person?\n\n"
                              . "• Address: " . $kosAddress . "\n"
                              . "• Visiting Hours: Every day from 08:00 AM – 06:00 PM WIB.\n\n"
                              . "To ensure a room key is prepared for viewing, please schedule an appointment first with the Owner via WhatsApp: " . $ownerPhone . ".";
                } else {
                    $response = "Ingin Survei Kamar Langsung?\n\n"
                              . "• Alamat: " . $kosAddress . "\n"
                              . "• Jam Kunjungan Survei: Setiap hari pukul 08.00 – 18.00 WIB.\n\n"
                              . "Agar kami bisa menyiapkan kunci kamar untuk Anda lihat, silakan buat janji temu terlebih dahulu dengan Owner via WhatsApp: " . $ownerPhone . ".";
                }
            }

            // 14. KONTAK OWNER / PENGELOLA / CONTACT
            elseif (preg_match('/\b(owner|pemilik|kontak|contact|wa|whatsapp|telepon|telp|phone|hp|hubungi|admin|call)\b/', $message)) {
                if ($isEn) {
                    $response = "Official Kosify Management Contact:\n\n"
                              . "• Management: " . $ownerName . "\n"
                              . "• WhatsApp: " . $ownerPhone . " (Fast Response)\n"
                              . "• Email: " . $ownerEmail . "\n"
                              . "• Address: " . $kosAddress . "\n\n"
                              . "Contact our WhatsApp for rental inquiries or to schedule an in-person room visit.";
                } else {
                    $response = "Kontak Resmi Pengelola Kosify:\n\n"
                              . "• Pengelola: " . $ownerName . "\n"
                              . "• WhatsApp: " . $ownerPhone . " (Fast Response)\n"
                              . "• Email: " . $ownerEmail . "\n"
                              . "• Alamat: " . $kosAddress . "\n\n"
                              . "Silakan hubungi WhatsApp kami untuk konsultasi sewa atau survei lokasi langsung.";
                }
            }

            // 15. SAPAAN / BASA-BASI / GREETINGS
            elseif (preg_match('/\b(halo|hello|hi|hai|hei|pagi|siang|sore|malam|morning|afternoon|evening|tes|test|permisi|assalamualaikum)\b/', $message)) {
                if ($isEn) {
                    $response = "Hello! Welcome to Kosify's virtual assistant service.\n\n"
                              . "How can we help you? Feel free to ask about:\n"
                              . "1. Room recommendations (for students, employees, or couples)\n"
                              . "2. Price list & room facilities\n"
                              . "3. Available ready-to-move-in rooms\n"
                              . "4. Curfew & house rules\n"
                              . "5. Online booking & payment steps";
                } else {
                    $response = "Halo! Selamat datang di layanan asisten virtual Kosify.\n\n"
                              . "Ada yang bisa kami bantu? Anda bisa tanyakan seputar:\n"
                              . "1. Rekomendasi kamar (untuk mahasiswa, karyawan, atau berdua)\n"
                              . "2. Daftar harga & fasilitas kamar\n"
                              . "3. Kamar kosong yang siap huni\n"
                              . "4. Jam malam & aturan kos\n"
                              . "5. Cara booking & pembayaran online";
                }
            }

            // 16. TERIMA KASIH / THANKS
            elseif (str_contains($message, 'makasih') || str_contains($message, 'terima kasih') || str_contains($message, 'thanks') || str_contains($message, 'thank you') || str_contains($message, 'thx') || str_contains($message, 'ok') || str_contains($message, 'oke') || str_contains($message, 'alright') || str_contains($message, 'great')) {
                if ($isEn) {
                    $response = "You're very welcome! Happy to assist you. If you have any further questions or wish to arrange a room visit, feel free to ask anytime.";
                } else {
                    $response = "Sama-sama! Senang bisa membantu Anda. Jika ada hal lain yang ingin ditanyakan atau ingin survei kamar, jangan ragu untuk bertanya lagi ya.";
                }
            }

            // 17. DEFAULT FALLBACK
            else {
                if ($isEn) {
                    $response = "Thank you for your question. For more details regarding \"" . htmlspecialchars($rawMessage) . "\", feel free to ask about:\n\n"
                              . "• Student or employee room recommendations\n"
                              . "• Room rates & complete facilities\n"
                              . "• Available vacant rooms right now\n"
                              . "• Curfew & visitor house rules\n"
                              . "• Owner WhatsApp Contact: " . $ownerPhone;
                } else {
                    $response = "Terima kasih atas pertanyaannya. Untuk informasi lebih lengkap mengenai \"" . htmlspecialchars($rawMessage) . "\", Anda dapat menanyakan seputar:\n\n"
                              . "• Rekomendasi kamar mahasiswa / karyawan\n"
                              . "• Rincian harga per tipe kamar & fasilitas\n"
                              . "• Ketersediaan kamar kosong saat ini\n"
                              . "• Aturan jam malam & tamu\n"
                              . "• Kontak WhatsApp Owner: " . $ownerPhone;
                }
            }

        } catch (\Exception $e) {
            $response = $isEn
                ? "Hello! Please contact the Kosify Owner directly via WhatsApp at " . $ownerPhone . " for room availability and rental details."
                : "Halo! Silakan hubungi langsung Owner Kosify melalui WhatsApp di " . $ownerPhone . " untuk informasi seputar ketersediaan kamar dan sewa.";
        }

        return response()->json([
            'reply' => $response
        ]);
    }
}
