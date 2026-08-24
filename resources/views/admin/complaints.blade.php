<x-app-layout>
    <div class="p-6 md:p-8 max-w-7xl mx-auto space-y-8 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">LAYANAN & PEMELIHARAAN</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Kendala & Komplain</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola laporan kerusakan fasilitas dan permintaan perbaikan dari penyewa kos.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-wider shadow-2xs">
                [ SUKSES ] {{ session('success') }}
            </div>
        @endif

        <!-- Stat Cards (Text-First) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-widest text-amber-700 block mb-2">MENUNGGU DITINJAU</span>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ $pendingCount }} <span class="text-sm font-bold text-slate-400">TIKET</span></h3>
                <p class="text-xs text-slate-500 font-medium">Perlu penugasan teknisi</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-700 block mb-2">SEDANG DIKERJAKAN</span>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ $inProgressCount }} <span class="text-sm font-bold text-slate-400">TIKET</span></h3>
                <p class="text-xs text-slate-500 font-medium">Dalam proses perbaikan fasilitas</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-700 block mb-2">SELESAI DIPERBAIKI</span>
                <h3 class="text-3xl font-black text-slate-900 mb-1">{{ $resolvedCount }} <span class="text-sm font-bold text-slate-400">TIKET</span></h3>
                <p class="text-xs text-slate-500 font-medium">Laporan kendala telah teratasi</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">TABEL TIKET</span>
                    <h2 class="text-base font-black text-slate-900">Daftar Laporan Masuk</h2>
                </div>
                <div class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider flex-wrap">
                    <a href="{{ route('admin.complaints.index') }}" class="px-3.5 py-1.5 rounded-xl {{ !request('status') || request('status') === 'all' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">SEMUA</a>
                    <a href="{{ route('admin.complaints.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl {{ request('status') === 'pending' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">PENDING</a>
                    <a href="{{ route('admin.complaints.index', ['status' => 'in_progress']) }}" class="px-3.5 py-1.5 rounded-xl {{ request('status') === 'in_progress' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">PROSES</a>
                    <a href="{{ route('admin.complaints.index', ['status' => 'resolved']) }}" class="px-3.5 py-1.5 rounded-xl {{ request('status') === 'resolved' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">SELESAI</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6">PELAPOR / KAMAR</th>
                            <th class="py-4 px-6">KATEGORI & JUDUL</th>
                            <th class="py-4 px-6">DESKRIPSI & FOTO</th>
                            <th class="py-4 px-6">STATUS & TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($complaints as $item)
                            <tr class="hover:bg-slate-50 transition-colors items-start">
                                <td class="py-4 px-6 align-top">
                                    <span class="font-black text-slate-900 block text-xs">{{ $item->user->name ?? 'Penyewa' }}</span>
                                    <span class="text-[11px] text-slate-400 font-semibold block">{{ $item->user->phone ?? $item->user->email ?? '-' }}</span>
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 rounded text-[10px] font-bold uppercase tracking-wider text-slate-800 border border-slate-200">
                                        KAMAR {{ $item->room->room_number ?? '-' }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 align-top">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">
                                        {{ $item->category }}
                                    </span>
                                    <span class="font-black text-slate-900 block text-xs">{{ $item->title }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold">{{ $item->created_at->format('d M Y, H:i') }}</span>
                                </td>

                                <td class="py-4 px-6 align-top max-w-xs">
                                    <p class="text-xs text-slate-700 leading-relaxed mb-2 font-medium">{{ $item->description }}</p>
                                    @if($item->photo)
                                        <a href="{{ asset('storage/' . $item->photo) }}" target="_blank" class="text-[10px] font-black uppercase tracking-wider text-blue-600 hover:underline block">
                                            [ LIHAT FOTO KERUSAKAN ]
                                        </a>
                                    @endif
                                </td>

                                <td class="py-4 px-6 align-top">
                                    <form action="{{ route('admin.complaints.update', $item->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status" class="w-full text-xs font-bold uppercase border border-slate-300 rounded-xl px-3 py-1.5 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none cursor-pointer">
                                            <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>PENDING (MENUNGGU)</option>
                                            <option value="in_progress" {{ $item->status === 'in_progress' ? 'selected' : '' }}>SEDANG DIKERJAKAN</option>
                                            <option value="resolved" {{ $item->status === 'resolved' ? 'selected' : '' }}>SELESAI DIPERBAIKI</option>
                                        </select>

                                        <input type="text" name="admin_notes" value="{{ $item->admin_notes }}" placeholder="Catatan teknisi..." class="w-full text-xs font-semibold px-3 py-1.5 rounded-xl border border-slate-300 bg-slate-50 focus:bg-white focus:border-slate-900 outline-none">

                                        <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-black text-white text-[11px] font-black uppercase tracking-wider rounded-xl transition-all shadow-xs">
                                            SIMPAN TINDAKAN &rarr;
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400 font-bold uppercase tracking-wider text-xs">
                                    Belum ada laporan kendala masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
