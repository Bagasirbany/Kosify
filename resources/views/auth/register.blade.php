<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Baru - Kosify</title>

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
        .glass-input::placeholder { color: rgba(255, 255, 255, 0.40); }
        .glass-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.45);
        }

        .left-panel {
            background-image: url('{{ asset('images/rooms/room_102.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .photo-overlay {
            background: linear-gradient(
                to right,
                rgba(10, 15, 20, 0.60) 0%,
                rgba(10, 15, 20, 0.20) 60%,
                rgba(10, 15, 20, 0.0) 100%
            );
        }

        .room-badge {
            background: rgba(10, 12, 15, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.1);
        }

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

        .tab-active { border-bottom: 2px solid #fff; color: #fff; }
        .tab-inactive { border-bottom: 2px solid transparent; color: rgba(255,255,255,0.45); }

        .eye-btn { color: rgba(255,255,255,0.5); transition: color 0.2s; }
        .eye-btn:hover { color: #fff; }

        .dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.35); }
        .dot.active { background: #fff; width: 20px; border-radius: 3px; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeInUp 0.5s ease both; }
        .fade-up-1 { animation-delay: 0.05s; }
        .fade-up-2 { animation-delay: 0.10s; }
        .fade-up-3 { animation-delay: 0.15s; }
        .fade-up-4 { animation-delay: 0.20s; }
        .fade-up-5 { animation-delay: 0.25s; }
        .fade-up-6 { animation-delay: 0.30s; }
        body { overflow-x: hidden; }
    </style>
</head>

<body class="min-h-screen bg-[#0f1217] flex">

    {{-- =========================================================
         LEFT PANEL
    ========================================================= --}}
    <div class="hidden lg:flex lg:w-[55%] xl:w-[58%] relative left-panel flex-col">
        <div class="absolute inset-0 photo-overlay"></div>

        {{-- Branding --}}
        <div class="relative z-10 p-10 flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-9 w-auto object-contain brightness-0 invert">
            <span class="text-white/80 text-sm font-bold tracking-widest uppercase">Kosify</span>
        </div>

        {{-- Center text --}}
        <div class="relative z-10 flex-1 flex flex-col justify-center px-14">
            <span class="text-white/50 text-xs font-bold uppercase tracking-widest mb-4">Bergabung Sekarang</span>
            <h2 class="text-white text-4xl xl:text-5xl font-black leading-tight tracking-tight mb-4">
                Mulai Perjalanan<br>Hunian Ideal Anda
            </h2>
            <p class="text-white/65 text-sm font-medium leading-relaxed max-w-xs">
                Daftar gratis dan nikmati kemudahan booking kamar kos secara online, lengkap dengan sistem pembayaran digital yang aman.
            </p>

            {{-- Features list --}}
            <div class="flex flex-col gap-3 mt-8">
                @foreach(['Reservasi online 24/7', 'Pembayaran digital (Midtrans)', 'Kontrak sewa resmi & invoice', 'Laporan & histori sewa'] as $feat)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-white/65 text-sm font-medium">{{ $feat }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom badge --}}
        <div class="relative z-10 p-10">
            <div class="room-badge rounded-2xl p-4 inline-flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="">
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Kamar Standard Mahasiswa</p>
                    <p class="text-white/55 text-xs font-medium mt-0.5">Mulai dari Rp 1.200.000 / bulan</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="ml-4 text-white/70 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="flex items-center gap-2 mt-5">
                <div class="dot"></div>
                <div class="dot active"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         RIGHT PANEL — Register form
    ========================================================= --}}
    <div class="flex-1 flex flex-col items-center justify-center min-h-screen px-6 py-10 relative overflow-y-auto"
         style="background: linear-gradient(145deg, #0f1217 0%, #151c26 60%, #0d1520 100%)">

        <div class="absolute top-1/4 left-1/3 w-56 h-56 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-40 h-40 bg-sky-500/8 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Mobile logo --}}
        <div class="lg:hidden text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-10 w-auto object-contain brightness-0 invert">
                <span class="text-white font-black text-lg tracking-tight">Kosify</span>
            </a>
        </div>

        <div class="w-full max-w-[400px] glass-card rounded-3xl px-8 pt-8 pb-10 fade-up">

            {{-- Logo mark (desktop) --}}
            <div class="hidden lg:flex items-center gap-2.5 mb-8 fade-up fade-up-1">
                <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="w-5 h-5 object-contain brightness-0 invert">
                </div>
                <span class="text-white font-black text-base tracking-tight">Kosify</span>
            </div>

            {{-- Tab nav --}}
            <div class="flex items-end gap-6 mb-7 fade-up fade-up-1">
                <a href="{{ route('login') }}" class="tab-inactive text-sm font-bold pb-2 hover:text-white/70 transition-all">Masuk</a>
                <button class="tab-active text-sm font-bold pb-2 transition-all">Daftar</button>
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4" data-turbo="false">
                @csrf

                {{-- Nama --}}
                <div class="fade-up fade-up-2">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus autocomplete="name"
                               placeholder="Nama lengkap Anda"
                               class="glass-input w-full rounded-xl pl-11 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="fade-up fade-up-3">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               required placeholder="081234567890"
                               class="glass-input w-full rounded-xl pl-11 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- Email --}}
                <div class="fade-up fade-up-4">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Email Aktif</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required placeholder="nama@email.com"
                               class="glass-input w-full rounded-xl pl-11 pr-4 py-3 text-sm font-medium">
                    </div>
                </div>

                {{-- Password --}}
                <div class="fade-up fade-up-5">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password"
                               required placeholder="Minimal 8 karakter"
                               class="glass-input w-full rounded-xl pl-11 pr-12 py-3 text-sm font-medium">
                        <button type="button" onclick="togglePass('password', this)" class="eye-btn absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="fade-up fade-up-6">
                    <label class="block text-white/60 text-xs font-semibold mb-2 uppercase tracking-wider">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/35 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               required placeholder="Ulangi kata sandi"
                               class="glass-input w-full rounded-xl pl-11 pr-12 py-3 text-sm font-medium">
                        <button type="button" onclick="togglePass('password_confirmation', this)" class="eye-btn absolute right-4 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-2 fade-up fade-up-6">
                    <button type="submit" class="btn-submit w-full py-3.5 rounded-xl font-bold text-sm tracking-wide">
                        Buat Akun Sekarang
                    </button>
                </div>
            </form>

            {{-- Login link --}}
            <p class="text-center text-xs text-white/40 mt-7 font-medium">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-white font-bold hover:underline underline-offset-2 ml-1">Masuk di sini</a>
            </p>
        </div>

        <p class="text-white/20 text-xs font-medium mt-8">
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
