<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk ke Akun - Kosify</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Lock viewport — NO scroll */
        html, body {
            margin: 0; padding: 0;
            width: 100%; height: 100%;
            overflow: hidden;
            background: #f0f1f4;
        }

        .page-wrap {
            width: 100%; height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* The outer container card */
        .outer-card {
            display: flex;
            width: 100%;
            max-width: 1060px;
            height: min(92vh, 640px);
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);
        }

        /* Left photo panel — inside the card, with its own rounding */
        .photo-side {
            width: 46%;
            flex-shrink: 0;
            position: relative;
            margin: 14px;
            margin-right: 0;
            border-radius: 20px;
            overflow: hidden;
            background-image: url('{{ asset("images/rooms/room_201.jpg") }}');
            background-size: cover;
            background-position: center;
        }
        .photo-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(6,10,18,0.10) 0%, rgba(6,10,18,0.50) 55%, rgba(6,10,18,0.88) 100%);
        }
        .photo-side > * { position: relative; z-index: 2; }

        /* Right form side */
        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
        }

        /* Minimal clean input — bottom-border style like reference */
        .ref-input {
            width: 100%;
            border: none;
            border-bottom: 1.5px solid #e2e8f0;
            background: transparent;
            color: #0f172a;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 0;
            outline: none;
            transition: border-color 0.2s;
        }
        .ref-input::placeholder { color: #94a3b8; font-weight: 400; }
        .ref-input:focus { border-color: #0f172a; }

        /* Submit button — solid slate like website */
        .btn-submit {
            width: 100%;
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15,23,42,0.18);
        }

        /* Secondary outline button */
        .btn-outline {
            width: 100%;
            background: #fff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: border-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-outline:hover { border-color: #94a3b8; }

        /* Slide arrow buttons */
        .arrow-btn {
            width: 34px; height: 34px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.30);
            background: rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.80);
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .arrow-btn:hover { background: rgba(255,255,255,0.18); }

        /* Mobile: single column */
        @media (max-width: 1023px) {
            .page-wrap { padding: 16px; }
            .outer-card {
                flex-direction: column;
                height: auto;
                max-height: 96vh;
                overflow-y: auto;
            }
            .photo-side { display: none; }
            .form-side { flex: 1; }
        }
    </style>
</head>

<body>
<div class="page-wrap">
    <div class="outer-card">

        {{-- ===== LEFT: Photo Card (inset rounded) ===== --}}
        <div class="photo-side hidden lg:flex flex-col">

            {{-- Top bar --}}
            <div class="flex items-center justify-between p-6 pb-0">
                <span class="text-white font-black text-sm tracking-tight">Kosify</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('register') }}" class="text-[11px] text-white/70 font-semibold hover:text-white transition-colors">Daftar</a>
                    <a href="{{ route('catalog.index') }}" class="text-[11px] text-white font-bold bg-white/15 hover:bg-white/25 border border-white/25 px-3.5 py-1.5 rounded-full transition-all">Katalog</a>
                </div>
            </div>

            {{-- Spacer --}}
            <div class="flex-1"></div>

            {{-- Bottom info --}}
            <div class="p-6 pt-0">
                {{-- Author badge --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/25 flex-shrink-0">
                        <img src="{{ asset('images/rooms/room_301.jpg') }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm leading-tight">Suite Eksekutif</p>
                        <p class="text-white/50 text-xs font-medium">Rp 2.100.000 / bulan</p>
                    </div>
                </div>

                {{-- Slide arrows --}}
                <div class="flex items-center gap-2">
                    <button class="arrow-btn">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button class="arrow-btn">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT: Form Side ===== --}}
        <div class="form-side">

            {{-- Top right nav --}}
            <div class="flex items-center justify-between px-10 pt-7">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-7 w-auto">
                    <span class="text-slate-900 font-black text-sm tracking-tight hidden lg:inline">KOSIFY</span>
                </a>
                <a href="{{ route('catalog.index') }}" class="text-[11px] font-bold text-slate-500 hover:text-slate-900 uppercase tracking-wider transition-colors">
                    Katalog →
                </a>
            </div>

            {{-- Centered form content --}}
            <div class="flex-1 flex flex-col justify-center px-10 lg:px-14 xl:px-16">

                {{-- Heading --}}
                <h1 class="text-[32px] xl:text-[38px] font-black text-slate-900 tracking-tight leading-[1.1] mb-1.5">
                    Halo, Selamat<br>Datang 👋
                </h1>
                <p class="text-slate-500 text-sm font-medium mb-8">Masuk ke akun Kosify Anda</p>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" data-turbo="false">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-1">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="Email"
                               class="ref-input">
                    </div>

                    {{-- Password --}}
                    <div class="mb-1 relative">
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               placeholder="Password"
                               class="ref-input pr-10">
                        <button type="button" onclick="togglePass()" class="absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Forgot password --}}
                    <div class="flex justify-end mb-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-xs font-semibold text-slate-400 hover:text-slate-900 transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 mb-5">
                        <div class="flex-1 h-px bg-slate-200"></div>
                        <span class="text-slate-400 text-xs font-medium">atau</span>
                        <div class="flex-1 h-px bg-slate-200"></div>
                    </div>

                    {{-- Catalog button --}}
                    <button type="button" onclick="window.location='{{ route('catalog.index') }}'" class="btn-outline mb-5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Lihat Katalog Kamar
                    </button>

                    {{-- Login submit --}}
                    <button type="submit" class="btn-submit">
                        Masuk ke Akun
                    </button>
                </form>

                {{-- Register --}}
                <p class="text-center text-sm text-slate-500 mt-5 font-medium">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-slate-900 font-bold hover:underline underline-offset-2">Daftar</a>
                </p>
            </div>

            {{-- Footer --}}
            <div class="px-10 pb-5 pt-2 text-center">
                <p class="text-[11px] text-slate-400 font-medium">&copy; 2026 Kosify Indonesia</p>
            </div>
        </div>

    </div>
</div>

<script>
    function togglePass() {
        const pw = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            pw.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }
</script>
</body>
</html>
