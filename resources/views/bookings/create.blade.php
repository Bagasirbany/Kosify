<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking & Reservasi - Kosify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col">

        <!-- Topbar (Text-First) -->
        <header class="bg-white sticky top-0 z-50 border-b border-slate-200 px-6 md:px-12 py-4 flex items-center justify-between gap-6">
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Kosify" class="h-8 w-auto">
                    <span class="text-xl font-black tracking-tight text-slate-900 uppercase">KOSIFY</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-xs font-bold uppercase tracking-wider">
                    <a href="{{ route('catalog.index') }}" class="text-slate-900 hover:underline">Katalog</a>
                    <a href="{{ route('bookings.my') }}" class="text-slate-500 hover:text-slate-900 transition">Booking Saya</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('catalog.index') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-slate-900">
                    &larr; KEMBALI KE KATALOG
                </a>
            </div>
        </header>

        <!-- Step indicator (Text-First) -->
        <div class="bg-white border-b border-slate-200 py-3 shadow-2xs">
            <div class="max-w-4xl mx-auto flex items-center justify-center gap-6 text-xs font-bold uppercase tracking-wider text-center px-4">
                <div class="flex items-center gap-2 text-slate-900">
                    <span class="px-2 py-0.5 rounded bg-slate-900 text-white text-[10px] font-black">01</span>
                    <span>Data Reservasi</span>
                </div>
                <span class="text-slate-300">———</span>
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">02</span>
                    <span>Pembayaran</span>
                </div>
                <span class="text-slate-300">———</span>
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">03</span>
                    <span>Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="flex-1 max-w-6xl w-full mx-auto px-6 md:px-8 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: Forms -->
                <div class="lg:col-span-2 space-y-6">

                    <form id="booking-form" method="POST" action="{{ route('bookings.store') }}" class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-6">
                        @csrf
                        <div class="border-b border-slate-100 pb-4">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">LANGKAH 01</span>
                            <h1 class="text-2xl font-black text-slate-900">Lengkapi Data Pemesanan</h1>
                        </div>

                        <!-- Info Pribadi -->
                        <div>
                            <span class="text-[10px] font-black text-slate-400 tracking-widest uppercase mb-3 block">INFORMASI PRIBADI PENYEWA</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required placeholder="Contoh: Budi Santoso"
                                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:border-slate-900 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor WhatsApp</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required placeholder="0812-xxxx-xxxx"
                                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:border-slate-900 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Aktif</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required placeholder="email@contoh.com"
                                       class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-semibold text-slate-900 focus:bg-white focus:border-slate-900 outline-none">
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        <!-- Detail Sewa -->
                        <div>
                            <span class="text-[10px] font-black text-slate-400 tracking-widest uppercase mb-3 block">DETAIL PERIODE SEWA</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Masuk (Check-in)</label>
                                    <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required
                                           class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-bold text-slate-900 focus:bg-white focus:border-slate-900 outline-none">
                                    @error('start_date') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Durasi Sewa</label>
                                    <select name="duration_months" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-bold uppercase text-slate-900 focus:bg-white focus:border-slate-900 outline-none cursor-pointer">
                                        <option value="1">1 BULAN</option>
                                        <option value="3">3 BULAN</option>
                                        <option value="6">6 BULAN (DISKON PROMO)</option>
                                        <option value="12">12 BULAN (1 TAHUN)</option>
                                    </select>
                                    @error('duration_months') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Contoh: Perkiraan waktu tiba atau membawa kendaraan..."
                                      class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-xs font-medium text-slate-800 focus:bg-white focus:border-slate-900 outline-none">{{ old('notes') }}</textarea>
                        </div>
                    </form>

                    <!-- Metode Pembayaran -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 shadow-xs">
                        <span class="text-[10px] font-black text-slate-400 tracking-widest uppercase mb-1 block">LANGKAH 02</span>
                        <h2 class="text-xl font-black text-slate-900 mb-5">Pilihan Pembayaran</h2>

                        <div class="space-y-3">
                            <label class="flex items-center gap-4 border-2 border-slate-900 bg-slate-50 rounded-2xl p-4 cursor-pointer">
                                <input type="radio" name="payment_method" value="qris" checked form="booking-form" class="accent-slate-900 w-4 h-4">
                                <div class="flex-1">
                                    <p class="font-black text-slate-900 text-xs uppercase tracking-wide">QRIS / E-Wallet / Instant Midtrans</p>
                                    <p class="text-slate-500 text-[11px] font-medium">OVO, GoPay, Dana, ShopeePay, Virtual Account Otomatis</p>
                                </div>
                                <span class="bg-emerald-50 text-emerald-800 border border-emerald-300 text-[10px] font-black uppercase px-2.5 py-0.5 rounded">INSTAN</span>
                            </label>

                            <label class="flex items-center gap-4 border border-slate-200 rounded-2xl p-4 cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="payment_method" value="manual" form="booking-form" class="accent-slate-900 w-4 h-4">
                                <div class="flex-1">
                                    <p class="font-black text-slate-900 text-xs uppercase tracking-wide">Transfer Bank Manual (BCA / Mandiri / BRI)</p>
                                    <p class="text-slate-500 text-[11px] font-medium">Upload bukti struk transfer setelah reservasi dibuat</p>
                                </div>
                                <span class="bg-slate-100 text-slate-700 border border-slate-300 text-[10px] font-black uppercase px-2.5 py-0.5 rounded">MANUAL</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden sticky top-24 shadow-xs">
                        @php
                            $roomPhoto = $room->photo 
                                ? (str_starts_with($room->photo, 'http') ? $room->photo : (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)))
                                : asset('images/deluxe_single_room.jpg');
                        @endphp
                        <img src="{{ $roomPhoto }}" class="w-full h-44 object-cover" alt="Kamar {{ $room->room_number }}">
                        <div class="p-6">
                            <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-300 mb-2 inline-block">TERSEDIA</span>
                            <h2 class="text-lg font-black text-slate-900">Kamar {{ $room->room_number }}</h2>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-4">Tipe: {{ $room->room_type ?: 'Standard Room' }}</p>

                            <hr class="border-slate-100 mb-4">

                            <div class="space-y-2.5 text-xs font-semibold mb-4">
                                <div class="flex justify-between">
                                    <span class="text-slate-500 uppercase text-[11px]">Tarif Sewa / Bulan</span>
                                    <span class="text-slate-900 font-bold">Rp {{ number_format($room->price_per_month, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500 uppercase text-[11px]">Biaya Administrasi</span>
                                    <span class="text-slate-900 font-bold">GRATIS</span>
                                </div>
                            </div>
                            <hr class="border-slate-200 mb-4">
                            <div class="flex justify-between items-center mb-6">
                                <span class="font-black text-slate-900 text-xs uppercase tracking-wider">Total Pembayaran</span>
                                <span class="font-black text-slate-900 text-xl">Rp {{ number_format($room->price_per_month, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" form="booking-form"
                                    class="w-full bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider py-4 rounded-2xl shadow-md transition-all">
                                KONFIRMASI & BAYAR SEKARANG &rarr;
                            </button>
                            <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-wider mt-3">
                                [ PROSES AMAN & TERENKRIPSI ]
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
