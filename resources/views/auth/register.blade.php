<!DOCTYPE html>
<html lang="id">
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

        .outer-card {
            display: flex;
            width: 100%;
            max-width: 1060px;
            height: min(94vh, 700px);
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);
        }

        .photo-side {
            width: 46%;
            flex-shrink: 0;
            position: relative;
            margin: 14px;
            margin-right: 0;
            border-radius: 20px;
            overflow: hidden;
            background-image: url('{{ asset("images/rooms/room_102.jpg") }}');
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

        .form-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .ref-input {
            width: 100%;
            border: none;
            border-bottom: 1.5px solid #e2e8f0;
            background: transparent;
            color: #0f172a;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 0;
            outline: none;
            transition: border-color 0.2s;
        }
        .ref-input::placeholder { color: #94a3b8; font-weight: 400; }
        .ref-input:focus { border-color: #0f172a; }

        .btn-submit {
            width: 100%;
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
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

        .eye-btn { color: #94a3b8; transition: color 0.2s; cursor: pointer; }
        .eye-btn:hover { color: #0f172a; }

        @media (max-width: 1023px) {
            .page-wrap { padding: 16px; }
            .outer-card {
                flex-direction: column;
                height: auto;
                max-height: 96vh;
                overflow-y: auto;
            }
            .photo-side { display: none; }
        }
    </style>
</head>

<body>
<div class="page-wrap">
    <div class="outer-card">

        {{-- ===== LEFT: Photo ===== --}}
        <div class="photo-side hidden lg:flex flex-col">
            <div class="flex items-center justify-between p-6 pb-0">
                <span class="text-white font-black text-sm tracking-tight">Kosify</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="text-[11px] text-white/70 font-semibold hover:text-white transition-colors">Masuk</a>
                    <a href="{{ route('catalog.index') }}" class="text-[11px] text-white font-bold bg-white/15 hover:bg-white/25 border border-white/25 px-3.5 py-1.5 rounded-full transition-all">Katalog</a>
                </div>
            </div>

            <div class="flex-1"></div>

            <div class="p-6 pt-0">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/25 flex-shrink-0">
                        <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm leading-tight">Kamar Standard</p>
                        <p class="text-white/50 text-xs font-medium">Rp 1.200.000 / bulan</p>
                    </div>
                </div>
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

        {{-- ===== RIGHT: Form ===== --}}
        <div class="form-side">

            <div class="flex items-center justify-between px-10 pt-7">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-7 w-auto">
                    <span class="text-slate-900 font-black text-sm tracking-tight hidden lg:inline">KOSIFY</span>
                </a>
                <a href="{{ route('catalog.index') }}" class="text-[11px] font-bold text-slate-500 hover:text-slate-900 uppercase tracking-wider transition-colors">Katalog →</a>
            </div>

            <div class="flex-1 flex flex-col justify-center px-10 lg:px-14 xl:px-16">

                <h1 class="text-[28px] xl:text-[34px] font-black text-slate-900 tracking-tight leading-[1.1] mb-1.5">
                    Buat Akun Baru 🏡
                </h1>
                <p class="text-slate-500 text-sm font-medium mb-6">Lengkapi data berikut untuk memulai.</p>

                @if ($errors->any())
                    <div class="mb-4 px-4 py-2.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" data-turbo="false">
                    @csrf

                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           required autofocus placeholder="Nama Lengkap"
                           class="ref-input mb-0.5">

                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                           required placeholder="Nomor WhatsApp"
                           class="ref-input mb-0.5">

                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required placeholder="Email"
                           class="ref-input mb-0.5">

                    <div class="relative mb-0.5">
                        <input id="reg-password" type="password" name="password"
                               required placeholder="Password"
                               class="ref-input pr-10">
                        <button type="button" onclick="togglePass('reg-password', this)" class="eye-btn absolute right-0 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="relative mb-5">
                        <input id="reg-password-confirm" type="password" name="password_confirmation"
                               required placeholder="Konfirmasi Password"
                               class="ref-input pr-10">
                        <button type="button" onclick="togglePass('reg-password-confirm', this)" class="eye-btn absolute right-0 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="btn-submit">Buat Akun Sekarang</button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-5 font-medium">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline underline-offset-2">Masuk</a>
                </p>
            </div>

            <div class="px-10 pb-5 pt-2 text-center">
                <p class="text-[11px] text-slate-400 font-medium">&copy; 2026 Kosify Indonesia</p>
            </div>
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
