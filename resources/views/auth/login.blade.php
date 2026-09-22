<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk ke Akun - Kosify</title>

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
            padding: 11px 16px;
            font-size: 13.5px;
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
            padding: 12px;
            font-size: 14px;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18);
        }
        .btn-primary-dark:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.25);
        }

        .btn-google {
            width: 100%;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            color: #0f172a;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }
        .btn-google:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        }

        .btn-secondary-light {
            width: 100%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-secondary-light:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #0f172a;
        }
    </style>
</head>

<body class="h-full flex items-center justify-center p-4 md:p-6 lg:p-8">

    {{-- Main Container Card (Clean Solid White Floating Card) --}}
    <div class="w-full max-w-[980px] h-[92vh] max-h-[600px] bg-white rounded-[28px] shadow-2xl shadow-slate-300/70 border border-slate-200/60 flex overflow-hidden my-auto">

        {{-- LEFT PANEL: Inset Photo Showcase (46%) --}}
        <div class="hidden lg:flex lg:w-[46%] p-3.5 flex-shrink-0">
            <div id="showcase-bg" class="w-full h-full rounded-[22px] overflow-hidden relative bg-cover bg-center shadow-inner transition-all duration-700"
                 style="background-image: url('{{ asset('images/rooms/room_201.jpg') }}');">
            </div>
        </div>

        {{-- RIGHT PANEL: Clean Minimal Form (54%) --}}
        <div class="flex-1 flex flex-col justify-between p-6 sm:p-8 lg:p-10">

            {{-- Top Branding Header --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/favicon-circle.png') }}?v=3" alt="Kosify" class="h-7 w-7 object-contain">
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
            <div class="w-full max-w-[350px] mx-auto my-auto py-2">
                
                {{-- Headings --}}
                <div class="text-center mb-5">
                    <h1 class="text-2xl sm:text-[28px] font-black text-slate-900 tracking-tight leading-tight">
                        Halo, Selamat Datang
                    </h1>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium mt-1">
                        Masuk ke akun Kosify Anda untuk melanjutkan
                    </p>
                </div>

                {{-- Alerts --}}
                @if ($errors->any())
                    <div class="mb-3.5 px-3.5 py-2 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-3.5 px-3.5 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-3.5 px-3.5 py-2.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-3" data-turbo="false">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', Cookie::get('kosify_remember_email') ?? (Cookie::queued('kosify_remember_email') ? Cookie::queued('kosify_remember_email')->getValue() : '')) }}"
                               required autofocus autocomplete="username"
                               placeholder="nama@email.com"
                               class="input-clean">
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="input-clean pr-10">
                            <button type="button" onclick="togglePass()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me (Selalu Ingat Saya) --}}
                    <div class="flex items-center justify-between pt-1 pb-1">
                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                            <input id="remember" type="checkbox" name="remember" value="1" 
                                   {{ old('remember', Cookie::get('kosify_remember_active', '1')) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 accent-slate-900 cursor-pointer">
                            <span class="text-xs font-semibold text-slate-700">Selalu ingat saya</span>
                        </label>
                    </div>

                    {{-- Primary Submit Button --}}
                    <div class="pt-1">
                        <button type="submit" class="btn-primary-dark">
                            Masuk ke Akun
                        </button>
                    </div>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 py-1">
                        <div class="flex-1 h-px bg-slate-200"></div>
                        <span class="text-slate-400 text-[11px] font-semibold uppercase tracking-wider">atau masuk dengan</span>
                        <div class="flex-1 h-px bg-slate-200"></div>
                    </div>

                    {{-- Google Login Button --}}
                    <a href="{{ route('login.google') }}" class="btn-google">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Masuk dengan Google</span>
                    </a>
                </form>

                {{-- Sign up link --}}
                <p class="text-center text-xs text-slate-500 mt-4 font-medium">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-slate-900 font-bold hover:underline ml-1">Daftar sekarang</a>
                </p>

            </div>

            {{-- Footer info --}}
            <div class="text-center">
                <p class="text-[11px] text-slate-400 font-medium">&copy; 2026 Kosify. Platform Hunian Modern & Nyaman.</p>
            </div>

        </div>

    </div>

    <script>
        function togglePass() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                pw.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        // Auto-refresh page if restored from browser back-forward cache (bfcache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        // Left Panel Showcase Slider
        const showcaseImages = [
            '{{ asset('images/rooms/room_201.jpg') }}',
            '{{ asset('images/rooms/room_101.jpg') }}',
            '{{ asset('images/rooms/room_202.jpg') }}'
        ];
        let currentShowcaseIdx = 0;
        let showcaseTimer = null;

        function updateShowcase(idx) {
            currentShowcaseIdx = (idx + showcaseImages.length) % showcaseImages.length;
            const bg = document.getElementById('showcase-bg');
            if (bg) {
                bg.style.backgroundImage = `url('${showcaseImages[currentShowcaseIdx]}')`;
            }
        }

        function startShowcaseAutoplay() {
            clearInterval(showcaseTimer);
            showcaseTimer = setInterval(() => {
                updateShowcase(currentShowcaseIdx + 1);
            }, 6000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            startShowcaseAutoplay();

            // Fitur 'Selalu ingat saya': otomatis mengisi email dari LocalStorage jika belum terisi
            const emailInput = document.getElementById('email');
            const rememberCheckbox = document.getElementById('remember');
            const loginForm = document.querySelector('form');

            if (emailInput && !emailInput.value) {
                const savedEmail = localStorage.getItem('kosify_saved_email');
                if (savedEmail) {
                    emailInput.value = savedEmail;
                    if (rememberCheckbox) rememberCheckbox.checked = true;
                }
            }

            if (loginForm && emailInput && rememberCheckbox) {
                loginForm.addEventListener('submit', () => {
                    if (rememberCheckbox.checked) {
                        localStorage.setItem('kosify_saved_email', emailInput.value.trim());
                        localStorage.setItem('kosify_remember_active', '1');
                    } else {
                        localStorage.removeItem('kosify_saved_email');
                        localStorage.removeItem('kosify_remember_active');
                    }
                });
            }
        });
    </script>
</body>
</html>
