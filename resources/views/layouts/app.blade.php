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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
        <!-- Fast Navigation & Premium Animations -->
        <meta name="turbo-prefetch" content="true">
        <script type="module">
            import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
        </script>
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
                <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center justify-between sticky top-0 z-30 shrink-0">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Sidebar Toggle (Gambar 2 Reference) -->
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
                    
                    <div class="flex items-center gap-3">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 border border-slate-200 rounded-xl px-3 py-1.5 hover:bg-slate-50 transition-colors text-xs font-bold text-slate-800">
                                <span class="w-6 h-6 rounded-md bg-slate-900 text-white flex items-center justify-center text-[10px] font-black">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                                </span>
                                <span class="hidden sm:inline font-bold uppercase tracking-wider">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <span class="text-[10px] text-slate-400">▼</span>
                            </button>
                            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 text-xs z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 block">ROLE PENGGUNA</span>
                                    <p class="font-bold text-slate-900 uppercase tracking-wider">{{ auth()->user()->role ?? 'ADMIN' }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 font-bold uppercase tracking-wider text-slate-700 hover:bg-slate-50">
                                    Profil Saya
                                </a>

                                <a href="/" class="block px-4 py-2 font-bold uppercase tracking-wider text-slate-700 hover:bg-slate-50">
                                    Ke Halaman Beranda &rarr;
                                </a>

                                <hr class="my-1 border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 font-black uppercase tracking-wider text-rose-600 hover:bg-rose-50">
                                        KELUAR [ LOGOUT ]
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
            document.addEventListener('turbo:load', function () {
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
            });
        </script>
    </body>
</html>
