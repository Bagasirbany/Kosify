<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Baru - Kosify</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #eef1f5;
        }

        .ref-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 9.5px 14px;
            font-size: 13px;
            font-weight: 500;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .ref-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        .ref-input:focus {
            outline: none;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06);
            background: #ffffff;
        }

        .btn-primary-dark {
            width: 100%;
            background: #0f172a;
            color: #ffffff;
            border-radius: 12px;
            padding: 11px 20px;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15);
        }
        .btn-primary-dark:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.22);
        }

        .arrow-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .arrow-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            border-color: rgba(255, 255, 255, 0.6);
            transform: scale(1.05);
        }

        .social-link {
            color: #94a3b8;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .social-link:hover {
            color: #0f172a;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="h-full flex items-center justify-center p-3 md:p-6 lg:p-8">

    {{-- Main Container Card --}}
    <div class="w-full max-w-[1020px] h-[94vh] max-h-[640px] bg-white rounded-[32px] shadow-2xl shadow-slate-300/60 border border-slate-100 flex overflow-hidden">

        {{-- LEFT PANEL: Inset Photo Showcase --}}
        <div class="hidden lg:flex lg:w-[46%] p-3.5 flex-shrink-0">
            <div class="w-full h-full rounded-[24px] overflow-hidden relative flex flex-col justify-between p-6 bg-cover bg-center"
                 style="background-image: url('{{ asset('images/rooms/room_102.jpg') }}');">
                
                {{-- Cinematic Dark Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/85 z-0"></div>

                {{-- Left Header Navigation --}}
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-white font-bold text-sm tracking-wide">Selected Rooms</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-xs text-white/80 font-medium hover:text-white transition-colors px-2">Masuk</a>
                        <a href="{{ route('catalog.index') }}" class="text-xs font-semibold text-white bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md px-3.5 py-1 rounded-full transition-all">
                            Katalog
                        </a>
                    </div>
                </div>

                {{-- Left Bottom Profile / Room Pill & Arrows --}}
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-3 bg-black/30 backdrop-blur-md border border-white/15 rounded-full py-1.5 px-2.5 pr-4">
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-white/40 flex-shrink-0">
                            <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="Standard">
                        </div>
                        <div class="leading-none">
                            <p class="text-white font-bold text-xs">Kamar Standard</p>
                            <p class="text-white/60 text-[10px] mt-0.5 font-medium">Kosify Mahasiswa</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <button type="button" class="arrow-btn" aria-label="Previous">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button type="button" class="arrow-btn" aria-label="Next">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT PANEL: Clean Minimal Form --}}
        <div class="flex-1 flex flex-col justify-between p-6 sm:p-8 lg:p-9 lg:pl-8">

            {{-- Top Branding Header --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-7 w-auto">
                    <span class="text-slate-900 font-black text-base tracking-tight">KOSIFY</span>
                </a>

                <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 bg-slate-100/80 border border-slate-200/80 rounded-full px-3 py-1">
                    <span>🇮🇩 IDN</span>
                </div>
            </div>

            {{-- Center Form Content --}}
            <div class="w-full max-w-[360px] mx-auto my-auto py-1">
                
                {{-- Headings --}}
                <div class="text-center mb-4">
                    <h1 class="text-2xl sm:text-[26px] font-black text-slate-900 tracking-tight">
                        Buat Akun Baru 🏡
                    </h1>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">
                        Daftar akun untuk mulai reservasi kamar
                    </p>
                </div>

                {{-- Alerts --}}
                @if ($errors->any())
                    <div class="mb-3 px-3 py-2 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-2.5" data-turbo="false">
                    @csrf

                    <div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus placeholder="Nama Lengkap"
                               class="ref-input">
                    </div>

                    <div>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               required placeholder="Nomor WhatsApp"
                               class="ref-input">
                    </div>

                    <div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required placeholder="Email Aktif"
                               class="ref-input">
                    </div>

                    <div class="relative">
                        <input id="reg-password" type="password" name="password"
                               required placeholder="Password"
                               class="ref-input pr-10">
                        <button type="button" onclick="togglePass('reg-password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="relative">
                        <input id="reg-password-confirm" type="password" name="password_confirmation"
                               required placeholder="Konfirmasi Password"
                               class="ref-input pr-10">
                        <button type="button" onclick="togglePass('reg-password-confirm', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="btn-primary-dark mt-2">
                        Daftar Sekarang
                    </button>
                </form>

                <p class="text-center text-xs text-slate-500 mt-3 font-medium">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline ml-1">Masuk</a>
                </p>

            </div>

            {{-- Footer Social Icons --}}
            <div class="flex items-center justify-center gap-5 pt-1">
                <a href="{{ route('home') }}" class="social-link" title="Beranda">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.09961L1 12H4V21H10V14H14V21H20V12H23L12 2.09961Z"/>
                    </svg>
                </a>
                <a href="{{ route('catalog.index') }}" class="social-link" title="Katalog">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="social-link" title="WhatsApp">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.04 14.69 2 12.04 2M12.04 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.04 3.67Z"/>
                    </svg>
                </a>
            </div>

        </div>

    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            const open = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            const off = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            const svg = btn.querySelector('svg');
            if (input.type === 'password') { input.type = 'text'; svg.innerHTML = off; }
            else { input.type = 'password'; svg.innerHTML = open; }
        }
    </script>
</body>
</html>
