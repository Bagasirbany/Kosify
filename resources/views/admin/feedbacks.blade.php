<x-app-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between flex-wrap gap-4 pb-4 border-b border-slate-200">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-600 block mb-1">Feedback Pengguna</span>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kritik & Saran Pengunjung</h1>
                <p class="text-xs text-slate-600 mt-0.5 font-medium">Daftar masukan dan pesan kontak dari pengunjung website Kosify.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <!-- Feedback Table Card -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-2xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold tracking-wider border-b border-slate-200">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Nama & Kontak</th>
                            <th scope="col" class="px-6 py-3.5">Pesan Feedback</th>
                            <th scope="col" class="px-6 py-3.5">Waktu Kirim</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse ($feedbacks as $fb)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900">{{ $fb->name ?? 'Pengunjung' }}</p>
                                <p class="text-[11px] text-slate-500 font-medium">{{ $fb->email ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <p class="text-slate-800 leading-relaxed">{{ $fb->message ?? $fb->content ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $fb->created_at ? $fb->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <form action="{{ route('feedbacks.destroy', $fb->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus feedback ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition border border-rose-200">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-medium text-xs">
                                Belum ada pesan feedback yang masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
