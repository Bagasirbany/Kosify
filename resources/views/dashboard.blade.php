<x-app-layout>
    <!-- Main wrapper with slate-50 background -->
    <div class="bg-slate-50 min-h-screen p-6 md:p-8 animate-[fadeIn_0.5s_ease-out] font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">DASHBOARD ADMIN</span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Ringkasan Analitik & Properti</h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-700 shadow-2xs">
                    PERIODE: {{ strtoupper(date('F Y')) }}
                </span>
            </div>
        </div>
            
        <!-- PENGINGAT JATUH TEMPO SEWA (DUE DATE REMINDER) -->
        @if(isset($expiringLeases) && $expiringLeases->count() > 0)
            <div class="mb-8 bg-amber-50 border border-amber-300 rounded-3xl p-6 shadow-xs">
                <div class="flex items-start justify-between gap-4 mb-4 flex-wrap">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-amber-800 bg-amber-200/70 px-2.5 py-1 rounded-md inline-block mb-2">
                            [ PERINGATAN JATUH TEMPO ]
                        </span>
                        <h3 class="font-black text-slate-900 text-base">{{ $expiringLeases->count() }} Penyewa Mendekati Akhir Masa Sewa</h3>
                        <p class="text-xs text-slate-600 font-medium mt-0.5">Masa sewa tersisa kurang dari 7 hari. Segera konfirmasi perpanjangan sewa.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 pt-2">
                    @foreach($expiringLeases as $lease)
                        <div class="bg-white p-4 rounded-2xl border border-amber-200 shadow-2xs flex items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-black text-slate-900 text-xs">{{ $lease->tenant_name }}</span>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-800 text-[10px] font-black rounded uppercase">KMR {{ $lease->room->room_number ?? '-' }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-1 font-medium">
                                    Habis: <strong class="text-slate-900 font-bold">{{ \Carbon\Carbon::parse($lease->calculated_end_date)->format('d M Y') }}</strong>
                                    @if($lease->days_left <= 0)
                                        <span class="text-red-600 font-black uppercase block text-[10px]">[ JATUH TEMPO ]</span>
                                    @else
                                        <span class="text-amber-700 font-bold block text-[10px]">({{ $lease->days_left }} HARI LAGI)</span>
                                    @endif
                                </p>
                            </div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lease->tenant_phone ?? '6281234567890') }}?text={{ urlencode('Halo Kak ' . $lease->tenant_name . ', kami dari pengelola Kosify ingin mengonfirmasi terkait sewa Kamar ' . ($lease->room->room_number ?? '') . ' yang akan berakhir pada tanggal ' . \Carbon\Carbon::parse($lease->calculated_end_date)->format('d M Y') . '. Apakah berencana untuk memperpanjang sewa bulan depan? Terima kasih.') }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-wider rounded-xl shrink-0 transition-colors shadow-xs">
                                WA &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- ROW 1: TOP SUMMARY GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
            <!-- Card 1 -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">TOTAL PENDAPATAN</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">BULAN INI</span>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-black text-slate-900 mb-2 tracking-tight">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        STATUS: <span class="text-emerald-600 font-black">TERVERIFIKASI</span>
                    </p>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">PENYEWA BARU</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 border border-indigo-200">TOTAL</span>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-black text-slate-900 mb-2 tracking-tight">{{ $penyewaBaru }} <span class="text-sm font-bold text-slate-400">ORANG</span></h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        STATUS: <span class="text-indigo-600 font-black">TERDAFTAR</span>
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">BOOKING AKTIF</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">SAAT INI</span>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-black text-slate-900 mb-2 tracking-tight">{{ $bookingAktif }} <span class="text-sm font-bold text-slate-400">UNIT</span></h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        STATUS: <span class="text-blue-600 font-black">BERJALAN</span>
                    </p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">PENGELUARAN</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-rose-50 text-rose-700 border border-rose-200">OPERASIONAL</span>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-black text-slate-900 mb-2 tracking-tight">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        STATUS: <span class="text-rose-600 font-black">TERCATAT</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- ROW 2: MIDDLE SECTION -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-6">
            <!-- Left Column: Stack 2 small vertical cards -->
            <div class="xl:col-span-1 flex flex-col gap-6">
                <!-- Occ Card 1 -->
                <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex-1 flex flex-col justify-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">TINGKAT OKUPANSI</span>
                    <h3 class="text-4xl font-black text-slate-900 mb-4 tracking-tight">{{ $okupansi }}%</h3>
                    <div class="space-y-2 border-t border-slate-100 pt-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                            <span class="text-slate-500">KAMAR TERISI:</span>
                            <span class="font-black text-slate-900">{{ $kamarTerisi }} UNIT</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                            <span class="text-slate-500">KAMAR KOSONG:</span>
                            <span class="font-black text-slate-900">{{ $kamarKosong }} UNIT</span>
                        </div>
                    </div>
                </div>
                <!-- Occ Card 2 -->
                <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex-1 flex flex-col justify-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">TOTAL KAMAR TERSEDIA</span>
                    <h3 class="text-4xl font-black text-slate-900 mb-1">{{ $totalKamar }}</h3>
                    <p class="text-xs font-semibold text-slate-500 mt-2">Kapasitas total properti kos</p>
                </div>
            </div>

            <!-- Right Column: Bar Chart -->
            <div class="xl:col-span-3 bg-white border border-slate-200 shadow-xs rounded-2xl p-6 lg:p-8 flex flex-col">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">GRAFIK PERFORMA</span>
                        <h2 class="text-lg font-black text-slate-900">Tren Pendapatan Bulanan</h2>
                    </div>
                    <span class="text-xs font-black uppercase tracking-wider text-slate-700 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                        TAHUN 2026
                    </span>
                </div>
                <!-- Bar Chart Wrapper -->
                <div class="flex-1 flex items-end gap-3 sm:gap-6 h-[220px] mt-auto relative">
                    <!-- Subtle Y-Axis Grid lines -->
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none z-0">
                        <div class="w-full border-t border-slate-100 h-0"></div>
                        <div class="w-full border-t border-slate-100 h-0"></div>
                        <div class="w-full border-t border-slate-100 h-0"></div>
                        <div class="w-full border-t border-slate-100 h-0"></div>
                        <div class="w-full border-t border-slate-200 h-0"></div>
                    </div>
                    
                    @foreach ($chartData as $month => $val)
                    <div class="relative flex-1 flex flex-col items-center justify-end h-full z-10 group">
                        <div class="w-full max-w-[3rem] bg-slate-900 hover:bg-black rounded-t-md transition-colors duration-200" 
                             style="height: {{ $val }}%;">
                        </div>
                        <span class="text-[10px] font-black uppercase text-slate-500 mt-3">{{ $month }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ROW 3: BOTTOM SECTION -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Square 1 -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">STATUS PEMBAYARAN</span>
                    <span class="px-2.5 py-1 bg-emerald-50 border border-emerald-200 rounded-md text-[10px] font-black uppercase tracking-wider text-emerald-800">
                        LANCAR
                    </span>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900 mb-1">Semua Pembayaran Lunas</h3>
                    <p class="text-xs font-semibold text-slate-500 mt-2">Tidak ada tagihan sewa tertunda untuk periode berjalan ini.</p>
                </div>
            </div>

            <!-- Square 2 -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">LAYANAN KELUHAN</span>
                    <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 rounded-md text-[10px] font-black uppercase tracking-wider text-slate-800">
                        MONITORING
                    </span>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900 mb-1">Respon Cepat 24 Jam</h3>
                    <p class="text-xs font-semibold text-slate-500 mt-2">Gunakan menu Lapor Kendala untuk memantau keluhan fasilitas penyewa.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
