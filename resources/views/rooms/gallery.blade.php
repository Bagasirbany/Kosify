<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Foto - {{ $room->name }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- Topbar -->
    <div class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('rooms.detail', $room->id) }}" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 font-semibold transition bg-white border border-slate-200 px-4 py-2 rounded-full shadow-sm hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <h1 class="font-bold text-slate-900 hidden md:block">Galeri Foto - {{ $room->name }}</h1>
            <div class="w-24 hidden md:block"></div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="max-w-5xl mx-auto px-4 md:px-6 py-8">
        <h2 class="text-2xl font-black text-slate-900 mb-6 md:hidden">Galeri Foto</h2>
        
        <div class="columns-1 sm:columns-2 md:columns-3 gap-4 space-y-4">
            <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=900&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
            <img src="https://images.unsplash.com/photo-1518481612222-68bbe828ecd1?auto=format&fit=crop&w=600&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
            <img src="https://images.unsplash.com/photo-1620626011761-996317b8d101?auto=format&fit=crop&w=600&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
            <img src="https://images.unsplash.com/photo-1595428774223-ef52624120d2?auto=format&fit=crop&w=600&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=600&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
            <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=600&q=80" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300" alt="Foto">
        </div>
    </div>

</body>
</html>
