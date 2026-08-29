<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kosify') }} - Katalog Kamar</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Instant Page Switch: Speculation Rules -->
    <script type="speculationrules">
    {
      "prerender": [
        {
          "where": { "href_matches": "/*" },
          "eagerness": "moderate"
        }
      ],
      "prefetch": [
        {
          "where": { "href_matches": "/*" },
          "eagerness": "conservative"
        }
      ]
    }
    </script>

    <!-- Turbo Drive for Instant SPA-like Page Navigation -->
    <meta name="turbo-prefetch" content="true">
    <script type="module">
        import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
    </script>
    <style>
        .turbo-progress-bar {
            height: 3px;
            background-color: #0f172a;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-[#F3EFE7] text-slate-900 font-sans flex flex-col min-h-screen" x-data="{ mobileNav: false }">

    <!-- Header / Navbar -->
    <header class="bg-[#F3EFE7]/85 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify Logo" class="h-10 w-auto object-contain">
                </a>
                <nav class="hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-wider">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-500 hover:text-slate-900 transition' }}">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-500 hover:text-slate-900 transition' }}">Katalog</a>
                    <a href="{{ route('bookings.my') }}" class="{{ request()->routeIs('bookings.my') ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-500 hover:text-slate-900 transition' }}">Booking Saya</a>
                    <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.*') ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-500 hover:text-slate-900 transition' }}">Lapor Kendala</a>
                </nav>
            </div>
            
            <!-- Desktop Auth Menu -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 p-1.5 pl-3 pr-2.5 rounded-full border border-slate-300 hover:bg-slate-200/60 transition-colors focus:outline-none">
                            <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-slate-900 text-white">
                                {{ auth()->user()->role === 'admin' ? 'ADMIN' : 'PENYEWA' }}
                            </span>
                        </button>
                        <div x-show="open" x-cloak x-transition.opacity class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs font-bold text-slate-900">{{ auth()->user()->name }}</p>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">{{ auth()->user()->role === 'admin' ? 'ADMIN' : 'PENYEWA' }}</span>
                            </div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-xs font-bold text-indigo-700 hover:bg-indigo-50 uppercase tracking-wider">Dashboard Admin</a>
                            @endif
                            <a href="{{ route('bookings.my') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">Booking Saya</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50">Profil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 uppercase tracking-wider">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-slate-700 hover:text-slate-900 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="text-xs font-bold uppercase tracking-wider px-4 py-2 bg-slate-900 text-white rounded-full hover:bg-black transition-colors">Daftar</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile Toggle (Gambar 2 Reference) -->
            <button @click="mobileNav = !mobileNav" type="button" aria-label="Toggle Navigation Menu" class="md:hidden p-2 rounded-xl text-slate-800 hover:bg-slate-200/60 focus:outline-none transition-colors">
                <!-- 3 Horizontal Bars (Hamburger Icon) -->
                <svg x-show="!mobileNav" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>
                <!-- Close (X) Icon when open -->
                <svg x-show="mobileNav" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Mobile Backdrop Overlay -->
        <div x-show="mobileNav" x-cloak x-transition.opacity
             @click="mobileNav = false"
             class="fixed inset-0 top-16 bg-slate-900/40 backdrop-blur-xs z-40 md:hidden"></div>

        <!-- Floating Mobile Drawer (Transparan Frosted Glassmorphism) -->
        <div x-show="mobileNav" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             class="absolute top-full left-0 right-0 z-50 md:hidden border-t border-slate-300/80 bg-[#F3EFE7]/85 backdrop-blur-xl px-6 py-5 space-y-4 text-xs font-bold uppercase tracking-wider shadow-2xl rounded-b-3xl max-h-[calc(100vh-5rem)] overflow-y-auto">
            <a href="{{ route('home') }}" class="block text-slate-800 hover:text-black py-1">Beranda</a>
            <a href="{{ route('catalog.index') }}" class="block text-slate-800 hover:text-black py-1">Katalog</a>
            <a href="{{ route('bookings.my') }}" class="block text-slate-800 hover:text-black py-1">Booking Saya</a>
            <a href="{{ route('complaints.index') }}" class="block text-slate-800 hover:text-black py-1">Lapor Kendala</a>
            <div class="pt-4 border-t border-slate-300 space-y-2">
                @auth
                    <div class="p-3 bg-white/70 rounded-xl mb-2">
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block">AKUN LOGIN</span>
                        <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    </div>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="block py-2 text-xs font-bold text-indigo-700 bg-white/80 px-3 rounded-lg uppercase tracking-wider">Dashboard Admin &rarr;</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-xs font-semibold text-slate-700 hover:text-black">Profil Akun</a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-xs font-bold text-red-600 uppercase tracking-wider">Keluar (Logout)</button>
                    </form>
                @else
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('login') }}" class="w-1/2 py-2.5 text-center text-xs font-bold border border-slate-300 rounded-xl bg-white hover:bg-slate-100 uppercase tracking-wider">Masuk</a>
                        <a href="{{ route('register') }}" class="w-1/2 py-2.5 text-center text-xs font-bold bg-slate-900 text-white rounded-xl hover:bg-black uppercase tracking-wider">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer (TEXT-FIRST & BRIGHT THEME) -->
    <footer id="tentang-kami" class="bg-slate-50 text-slate-900 pt-16 pb-8 px-6 mt-16 border-t border-slate-200 scroll-mt-20" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-10 mb-14">
                
                <!-- Col 1: Logo & Tentang Kami Profile -->
                <div class="space-y-3">
                    <div>
                        <a href="{{ route('home') }}" class="inline-block mb-1">
                            <img src="{{ asset('images/logo.png') }}" alt="Kosify Logo" class="h-10 w-auto object-contain">
                        </a>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mt-2 mb-1">Tentang Kami</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Kosify adalah platform hunian kos modern terintegrasi yang menghadirkan kamar eksklusif dengan fasilitas lengkap, keamanan 24 jam, dan kemudahan booking online.
                        </p>
                    </div>
                </div>

                <!-- Col 2: Information -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-4">Informasi</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('home') }}#tentang-kami" class="hover:text-slate-900 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Katalog Kamar</a></li>
                        <li><a href="{{ route('home') }}#keunggulan" class="hover:text-slate-900 transition-colors">Keunggulan Layanan</a></li>
                        <li><a href="{{ route('home') }}#promo" class="hover:text-slate-900 transition-colors">Paket & Promo</a></li>
                    </ul>
                </div>

                <!-- Col 3: Helpful Links -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-4">Bantuan & Syarat</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Layanan Booking</a></li>
                        <li><a href="{{ route('home') }}#bantuan" class="hover:text-slate-900 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-slate-900 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-slate-900 transition-colors">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Col 4: Our Services -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-4">Layanan Kami</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Kamar Pilihan</a></li>
                        <li><a href="{{ route('bookings.my') }}" class="hover:text-slate-900 transition-colors">Sewa & Booking</a></li>
                        <li><a href="{{ route('complaints.index') }}" class="hover:text-slate-900 transition-colors">Lapor Kendala</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-900 transition-colors">Fasilitas Kos</a></li>
                    </ul>
                </div>

                <!-- Col 5: Contact Us & Socials -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-4">Hubungi Kami</h4>
                    <div class="space-y-2.5 text-xs mb-6 font-medium">
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-slate-400">WhatsApp / Telp:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6281234567890') }}?text={{ urlencode('Halo Owner Kosify, saya ingin bertanya tentang kamar kos.') }}" target="_blank" class="font-bold text-slate-800 hover:text-emerald-700 transition-colors">
                                {{ $webSettings['owner_phone'] ?? '+62 812-3456-7890' }}
                            </a>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-slate-400">Email Resmi:</span>
                            <a href="mailto:{{ $webSettings['owner_email'] ?? 'owner@kosify.com' }}" class="font-bold text-slate-800 hover:text-black transition-colors">
                                {{ $webSettings['owner_email'] ?? 'owner@kosify.com' }}
                            </a>
                        </div>
                    </div>

                    <!-- Social Links (Text Pills) -->
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <a href="#" class="px-2.5 py-1 rounded-md bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase transition-all">FB</a>
                        <a href="#" class="px-2.5 py-1 rounded-md bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase transition-all">IG</a>
                        <a href="#" class="px-2.5 py-1 rounded-md bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase transition-all">X</a>
                        <a href="#" class="px-2.5 py-1 rounded-md bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-[11px] font-bold uppercase transition-all">G+</a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Links -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-400 font-medium">
                <p>{{ date('Y') }} &copy; Kosify.Ltd | Hak Cipta Dilindungi</p>
                <div class="flex items-center gap-6 text-xs text-slate-500 font-semibold uppercase tracking-wider">
                    <a href="{{ route('home') }}#bantuan" class="hover:text-slate-900 transition-colors">FAQ</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Privasi</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <x-chatbot />
</body>
</html>
