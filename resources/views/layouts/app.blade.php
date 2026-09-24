<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kosify Admin') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
            /* Turbo Progress Bar */
            .turbo-progress-bar {
                height: 3px;
                background-color: #0f172a;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        
        <!-- Global Dashboard Layout -->
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-slate-50">
            
            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" x-transition.opacity 
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 lg:hidden"
                 @click="sidebarOpen = false" style="display: none;"></div>

            <!-- Sidebar Container -->
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                 class="fixed inset-y-0 left-0 w-64 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:flex-shrink-0 h-full overflow-y-auto border-r border-slate-200 bg-white shadow-xs z-50">
                @include('layouts.navigation')
            </div>

            <!-- Main Content Container -->
            <div class="flex-1 h-full overflow-y-auto flex flex-col relative w-full lg:w-auto">
                
                <!-- Topbar (Text-First) -->
                <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex items-center justify-between sticky top-0 z-30 shrink-0">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Sidebar Toggle -->
                        <button @click="sidebarOpen = true" type="button" aria-label="Buka Menu Sidebar" class="lg:hidden p-2 rounded-xl text-slate-800 hover:bg-slate-100 focus:outline-none transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="18" x2="20" y2="18"></line>
                            </svg>
                        </button>
                        
                        <div class="hidden sm:block">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">PANEL ADMINISTRATOR</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 sm:gap-3">
                        <!-- Direct Language Switcher (Segmented Button, No Dropdown) -->
                        <div class="flex items-center gap-0.5 bg-slate-100/90 p-1 rounded-full border border-slate-200 text-xs font-bold">
                            <span class="pl-1.5 pr-0.5 text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </span>
                            <a href="{{ route('lang.switch', 'id') }}" 
                               title="Bahasa Indonesia"
                               class="px-2.5 py-1 rounded-full transition-all duration-200 cursor-pointer {{ app()->getLocale() === 'id' ? 'bg-slate-900 text-white shadow-xs font-black' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                                ID
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" 
                               title="English"
                               class="px-2.5 py-1 rounded-full transition-all duration-200 cursor-pointer {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white shadow-xs font-black' : 'text-slate-500 hover:text-slate-900 font-semibold' }}">
                                EN
                            </a>
                        </div>

                        <!-- Direct Logout Button -->
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('topbar-logout-form').submit();" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200/60 rounded-xl transition-all shadow-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>{{ __('messages.nav_logout') }}</span>
                        </a>
                        <form id="topbar-logout-form" method="POST" action="{{ route('logout') }}" class="hidden" data-turbo="false">
                            @csrf
                        </form>

                        <!-- Profile Dropdown (Sama Persis dengan Tampilan User Navbar) -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-slate-300 hover:border-slate-400 hover:bg-slate-100 transition-all focus:outline-none select-none cursor-pointer">
                                <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-cloak x-transition.opacity style="display: none;" class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 text-xs z-50">
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <p class="text-xs font-black text-slate-900 leading-none">{{ auth()->user()->name ?? 'Admin' }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium mt-1 truncate">{{ auth()->user()->email ?? 'admin@kosify.id' }}</p>
                                    @if(in_array(auth()->user()->role, ['pemilik', 'admin', 'owner']))
                                        <span class="inline-block mt-2 px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Pemilik Kos
                                        </span>
                                    @elseif(auth()->user()->role === 'admin_web')
                                        <span class="inline-block mt-2 px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            Admin Web (IT)
                                        </span>
                                    @else
                                        <span class="inline-block mt-2 px-2.5 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                            Penyewa
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                    Profil Saya
                                </a>

                                <a href="{{ route('catalog.index') }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                    Katalog Kamar &rarr;
                                </a>

                                <a href="/" class="block px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                    Ke Halaman Beranda &rarr;
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" data-turbo="false">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Header Template -->
                @if (isset($header))
                    <div class="px-6 md:px-8 py-5 border-b border-slate-200 bg-white shrink-0">
                        {{ $header }}
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-6 md:p-8">
                    {{ $slot }}
                </main>

                <!-- Footer (Text-First) -->
                <footer class="bg-white border-t border-slate-200 text-xs text-slate-500 py-4 px-6 md:px-8 mt-auto flex flex-col sm:flex-row justify-between items-center z-10 gap-2 font-medium">
                    <div class="uppercase tracking-wider text-[11px] font-bold text-slate-600">
                        &copy; 2026 KOSIFY INDONESIA. ALL RIGHTS RESERVED.
                    </div>
                    <div class="flex items-center gap-4 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <span>SISTEM OPERASIONAL PROPERTI</span>
                    </div>
                </footer>

            </div>
        </div>
        
        <!-- SweetAlert2 Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function initAdminAlerts() {
                @if(session('success'))
                    Swal.fire({
                        title: 'BERHASIL',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true,
                        position: 'top-end',
                        customClass: { popup: 'rounded-xl font-sans' }
                    });
                @endif
                
                @if(session('error'))
                    Swal.fire({
                        title: 'PERHATIAN',
                        text: '{{ session('error') }}',
                        toast: true,
                        position: 'top-end',
                        customClass: { popup: 'rounded-xl font-sans' }
                    });
                @endif
            }
            document.addEventListener('DOMContentLoaded', initAdminAlerts);
            document.addEventListener('turbo:load', initAdminAlerts);
        </script>
    </body>
</html>
