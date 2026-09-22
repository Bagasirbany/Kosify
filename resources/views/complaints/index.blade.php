<x-catalog-layout>
    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex-1 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        
        {{-- Breadcrumb & Header --}}
        <div class="mb-8 pb-6 border-b border-slate-200">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                <a href="{{ route('home') }}" class="hover:text-slate-700 transition">Beranda</a>
                <span>/</span>
                <span class="text-slate-700">Layanan Penghuni</span>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Lapor Kendala & Fasilitas</h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Sampaikan keluhan fasilitas kamar atau area bersama (AC, kran, listrik, WiFi) untuk ditangani teknisi pengelola.</p>
                </div>
                
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $webSettings['owner_phone'] ?? '6285815721534')) }}?text={{ urlencode('Halo Pengelola Kosify, saya ' . auth()->user()->name . ' ingin lapor kendala mendesak...') }}" target="_blank" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-xs transition-all flex items-center gap-2 shrink-0 active:scale-95">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.693.072-2.18-.546-1.898-.788-3.125-2.73-3.22-2.857-.095-.127-.768-1.021-.768-1.948 0-.927.487-1.383.66-1.573.173-.19.378-.238.505-.238.127 0 .254.002.365.007.119.006.278-.045.435.333.161.388.549 1.341.597 1.439.048.098.08.213.016.34-.064.127-.096.206-.19.317-.095.111-.2.247-.285.333-.096.095-.196.198-.085.389.111.19.492.813 1.055 1.314.724.644 1.334.843 1.524.938.19.095.301.079.412-.048.111-.127.476-.556.603-.746.127-.19.254-.159.428-.095.175.063 1.11.523 1.301.618.19.095.317.143.365.222.048.079.048.46-.096.865z"/></svg>
                    <span>Chat WA Owner</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-2xs">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Form Buat Laporan Baru (lg:col-span-5) -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-2xs">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">TIKET BARU</span>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight mb-1">Buat Laporan Kendala</h2>
                    <p class="text-xs text-slate-500 font-medium mb-5">Isi formulir agar teknisi kami dapat segera meninjau.</p>

                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        @if($activeReservation && $activeReservation->room)
                            <input type="hidden" name="room_id" value="{{ $activeReservation->room->id }}">
                            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 block font-bold uppercase tracking-wider text-[9px]">KAMAR SEWA AKTIF</span>
                                    <span class="font-black text-slate-900 text-xs">Kamar {{ $activeReservation->room->room_number }}</span>
                                </div>
                                <span class="px-2 py-0.5 bg-slate-200 text-slate-700 text-[10px] font-black uppercase rounded-md">
                                    Lantai {{ $activeReservation->room->floor_number }}
                                </span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Kendala</label>
                            <input type="text" name="title" required placeholder="Contoh: AC kurang dingin / Kran bocor" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:border-slate-900 focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori</label>
                            <select name="category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold uppercase focus:outline-none focus:border-slate-900 focus:bg-white transition-all cursor-pointer">
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
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap</label>
                            <textarea name="description" rows="3" required placeholder="Jelaskan detail kendala yang dialami secara rinci..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-slate-900 focus:bg-white transition-all leading-relaxed"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto Bukti (Opsional)</label>
                            <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:uppercase file:bg-slate-900 file:text-white hover:file:bg-black cursor-pointer">
                        </div>

                        <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-xs transition-all mt-2 active:scale-98">
                            KIRIM LAPORAN KENDALA &rarr;
                        </button>
                    </form>

                    <p class="text-[11px] text-slate-400 text-center font-medium mt-4 pt-3 border-t border-slate-100">
                        Jam kerja teknisi: Senin - Sabtu (08:00 - 17:00). Kendala darurat ditangani 24 jam.
                    </p>
                </div>
            </div>

            <!-- Right Column: Daftar Tiket Laporan (lg:col-span-7) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="flex items-center justify-between mb-1">
                    <h2 class="text-base font-black text-slate-900 uppercase">Riwayat Tiket Laporan ({{ $complaints->count() }})</h2>
                </div>

                @forelse($complaints as $item)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-2xs flex flex-col sm:flex-row gap-6 items-start justify-between">
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
                    <!-- Single Clean Reassuring Card (Sederhana & Proporsional) -->
                    <div class="bg-white rounded-3xl p-7 border border-slate-200 shadow-2xs">
                        <div class="text-center pb-6 border-b border-slate-100">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base mb-1">Semua Fasilitas Berfungsi Normal</h3>
                            <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                                Anda belum memiliki riwayat kendala. Gunakan formulir jika ada fasilitas kamar yang membutuhkan pengecekan atau perbaikan.
                            </p>
                        </div>

                        <!-- Informasi Layanan Sederhana & Rapi -->
                        <div class="pt-6">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3.5">Ketentuan & Waktu Penanganan</h4>
                            <div class="space-y-3.5 text-xs text-slate-600">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-800">Waktu Penanganan:</span>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Kendala darurat (air/listrik mati) ditangani &lt; 2 jam. Kendala umum maksimal 1x24 jam kerja.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-800">Perawatan Gratis:</span>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Penggantian bohlam kamar tidur dan servis filter AC berkala disediakan langsung tanpa biaya tambahan.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-slate-800">Kontak Cepat:</span>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Untuk situasi mendesak di luar jam kerja (malam hari), Anda dapat langsung menghubungi WhatsApp pengelola.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-catalog-layout>
