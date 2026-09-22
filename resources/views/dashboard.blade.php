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
            
        <!-- PENGINGAT JATUH TEMPO SEWA (DUE DATE REMINDER - Modern & Elegan) -->
        @if(isset($expiringLeases) && $expiringLeases->count() > 0)
            <div class="mb-8 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs">
                <div class="flex items-start justify-between gap-4 mb-4 pb-3 border-b border-slate-100 flex-wrap">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-amber-50 text-amber-800 border border-amber-200/70 mb-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Peringatan Jatuh Tempo
                        </div>
                        <h3 class="font-black text-slate-900 text-base">{{ $expiringLeases->count() }} Penyewa Mendekati Akhir Masa Sewa</h3>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Masa sewa tersisa kurang dari 7 hari. Segera konfirmasi perpanjangan sewa kepada penghuni.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
                    @foreach($expiringLeases as $lease)
                        <div class="bg-slate-50 hover:bg-slate-100/80 p-4 rounded-2xl border border-slate-200/80 shadow-2xs flex items-center justify-between gap-3 transition-colors">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-bold text-slate-900 text-xs truncate">{{ $lease->tenant_name }}</span>
                                    <span class="px-2 py-0.5 bg-white border border-slate-200 text-slate-700 text-[10px] font-bold rounded-md uppercase shrink-0">Kamar {{ $lease->room->room_number ?? '-' }}</span>
                                </div>
                                <div class="text-[11px] text-slate-500 font-medium">
                                    <span>Batas: <strong class="text-slate-800 font-semibold">{{ \Carbon\Carbon::parse($lease->calculated_end_date)->format('d M Y') }}</strong></span>
                                    @if($lease->days_left <= 0)
                                        <span class="text-rose-600 font-bold block text-[10px] mt-0.5">Jatuh Tempo Hari Ini</span>
                                    @else
                                        <span class="text-amber-600 font-bold block text-[10px] mt-0.5">Sisa {{ $lease->days_left }} Hari Lagi</span>
                                    @endif
                                </div>
                            </div>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $lease->tenant_phone ?? '6285815721534')) }}?text={{ urlencode('Halo Kak ' . $lease->tenant_name . ', kami dari pengelola Kosify ingin mengonfirmasi terkait sewa Kamar ' . ($lease->room->room_number ?? '') . ' yang akan berakhir pada tanggal ' . \Carbon\Carbon::parse($lease->calculated_end_date)->format('d M Y') . '. Apakah berencana untuk memperpanjang sewa bulan depan? Terima kasih.') }}" target="_blank" class="px-3.5 py-2 bg-slate-900 hover:bg-black text-white text-xs font-bold rounded-xl shrink-0 transition-colors shadow-xs inline-flex items-center gap-1.5">
                                <span>Hubungi</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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

        <!-- ROW 3: STATS OVERVIEW -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Status Pembayaran -->
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

            <!-- Card 2: Layanan Keluhan -->
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

            <!-- Card 3: Kepuasan Penghuni (Rating Kos) -->
            <div class="bg-white border border-slate-200 shadow-xs rounded-2xl p-6 flex flex-col justify-between">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">KEPUASAN PENGHUNI</span>
                    <span class="px-2.5 py-1 {{ isset($totalReviews) && $totalReviews > 0 ? 'bg-amber-50 border border-amber-200 text-amber-800' : 'bg-slate-100 border border-slate-200 text-slate-600' }} rounded-md text-[10px] font-black uppercase tracking-wider">
                        {{ isset($totalReviews) && $totalReviews > 0 ? ($averageRating >= 4.5 ? 'SANGAT BAIK' : 'BAIK') : 'BELUM ADA' }}
                    </span>
                </div>
                <div>
                    @if(isset($totalReviews) && $totalReviews > 0)
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">{{ number_format($averageRating, 1) }}</span>
                            <div class="flex items-center gap-1 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-amber-500 fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-2xl lg:text-3xl font-black text-slate-300 tracking-tight">-</span>
                            <div class="flex items-center gap-1 text-slate-200">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 text-slate-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                    @endif
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        TOTAL: <span class="text-slate-900 font-black">{{ $totalReviews ?? 0 }} ULASAN REALTIME</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- ROW 4: ULASAN & RATING PENGHUNI TERBARU -->
        <div class="bg-white border border-slate-200 shadow-xs rounded-3xl p-6 md:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">FEEDBACK & REPUTASI</span>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Ulasan & Rating Penghuni Terbaru</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-xl bg-slate-100 text-xs font-bold text-slate-700">
                        {{ $totalReviews ?? 0 }} Total Ulasan Masuk
                    </span>
                </div>
            </div>

            @if(isset($recentReviews) && $recentReviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recentReviews as $rev)
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-slate-300 transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($rev->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-900 truncate">{{ $rev->user->name ?? 'Penyewa Kos' }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $rev->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded bg-white border border-slate-200 text-[10px] font-black uppercase tracking-wider text-slate-800 shrink-0">
                                        KMR {{ $rev->room->room_number ?? '-' }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-1 text-amber-500 mb-2">
                                    <div class="flex items-center gap-0.5">
                                        @for($s = 1; $s <= 5; $s++)
                                            <svg class="w-3.5 h-3.5 {{ $s <= $rev->rating ? 'text-amber-500 fill-current' : 'text-slate-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-slate-600 font-bold ml-1 text-[11px]">{{ $rev->rating }}.0</span>
                                </div>

                                <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-3">
                                    "{{ $rev->comment }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <svg class="w-6 h-6 text-slate-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Ulasan Masuk</h3>
                    <p class="text-xs text-slate-500">Ulasan dan rating yang dikirimkan oleh penghuni akan tampil secara otomatis di sini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
