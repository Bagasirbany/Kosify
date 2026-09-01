<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Kosify</title>

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
            background: #eef1f6;
        }

        .ref-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8.5px 14px;
            font-size: 12.5px;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .ref-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        .ref-input:focus {
            outline: none;
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.05);
        }

        .btn-red {
            width: 100%;
            background: #e11d48;
            color: #ffffff;
            border-radius: 12px;
            padding: 10px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(225, 29, 72, 0.25);
        }
        .btn-red:hover {
            background: #be123c;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(225, 29, 72, 0.35);
        }

        .circle-nav-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .circle-nav-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: #ffffff;
        }
    </style>
</head>

<body class="h-full flex items-center justify-center p-3 sm:p-5 md:p-8">

    {{-- Outer Card Container --}}
    <div class="w-full max-w-[940px] h-[94vh] max-h-[600px] bg-white rounded-[32px] shadow-2xl shadow-slate-300/70 border border-slate-100 flex overflow-hidden">

        {{-- LEFT: Visual Showcase Card --}}
        <div class="hidden lg:flex lg:w-[48%] p-3.5 flex-shrink-0">
            <div class="w-full h-full rounded-[24px] overflow-hidden relative flex flex-col justify-between p-6 bg-cover bg-center"
                 style="background-image: url('{{ asset('images/rooms/room_102.jpg') }}');">
                
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black/80 z-0"></div>

                {{-- Top Navigation inside Photo --}}
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-white font-medium text-xs tracking-wider">Selected Works</span>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-xs text-white/90 hover:text-white font-medium transition-colors">Sign In</a>
                        <a href="{{ route('catalog.index') }}" class="text-xs text-white font-medium bg-black/40 hover:bg-black/60 border border-white/30 px-3.5 py-1 rounded-full backdrop-blur-md transition-all">
                            Join Us
                        </a>
                    </div>
                </div>

                {{-- Center is clear --}}
                <div class="relative z-10 flex-1"></div>

                {{-- Bottom Profile & Arrow Controls --}}
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full overflow-hidden border-2 border-white/60 shadow-md flex-shrink-0">
                            <img src="{{ asset('images/rooms/room_102.jpg') }}" class="w-full h-full object-cover" alt="Kosify">
                        </div>
                        <div class="leading-tight">
                            <p class="text-white font-bold text-xs">Kosify Standard</p>
                            <p class="text-white/70 text-[11px] font-normal">Student Comfort</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <button type="button" class="circle-nav-btn" aria-label="Previous">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button type="button" class="circle-nav-btn" aria-label="Next">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Form Section --}}
        <div class="flex-1 flex flex-col justify-between p-6 sm:p-8 lg:p-9">

            {{-- Top Row --}}
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="font-extrabold text-sm tracking-wider text-slate-900 uppercase">
                    KOSIFY
                </a>
                <div class="flex items-center gap-1 text-[11px] font-medium text-slate-600 border border-slate-200 rounded-full px-2.5 py-0.5">
                    <span>🇬🇧 EN</span>
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            {{-- Form Center --}}
            <div class="w-full max-w-[320px] mx-auto my-auto">
                
                {{-- Title --}}
                <div class="text-center mb-4">
                    <h1 class="text-2xl sm:text-[26px] font-extrabold text-slate-900 tracking-tight">
                        Create Account
                    </h1>
                    <p class="text-slate-400 text-xs mt-0.5">
                        Join Kosify community today
                    </p>
                </div>

                {{-- Alert Messages --}}
                @if ($errors->any())
                    <div class="mb-3 px-3 py-1.5 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 text-[11px] font-medium">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-2" data-turbo="false">
                    @csrf

                    <div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus placeholder="Full Name"
                               class="ref-input">
                    </div>

                    <div>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                               required placeholder="WhatsApp Number"
                               class="ref-input">
                    </div>

                    <div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required placeholder="Email Address"
                               class="ref-input">
                    </div>

                    <div>
                        <input id="password" type="password" name="password"
                               required placeholder="Password"
                               class="ref-input">
                    </div>

                    <div>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               required placeholder="Confirm Password"
                               class="ref-input">
                    </div>

                    <button type="submit" class="btn-red mt-2">
                        Sign Up
                    </button>
                </form>

                <p class="text-center text-[11px] text-slate-500 mt-3 font-normal">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-rose-500 font-semibold hover:underline ml-0.5">Sign in</a>
                </p>

            </div>

            {{-- Bottom Social Icons --}}
            <div class="flex items-center justify-center gap-4 text-slate-600">
                <a href="#" class="hover:text-slate-900 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="#" class="hover:text-slate-900 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                </a>
                <a href="#" class="hover:text-slate-900 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
                <a href="#" class="hover:text-slate-900 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>

        </div>

    </div>

</body>
</html>
