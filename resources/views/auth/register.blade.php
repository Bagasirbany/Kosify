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
        }

        .bg-light-cinematic {
            background-image: url('{{ asset("images/auth_light_bg.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .glass-card-light {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.18), 0 0 0 1px rgba(255, 255, 255, 0.6);
        }

        .input-clean {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #0f172a;
            font-size: 12.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .input-clean::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        .input-clean:focus {
            outline: none;
            background: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.06);
        }

        .btn-primary-dark {
            width: 100%;
            background: #0f172a;
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 11px;
            font-size: 13px;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.15);
        }
        .btn-primary-dark:hover {
            background: #020617;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
        }
    </style>
</head>

<body class="h-full bg-light-cinematic flex items-center justify-center p-4 relative">

    {{-- Soft Ambient Overlay --}}
    <div class="absolute inset-0 bg-slate-900/15 backdrop-blur-[2px] z-0"></div>

    {{-- Frosted Glass Light Card --}}
    <div class="relative z-10 w-full max-w-[390px] glass-card-light rounded-[28px] p-6 sm:p-7 flex flex-col my-auto">

        {{-- Top Brand Logo --}}
        <div class="flex justify-center mb-3">
            <a href="{{ route('home') }}" class="group">
                <div class="w-10 h-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-6 w-auto object-contain">
                </div>
            </a>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex items-center justify-center gap-10 border-b border-slate-200/80 mb-4 pb-0.5">
            <a href="{{ route('login') }}" class="text-slate-400 hover:text-slate-700 font-semibold text-sm pb-2.5 border-b-2 border-transparent transition-all">
                Sign In
            </a>
            <button type="button" class="text-slate-900 font-extrabold text-sm pb-2.5 border-b-2 border-slate-900 transition-all">
                Sign Up
            </button>
        </div>

        {{-- Error Alerts --}}
        @if ($errors->any())
            <div class="mb-3 px-3.5 py-1.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-2.5" data-turbo="false">
            @csrf

            {{-- Full Name --}}
            <div>
                <label for="name" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           required autofocus autocomplete="name"
                           placeholder="Nama Lengkap"
                           class="input-clean pl-10 pr-3.5 py-2">
                </div>
            </div>

            {{-- Phone / WA --}}
            <div>
                <label for="phone" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">WhatsApp</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                           required placeholder="081234567890"
                           class="input-clean pl-10 pr-3.5 py-2">
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Email</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required placeholder="you@example.com"
                           class="input-clean pl-10 pr-3.5 py-2">
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Password</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password"
                           required placeholder="••••••••"
                           class="input-clean pl-10 pr-10 py-2">
                    <button type="button" onclick="togglePass('password', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-0.5">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           required placeholder="••••••••"
                           class="input-clean pl-10 pr-10 py-2">
                    <button type="button" onclick="togglePass('password_confirmation', this)" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Primary Submit Button --}}
            <div class="pt-1.5">
                <button type="submit" class="btn-primary-dark">
                    Sign Up
                </button>
            </div>
        </form>

        {{-- Footer link --}}
        <p class="text-center text-xs text-slate-500 mt-3.5 font-medium">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:underline ml-0.5">Sign in</a>
        </p>

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
