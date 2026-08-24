<x-app-layout>
    <div class="space-y-8 max-w-5xl mx-auto p-6 md:p-8 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">KONFIGURASI SISTEM</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Web & Informasi Kos</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Ubah judul hero beranda, gambar latar, kontak WhatsApp owner, dan alamat kos secara langsung.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-wider shadow-2xs">
                [ SUKSES ] {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section 1: Hero Beranda -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">BAGIAN 01</span>
                    <h2 class="text-lg font-black text-slate-900 uppercase">
                        Hero Beranda (Banner Utama)
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Atur teks utama, deskripsi, tombol, dan gambar banner yang pertama kali dilihat pengunjung.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="hero_title" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Utama (Headline)</label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'KOSIFY') }}" class="w-full text-xs font-bold uppercase tracking-wide border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="hero_subtitle" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Subjudul / Deskripsi Singkat</label>
                        <textarea name="hero_subtitle" id="hero_subtitle" rows="3" class="w-full text-xs font-medium border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all leading-relaxed" required>{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Temukan kos impianmu dengan fasilitas lengkap, desain estetis, dan proses booking yang bebas ribet dalam satu platform.') }}</textarea>
                    </div>

                    <div>
                        <label for="hero_button_text" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Teks Tombol Aksi</label>
                        <input type="text" name="hero_button_text" id="hero_button_text" value="{{ old('hero_button_text', $settings['hero_button_text'] ?? 'Cari Kamarmu') }}" class="w-full text-xs font-bold uppercase tracking-wider border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all">
                    </div>

                    <div>
                        <label for="hero_image" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Unggah Foto Hero Baru</label>
                        <input type="file" name="hero_image" id="hero_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:uppercase file:bg-slate-900 file:text-white hover:file:bg-black transition-all">
                        <p class="text-[10px] font-bold text-slate-400 mt-1.5 uppercase">FORMAT: JPG, PNG, WEBP (MAX: 3MB)</p>
                    </div>
                </div>

                @if(isset($settings['hero_image']) && $settings['hero_image'] != '')
                    <div class="pt-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">PREVIEW GAMBAR HERO SAAT INI:</span>
                        <div class="w-full max-w-md h-48 rounded-2xl overflow-hidden border border-slate-200 shadow-sm relative group bg-slate-100">
                            @php
                                $heroImgSrc = str_starts_with($settings['hero_image'], 'http') ? $settings['hero_image'] : (str_starts_with($settings['hero_image'], 'images/') ? asset($settings['hero_image']) : asset('storage/' . $settings['hero_image']));
                            @endphp
                            <img src="{{ $heroImgSrc }}" alt="Hero Image" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif
            </div>

            <!-- Section 2: Informasi Owner & Kontak Kos -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">BAGIAN 02</span>
                    <h2 class="text-lg font-black text-slate-900 uppercase">
                        Informasi Owner & Kontak Layanan
                    </h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Kontak ini otomatis tampil di footer, pesan chatbot, dan nota sewa.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="owner_name" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Pemilik / Pengelola</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $settings['owner_name'] ?? 'Bpk. Kosify Owner') }}" class="w-full text-xs font-bold border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all">
                    </div>

                    <div>
                        <label for="owner_phone" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor WhatsApp / Telp</label>
                        <input type="text" name="owner_phone" id="owner_phone" value="{{ old('owner_phone', $settings['owner_phone'] ?? '0812-3456-7890') }}" class="w-full text-xs font-bold border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all">
                    </div>

                    <div>
                        <label for="owner_email" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Email Resmi</label>
                        <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email', $settings['owner_email'] ?? 'owner@kosify.com') }}" class="w-full text-xs font-bold border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all">
                    </div>

                    <div>
                        <label for="kos_address" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Lengkap Kos</label>
                        <input type="text" name="kos_address" id="kos_address" value="{{ old('kos_address', $settings['kos_address'] ?? 'Jl. Kosify Raya No. 88, Pusat Kota') }}" class="w-full text-xs font-bold border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Submit Button (Text-First) -->
            <div class="flex items-center justify-end gap-4 pt-2">
                <button type="submit" class="px-8 py-3.5 bg-slate-900 hover:bg-black text-white text-xs font-black uppercase tracking-wider rounded-2xl transition-all shadow-md hover:shadow-lg">
                    SIMPAN SEMUA PERUBAHAN &rarr;
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
