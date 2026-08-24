<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kosify') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fast Navigation & Premium Animations -->
    <meta name="turbo-prefetch" content="true">
    <script type="module">
        import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
    </script>
    <style>
        /* Smooth Page Transition */
        body {
            animation: fadeIn 0.4s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        /* Turbo Progress Bar */
        .turbo-progress-bar {
            height: 3px;
            background-color: #059669;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <div class="flex-1 flex flex-col md:flex-row bg-slate-50">
            <!-- Kolom kiri: form -->
            <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 py-12">
                <div class="mb-8 text-center">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 object-contain rounded-lg drop-shadow-md" alt="Kosify Logo">
                        <span class="text-2xl font-bold text-slate-800">Kosify</span>
                    </div>
                    <p class="text-slate-500 text-sm">Kelola properti kos Anda dengan lebih mudah.</p>
                </div>

                <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Kolom kanan: gambar -->
            <div class="hidden md:block w-1/2 bg-slate-100">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80"
                     alt="Interior kos"
                     class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-slate-200 bg-slate-50">
            <div class="max-w-6xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center gap-2 text-xs text-slate-500">
                <span>© 2026 Kosify SaaS. Hak Cipta Dilindungi.</span>
                <div class="flex gap-4">
                    <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:underline">Syarat & Ketentuan</a>
                    <a href="#" class="hover:underline">Bantuan</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>