<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Perjanjian Sewa - SPK/{{ strtoupper(substr($reservation->id, 0, 8)) }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .contract-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-10 px-4 sm:px-6">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('bookings.my') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Booking Saya
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Dokumen Kontrak (PDF)
            </button>
        </div>
    </div>

    <!-- Official Legal Contract Paper -->
    <div class="contract-paper max-w-4xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-14 relative leading-relaxed text-sm">
        
        <!-- Kop Surat -->
        <div class="border-b-2 border-slate-900 pb-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3.5">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify Logo" class="h-12 w-auto object-contain">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">KOSIFY PROPERTY MANAGEMENT</h2>
                    <p class="text-xs text-slate-500 font-medium">{{ $settings['company_address'] ?? 'Pusat Pengelolaan Hunian Kos Modern & Nyaman' }}</p>
                    <p class="text-xs text-slate-500 font-medium">WhatsApp: {{ $settings['admin_phone'] ?? '0812-3456-7890' }} | Email: legal@kosify.com</p>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-[10px] font-extrabold uppercase tracking-widest rounded mb-1">
                    Dokumen Legal
                </span>
                <p class="text-xs text-slate-500 font-semibold">No: SPK/KSF/{{ date('Y') }}/{{ strtoupper(substr($reservation->id, 0, 8)) }}</p>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center my-6">
            <h1 class="text-lg sm:text-xl font-black text-slate-900 uppercase tracking-wide underline underline-offset-4 decoration-2">
                SURAT PERJANJIAN SEWA MENYEWA KAMAR KOS
            </h1>
            <p class="text-xs text-slate-500 mt-1">Pada hari ini, tanggal <strong>{{ \Carbon\Carbon::parse($reservation->created_at ?? now())->isoFormat('D MMMM Y') }}</strong>, telah disepakati perjanjian sewa antara pihak-pihak berikut:</p>
        </div>

        <!-- Pihak Pertama & Kedua -->
        <div class="space-y-4 my-6 bg-slate-50 p-6 rounded-2xl border border-slate-100 text-xs sm:text-sm">
            <div>
                <p class="font-bold text-slate-900 mb-1">I. PIHAK PERTAMA (PENGELOLA KOS):</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 text-slate-700 pl-4">
                    <span class="text-slate-500">Nama Badan / Pengelola:</span>
                    <span class="sm:col-span-2 font-bold text-slate-900">Manajemen Kosify Indonesia</span>
                    <span class="text-slate-500">Jabatan:</span>
                    <span class="sm:col-span-2 font-semibold">Pengelola Operasional Properti Kos</span>
                    <span class="text-slate-500">Alamat:</span>
                    <span class="sm:col-span-2">{{ $settings['company_address'] ?? 'Jakarta Selatan, DKI Jakarta' }}</span>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-4">
                <p class="font-bold text-slate-900 mb-1">II. PIHAK KEDUA (PENYEWA):</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 text-slate-700 pl-4">
                    <span class="text-slate-500">Nama Lengkap:</span>
                    <span class="sm:col-span-2 font-bold text-slate-900">{{ $user->name }}</span>
                    <span class="text-slate-500">Email:</span>
                    <span class="sm:col-span-2 font-medium">{{ $user->email }}</span>
                    <span class="text-slate-500">No. Telepon / WhatsApp:</span>
                    <span class="sm:col-span-2 font-medium">{{ $user->phone ?? '08xxxxxxxxxx' }}</span>
                </div>
            </div>
        </div>

        <p class="text-xs text-slate-600 mb-6 italic">Kedua belah pihak telah bersepakat untuk mengikatkan diri dalam Perjanjian Sewa Kamar dengan syarat dan ketentuan sebagai berikut:</p>

        <!-- Pasal-Pasal Perjanjian -->
        <div class="space-y-6 text-xs sm:text-sm text-slate-700">
            
            <!-- Pasal 1 -->
            <div>
                <h3 class="font-extrabold text-slate-900 mb-1.5 uppercase text-xs tracking-wider">Pasal 1: Objek Sewa & Periode Waktu</h3>
                <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-2">
                    <li>PIHAK PERTAMA menyewakan kepada PIHAK KEDUA unit <strong>Kamar No. {{ $reservation->room->room_number ?? '-' }} (Tipe {{ $reservation->room->room_type ?? 'Standard' }})</strong>.</li>
                    <li>Masa sewa berlaku selama <strong>{{ $reservation->duration_months }} Bulan</strong>, terhitung mulai tanggal <strong>{{ \Carbon\Carbon::parse($reservation->start_date)->isoFormat('D MMMM Y') }}</strong> sampai dengan tanggal <strong>{{ \Carbon\Carbon::parse($reservation->end_date ?? \Carbon\Carbon::parse($reservation->start_date)->addMonths($reservation->duration_months))->isoFormat('D MMMM Y') }}</strong>.</li>
                </ol>
            </div>

            <!-- Pasal 2 -->
            <div>
                <h3 class="font-extrabold text-slate-900 mb-1.5 uppercase text-xs tracking-wider">Pasal 2: Biaya Sewa & Pembayaran</h3>
                <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-2">
                    <li>Tarif sewa kamar disepakati sebesar <strong>Rp {{ number_format($reservation->room->price_per_month ?? ($reservation->total_price / max(1, $reservation->duration_months)), 0, ',', '.') }} / bulan</strong>, dengan total biaya keseluruhan <strong>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</strong>.</li>
                    <li>Status pembayaran tagihan ini dinyatakan <strong>LUNAS / TERKONFIRMASI</strong> melalui sistem platform resmi Kosify.</li>
                </ol>
            </div>

            <!-- Pasal 3 -->
            <div>
                <h3 class="font-extrabold text-slate-900 mb-1.5 uppercase text-xs tracking-wider">Pasal 3: Hak & Fasilitas Penghuni</h3>
                <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-2">
                    <li>PIHAK KEDUA berhak menempati kamar yang telah ditentukan dan menikmati fasilitas umum kos (WiFi internet, dapur bersama, air bersih, tempat parkir).</li>
                    <li>PIHAK KEDUA berhak mengajukan tiket komplain / perbaikan melalui aplikasi jika terjadi kerusakan fasilitas bawaan kos.</li>
                </ol>
            </div>

            <!-- Pasal 4 -->
            <div>
                <h3 class="font-extrabold text-slate-900 mb-1.5 uppercase text-xs tracking-wider">Pasal 4: Tata Tertib & Larangan</h3>
                <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-2">
                    <li>Batas jam bertamu adalah pukul <strong>22.00 WIB</strong> demi menjaga ketertiban, keamanan, dan privasi sesama penghuni kos.</li>
                    <li>Dilarang keras merokok di dalam kamar ber-AC serta dilarang membawa, menyimpan, atau mengonsumsi narkoba dan minuman keras di lingkungan kos.</li>
                    <li>PIHAK KEDUA dilarang memindahtangankan sewa kamar kepada pihak ketiga tanpa persetujuan tertulis dari PIHAK PERTAMA.</li>
                </ol>
            </div>

            <!-- Pasal 5 -->
            <div>
                <h3 class="font-extrabold text-slate-900 mb-1.5 uppercase text-xs tracking-wider">Pasal 5: Kerusakan & Berakhirnya Sewa</h3>
                <ol class="list-decimal list-inside space-y-1 text-slate-600 pl-2">
                    <li>Apabila masa sewa berakhir dan PIHAK KEDUA tidak memperpanjang sewa, maka kamar harus dikosongkan selambat-lambatnya pada tanggal jatuh tempo.</li>
                    <li>Kerusakan fasilitas atau inventaris kamar akibat kelalaian PIHAK KEDUA wajib diperbaiki atau diganti oleh PIHAK KEDUA.</li>
                </ol>
            </div>

        </div>

        <!-- Kolom Tanda Tangan -->
        <div class="grid grid-cols-2 gap-8 mt-12 pt-8 border-t border-slate-200 text-center text-xs sm:text-sm">
            <div>
                <p class="text-slate-500 mb-1">PIHAK PERTAMA</p>
                <p class="font-bold text-slate-900">Pengelola Kosify Management</p>
                
                <!-- Digital Stamp -->
                <div class="my-4 h-20 flex items-center justify-center">
                    <div class="border-2 border-emerald-600 text-emerald-700 bg-emerald-50 px-4 py-2 rounded-xl text-center rotate-[-3deg] shadow-sm">
                        <span class="block text-[10px] font-bold uppercase tracking-wider">KOSIFY INDONESIA</span>
                        <span class="block text-[8px] text-slate-500">DIGITALLY VERIFIED</span>
                        <span class="block text-[11px] font-black">SAH & BERKIKAT</span>
                    </div>
                </div>

                <p class="font-bold text-slate-800 underline">Pengelola Operasional</p>
            </div>

            <div>
                <p class="text-slate-500 mb-1">PIHAK KEDUA</p>
                <p class="font-bold text-slate-900">Penyewa Kamar</p>
                
                <!-- Signature Space -->
                <div class="my-4 h-20 flex items-center justify-center">
                    <div class="border-b border-dashed border-slate-300 w-36 text-center text-[10px] text-slate-400 pb-1 self-end">
                        (Tanda Tangan Digital)
                    </div>
                </div>

                <p class="font-bold text-slate-800 underline">{{ $user->name }}</p>
            </div>
        </div>

    </div>

</body>
</html>
