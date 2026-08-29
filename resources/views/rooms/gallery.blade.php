<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Foto - Kamar {{ $room->room_number }} ({{ $room->room_type }})</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-circle.png') }}?v=2">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- Topbar -->
    <div class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('rooms.detail', $room->id) }}" class="flex items-center gap-2 text-slate-700 hover:text-slate-900 font-bold text-xs uppercase tracking-wider transition bg-white border border-slate-200 px-4 py-2 rounded-full shadow-xs hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Detail
            </a>
            <h1 class="font-black text-slate-900 text-sm tracking-tight hidden md:block">Galeri Foto - Kamar {{ $room->room_number }} (Tipe {{ $room->room_type }})</h1>
            <div class="w-24 hidden md:block"></div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="max-w-5xl mx-auto px-4 md:px-6 py-8">
        <div class="mb-6">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">DOKUMENTASI VISUAL</span>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900">Galeri Foto Kamar {{ $room->room_number }}</h2>
            <p class="text-xs text-slate-500 font-medium mt-1">Lihat foto detail interior, kamar mandi, perabot kamar, dan suasana ruangan.</p>
        </div>
        
        <div class="columns-1 sm:columns-2 md:columns-3 gap-4 space-y-4">
            @if($room->photo)
                <img src="{{ str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo) }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Utama Kamar {{ $room->room_number }}">
            @endif
            @if(!empty($room->gallery_photos) && is_array($room->gallery_photos))
                @foreach($room->gallery_photos as $gPhoto)
                    <img src="{{ str_starts_with($gPhoto, 'images/') || str_starts_with($gPhoto, 'http') ? asset($gPhoto) : asset('storage/' . $gPhoto) }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Galeri">
                @endforeach
            @else
                <img src="{{ asset('images/deluxe_single_room.jpg') }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Interior 1">
                <img src="{{ asset('images/room_1.jpg') }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Interior 2">
                <img src="{{ asset('images/room_2.jpg') }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Interior 3">
                <img src="{{ asset('images/room_3.jpg') }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Interior 4">
                <img src="{{ asset('images/room_4.jpg') }}" class="w-full rounded-2xl shadow-sm hover:shadow-md transition duration-300 border border-slate-200" alt="Foto Interior 5">
            @endif
        </div>
    </div>

</body>
</html>
