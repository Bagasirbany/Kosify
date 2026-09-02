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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #f1f5f9;
        }

        .input-clean {
            width: 100%;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 500;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .input-clean::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        .input-clean:focus {
            outline: none;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .btn-primary-dark {
            width: 100%;
            background: #0f172a;
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 11px;
            font-size: 13.5px;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18);
        }
        .btn-primary-dark:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.25);
        }

        .arrow-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.45);
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .arrow-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: #ffffff;
            transform: scale(1.05);
        }
    </style>
</head>

<body class="h-full flex items-center justify-center p-4 md:p-6 lg:p-8">

    {{-- Main Container Card --}}
    <div class="w-full max-w-[980px] h-[94vh] max-h-[640px] bg-white rounded-[28px] shadow-2xl shadow-slate-300/70 border border-slate-200/60 flex overflow-hidden my-auto">

        {{-- LEFT PANEL (46%) --}}
        <div class="hidden lg:flex lg:w-[46%] p-3.5 flex-shrink-0">
            <div class="w-full h-full rounded-[22px] overflow-hidden relative flex flex-col justify-between p-6 bg-cover bg-center shadow-inner"
                 style="background-image: url('{{ asset('images/rooms/room_102.jpg') }}');">
                
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-black/85 z-0"></div>

                {{-- Left Header Badge --}}
                <div class="relative z-10 flex items-center">
                    <span class="text-white font-bold text-xs tracking-wider uppercase bg-black/30 backdrop-blur-md border border-white/15 px-3 py-1 rounded-full">Pilihan Unggulan</span>
                </div>

                {{-- Left Bottom --}}
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-3 bg-black/40 backdrop-blur-md border border-white/20 rounded-full py-1.5 px-2.5 pr-4 shadow-lg">
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-white/50 flex-shrink-0">
                            <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="Standard">
                        </div>
                        <div class="leading-tight">
                            <p class="text-white font-bold text-xs">Kamar Standard Mahasiswa</p>
                            <p class="text-white/70 text-[10.5px] font-medium">Kosify Comfort Living</p>
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

        {{-- RIGHT PANEL (54%) --}}
        <div class="flex-1 flex flex-col justify-between p-6 sm:p-8 lg:p-9">

            {{-- Top Branding Header --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-7 w-auto object-contain">
                    <span class="text-slate-900 font-black text-base tracking-tight group-hover:text-slate-700 transition-colors">KOSIFY</span>
                </a>

                <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-1">
                    <span>Beranda</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- Center Form Content --}}
            <div class="w-full max-w-[360px] mx-auto my-auto py-1">
                
                {{-- Headings --}}
                <div class="text-center mb-4">
                    <h1 class="text-2xl sm:text-[26px] font-black text-slate-900 tracking-tight leading-tight">
                        Buat Akun Baru 🏡
                    </h1>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium mt-0.5">
                        Daftar akun untuk mulai reservasi kamar kos impian
                    </p>
                </div>

                {{-- Alerts --}}
                @if ($errors->any())
                    <div class="mb-3 px-3.5 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-2.5" data-turbo="false">
                    @csrf

                    <div>
                        <label for="name" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus placeholder="Nama lengkap Anda"
                               class="input-clean">
                    </div>

                    <div>
                        <label for="phone" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">WhatsApp</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               required placeholder="081234567890"
                               class="input-clean">
                    </div>

                    <div>
                        <label for="email" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Email Aktif</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required placeholder="nama@email.com"
                               class="input-clean">
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password"
                                   required placeholder="Minimal 8 karakter"
                                   class="input-clean pr-10">
                            <button type="button" onclick="togglePass('password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Konfirmasi Password</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   required placeholder="Ulangi password"
                                   class="input-clean pr-10">
                            <button type="button" onclick="togglePass('password_confirmation', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-1.5">
                        <button type="submit" class="btn-primary-dark">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <p class="text-center text-xs text-slate-500 mt-3 font-medium">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline ml-1">Masuk</a>
                </p>

            </div>

            <div class="text-center">
                <p class="text-[11px] text-slate-400 font-medium">&copy; 2026 Kosify. Platform Hunian Modern & Nyaman.</p>
            </div>

        </div>

    </div>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (!input) return;
            const open = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            const off = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            const svg = btn.querySelector('svg');
            if (input.type === 'password') { input.type = 'text'; svg.innerHTML = off; }
            else { input.type = 'password'; svg.innerHTML = open; }
        }
    </script>
</body>
</html>
