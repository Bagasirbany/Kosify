<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <div class="mb-6 pb-4 border-b border-slate-200">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">PROPERTI KOS</span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Data Kamar {{ $room->room_number }}</h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Perbarui tarif sewa, spesifikasi tipe, dan status ketersediaan unit.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-wider shadow-2xs">
                [ SUKSES ] {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-xs">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="room_number" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor Kamar</label>
                        <input type="text" name="room_number" id="room_number" value="{{ old('room_number', $room->room_number) }}" required class="w-full text-xs font-bold border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none">
                        @error('room_number') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="room_type" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tipe Kamar</label>
                        <select name="room_type" id="room_type" required class="w-full text-xs font-bold uppercase border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none cursor-pointer">
                            <option value="Standard" {{ old('room_type', $room->room_type) === 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Deluxe" {{ old('room_type', $room->room_type) === 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="Suite" {{ old('room_type', $room->room_type) === 'Suite' ? 'selected' : '' }}>Suite</option>
                        </select>
                        @error('room_type') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="price_per_month" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Harga per Bulan (Rp)</label>
                        <input type="number" name="price_per_month" id="price_per_month" value="{{ old('price_per_month', $room->price_per_month) }}" required class="w-full text-xs font-bold border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none">
                        @error('price_per_month') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Status Hunian</label>
                        <select name="status" id="status" required class="w-full text-xs font-bold uppercase border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none cursor-pointer">
                            <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>KOSONG (AVAILABLE)</option>
                            <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>TERISI (OCCUPIED)</option>
                            <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>PERBAIKAN (MAINTENANCE)</option>
                        </select>
                        @error('status') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="photo" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Foto Utama Kamar</label>
                        @if($room->photo)
                            <div class="mb-2">
                                <img src="{{ str_starts_with($room->photo, 'http') ? $room->photo : (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)) }}" class="w-32 h-24 object-cover rounded-xl border border-slate-200" alt="Foto Saat Ini">
                            </div>
                        @endif
                        <input type="file" name="photo" id="photo" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:uppercase file:bg-slate-900 file:text-white hover:file:bg-black cursor-pointer">
                        @error('photo') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="gallery_photos" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Foto Galeri Tambahan (Bisa Pilih Banyak)</label>
                        @if($room->gallery_photos && is_array($room->gallery_photos) && count($room->gallery_photos) > 0)
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                @foreach($room->gallery_photos as $gp)
                                    <img src="{{ str_starts_with($gp, 'http') ? $gp : (str_starts_with($gp, 'images/') ? asset($gp) : asset('storage/' . $gp)) }}" class="w-16 h-12 object-cover rounded-lg border border-slate-200" alt="Galeri">
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="gallery_photos[]" id="gallery_photos" accept="image/*" multiple class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:uppercase file:bg-slate-700 file:text-white hover:file:bg-slate-800 cursor-pointer">
                        @error('gallery_photos.*') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-[10px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi & Fasilitas Kamar</label>
                        <textarea name="description" id="description" rows="4" class="w-full text-xs font-medium border border-slate-300 rounded-xl px-3.5 py-2.5 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none leading-relaxed">{{ old('description', $room->description) }}</textarea>
                        @error('description') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('rooms.index') }}" class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors">&larr; KEMBALI KE DAFTAR KAMAR</a>
                    <div class="flex gap-3">
                        <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">BATAL</a>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black uppercase tracking-wider text-white bg-slate-900 hover:bg-black rounded-xl transition-all shadow-xs">
                            SIMPAN PERUBAHAN &rarr;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
