<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kosify') }} - Platform Pencarian Kos Modern</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
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
<body class="antialiased bg-white text-slate-900 font-sans selection:bg-slate-900 selection:text-white flex flex-col min-h-screen" 
      x-data="{ 
          mobileMenu: false,
          activeSection: window.location.hash ? window.location.hash.replace('#', '') : 'beranda',
          init() {
              const sections = ['beranda', 'keunggulan', 'tentang-kami'];
              const updateActive = () => {
                  const scrollPos = window.scrollY + 180;
                  let current = 'beranda';
                  for (let i = 0; i < sections.length; i++) {
                      const el = document.getElementById(sections[i]);
                      if (el) {
                          const top = el.getBoundingClientRect().top + window.scrollY;
                          if (scrollPos >= top) {
                              current = sections[i];
                          }
                      }
                  }
                  this.activeSection = current;
              };
              window.addEventListener('scroll', updateActive, { passive: true });
              window.addEventListener('hashchange', () => {
                  if (window.location.hash) {
                      this.activeSection = window.location.hash.replace('#', '');
                  }
              });
              this.$nextTick(() => updateActive());
          }
      }">

    <!-- ============ NAVBAR ============ -->
    <nav class="sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between gap-8">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify Logo" class="h-12 w-auto object-contain">
            </a>

            <!-- Center Links with Dynamic ScrollSpy Active Indicator -->
            <div class="hidden lg:flex items-center gap-8 text-xs font-black uppercase tracking-wider">
                <a href="{{ route('home') }}#beranda" 
                   @click="activeSection = 'beranda'"
                   :class="activeSection === 'beranda' ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-400 hover:text-slate-700'"
                   class="transition-all duration-200">
                    Beranda
                </a>
                <a href="{{ route('home') }}#keunggulan" 
                   @click="activeSection = 'keunggulan'"
                   :class="activeSection === 'keunggulan' ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-400 hover:text-slate-700'"
                   class="transition-all duration-200">
                    Keunggulan
                </a>
                <a href="{{ route('home') }}#tentang-kami" 
                   @click="activeSection = 'tentang-kami'"
                   :class="activeSection === 'tentang-kami' ? 'text-slate-900 border-b-2 border-slate-900 pb-0.5' : 'text-slate-400 hover:text-slate-700'"
                   class="transition-all duration-200">
                    Tentang Kami
                </a>
            </div>

            <!-- Desktop Right Actions -->
            <div class="hidden lg:flex items-center gap-4 justify-end">
                @if (Route::has('login'))
                    @auth
                        <div class="relative" x-data="{ userMenu: false }">
                            <button @click="userMenu = !userMenu" @click.away="userMenu = false" class="flex items-center gap-2 p-1 pl-3 pr-2.5 rounded-full border border-slate-300 hover:border-slate-400 hover:bg-slate-50 transition-all focus:outline-none shadow-2xs">
                                <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-slate-900 text-white">
                                    {{ auth()->user()->role === 'admin' ? 'ADMIN' : 'PENYEWA' }}
                                </span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="userMenu" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50">
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-xs font-bold text-indigo-700 hover:bg-indigo-50 transition-colors uppercase tracking-wider">
                                            [ DASHBOARD ADMIN ]
                                        </a>
                                    @else
                                        <a href="{{ route('bookings.my') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                            Booking Saya
                                        </a>
                                        <a href="{{ route('complaints.index') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                            Lapor Kendala
                                        </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                        Profil Akun
                                    </a>
                                </div>

                                <div class="border-t border-slate-100 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors uppercase tracking-wider">
                                            KELUAR (LOGOUT)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-slate-700 hover:text-black transition-colors px-3 py-2">Masuk</a>
                            <a href="{{ route('register') }}" class="text-xs font-bold uppercase tracking-wider px-5 py-2.5 bg-black text-white rounded-full hover:bg-slate-800 transition-colors flex-shrink-0">Daftar</a>
                        </div>
                    @endauth
                @endif
            </div>

            <!-- Mobile Menu Hamburger Button (Gambar 2 Reference) -->
            <button @click="mobileMenu = !mobileMenu" type="button" aria-label="Toggle Navigation Menu" class="lg:hidden p-2 rounded-xl text-slate-800 hover:bg-slate-100/80 focus:outline-none transition-colors">
                <!-- 3 Horizontal Bars (Hamburger Icon) -->
                <svg x-show="!mobileMenu" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                    <line x1="4" y1="6" x2="20" y2="6"></line>
                    <line x1="4" y1="12" x2="20" y2="12"></line>
                    <line x1="4" y1="18" x2="20" y2="18"></line>
                </svg>
                <!-- Close (X) Icon when open -->
                <svg x-show="mobileMenu" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Mobile Backdrop Overlay -->
        <div x-show="mobileMenu" x-cloak x-transition.opacity
             @click="mobileMenu = false"
             class="fixed inset-0 top-20 bg-slate-900/40 backdrop-blur-xs z-40 lg:hidden"></div>

        <!-- Floating Mobile Drawer (Transparan Frosted Glassmorphism) -->
        <div x-show="mobileMenu" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             class="absolute top-full left-0 right-0 z-50 lg:hidden border-t border-slate-200/60 bg-white/80 backdrop-blur-xl px-6 py-5 space-y-4 text-xs font-bold uppercase tracking-wider shadow-2xl rounded-b-3xl max-h-[calc(100vh-6rem)] overflow-y-auto">
            <a href="{{ route('home') }}#beranda" 
               @click="activeSection = 'beranda'; mobileMenu = false" 
               :class="activeSection === 'beranda' ? 'text-slate-900 font-black bg-slate-100/90 px-3.5 py-2 rounded-xl' : 'text-slate-600 hover:text-slate-900 px-3.5 py-1.5'"
               class="block transition-all">
                Beranda
            </a>
            <a href="{{ route('home') }}#keunggulan" 
               @click="activeSection = 'keunggulan'; mobileMenu = false" 
               :class="activeSection === 'keunggulan' ? 'text-slate-900 font-black bg-slate-100/90 px-3.5 py-2 rounded-xl' : 'text-slate-600 hover:text-slate-900 px-3.5 py-1.5'"
               class="block transition-all">
                Keunggulan
            </a>
            <a href="{{ route('home') }}#tentang-kami" 
               @click="activeSection = 'tentang-kami'; mobileMenu = false" 
               :class="activeSection === 'tentang-kami' ? 'text-slate-900 font-black bg-slate-100/90 px-3.5 py-2 rounded-xl' : 'text-slate-600 hover:text-slate-900 px-3.5 py-1.5'"
               class="block transition-all">
                Tentang Kami
            </a>
            <a href="{{ route('catalog.index') }}" 
               @click="mobileMenu = false"
               class="block text-slate-600 hover:text-slate-900 px-3.5 py-1.5 transition-all">
                Katalog Kamar
            </a>
            
            <div class="pt-4 border-t border-slate-200/60 space-y-2">
                @auth
                    <div class="p-3.5 bg-white/60 backdrop-blur-md rounded-2xl border border-slate-200/60 mb-3 shadow-2xs">
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block">AKUN ANDA</span>
                        <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-block text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 mt-1 rounded bg-slate-900 text-white">
                            {{ auth()->user()->role === 'admin' ? 'ADMINISTRATOR' : 'PENYEWA' }}
                        </span>
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="block py-2 text-xs font-bold text-indigo-700 bg-indigo-50/80 px-3 rounded-xl uppercase tracking-wider">
                            Dashboard Admin &rarr;
                        </a>
                    @else
                        <a href="{{ route('bookings.my') }}" class="block py-2 text-xs font-semibold text-slate-800 hover:text-black">
                            Booking Saya
                        </a>
                        <a href="{{ route('complaints.index') }}" class="block py-2 text-xs font-semibold text-slate-800 hover:text-black">
                            Lapor Kendala
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block py-2 text-xs font-semibold text-slate-800 hover:text-black">
                        Profil Akun
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-xs font-bold text-red-600 uppercase tracking-wider">
                            Keluar (Logout)
                        </button>
                    </form>
                @else
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('login') }}" class="w-1/2 py-2.5 text-center text-xs font-bold border border-slate-300/80 rounded-xl bg-white/70 hover:bg-white text-slate-800 uppercase tracking-wider">Masuk</a>
                        <a href="{{ route('register') }}" class="w-1/2 py-2.5 text-center text-xs font-bold bg-slate-900 text-white rounded-xl hover:bg-black uppercase tracking-wider">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- ============ FOOTER (TEXT-FIRST & BRIGHT THEME) ============ -->
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
