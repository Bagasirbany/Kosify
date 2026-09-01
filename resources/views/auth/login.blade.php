<!DOCTYPE html>
<html lang="id" class="h-full">
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

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .bg-cover-cinematic {
            background-image: url('{{ asset("images/rooms/room_201.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .glass-card {
            background: rgba(22, 28, 24, 0.72);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.45);
        }

        .input-glass {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #ffffff;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .input-glass::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }
        .input-glass:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.10);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .btn-light-solid {
            background: #ece8de;
            color: #1a1e1b;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px;
            font-size: 14px;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
        }
        .btn-light-solid:hover {
            background: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-glass-alt {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 10px 14px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 12.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: all 0.2s ease;
        }
        .btn-glass-alt:hover {
            background: rgba(255, 255, 255, 0.10);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }
    </style>
</head>

<body class="h-full bg-cover-cinematic flex items-center justify-center p-4 relative">

    {{-- Dark Vignette Overlay --}}
    <div class="absolute inset-0 bg-black/45 backdrop-blur-[2px] z-0"></div>

    {{-- Frosted Glass Center Card --}}
    <div class="relative z-10 w-full max-w-[390px] glass-card rounded-[28px] p-6 sm:p-7 flex flex-col my-auto">

        {{-- Top Logo Icon --}}
        <div class="flex justify-center mb-4">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1.5 group">
                <div class="w-10 h-10 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center backdrop-blur-md group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-6 w-auto brightness-0 invert opacity-95">
                </div>
            </a>
        </div>

        {{-- Tab Navigation: Sign In / Sign Up --}}
        <div class="flex items-center justify-center gap-10 border-b border-white/10 mb-5 pb-0.5">
            <button type="button" class="text-white font-bold text-sm pb-2.5 border-b-2 border-white transition-all">
                Sign In
            </button>
            <a href="{{ route('register') }}" class="text-white/45 hover:text-white/80 font-semibold text-sm pb-2.5 border-b-2 border-transparent transition-all">
                Sign Up
            </a>
        </div>

        {{-- Error Alerts --}}
        @if ($errors->any())
            <div class="mb-3 px-3.5 py-2 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-200 text-xs font-medium">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="mb-3 px-3.5 py-2 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-200 text-xs font-medium">
                {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-3.5" data-turbo="false">
            @csrf

            {{-- Email Input --}}
            <div>
                <label for="email" class="block text-[11px] font-medium text-white/70 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           placeholder="you@example.com"
                           class="input-glass pl-10 pr-3.5 py-2.5">
                </div>
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="block text-[11px] font-medium text-white/70 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           placeholder="••••••••"
                           class="input-glass pl-10 pr-10 py-2.5">
                    <button type="button" onclick="togglePass()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-white/40 hover:text-white transition-colors">
                        <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>

                {{-- Forgot password link --}}
                <div class="flex justify-end mt-1.5">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-[11px] font-medium text-white/55 hover:text-white transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>
            </div>

            {{-- Primary Submit Button --}}
            <div class="pt-1">
                <button type="submit" class="btn-light-solid">
                    Sign In
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-2.5 my-3.5">
            <div class="flex-1 h-px bg-white/10"></div>
            <span class="text-white/40 text-[11px] font-medium">or continue with</span>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>

        {{-- Stacked Alternative Options --}}
        <div class="space-y-2">
            {{-- Google Button --}}
            <a href="{{ route('catalog.index') }}" class="btn-glass-alt">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Continue with Google</span>
            </a>

            {{-- Catalog / Explore Button --}}
            <a href="{{ route('catalog.index') }}" class="btn-glass-alt">
                <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Jelajahi Katalog Kosify</span>
            </a>
        </div>

        {{-- Footer link --}}
        <p class="text-center text-[11.5px] text-white/55 mt-4 font-normal">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-white font-bold hover:underline ml-0.5">Sign up</a>
        </p>

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
    </script>
</body>
</html>
