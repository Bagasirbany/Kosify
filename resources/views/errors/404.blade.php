<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Kosify</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F3EFE7;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 text-slate-900">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-xl text-center relative overflow-hidden">
        
        <!-- Top Accent -->
        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-amber-500 to-slate-900"></div>

        <!-- 404 Badge & Icon -->
        <div class="w-20 h-20 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-6 text-3xl font-black shadow-inner border border-amber-100">
            🔍
        </div>

        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-[11px] font-extrabold uppercase tracking-widest rounded-md mb-3">
            Error 404
        </span>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2">
            Kamar Tidak Ditemukan
        </h1>

        <p class="text-sm text-slate-500 mb-8 leading-relaxed">
            Halaman atau kamar kos yang Anda tuju tidak tersedia, telah dipindahkan, atau tautan yang Anda masukkan keliru.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="px-6 py-3 bg-slate-900 hover:bg-black text-white text-sm font-bold rounded-xl shadow-md transition-all">
                Kembali ke Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all">
                Lihat Katalog Kamar
            </a>
        </div>

    </div>

</body>
</html>
