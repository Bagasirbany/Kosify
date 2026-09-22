<x-app-layout>
    <div x-data="{ roleModalOpen: false, resetModalOpen: false, activeUser: {} }" class="bg-slate-50 min-h-screen p-6 md:p-8 animate-[fadeIn_0.5s_ease-out] font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">PENGELOLAAN SISTEM (ADMIN WEB)</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Akun Pengguna</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola seluruh akun pengguna, peran hak akses (Admin Web / Pemilik Kos / Penyewa), dan setel ulang kata sandi.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-black uppercase tracking-wider">
                    ROLE: ADMIN WEB (SUPER ADMIN)
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- TOP SUMMARY METRICS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">TOTAL AKUN TERDAFTAR</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $roleCounts['all'] }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-indigo-500 block">ADMIN WEB (IT)</span>
                <h3 class="text-2xl font-black text-indigo-600 mt-1">{{ $roleCounts['admin_web'] }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-600 block">PEMILIK KOS (OWNER)</span>
                <h3 class="text-2xl font-black text-emerald-700 mt-1">{{ $roleCounts['pemilik'] }}</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-500 block">PENYEWA KOS</span>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $roleCounts['penyewa'] }}</h3>
            </div>
        </div>

        <!-- SEARCH & FILTER -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau nomor telepon..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-slate-900">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <select name="role" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:outline-hidden">
                    <option value="">Semua Peran (Role)</option>
                    <option value="admin_web" {{ request('role') === 'admin_web' ? 'selected' : '' }}>Admin Web</option>
                    <option value="pemilik" {{ request('role') === 'pemilik' ? 'selected' : '' }}>Pemilik Kos</option>
                    <option value="penyewa" {{ request('role') === 'penyewa' ? 'selected' : '' }}>Penyewa</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-black transition-colors cursor-pointer">
                    Filter
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-colors flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- MAIN TABLE CARD -->
        <div class="bg-white border border-slate-200 rounded-3xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-4 font-bold">Email & Telepon</th>
                            <th scope="col" class="px-6 py-4 font-bold">Peran (Role)</th>
                            <th scope="col" class="px-6 py-4 font-bold">Terdaftar</th>
                            <th scope="col" class="px-6 py-4 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 font-black text-xs flex items-center justify-center">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span>{{ $user->name }}</span>
                                        @if(auth()->id() === $user->id)
                                            <span class="text-[9px] font-black uppercase text-indigo-600 ml-1">(Akun Anda)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $user->email }}</div>
                                <div class="text-[11px] text-slate-400">{{ $user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin_web')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-black uppercase rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                        Admin Web
                                    </span>
                                @elseif(in_array($user->role, ['pemilik', 'admin']))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-black uppercase rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        Pemilik Kos
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-black uppercase rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Penyewa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-medium">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Form Ubah Role Cepat --}}
                                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="inline flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="text-[11px] font-bold px-2 py-1 rounded-lg border border-slate-200 bg-slate-50 text-slate-700 focus:bg-white cursor-pointer" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                            <option value="admin_web" {{ $user->role === 'admin_web' ? 'selected' : '' }}>Set Admin Web</option>
                                            <option value="pemilik" {{ in_array($user->role, ['pemilik', 'admin']) ? 'selected' : '' }}>Set Pemilik Kos</option>
                                            <option value="penyewa" {{ in_array($user->role, ['penyewa', 'user']) || is_null($user->role) ? 'selected' : '' }}>Set Penyewa</option>
                                        </select>
                                    </form>

                                    {{-- Tombol Reset Password --}}
                                    <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password akun {{ $user->name }} menjadi: kosify123?')" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors cursor-pointer" title="Reset Password ke kosify123">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium text-xs">
                                Tidak ada akun pengguna yang sesuai dengan filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
