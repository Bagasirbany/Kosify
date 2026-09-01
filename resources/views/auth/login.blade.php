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

        body { background: #f8f9fb; }

        .left-panel {
            background-image: url('{{ asset('images/rooms/room_201.jpg') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .left-overlay {
            background: linear-gradient(
                to top,
                rgba(10, 14, 20, 0.82) 0%,
                rgba(10, 14, 20, 0.40) 55%,
                rgba(10, 14, 20, 0.10) 100%
            );
        }

        /* Input style — clean light */
        .form-input {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            color: #0f172a;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input::placeholder { color: #94a3b8; }
        .form-input:focus {
            outline: none;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06);
        }

        .btn-primary {
            background: #0f172a;
            color: #fff;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15,23,42,0.18);
        }

        .tab-active {
            color: #0f172a;
            border-bottom: 2px solid #0f172a;
            font-weight: 800;
        }
        .tab-inactive {
            color: #94a3b8;
            border-bottom: 2px solid transparent;
            font-weight: 600;
        }
        .tab-inactive:hover { color: #64748b; }

        .room-badge {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.22);
        }

        .dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.35); }
        .dot.active { background: #fff; width: 20px; border-radius: 3px; }

        .eye-btn { color: #94a3b8; transition: color 0.2s; }
        .eye-btn:hover { color: #0f172a; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.45s ease both; }
        .d1 { animation-delay: 0.04s; }
        .d2 { animation-delay: 0.10s; }
        .d3 { animation-delay: 0.16s; }
        .d4 { animation-delay: 0.22s; }
        .d5 { animation-delay: 0.28s; }
    </style>
</head>

<body class="min-h-screen flex">

    {{-- ===== LEFT — Photo Panel ===== --}}
    <div class="hidden lg:block lg:w-[48%] xl:w-[52%] left-panel flex-shrink-0">
        <div class="absolute inset-0 left-overlay"></div>

        {{-- Top brand --}}
        <div class="relative z-10 p-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-8 w-auto brightness-0 invert">
                <span class="text-white font-black text-base tracking-tight">Kosify</span>
            </a>
        </div>

        {{-- Center headline --}}
        <div class="relative z-10 absolute inset-0 flex flex-col justify-end p-10 pb-16">
            <span class="text-white/55 text-xs font-bold uppercase tracking-widest mb-3">Featured Property</span>
            <h2 class="text-white text-3xl xl:text-4xl font-black leading-tight tracking-tight mb-3">
                Temukan Hunian<br>Terbaik Anda
            </h2>
            <p class="text-white/60 text-sm font-medium leading-relaxed mb-6 max-w-xs">
                Kamar kos modern, fasilitas premium, lokasi strategis. Nyaman untuk mahasiswa dan profesional muda.
            </p>

            {{-- Badge --}}
            <div class="room-badge rounded-2xl p-4 inline-flex items-center gap-4 self-start mb-6">
                <div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/rooms/room_201.jpg') }}" class="w-full h-full object-cover" alt="">
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Kamar Suite Eksekutif</p>
                    <p class="text-white/55 text-xs font-medium mt-0.5">Mulai Rp 2.100.000 / bulan</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="ml-3 text-white/60 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- Dots --}}
            <div class="flex items-center gap-2">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    {{-- ===== RIGHT — Form Panel ===== --}}
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-[#f8f9fb]">

        {{-- Mobile logo --}}
        <div class="lg:hidden text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-10 w-auto">
                <span class="text-slate-900 font-black text-lg">Kosify</span>
            </a>
        </div>

        {{-- Form card --}}
        <div class="w-full max-w-[420px]">

            {{-- Logo (desktop only) --}}
            <div class="hidden lg:flex items-center gap-2.5 mb-8 fade-up d1">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-9 w-auto object-contain">
            </div>

            {{-- Tabs --}}
            <div class="flex items-end gap-7 mb-8 fade-up d1">
                <button class="tab-active text-base pb-2.5 transition-all">Masuk</button>
                <a href="{{ route('register') }}" class="tab-inactive text-base pb-2.5 transition-all">Daftar</a>
            </div>

            {{-- Headline --}}
            <div class="mb-7 fade-up d2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali 👋</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Masukkan akun Anda untuk melanjutkan.</p>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-5 px-4 py-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                    <ul class="space-y-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-5 px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4" data-turbo="false">
                @csrf

                {{-- Email --}}
                <div class="fade-up d3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="nama@email.com"
                               class="form-input w-full rounded-xl pl-10 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- Password --}}
                <div class="fade-up d4">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs text-slate-500 hover:text-slate-900 font-semibold underline underline-offset-2 transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               placeholder="Masukkan kata sandi"
                               class="form-input w-full rounded-xl pl-10 pr-12 py-3 text-sm font-medium">
                        <button type="button" onclick="togglePass('password', this)"
                                class="eye-btn absolute right-3.5 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2.5 fade-up d4">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                    <label for="remember_me" class="text-xs text-slate-600 font-semibold cursor-pointer select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <div class="pt-1 fade-up d5">
                    <button type="submit" class="btn-primary w-full py-3.5 rounded-xl font-bold text-sm tracking-wide">
                        Masuk ke Akun →
                    </button>
                </div>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-5 fade-up d5">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-slate-400 text-xs font-semibold">atau</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            {{-- Browse catalog shortcut --}}
            <a href="{{ route('catalog.index') }}"
               class="fade-up d5 w-full flex items-center justify-center gap-2.5 py-3 rounded-xl border-2 border-slate-200 bg-white text-slate-700 hover:border-slate-400 hover:text-slate-900 transition-all text-sm font-semibold">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Lihat Katalog Kamar
            </a>

            {{-- Register link --}}
            <p class="text-center text-sm text-slate-500 mt-6 font-medium fade-up d5">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-slate-900 font-bold hover:underline underline-offset-2 ml-1">
                    Daftar Sekarang
                </a>
            </p>

        </div>

        {{-- Footer --}}
        <p class="text-slate-400 text-xs font-medium mt-10 text-center">
            &copy; 2026 Kosify Indonesia. All rights reserved.
        </p>
    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            const eyeOpen = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>`;
            const eyeOff = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>`;
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = eyeOff;
            } else {
                input.type = 'password';
                btn.innerHTML = eyeOpen;
            }
        }
    </script>
</body>
</html>
