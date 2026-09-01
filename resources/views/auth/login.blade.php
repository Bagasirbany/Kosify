<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk ke Akun - Kosify</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Page background — light like website */
        body { background: #f0f2f5; min-height: 100vh; }

        /* Floating photo card */
        .photo-card {
            background-image: url('{{ asset('images/rooms/room_201.jpg') }}');
            background-size: cover;
            background-position: center;
            border-radius: 28px;
            overflow: hidden;
            position: relative;
        }

        .photo-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(8, 12, 20, 0.20) 0%,
                rgba(8, 12, 20, 0.55) 60%,
                rgba(8, 12, 20, 0.90) 100%
            );
        }

        /* White form panel */
        .form-panel {
            background: #ffffff;
        }

        /* Clean input */
        .clean-input {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            color: #0f172a;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 16px;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .clean-input::placeholder { color: #94a3b8; font-weight: 400; }
        .clean-input:focus {
            outline: none;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15,23,42,0.07);
        }

        /* Pill input with icon */
        .icon-input-wrap { position: relative; }
        .icon-input-wrap .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            pointer-events: none;
        }
        .icon-input-wrap .clean-input { padding-left: 42px; }

        /* Submit button */
        .btn-login {
            background: #0f172a;
            color: #fff;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.01em;
            width: 100%;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-login:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(15,23,42,0.22);
        }

        /* Secondary button */
        .btn-secondary {
            background: #fff;
            color: #334155;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            width: 100%;
            transition: border-color 0.2s, background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-secondary:hover {
            border-color: #94a3b8;
            background: #f8fafc;
        }

        /* Room info badge */
        .room-badge {
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.20);
            border-radius: 18px;
        }

        /* Slide dot */
        .sdot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.35); transition: all 0.3s; }
        .sdot.on { width: 22px; border-radius: 3px; background: #fff; }

        /* Slide nav btn */
        .slide-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.22);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.75);
            transition: background 0.2s;
        }
        .slide-btn:hover { background: rgba(255,255,255,0.22); color: #fff; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fu { animation: fadeUp 0.4s ease both; }
        .d1{animation-delay:.04s} .d2{animation-delay:.09s} .d3{animation-delay:.14s}
        .d4{animation-delay:.19s} .d5{animation-delay:.24s} .d6{animation-delay:.29s}
    </style>
</head>

<body class="flex items-center justify-center p-4 md:p-6 lg:p-8">

    {{-- ===== OUTER WRAPPER ===== --}}
    <div class="w-full max-w-[1100px] flex items-stretch gap-0 min-h-[600px] lg:min-h-[680px] shadow-2xl rounded-[32px] overflow-hidden">

        {{-- ===== LEFT — Floating Photo Card ===== --}}
        <div class="hidden lg:block lg:w-[48%] xl:w-[46%] photo-card flex-shrink-0">
            <div class="photo-card-overlay"></div>

            {{-- Top nav row --}}
            <div class="relative z-10 flex items-center justify-between p-7 pb-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-8 w-auto brightness-0 invert opacity-90">
                    <span class="text-white font-black text-base tracking-tight">Kosify</span>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('catalog.index') }}"
                       class="text-xs text-white/70 font-semibold hover:text-white transition-colors">
                        Katalog
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-xs text-white font-bold bg-white/15 hover:bg-white/25 border border-white/20 px-4 py-1.5 rounded-full transition-all">
                        Daftar
                    </a>
                </div>
            </div>

            {{-- Center — spacer --}}
            <div class="relative z-10 flex-1 flex flex-col justify-end p-7 h-full" style="min-height: calc(100% - 80px)">

                {{-- Headline --}}
                <div class="mb-6">
                    <span class="text-white/50 text-[10px] font-bold uppercase tracking-widest block mb-3">Featured Property</span>
                    <h2 class="text-white text-3xl xl:text-[38px] font-black leading-[1.15] tracking-tight mb-3">
                        Temukan Hunian<br>Terbaik Anda
                    </h2>
                    <p class="text-white/60 text-sm font-medium leading-relaxed max-w-[260px]">
                        Kamar kos modern, fasilitas premium, lokasi strategis. Nyaman untuk mahasiswa & profesional.
                    </p>
                </div>

                {{-- Room badge + slide controls --}}
                <div class="room-badge p-4 flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/rooms/room_201.jpg') }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-bold text-sm truncate">Kamar Suite Eksekutif</p>
                        <p class="text-white/55 text-xs font-medium mt-0.5">Mulai Rp 2.100.000 / bulan</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button class="slide-btn">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button class="slide-btn">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Dots --}}
                <div class="flex items-center gap-2">
                    <div class="sdot on"></div>
                    <div class="sdot"></div>
                    <div class="sdot"></div>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT — White Form Panel ===== --}}
        <div class="form-panel flex-1 flex flex-col">

            {{-- Top right branding (desktop) --}}
            <div class="hidden lg:flex items-center justify-between px-10 pt-8 pb-0">
                <span class="text-slate-900 font-black text-lg tracking-tight">KOSIFY</span>
                <a href="{{ route('catalog.index') }}"
                   class="text-xs font-bold text-slate-500 hover:text-slate-900 uppercase tracking-wider transition-colors">
                    Lihat Katalog →
                </a>
            </div>

            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center justify-center pt-8 pb-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-9 w-auto">
                    <span class="text-slate-900 font-black text-lg">Kosify</span>
                </a>
            </div>

            {{-- Form center --}}
            <div class="flex-1 flex flex-col justify-center px-8 md:px-12 lg:px-14 xl:px-16 py-8">

                {{-- Headline --}}
                <div class="mb-7 fu d1">
                    <h1 class="text-3xl xl:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-2">
                        Halo, Selamat<br>Datang 👋
                    </h1>
                    <p class="text-slate-500 text-sm font-medium">Masuk ke akun Kosify Anda</p>
                </div>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4" data-turbo="false">
                    @csrf

                    {{-- Email --}}
                    <div class="fu d2">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="nama@email.com"
                               class="clean-input">
                    </div>

                    {{-- Password --}}
                    <div class="fu d3">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-semibold text-slate-400 hover:text-slate-900 underline underline-offset-2 transition-colors">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="clean-input pr-12">
                            <button type="button" onclick="togglePass('password', this)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center gap-2.5 fu d3">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                        <label for="remember_me" class="text-xs text-slate-500 font-medium cursor-pointer select-none">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="fu d4">
                        <button type="submit" class="btn-login">
                            Masuk ke Akun
                        </button>
                    </div>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-3 my-5 fu d5">
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <span class="text-slate-400 text-xs font-semibold">atau</span>
                    <div class="flex-1 h-px bg-slate-200"></div>
                </div>

                {{-- Catalog shortcut --}}
                <button onclick="window.location='{{ route('catalog.index') }}'" class="btn-secondary fu d5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lihat Katalog Kamar
                </button>

                {{-- Register --}}
                <p class="text-center text-sm text-slate-500 mt-6 font-medium fu d6">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-slate-900 font-bold hover:underline underline-offset-2 ml-1">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

            {{-- Bottom copyright --}}
            <p class="text-center text-xs text-slate-400 font-medium pb-6">
                &copy; 2026 Kosify Indonesia
            </p>
        </div>

    </div><!-- /outer wrapper -->

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            const eyeOpen = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
            const eyeOff = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;
            if (input.type === 'password') { input.type = 'text'; btn.innerHTML = eyeOff; }
            else { input.type = 'password'; btn.innerHTML = eyeOpen; }
        }
    </script>
</body>
</html>
