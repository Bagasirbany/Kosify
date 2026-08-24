<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- Header & Breadcrumb -->
        <div class="flex items-center justify-between flex-wrap gap-4 pb-4 border-b border-slate-200">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <a href="{{ route('rooms.index') }}" class="hover:text-slate-900 transition">&larr; KEMBALI KE MANAJEMEN KAMAR</a>
                </p>
                <h1 class="text-2xl font-black text-slate-900 mt-1">Kamar {{ $room->room_number }} - {{ $room->room_type ?: 'Standard Room' }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('rooms.edit', $room->id) }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-black transition-all shadow-xs">
                    EDIT KAMAR
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Detail -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
                    <div class="relative aspect-[16/9] bg-slate-900">
                        @php
                            $detailPhoto = $room->photo 
                                ? (str_starts_with($room->photo, 'http') ? $room->photo : (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)))
                                : asset('images/deluxe_single_room.jpg');
                        @endphp
                        <img src="{{ $detailPhoto }}" class="w-full h-full object-cover" alt="Kamar {{ $room->room_number }}">
                        <div class="absolute bottom-4 left-4 flex items-center gap-2">
                            <span class="text-xs font-black uppercase tracking-wider px-3 py-1 rounded-md text-white bg-slate-900/90 backdrop-blur-md">
                                KAMAR {{ $room->room_number }}
                            </span>
                            @if(in_array(strtolower($room->status), ['available', 'tersedia']))
                                <span class="text-xs font-black uppercase tracking-wider px-3 py-1 rounded-md text-white bg-emerald-600">TERSEDIA</span>
                            @elseif(in_array(strtolower($room->status), ['occupied', 'terisi']))
                                <span class="text-xs font-black uppercase tracking-wider px-3 py-1 rounded-md text-white bg-amber-600">TERISI</span>
                            @else
                                <span class="text-xs font-black uppercase tracking-wider px-3 py-1 rounded-md text-white bg-rose-600">PERBAIKAN</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 md:p-8 space-y-6">
                        <div class="flex items-start justify-between gap-4 flex-wrap pb-6 border-b border-slate-100">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-1">TIPE KAMAR</span>
                                <h2 class="text-2xl font-black text-slate-900">{{ $room->room_type ?: 'Standard Single' }}</h2>
                                <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wider">Lokasi: Sayap Utama, Lantai 1</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">TARIF SEWA</span>
                                <p class="text-2xl font-black text-slate-900">
                                    Rp {{ number_format($room->price_per_month, 0, ',', '.') }}<span class="text-xs font-medium text-slate-400"> / BLN</span>
                                </p>
                            </div>
                        </div>

                        <!-- Specs Grid (Text-First) -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-2">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Ukuran</p>
                                <p class="text-xs font-black text-slate-900 uppercase">4 x 5 M²</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Listrik</p>
                                <p class="text-xs font-black text-slate-900 uppercase">Token 1300W</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kamar Mandi</p>
                                <p class="text-xs font-black text-slate-900 uppercase">Dalam (Shower)</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kapasitas</p>
                                <p class="text-xs font-black text-slate-900 uppercase">1 Orang</p>
                            </div>
                        </div>

                        <!-- Fasilitas Tags -->
                        <div class="pt-6 border-t border-slate-100">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">FASILITAS KAMAR</span>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider border border-slate-200">WiFi Fiber 50Mbps</span>
                                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider border border-slate-200">AC 1/2 PK</span>
                                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider border border-slate-200">Kasur Springbed</span>
                                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider border border-slate-200">Lemari Pakaian</span>
                                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider border border-slate-200">Meja Kerja & Kursi</span>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="pt-6 border-t border-slate-100">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2">DESKRIPSI LENGKAP</span>
                            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                {{ $room->description ?: 'Kamar kos modern dengan sirkulasi udara optimal, pencahayaan alami yang baik, dan lingkungan tenang yang sangat cocok untuk istirahat maupun fokus bekerja/belajar.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Info -->
            <div class="space-y-6">
                <!-- Status Box -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs space-y-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">STATUS HUNIAN</span>
                    
                    <div class="p-4 rounded-2xl border {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-800' }}">
                        <p class="text-xs font-black uppercase tracking-wider">
                            {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'STATUS: TERSEDIA (SIAP HUNI)' : 'STATUS: TERISI OLEH PENYEWA' }}
                        </p>
                        <p class="text-[11px] font-medium text-slate-500 mt-1">
                            {{ in_array(strtolower($room->status), ['available', 'tersedia']) ? 'Kamar dapat langsung dipesan oleh calon penyewa baru melalui katalog.' : 'Kamar sedang dalam masa sewa aktif.' }}
                        </p>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('rooms.index') }}" class="block w-full py-2.5 px-4 text-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold uppercase tracking-wider transition-colors">
                            KEMBALI KE DAFTAR KAMAR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
