<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Kosify</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

        /* Lock viewport */
        html, body { height: 100%; overflow: hidden; }

        /* Page background: Scenic window view looking outside with 15% subtle overlay */
        .page-bg {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset("images/window_view_bg.jpg") }}');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 24px;
        }
        .page-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(1.5px);
            -webkit-backdrop-filter: blur(1.5px);
            z-index: 1;
        }

        /* Main split container: 56% translucent frosted glass */
        .login-container {
            position: relative;
            z-index: 2;
            display: flex;
            width: 100%;
            max-width: 960px;
            height: min(88vh, 580px);
            background: rgba(255, 255, 255, 0.56);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.75);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 70px -10px rgba(0, 0, 0, 0.22), 0 0 0 1px rgba(255, 255, 255, 0.4);
        }

        /* ── LEFT PANEL (45%) ── */
        .panel-left {
            width: 45%;
            flex-shrink: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .photo-card {
            position: absolute;
            inset: 10px;
            border-radius: 18px;
            overflow: hidden;
            background-image: url('{{ asset("images/rooms/room_201.jpg") }}');
            background-size: cover;
            background-position: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .photo-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(170deg,
                rgba(8,6,18,0.25) 0%,
                rgba(8,6,18,0.15) 30%,
                rgba(8,6,18,0.50) 65%,
                rgba(8,6,18,0.88) 100%
            );
        }
        .photo-card > * { position: relative; z-index: 2; }

        .left-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 22px;
        }
        .left-top-title {
            color: #ffffff;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 4px rgba(0,0,0,0.4);
        }
        .left-top-actions { display: flex; align-items: center; gap: 10px; }
        .left-top-actions a.text-link {
            color: rgba(255,255,255,0.9);
            font-size: 11px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .left-top-actions a.text-link:hover { color: #fff; }
        .left-top-actions a.pill-btn {
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 16px;
            border: 1.5px solid rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .left-top-actions a.pill-btn:hover {
            background: rgba(255,255,255,0.3);
            border-color: #ffffff;
        }

        .left-spacer { flex: 1; }

        .left-bottom { padding: 0 22px 20px; }

        .artist-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        .artist-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.5);
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }
        .artist-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .artist-name { color: #ffffff; font-weight: 700; font-size: 12.5px; line-height: 1.2; }
        .artist-role { color: rgba(255,255,255,0.75); font-weight: 400; font-size: 11px; margin-top: 1px; }

        .nav-arrows { display: flex; align-items: center; gap: 6px; }
        .nav-arrow {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.45);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.2s;
        }
        .nav-arrow:hover {
            background: rgba(255,255,255,0.25);
            border-color: #ffffff;
        }
        .nav-arrow svg { width: 13px; height: 13px; }

        /* ── RIGHT PANEL (55%) ── */
        .panel-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: transparent;
            padding: 0;
        }

        .right-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 40px 0;
        }
        .brand-text {
            font-weight: 900;
            font-size: 14.5px;
            color: #0f172a;
            letter-spacing: 0.08em;
            text-decoration: none;
        }
        .lang-pill {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(203, 213, 225, 0.8);
            border-radius: 20px;
            padding: 4px 12px;
            backdrop-filter: blur(4px);
        }
        .lang-pill svg { width: 12px; height: 12px; }

        .form-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 58px;
        }

        .greeting-title {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.15;
            margin-bottom: 6px;
        }
        .greeting-sub {
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 30px;
        }

        .field-group { margin-bottom: 16px; }
        .field-input {
            width: 100%;
            border: none;
            border-bottom: 1.5px solid rgba(15, 23, 42, 0.2);
            padding: 10px 2px;
            font-size: 13.5px;
            font-weight: 500;
            color: #0f172a;
            background: transparent;
            outline: none;
            transition: border-color 0.2s;
        }
        .field-input::placeholder { color: #94a3b8; font-weight: 400; }
        .field-input:focus { border-color: #0f172a; }

        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 6px;
            margin-bottom: 18px;
        }
        .forgot-link {
            font-size: 11.5px;
            font-weight: 600;
            color: #ef4444;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #dc2626; text-decoration: underline; }

        .or-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }
        .or-divider .line { flex: 1; height: 1px; background: rgba(15, 23, 42, 0.15); }
        .or-divider span { font-size: 11px; color: #64748b; font-weight: 500; }

        .btn-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9.5px;
            border: 1px solid rgba(203, 213, 225, 0.9);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.85);
            color: #1e293b;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 12px;
            backdrop-filter: blur(4px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .btn-google:hover {
            background: #ffffff;
            border-color: #94a3b8;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
        .btn-google svg { width: 16px; height: 16px; }

        .btn-login {
            width: 100%;
            padding: 11.5px;
            border: none;
            border-radius: 12px;
            background: #ef4444;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
            margin-bottom: 15px;
        }
        .btn-login:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.45);
        }

        .signup-text {
            text-align: center;
            font-size: 12px;
            font-weight: 500;
            color: #475569;
        }
        .signup-text a {
            color: #ef4444;
            font-weight: 700;
            text-decoration: none;
            margin-left: 2px;
        }
        .signup-text a:hover { text-decoration: underline; }

        .social-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding: 18px 40px 22px;
        }
        .social-footer a {
            color: #64748b;
            transition: color 0.2s, transform 0.2s;
        }
        .social-footer a:hover {
            color: #0f172a;
            transform: translateY(-1px);
        }
        .social-footer svg { width: 16px; height: 16px; }

        @media (max-width: 768px) {
            .page-bg { padding: 12px; }
            .login-container {
                flex-direction: column;
                height: auto;
                max-height: 98vh;
                border-radius: 20px;
                overflow-y: auto;
            }
            .panel-left { display: none; }
            .panel-right { width: 100%; }
            .form-area { padding: 0 28px; }
            .right-top { padding: 20px 28px 0; }
            .social-footer { padding: 16px 28px 20px; }
        }
    </style>
</head>

<body>
<div class="page-bg">
    <div class="login-container">

        <!-- ═══════ LEFT PANEL (45%) ═══════ -->
        <div class="panel-left">
            <div class="photo-card">

                <div class="left-top">
                    <span class="left-top-title">Selected Works</span>
                    <div class="left-top-actions">
                        <a href="{{ route('register') }}" class="text-link">Sign Up</a>
                        <a href="{{ route('catalog.index') }}" class="pill-btn">Join Us</a>
                    </div>
                </div>

                <div class="left-spacer"></div>

                <div class="left-bottom">
                    <div class="artist-row">
                        <div class="artist-avatar">
                            <img src="{{ asset('images/rooms/room_301.jpg') }}" alt="Kosify">
                        </div>
                        <div>
                            <div class="artist-name">Kosify.id</div>
                            <div class="artist-role">Premium Living</div>
                        </div>
                    </div>

                    <div class="nav-arrows">
                        <button class="nav-arrow" type="button" aria-label="Previous">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button class="nav-arrow" type="button" aria-label="Next">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- ═══════ RIGHT PANEL (55%) ═══════ -->
        <div class="panel-right">

            <div class="right-top">
                <a href="{{ route('home') }}" class="brand-text">KOSIFY</a>
                <div class="lang-pill">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>
                    </svg>
                    EN
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="width:10px;height:10px">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <div class="form-area">

                <h1 class="greeting-title">Halo, Selamat<br>Datang 👋</h1>
                <p class="greeting-sub">Welcome to KOSIFY</p>

                @if ($errors->any())
                    <div style="margin-bottom:16px;padding:10px 14px;border-radius:10px;background:rgba(254, 242, 242, 0.9);border:1px solid #fecaca;color:#dc2626;font-size:12px;font-weight:600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div style="margin-bottom:16px;padding:10px 14px;border-radius:10px;background:rgba(240, 253, 244, 0.9);border:1px solid #bbf7d0;color:#16a34a;font-size:12px;font-weight:600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" data-turbo="false">
                    @csrf

                    <div class="field-group">
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="Email"
                               class="field-input">
                    </div>

                    <div class="field-group" style="margin-bottom:0">
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               placeholder="Password"
                               class="field-input">
                    </div>

                    <div class="forgot-row">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password ?</a>
                        @endif
                    </div>

                    <div class="or-divider">
                        <div class="line"></div>
                        <span>or</span>
                        <div class="line"></div>
                    </div>

                    <a href="{{ route('catalog.index') }}" class="btn-google">
                        <svg viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.07 5.07 0 01-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Login with Google
                    </a>

                    <button type="submit" class="btn-login">Login</button>
                </form>

                <p class="signup-text">
                    Don't have an account?
                    <a href="{{ route('register') }}">Sign up</a>
                </p>
            </div>

            <div class="social-footer">
                <a href="#" aria-label="Facebook">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                </a>
                <a href="#" aria-label="LinkedIn">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
                <a href="#" aria-label="Instagram">
                    <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>

        </div>

    </div>
</div>
</body>
</html>
