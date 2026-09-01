<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk ke Akun - Kosify</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
            transition: all 0.2s ease;
        }
        .glass-input::placeholder { color: rgba(255, 255, 255, 0.45); }
        .glass-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.45);
        }

        /* Left panel photo */
        .left-panel {
            background-image: url('{{ asset('images/rooms/room_201.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        /* Slide indicator dots */
        .dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.35); }
        .dot.active { background: #fff; width: 20px; border-radius: 3px; }

        /* Eye toggle button */
        .eye-btn { color: rgba(255,255,255,0.5); transition: color 0.2s; }
        .eye-btn:hover { color: #fff; }

        /* Submit btn glow */
        .btn-submit {
            background: linear-gradient(135deg, #f8f5f0 0%, #e8e2da 100%);
            color: #1a1a1a;
            transition: all 0.2s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 28px rgba(0,0,0,0.3);
        }

        /* Subtle tab underline */
        .tab-active {
            border-bottom: 2px solid #fff;
            color: #fff;
        }
        .tab-inactive {
            border-bottom: 2px solid transparent;
            color: rgba(255,255,255,0.45);
        }

        /* Scrollbar hidden on mobile */
        body { overflow-x: hidden; }

        /* Photo overlay gradient */
        .photo-overlay {
            background: linear-gradient(
                to right,
                rgba(10, 15, 20, 0.55) 0%,
                rgba(10, 15, 20, 0.15) 50%,
                rgba(10, 15, 20, 0.0) 100%
            );
        }

        /* Dark badge room info */
        .room-badge {
            background: rgba(10, 12, 15, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeInUp 0.5s ease both; }
        .fade-up-1 { animation-delay: 0.05s; }
        .fade-up-2 { animation-delay: 0.12s; }
        .fade-up-3 { animation-delay: 0.18s; }
        .fade-up-4 { animation-delay: 0.24s; }
        .fade-up-5 { animation-delay: 0.30s; }
    </style>
</head>

<body class="min-h-screen bg-[#0f1217] flex">

    {{-- =========================================================
         LEFT PANEL — Photo with overlay info
    ========================================================= --}}
    <div class="hidden lg:flex lg:w-[55%] xl:w-[58%] relative left-panel flex-col">
        {{-- Dark gradient overlay --}}
        <div class="absolute inset-0 photo-overlay"></div>

        {{-- Top-left branding --}}
        <div class="relative z-10 p-10 flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-9 w-auto object-contain brightness-0 invert">
            <span class="text-white/80 text-sm font-bold tracking-widest uppercase">Kosify</span>
        </div>

        {{-- Center quote --}}
        <div class="relative z-10 flex-1 flex flex-col justify-center px-14">
            <span class="text-white/50 text-xs font-bold uppercase tracking-widest mb-4">Featured Property</span>
            <h2 class="text-white text-4xl xl:text-5xl font-black leading-tight tracking-tight mb-4">
                Temukan Hunian<br>Terbaik Anda
            </h2>
            <p class="text-white/65 text-sm font-medium leading-relaxed max-w-xs">
                Kamar kos modern dengan fasilitas premium. Nyaman untuk mahasiswa, pekerja, dan profesional muda.
            </p>
        </div>

        {{-- Bottom — Room info badge + photo dots --}}
        <div class="relative z-10 p-10">
            <div class="room-badge rounded-2xl p-4 inline-flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/rooms/room_201.jpg') }}" class="w-full h-full object-cover" alt="">
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Kamar Suite Eksekutif</p>
                    <p class="text-white/55 text-xs font-medium mt-0.5">Mulai dari Rp 2.100.000 / bulan</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="ml-4 text-white/70 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- Slide dots --}}
            <div class="flex items-center gap-2 mt-5">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         RIGHT PANEL — Frosted glass login form
    ========================================================= --}}
    <div class="flex-1 flex flex-col items-center justify-center min-h-screen px-6 py-12 relative"
         style="background: linear-gradient(145deg, #0f1217 0%, #151c26 60%, #0d1520 100%)">

        {{-- Background subtle blur blobs --}}
        <div class="absolute top-1/4 left-1/3 w-56 h-56 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-40 h-40 bg-sky-500/8 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Logo for mobile only --}}
        <div class="lg:hidden text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-10 w-auto object-contain brightness-0 invert">
                <span class="text-white font-black text-lg tracking-tight">Kosify</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="w-full max-w-[400px] glass-card rounded-3xl px-8 pt-8 pb-10 fade-up">

            {{-- Kosify logo mark (desktop) --}}
            <div class="hidden lg:flex items-center gap-2.5 mb-8 fade-up fade-up-1">
                <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="w-5 h-5 object-contain brightness-0 invert">
                </div>
                <span class="text-white font-black text-base tracking-tight">Kosify</span>
            </div>

            {{-- Tab nav: Masuk / Daftar --}}
            <div class="flex items-end gap-6 mb-8 fade-up fade-up-1">
                <button class="tab-active text-sm font-bold pb-2 transition-all">Masuk</button>
                <a href="{{ route('register') }}" class="tab-inactive text-sm font-bold pb-2 hover:text-white/70 transition-all">Daftar</a>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-5 px-4 py-3 rounded-2xl bg-rose-500/15 border border-rose-400/30 text-rose-300 text-xs font-bold">
                    <ul class="space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-5 px-4 py-3 rounded-2xl bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs font-bold">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4" data-turbo="false">
                @csrf

                {{-- Email --}}
                <div class="fade-up fade-up-2">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="nama@email.com"
                               class="glass-input w-full rounded-xl pl-11 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- Password --}}
                <div class="fade-up fade-up-3">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               placeholder="••••••••"
                               class="glass-input w-full rounded-xl pl-11 pr-12 py-3 text-sm font-medium">
                        <button type="button" onclick="togglePass('password', this)"
                                class="eye-btn absolute right-4 top-1/2 -translate-y-1/2">
                            {{-- Eye open icon --}}
                            <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Forgot password --}}
                    <div class="flex justify-end mt-2">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-white/45 hover:text-white/80 font-semibold transition-colors underline underline-offset-2">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-3 fade-up fade-up-4">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-white/20 bg-white/10 text-white focus:ring-white/30 cursor-pointer">
                    <label for="remember_me" class="text-xs text-white/55 font-semibold cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <div class="pt-2 fade-up fade-up-5">
                    <button type="submit" class="btn-submit w-full py-3.5 rounded-xl font-bold text-sm tracking-wide">
                        Masuk ke Akun
                    </button>
                </div>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-white/10"></div>
                <span class="text-white/30 text-xs font-semibold">atau lanjutkan dengan</span>
                <div class="flex-1 h-px bg-white/10"></div>
            </div>

            {{-- Social style button (WhatsApp owner contact) --}}
            <a href="{{ route('catalog.index') }}"
               class="w-full flex items-center justify-center gap-3 py-3 rounded-xl border border-white/12 text-white/70 hover:text-white hover:border-white/25 hover:bg-white/5 transition-all text-sm font-semibold">
                <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Lihat Katalog Kamar Terlebih Dahulu
            </a>

            {{-- Register link --}}
            <p class="text-center text-xs text-white/40 mt-7 font-medium">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-white font-bold hover:underline underline-offset-2 ml-1">Daftar Sekarang</a>
            </p>
        </div>

        {{-- Footer note --}}
        <p class="text-white/20 text-xs font-medium mt-8">
            &copy; 2026 Kosify Indonesia. All rights reserved.
        </p>
    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>`;
            } else {
                input.type = 'password';
                btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>`;
            }
        }
    </script>
</body>
</html>
