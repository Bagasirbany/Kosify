<x-public-layout>
    <!-- ============ HERO SECTION ============ -->
    <section id="beranda" class="pt-4 sm:pt-6 pb-8 sm:pb-12 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto h-[60vh] sm:h-[70vh] min-h-[440px] sm:min-h-[500px] max-h-[700px] relative rounded-2xl sm:rounded-3xl overflow-hidden group bg-black">
            <!-- Background Image (High Priority LCP) -->
            <img src="{{ isset($settings['hero_image']) && $settings['hero_image'] != '' ? (str_starts_with($settings['hero_image'], 'images/') ? asset($settings['hero_image']) : asset('storage/' . $settings['hero_image'])) : asset('images/deluxe_single_room.jpg') }}" alt="Modern Kos Room" fetchpriority="high" decoding="async" class="w-full h-full object-cover">
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex flex-col items-start justify-end text-left px-5 sm:px-8 md:px-16 pb-8 sm:pb-16 md:pb-24">
                <h1 class="text-white font-black text-4xl sm:text-6xl lg:text-7xl tracking-tight mb-3 sm:mb-4 drop-shadow-lg">
                    {{ $settings['hero_title'] ?? 'KOSIFY' }}
                </h1>
                <p class="text-white/90 font-medium text-sm sm:text-lg md:text-xl max-w-2xl mb-6 sm:mb-10 drop-shadow-md">
                    {{ $settings['hero_subtitle'] ?? 'Temukan kos impianmu dengan fasilitas lengkap, desain estetis, dan proses booking yang bebas ribet dalam satu platform.' }}
                </p>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full sm:w-auto">
                    <!-- Primary Button (Text-First) -->
                    <a href="{{ route('catalog.index') }}" class="group inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-white text-slate-900 font-black text-sm uppercase tracking-wider rounded-full hover:bg-slate-100 hover:shadow-xl transition-all duration-300 w-full sm:w-auto text-center">
                        <span>{{ $settings['hero_button_text'] ?? 'Cari Kamarmu' }}</span>
                        <span class="font-bold text-slate-900 group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHY CHOOSE US ============ -->
    <section id="keunggulan" class="py-20 px-6">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left: Stats -->
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-3 block">KEUNGGULAN KOSIFY</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-6">
                    Mengapa Ribuan Anak Kos Memilih KOSIFY untuk Hunian Mereka
                </h2>
                <p class="text-slate-600 mb-12 leading-relaxed font-medium text-sm">
                    Mulai dari lokasi strategis dekat kampus hingga dukungan fasilitas lengkap, kami membuat pencarian dan penyewaan kos menjadi lebih aman, nyaman, dan terpercaya dengan dukungan penuh.
                </p>
                
                <div class="grid grid-cols-3 border-t border-slate-200 pt-8 text-center gap-4">
                    <div>
                        <span class="text-3xl font-black text-slate-900 block">12k+</span>
                        <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mt-1">Penyewa Puas</p>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-slate-900 block">5 THN</span>
                        <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mt-1">Pengalaman</p>
                    </div>
                    <div>
                        <span class="text-3xl font-black text-slate-900 block">50+</span>
                        <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mt-1">Lokasi Kos</p>
                    </div>
                </div>
            </div>

            <!-- Right: Feature Cards (Typography-Driven) -->
            <div class="flex flex-col gap-4">
                <!-- Card 1 -->
                <div class="bg-slate-100/80 border border-slate-200/60 rounded-2xl p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-slate-100 transition-colors">
                    <div class="text-2xl font-black text-slate-900 tracking-tighter shrink-0 w-12 h-12 bg-white rounded-xl border border-slate-200 flex items-center justify-center shadow-2xs">
                        01
                    </div>
                    <div>
                        <h4 class="text-base font-bold uppercase tracking-wide text-slate-900 mb-1">Kurasi Ahli Lokal</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">Tim kami memastikan setiap kos memenuhi standar kenyamanan dan keamanan sebelum ditampilkan di platform.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-100/80 border border-slate-200/60 rounded-2xl p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-slate-100 transition-colors">
                    <div class="text-2xl font-black text-slate-900 tracking-tighter shrink-0 w-12 h-12 bg-white rounded-xl border border-slate-200 flex items-center justify-center shadow-2xs">
                        02
                    </div>
                    <div>
                        <h4 class="text-base font-bold uppercase tracking-wide text-slate-900 mb-1">Pemesanan Praktis</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">Booking kos idaman Anda dalam satu tempat—mudah, cepat, dan transparan tanpa biaya tersembunyi.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-100/80 border border-slate-200/60 rounded-2xl p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-slate-100 transition-colors">
                    <div class="text-2xl font-black text-slate-900 tracking-tighter shrink-0 w-12 h-12 bg-white rounded-xl border border-slate-200 flex items-center justify-center shadow-2xs">
                        03
                    </div>
                    <div>
                        <h4 class="text-base font-bold uppercase tracking-wide text-slate-900 mb-1">Dukungan 24/7</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">Tim support kami siap membantu Anda kapan saja. Dapatkan bantuan real-time sebelum dan selama menyewa.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ============ TOP ROOMS (CATALOG) ============ -->
    <section id="katalog" class="py-12 px-6">
        <div class="max-w-7xl mx-auto bg-slate-50 rounded-[2.5rem] p-8 md:p-12 border border-slate-200">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-10">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-2 block">PILIHAN TERBAIK</span>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900">Katalog Tipe Kamar</h2>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-xs font-bold uppercase tracking-wider text-slate-900 hover:underline">
                    LIHAT SEMUA KAMAR &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                @forelse($popularRooms as $room)
                <!-- Card -->
                <div class="group relative rounded-2xl overflow-hidden aspect-[3/4] shadow-sm bg-black">
                    <a href="{{ route('rooms.detail', $room->id) }}">
                        @php
                            $roomPhoto = $room->photo;
                            if (!$roomPhoto) {
                                $fallbackIndex = ($loop->index % 4) + 1;
                                $roomPhoto = "images/room_{$fallbackIndex}.jpg";
                            }
                        @endphp
                        <img src="{{ str_starts_with($roomPhoto, 'images/') ? asset($roomPhoto) : asset('storage/' . $roomPhoto) }}" loading="lazy" decoding="async" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Kamar {{ $room->room_number }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                        
                        <div class="absolute top-4 right-4 bg-white/95 backdrop-blur text-[11px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full text-slate-900 shadow-sm">
                            Rp {{ number_format($room->price_per_month, 0, ',', '.') }}
                        </div>

                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 mb-1 block">TERSEDIA</span>
                            <h3 class="text-white font-black text-lg mb-1 tracking-tight">Kamar {{ $room->room_number }}</h3>
                            <p class="text-white/80 text-xs font-medium">{{ $room->room_type ?: 'Standard Room' }}</p>
                        </div>
                    </a>
                </div>
                @empty
                    <p class="col-span-4 text-center text-slate-500 py-10 font-bold uppercase tracking-wider text-xs">Belum ada kamar yang tersedia saat ini.</p>
                @endforelse

            </div>

        </div>
    </section>

    <!-- ============ HOUSING HIGHLIGHTS ============ -->
    <section id="promo" class="py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Pilihan Hunian Sesuai Kebutuhan</h2>
                <p class="text-slate-600 text-sm font-medium mt-1">Dirancang khusus untuk kenyamanan belajar mahasiswa dan produktivitas profesional muda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Info Card -->
                <div class="bg-slate-900 text-white rounded-2xl p-7 flex flex-col justify-between items-start min-h-[280px]">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-2">FLEKSIBEL &amp; SIAP HUNI</span>
                        <h3 class="text-2xl font-black mb-3">Sewa Bulanan hingga Tahunan</h3>
                        <p class="text-slate-300 text-xs leading-relaxed font-medium">Nikmati kebebasan memilih durasi sewa dengan fasilitas lengkap siap pakai tanpa biaya admin tersembunyi.</p>
                    </div>
                    <a href="{{ route('catalog.index') }}" class="px-6 py-2.5 bg-white text-slate-900 font-bold uppercase tracking-wider rounded-full text-xs hover:bg-slate-100 transition-colors mt-6">
                        Cek Ketersediaan Kamar &rarr;
                    </a>
                </div>

                <!-- Housing Card 1: Mahasiswa -->
                <div class="relative rounded-2xl overflow-hidden min-h-[280px] shadow-sm bg-slate-900">
                    <img src="{{ asset('images/room_1.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="Hunian Mahasiswa">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-600 text-white px-2.5 py-0.5 rounded-md inline-block mb-2">Mahasiswa &amp; Pelajar</span>
                        <h3 class="text-white font-bold text-lg mb-1">Fokus Belajar, Dekat Kampus</h3>
                        <p class="text-white/80 text-xs font-medium leading-relaxed">Meja belajar luas, WiFi kencang &amp; stabil, serta suasana tenang.</p>
                    </div>
                </div>

                <!-- Housing Card 2: Karyawan -->
                <div class="relative rounded-2xl overflow-hidden min-h-[280px] shadow-sm bg-slate-900">
                    <img src="{{ asset('images/room_2.jpg') }}" class="absolute inset-0 w-full h-full object-cover" alt="Hunian Karyawan">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="text-[10px] font-bold uppercase tracking-wider bg-indigo-600 text-white px-2.5 py-0.5 rounded-md inline-block mb-2">Karyawan &amp; Pekerja</span>
                        <h3 class="text-white font-bold text-lg mb-1">Privasi Terjaga, Akses 24 Jam</h3>
                        <p class="text-white/80 text-xs font-medium leading-relaxed">Kamar mandi dalam, springbed premium, dan akses pintu mandiri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ HOW IT WORKS ============ -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-2 block">ALUR PEMESANAN</span>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">Booking Semudah 1-2-3</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200">
                    <div class="text-2xl font-black text-slate-900 tracking-tighter shrink-0 w-12 h-12 bg-white rounded-xl border border-slate-200 flex items-center justify-center shadow-2xs">
                        01
                    </div>
                    <div>
                        <h4 class="font-bold uppercase tracking-wide text-slate-900 mb-1 text-sm">Pilih Kamar</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">Cari tipe kamar yang sesuai dengan kebutuhan dan budget Anda dari katalog lengkap kami.</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200">
                    <div class="text-2xl font-black text-slate-900 tracking-tighter shrink-0 w-12 h-12 bg-white rounded-xl border border-slate-200 flex items-center justify-center shadow-2xs">
                        02
                    </div>
                    <div>
                        <h4 class="font-bold uppercase tracking-wide text-slate-900 mb-1 text-sm">Booking Online</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">Isi data diri dan tentukan tanggal masuk. Proses cepat, aman, dan dapat dilakukan kapan saja.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-2xl border border-slate-200">
                    <div class="text-2xl font-black text-slate-900 tracking-tighter shrink-0 w-12 h-12 bg-white rounded-xl border border-slate-200 flex items-center justify-center shadow-2xs">
                        03
                    </div>
                    <div>
                        <h4 class="font-bold uppercase tracking-wide text-slate-900 mb-1 text-sm">Konfirmasi & Pindah</h4>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">Selesaikan pembayaran dan dapatkan konfirmasi instan. Kamar siap ditempati.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
