<x-app-layout>
    <div x-data="{ showTenantModal: false }" class="bg-slate-50 min-h-screen p-6 md:p-8 animate-[fadeIn_0.5s_ease-out] font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">MANAJEMEN PENGGUNA</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Penyewa Kos</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola data seluruh penyewa aktif dan akun akses portal mereka.</p>
            </div>
            <button @click="showTenantModal = true" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-xs">
                + TAMBAH PENYEWA BARU
            </button>
        </div>

        <!-- MAIN TABLE CARD -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-xs overflow-hidden">
            
            <div class="p-6 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">DATABASE PENYEWA</span>
                    <h2 class="text-base font-black text-slate-900">Semua Penyewa Aktif ({{ count($tenants) }})</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-black tracking-wider border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-4">NAMA LENGKAP</th>
                            <th scope="col" class="px-6 py-4">KONTAK (EMAIL / TELEPON)</th>
                            <th scope="col" class="px-6 py-4">PEKERJAAN / STATUS</th>
                            <th scope="col" class="px-6 py-4">TERDAFTAR SEJAK</th>
                            <th scope="col" class="px-6 py-4 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($tenants as $tenant)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-black text-slate-900">
                                {{ $tenant->name }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $tenant->email }}</div>
                                <div class="text-[11px] text-slate-400 font-semibold">{{ $tenant->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold uppercase text-slate-600">{{ $tenant->occupation ?? 'Penyewa' }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $tenant->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-3 py-1 bg-slate-100 text-slate-800 text-[10px] font-black uppercase tracking-wider rounded-lg border border-slate-200">
                                    AKTIF
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold uppercase tracking-wider text-xs">
                                Belum ada penyewa yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-slate-100 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 text-center">
                Total: {{ count($tenants) }} Penyewa Terdata
            </div>
        </div>
        
        <!-- MODAL PENYEWA (Text-First) -->
        <div x-show="showTenantModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div x-show="showTenantModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" aria-hidden="true"></div>

                <div @click.away="showTenantModal = false" x-show="showTenantModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="inline-block bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-slate-200 p-6 md:p-8 relative z-10">
                    <form action="{{ route('tenants.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">FORMULIR PENDAFTARAN</span>
                                <h3 class="text-lg font-black text-slate-900 uppercase">Tambah Penyewa Baru</h3>
                            </div>
                            <button type="button" @click="showTenantModal = false" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold uppercase">
                                TUTUP
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                <input type="text" name="name" required class="w-full text-xs font-semibold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none" placeholder="Nama lengkap penyewa">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                                <input type="email" name="email" required class="w-full text-xs font-semibold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none" placeholder="email@contoh.com">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="phone" class="w-full text-xs font-semibold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none" placeholder="08123456789">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-700 uppercase tracking-wider mb-1">Password Sementara</label>
                                <input type="password" name="password" required class="w-full text-xs font-semibold border border-slate-300 rounded-xl bg-slate-50 focus:bg-white focus:border-slate-900 px-3.5 py-2.5 outline-none" placeholder="Password untuk akun penyewa">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showTenantModal = false" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold uppercase text-xs hover:bg-slate-50 transition-colors">
                                BATAL
                            </button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white font-black uppercase text-xs tracking-wider hover:bg-black transition-all shadow-xs">
                                SIMPAN DATA PENYEWA &rarr;
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
