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
        body { background: #f0f2f5; min-height: 100vh; }

        .photo-card {
            background-image: url('{{ asset('images/rooms/room_102.jpg') }}');
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
                rgba(8,12,20,0.15) 0%,
                rgba(8,12,20,0.55) 55%,
                rgba(8,12,20,0.92) 100%
            );
        }

        .form-panel { background: #ffffff; }

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

        .btn-login {
            background: #0f172a;
            color: #fff;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-login:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(15,23,42,0.22);
        }

        .room-badge {
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.20);
            border-radius: 18px;
        }

        .sdot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.35); transition: all 0.3s; }
        .sdot.on { width: 22px; border-radius: 3px; background: #fff; }

        .slide-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.22);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.75);
            transition: background 0.2s;
        }
        .slide-btn:hover { background: rgba(255,255,255,0.22); color: #fff; }

        .eye-btn { color: #94a3b8; transition: color 0.2s; }
        .eye-btn:hover { color: #0f172a; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fu { animation: fadeUp 0.4s ease both; }
        .d1{animation-delay:.04s} .d2{animation-delay:.08s} .d3{animation-delay:.12s}
        .d4{animation-delay:.16s} .d5{animation-delay:.20s} .d6{animation-delay:.24s}
        .d7{animation-delay:.28s} .d8{animation-delay:.32s}
    </style>
</head>

<body class="flex items-center justify-center p-4 md:p-6 lg:p-8">

    <div class="w-full max-w-[1100px] flex items-stretch gap-0 min-h-[680px] shadow-2xl rounded-[32px] overflow-hidden">

        {{-- ===== LEFT — Photo Card ===== --}}
        <div class="hidden lg:block lg:w-[48%] xl:w-[46%] photo-card flex-shrink-0">
            <div class="photo-card-overlay"></div>

            {{-- Top --}}
            <div class="relative z-10 flex items-center justify-between p-7 pb-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-8 w-auto brightness-0 invert opacity-90">
                    <span class="text-white font-black text-base tracking-tight">Kosify</span>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('catalog.index') }}" class="text-xs text-white/70 font-semibold hover:text-white transition-colors">Katalog</a>
                    <a href="{{ route('login') }}" class="text-xs text-white font-bold bg-white/15 hover:bg-white/25 border border-white/20 px-4 py-1.5 rounded-full transition-all">Masuk</a>
                </div>
            </div>

            {{-- Bottom content --}}
            <div class="relative z-10 absolute inset-0 flex flex-col justify-end p-7">
                <span class="text-white/50 text-[10px] font-bold uppercase tracking-widest block mb-3">Bergabung Sekarang</span>
                <h2 class="text-white text-3xl xl:text-[36px] font-black leading-[1.15] tracking-tight mb-3">
                    Mulai Perjalanan<br>Hunian Ideal Anda
                </h2>
                <p class="text-white/60 text-sm font-medium leading-relaxed mb-5 max-w-[260px]">
                    Daftar gratis, booking online, dan nikmati fasilitas kos modern.
                </p>

                {{-- Features --}}
                <div class="flex flex-col gap-2.5 mb-6">
                    @foreach(['Reservasi online 24/7', 'Pembayaran via Midtrans', 'Kontrak & invoice resmi', 'Histori sewa lengkap'] as $f)
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-white/18 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-white/65 text-sm font-medium">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Badge --}}
                <div class="room-badge p-4 flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-bold text-sm">Kamar Standard Mahasiswa</p>
                        <p class="text-white/55 text-xs font-medium mt-0.5">Mulai Rp 1.200.000 / bulan</p>
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

                <div class="flex items-center gap-2">
                    <div class="sdot"></div>
                    <div class="sdot on"></div>
                    <div class="sdot"></div>
                </div>
            </div>
        </div>

        {{-- ===== RIGHT — Form Panel ===== --}}
        <div class="form-panel flex-1 flex flex-col">

            <div class="hidden lg:flex items-center justify-between px-10 pt-8 pb-0">
                <span class="text-slate-900 font-black text-lg tracking-tight">KOSIFY</span>
                <a href="{{ route('catalog.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 uppercase tracking-wider transition-colors">Lihat Katalog →</a>
            </div>

            <div class="lg:hidden flex items-center justify-center pt-8 pb-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-9 w-auto">
                    <span class="text-slate-900 font-black text-lg">Kosify</span>
                </a>
            </div>

            <div class="flex-1 flex flex-col justify-center px-8 md:px-12 lg:px-14 xl:px-16 py-6">

                {{-- Headline --}}
                <div class="mb-6 fu d1">
                    <h1 class="text-3xl xl:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-2">
                        Buat Akun Baru 🏡
                    </h1>
                    <p class="text-slate-500 text-sm font-medium">Lengkapi formulir berikut untuk memulai.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold">
                        <ul class="space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-3.5" data-turbo="false">
                    @csrf

                    <div class="fu d2">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus placeholder="Nama lengkap Anda"
                               class="clean-input">
                    </div>

                    <div class="fu d3">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Nomor WhatsApp</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               required placeholder="081234567890"
                               class="clean-input">
                    </div>

                    <div class="fu d4">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Email Aktif</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required placeholder="nama@email.com"
                               class="clean-input">
                    </div>

                    <div class="fu d5">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" type="password" name="password"
                                   required placeholder="Minimal 8 karakter"
                                   class="clean-input pr-12">
                            <button type="button" onclick="togglePass('password', this)" class="eye-btn absolute right-4 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="fu d6">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   required placeholder="Ulangi kata sandi"
                                   class="clean-input pr-12">
                            <button type="button" onclick="togglePass('password_confirmation', this)" class="eye-btn absolute right-4 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-1 fu d7">
                        <button type="submit" class="btn-login">Buat Akun Sekarang</button>
                    </div>
                </form>

                <p class="text-center text-sm text-slate-500 mt-5 font-medium fu d8">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline underline-offset-2 ml-1">Masuk di sini</a>
                </p>
            </div>

            <p class="text-center text-xs text-slate-400 font-medium pb-6">
                &copy; 2026 Kosify Indonesia
            </p>
        </div>

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
