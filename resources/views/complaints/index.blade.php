<x-catalog-layout>
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex-1 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-6 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">LAYANAN PENGHUNI</span>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Lapor Kendala & Fasilitas</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Sampaikan keluhan fasilitas kamar atau area bersama (AC, kran, listrik, WiFi) untuk ditangani teknisi pengelola.</p>
            </div>
            
            <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Kosify, saya ' . auth()->user()->name . ' ingin lapor kendala mendesak...') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-xs transition-all">
                CHAT WA OWNER &rarr;
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-wider shadow-2xs">
                [ SUKSES ] {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Left: Form Buat Laporan Baru -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs lg:col-span-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">TIKET BARU</span>
                <h2 class="text-lg font-black text-slate-900 uppercase mb-1">Buat Laporan Kendala</h2>
                <p class="text-xs text-slate-500 font-medium mb-6">Isi formulir agar teknisi kami dapat segera meninjau.</p>

                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    @if($activeReservation && $activeReservation->room)
                        <input type="hidden" name="room_id" value="{{ $activeReservation->room->id }}">
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs">
                            <span class="text-slate-400 block font-bold uppercase tracking-wider text-[9px]">KAMAR ANDA</span>
                            <span class="font-black text-slate-900 text-xs">Kamar {{ $activeReservation->room->room_number }} ({{ $activeReservation->room->room_type }})</span>
                        </div>
                    @endif

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Kendala</label>
                        <input type="text" name="title" required placeholder="Contoh: AC kurang dingin / Kran bocor" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold focus:outline-none focus:border-slate-900 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                        <select name="category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold uppercase focus:outline-none focus:border-slate-900 focus:bg-white transition-all cursor-pointer">
                            <option value="AC & Pendingin">AC & PENDINGIN RUANGAN</option>
                            <option value="Air & Kamar Mandi">AIR & SALURAN KAMAR MANDI</option>
                            <option value="Listrik & Lampu">LISTRIK & LAMPU</option>
                            <option value="Koneksi WiFi">KONEKSI WIFI / INTERNET</option>
                            <option value="Furnitur & Kasur">FURNITUR (KASUR, LEMARI, MEJA)</option>
                            <option value="Kebersihan">KEBERSIHAN AREA KOS</option>
                            <option value="Lainnya">LAINNYA</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap</label>
                        <textarea name="description" rows="3" required placeholder="Jelaskan detail kendala yang dialami secara rinci..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:outline-none focus:border-slate-900 focus:bg-white transition-all leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto Bukti (Opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:uppercase file:bg-slate-900 file:text-white hover:file:bg-black cursor-pointer">
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-black text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md transition-all mt-2">
                        KIRIM LAPORAN KENDALA &rarr;
                    </button>
                </form>
            </div>

            <!-- Right: Daftar Tiket Laporan -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-base font-black text-slate-900 uppercase">Riwayat Tiket Laporan ({{ $complaints->count() }})</h2>
                </div>

                @forelse($complaints as $item)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col sm:flex-row gap-6 items-start justify-between">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $item->category }}
                                </span>
                                @if($item->status === 'pending')
                                    <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-300">
                                        MENUNGGU DITINJAU
                                    </span>
                                @elseif($item->status === 'in_progress')
                                    <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded bg-blue-50 text-blue-800 border border-blue-300">
                                        SEDANG DITANGANI
                                    </span>
                                @else
                                    <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-300">
                                        SELESAI DIPERBAIKI
                                    </span>
                                @endif
                                <span class="text-[11px] font-bold text-slate-400">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="text-base font-black text-slate-900 mb-1 tracking-tight">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mb-3 font-medium">{{ $item->description }}</p>

                            @if($item->admin_notes)
                                <div class="bg-slate-50 border-l-4 border-slate-900 p-3 rounded-r-xl text-xs text-slate-700 mb-3">
                                    <span class="font-black block text-slate-900 text-[10px] uppercase tracking-wider mb-0.5">Catatan Teknisi Pengelola:</span>
                                    <p class="font-medium">{{ $item->admin_notes }}</p>
                                </div>
                            @endif

                            @if($item->photo)
                                <a href="{{ asset('storage/' . $item->photo) }}" target="_blank" class="text-[10px] font-black uppercase tracking-wider text-blue-600 hover:underline block">
                                    [ LIHAT FOTO BUKTI ]
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-400 block mb-2">[ DATA BERSIH ]</span>
                        <h3 class="font-black text-slate-900 text-base mb-1">Semua Fasilitas Berfungsi Normal</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto font-medium">Anda belum memiliki riwayat kendala. Gunakan formulir di sebelah kiri jika ada fasilitas kamar yang membutuhkan perbaikan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-catalog-layout>
