<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Kamar - Kosify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>

    <!-- Fast Navigation & Premium Animations -->
    <meta name="turbo-prefetch" content="true">
    <script type="module">
        import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
    </script>
    <style>
        /* Smooth Page Transition */
        body {
            animation: fadeIn 0.4s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        /* Turbo Progress Bar */
        .turbo-progress-bar {
            height: 3px;
            background-color: #059669;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Topbar -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between gap-6">
            <div class="flex items-center gap-8">
                <a href="/" class="text-2xl font-black tracking-tight text-emerald-700 flex items-center gap-2">
                    <span class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white text-lg shadow-md shadow-emerald-600/20"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></span>
                    Kosify
                </a>
                <div class="hidden md:flex items-center gap-6 text-xs font-bold">
                    <a href="{{ route('catalog.index') }}" class="text-emerald-700 border-b-2 border-emerald-600 pb-0.5">Catalog</a>
                    <a href="{{ route('bookings.my') }}" class="text-slate-600 hover:text-emerald-700 transition">My Bookings</a>
                    <a href="{{ route('account.settings') }}" class="text-slate-600 hover:text-emerald-700 transition">Profile</a>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative w-72 max-w-full hidden sm:block">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></span>
                    <input type="text" placeholder="Cari area atau nama kos..."
                           class="w-full pl-9 pr-4 py-2 rounded-full border border-slate-200 bg-slate-100/70 text-xs text-slate-700 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all">
                </div>
                <button class="w-9 h-9 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 transition border border-slate-200/80"><svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></button>
                <button class="w-9 h-9 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-100 transition border border-slate-200/80">❓</button>
                <button class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold px-4 py-2.5 rounded-xl shadow-md shadow-emerald-600/20 whitespace-nowrap transition-all">
                    List a Property
                </button>
                <img src="{{ auth()->user()->avatar ?? '' }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=059669&color=fff'"
                     class="w-9 h-9 rounded-full object-cover border-2 border-emerald-500/30" alt="User">
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar filter -->
            <aside class="col-span-1">
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sticky top-20 shadow-sm space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-extrabold text-slate-900 text-sm">Filter</h3>
                        <a href="#" class="text-emerald-700 text-xs font-bold hover:underline">Reset</a>
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <p class="text-[11px] font-black text-slate-400 tracking-wider uppercase mb-2">LOKASI</p>
                        <select class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all">
                            <option>Semua Lokasi</option>
                            <option>Jakarta Selatan</option>
                            <option>Bandung</option>
                            <option>Yogyakarta</option>
                            <option>Surabaya</option>
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <p class="text-[11px] font-black text-slate-400 tracking-wider uppercase mb-3">HARGA (RP/BULAN)</p>
                        <div class="space-y-2.5 text-xs font-semibold text-slate-700">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                &lt; 1.5 Juta
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" checked class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                1.5 - 3 Juta
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                3 - 5 Juta
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                &gt; 5 Juta
                            </label>
                        </div>
                    </div>

                    <!-- Tipe Kamar -->
                    <div>
                        <p class="text-[11px] font-black text-slate-400 tracking-wider uppercase mb-3">TIPE KAMAR</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-emerald-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-xs cursor-pointer">Studio</span>
                            <span class="border border-slate-200 text-slate-600 text-xs font-bold px-3.5 py-1.5 rounded-full hover:bg-slate-50 transition cursor-pointer">Single</span>
                            <span class="border border-slate-200 text-slate-600 text-xs font-bold px-3.5 py-1.5 rounded-full hover:bg-slate-50 transition cursor-pointer">Exclusive</span>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div>
                        <p class="text-[11px] font-black text-slate-400 tracking-wider uppercase mb-3">FASILITAS UTAMA</p>
                        <div class="space-y-2.5 text-xs font-semibold text-slate-700">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" checked class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                WiFi Cepat
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" checked class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                Air Conditioner (AC)
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                Kamar Mandi Dalam
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                Parkir Mobil
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Room grid -->
            <div class="lg:col-span-3 space-y-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pilihan Kamar Populer</h1>
                    <div class="text-xs font-semibold text-slate-500">
                        Urutkan: <span class="font-extrabold text-emerald-700 cursor-pointer">Terbaru ▾</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $rooms = [
                            [
                                'nama' => 'Emerald Residence Dago', 'lokasi' => 'Bandung, Jawa Barat', 'rating' => 4.8,
                                'harga' => 2500000, 'fasilitas' => ['WiFi', 'AC', 'KM Dalam'],
                                'status' => 'Tersedia', 'tipe' => 'Studio',
                                'foto' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=500&q=80',
                                'cta' => 'Detail',
                            ],
                            [
                                'nama' => 'Urban Nest Kuningan', 'lokasi' => 'Jakarta Selatan', 'rating' => 4.9,
                                'harga' => 1850000, 'fasilitas' => ['WiFi', 'AC', 'Dapur'],
                                'status' => 'Hampir Penuh', 'tipe' => 'Single',
                                'foto' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=500&q=80',
                                'cta' => 'Detail',
                            ],
                            [
                                'nama' => 'The Loft Condongcatur', 'lokasi' => 'Yogyakarta', 'rating' => 4.7,
                                'harga' => 3200000, 'fasilitas' => ['WiFi', 'AC', 'Parkir'],
                                'status' => 'Tersedia', 'tipe' => 'Exclusive',
                                'foto' => 'https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?auto=format&fit=crop&w=500&q=80',
                                'cta' => 'Detail',
                            ],
                            [
                                'nama' => 'Student Hub Gading', 'lokasi' => 'Surabaya, Jawa Timur', 'rating' => 4.5,
                                'harga' => 1200000, 'fasilitas' => ['WiFi', 'AC'],
                                'status' => 'Penuh', 'tipe' => 'Single',
                                'foto' => 'https://images.unsplash.com/photo-1596162954151-cdcb4c0f70fb?auto=format&fit=crop&w=500&q=80',
                                'cta' => 'Waiting List',
                            ],
                        ];

                        $statusColor = [
                            'Tersedia' => 'bg-emerald-600',
                            'Hampir Penuh' => 'bg-rose-500',
                            'Penuh' => 'bg-slate-800',
                        ];

                        $iconFasilitas = [
                            'WiFi' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>', 'AC' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'KM Dalam' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>', 'Dapur' => '🍴', 'Parkir' => '🅿️',
                        ];
                    @endphp

                    @foreach ($rooms as $room)
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="relative overflow-hidden">
                                <img src="{{ $room['foto'] }}" alt="{{ $room['nama'] }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span class="{{ $statusColor[$room['status']] }} text-white text-[11px] font-black px-3 py-1 rounded-full shadow-xs">
                                        {{ $room['status'] }}
                                    </span>
                                    <span class="bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-black px-3 py-1 rounded-full">
                                        {{ $room['tipe'] }}
                                    </span>
                                </div>
                                <button class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center text-xs shadow-sm hover:bg-white transition">
                                    🤍
                                </button>
                            </div>
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="font-extrabold text-slate-900 text-sm leading-tight pr-2">{{ $room['nama'] }}</h3>
                                    <span class="flex items-center gap-1 text-amber-500 text-xs font-black whitespace-nowrap">
                                        ★ {{ number_format($room['rating'], 1) }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 font-medium mb-3"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ $room['lokasi'] }}</p>

                                <div class="flex gap-2.5 text-xs text-slate-600 border-b border-slate-100 pb-3 mb-3 font-semibold flex-wrap">
                                    @foreach ($room['fasilitas'] as $f)
                                        <span class="bg-slate-50 px-2 py-0.5 rounded-md border border-slate-100 flex items-center gap-1">{!! $iconFasilitas[$f] ?? '' !!} {{ $f }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="px-4 pb-4 flex items-end justify-between">
                            <div>
                                <p class="text-[11px] font-semibold text-slate-400">Mulai dari</p>
                                <p class="text-base font-black text-emerald-700">
                                    Rp {{ number_format($room['harga'], 0, ',', '.') }}
                                    <span class="text-xs font-semibold text-slate-400">/bln</span>
                                </p>
                            </div>
                            @if ($room['cta'] === 'Detail')
                                <button class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold px-4 py-2 rounded-xl shadow-xs transition">
                                    Detail
                                </button>
                            @else
                                <button class="bg-slate-300 text-slate-600 text-xs font-bold px-4 py-2 rounded-xl cursor-not-allowed">
                                    Waiting List
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center items-center gap-2 pt-4">
                    <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 flex items-center justify-center font-bold hover:bg-slate-50 transition">‹</button>
                    <button class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-black flex items-center justify-center shadow-xs">1</button>
                    <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 transition">2</button>
                    <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 transition">3</button>
                    <span class="text-slate-400 px-1 font-bold">...</span>
                    <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 transition">12</button>
                    <button class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 flex items-center justify-center font-bold hover:bg-slate-50 transition">›</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>