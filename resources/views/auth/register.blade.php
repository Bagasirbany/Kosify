<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Baru - Kosify</title>

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
            background-image: url('{{ asset('images/rooms/room_102.jpg') }}');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .left-overlay {
            background: linear-gradient(
                to top,
                rgba(10, 14, 20, 0.85) 0%,
                rgba(10, 14, 20, 0.45) 55%,
                rgba(10, 14, 20, 0.12) 100%
            );
        }

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

        .tab-active { color: #0f172a; border-bottom: 2px solid #0f172a; font-weight: 800; }
        .tab-inactive { color: #94a3b8; border-bottom: 2px solid transparent; font-weight: 600; }
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
        .d2 { animation-delay: 0.09s; }
        .d3 { animation-delay: 0.14s; }
        .d4 { animation-delay: 0.19s; }
        .d5 { animation-delay: 0.24s; }
        .d6 { animation-delay: 0.30s; }
    </style>
</head>

<body class="min-h-screen flex">

    {{-- ===== LEFT — Photo Panel ===== --}}
    <div class="hidden lg:block lg:w-[48%] xl:w-[52%] left-panel flex-shrink-0">
        <div class="absolute inset-0 left-overlay"></div>

        <div class="relative z-10 p-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-8 w-auto brightness-0 invert">
                <span class="text-white font-black text-base tracking-tight">Kosify</span>
            </a>
        </div>

        <div class="relative z-10 absolute inset-0 flex flex-col justify-end p-10 pb-16">
            <span class="text-white/55 text-xs font-bold uppercase tracking-widest mb-3">Bergabung Sekarang</span>
            <h2 class="text-white text-3xl xl:text-4xl font-black leading-tight tracking-tight mb-3">
                Mulai Perjalanan<br>Hunian Ideal Anda
            </h2>
            <p class="text-white/60 text-sm font-medium leading-relaxed mb-6 max-w-xs">
                Daftar gratis, booking online, dan nikmati fasilitas kos modern dengan sistem pembayaran digital yang aman.
            </p>

            {{-- Feature list --}}
            <div class="flex flex-col gap-2.5 mb-7">
                @foreach(['Reservasi online 24/7', 'Pembayaran via Midtrans', 'Kontrak & invoice resmi', 'Histori sewa lengkap'] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-white/65 text-sm font-medium">{{ $f }}</span>
                </div>
                @endforeach
            </div>

            <div class="room-badge rounded-2xl p-4 inline-flex items-center gap-4 self-start mb-6">
                <div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="">
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Kamar Standard Mahasiswa</p>
                    <p class="text-white/55 text-xs font-medium mt-0.5">Mulai Rp 1.200.000 / bulan</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="ml-3 text-white/60 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="flex items-center gap-2">
                <div class="dot"></div>
                <div class="dot active"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    {{-- ===== RIGHT — Form Panel ===== --}}
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-10 bg-[#f8f9fb] overflow-y-auto">

        {{-- Mobile logo --}}
        <div class="lg:hidden text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-10 w-auto">
                <span class="text-slate-900 font-black text-lg">Kosify</span>
            </a>
        </div>

        <div class="w-full max-w-[420px]">

            {{-- Logo desktop --}}
            <div class="hidden lg:flex items-center gap-2.5 mb-8 fade-up d1">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-9 w-auto object-contain">
            </div>

            {{-- Tabs --}}
            <div class="flex items-end gap-7 mb-8 fade-up d1">
                <a href="{{ route('login') }}" class="tab-inactive text-base pb-2.5 transition-all">Masuk</a>
                <button class="tab-active text-base pb-2.5 transition-all">Daftar</button>
            </div>

            {{-- Headline --}}
            <div class="mb-7 fade-up d2">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Buat Akun Baru 🏡</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Lengkapi formulir berikut untuk memulai.</p>
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4" data-turbo="false">
                @csrf

                {{-- Nama --}}
                <div class="fade-up d3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus placeholder="Nama lengkap Anda"
                               class="form-input w-full rounded-xl pl-10 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="fade-up d3">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               required placeholder="081234567890"
                               class="form-input w-full rounded-xl pl-10 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- Email --}}
                <div class="fade-up d4">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Email Aktif</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required placeholder="nama@email.com"
                               class="form-input w-full rounded-xl pl-10 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- Password --}}
                <div class="fade-up d5">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               required placeholder="Minimal 8 karakter"
                               class="form-input w-full rounded-xl pl-10 pr-12 py-3 text-sm font-medium">
                        <button type="button" onclick="togglePass('password', this)" class="eye-btn absolute right-3.5 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="fade-up d5">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               required placeholder="Ulangi kata sandi"
                               class="form-input w-full rounded-xl pl-10 pr-12 py-3 text-sm font-medium">
                        <button type="button" onclick="togglePass('password_confirmation', this)" class="eye-btn absolute right-3.5 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-1 fade-up d6">
                    <button type="submit" class="btn-primary w-full py-3.5 rounded-xl font-bold text-sm tracking-wide">
                        Buat Akun Sekarang →
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6 font-medium fade-up d6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline underline-offset-2 ml-1">
                    Masuk di sini
                </a>
            </p>
        </div>

        <p class="text-slate-400 text-xs font-medium mt-8 text-center">
            &copy; 2026 Kosify Indonesia. All rights reserved.
        </p>
    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            const open = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
            const off = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;
            input.type === 'password' ? (input.type = 'text', btn.innerHTML = off) : (input.type = 'password', btn.innerHTML = open);
        }
    </script>
</body>
</html>
