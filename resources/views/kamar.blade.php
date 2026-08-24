<x-app-layout>
    <div class="space-y-8 font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <!-- Page Header -->
        <div class="flex items-center justify-between flex-wrap gap-4 pb-4 border-b border-slate-200">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">PROPERTI KOS</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Kamar</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola tarif sewa, status unit, dan inventaris kamar.</p>
            </div>
            <a href="{{ route('rooms.create') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-xs">
                + TAMBAH KAMAR BARU
            </a>
        </div>

        <!-- Filter Bar (Text-First) -->
        <div class="flex items-center justify-between flex-wrap gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center gap-1.5 flex-wrap" id="filter-tabs">
                <button onclick="filterRooms('all')" data-filter="all" class="filter-btn active text-xs font-bold uppercase tracking-wider px-3.5 py-2 rounded-xl bg-slate-900 text-white transition-all shadow-2xs">
                    Semua (<span id="count-all">-</span>)
                </button>
                <button onclick="filterRooms('Terisi')" data-filter="Terisi" class="filter-btn text-xs font-bold uppercase tracking-wider px-3.5 py-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all">
                    Terisi (<span id="count-Terisi">-</span>)
                </button>
                <button onclick="filterRooms('Kosong')" data-filter="Kosong" class="filter-btn text-xs font-bold uppercase tracking-wider px-3.5 py-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all">
                    Kosong (<span id="count-Kosong">-</span>)
                </button>
                <button onclick="filterRooms('Perbaikan')" data-filter="Perbaikan" class="filter-btn text-xs font-bold uppercase tracking-wider px-3.5 py-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all">
                    Perbaikan (<span id="count-Perbaikan">-</span>)
                </button>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TIPE:</span>
                    <select onchange="filterByType(this.value)" class="text-xs font-bold uppercase tracking-wider border border-slate-200 rounded-xl px-3 py-1.5 bg-slate-50 text-slate-800 outline-none cursor-pointer">
                        <option value="all">SEMUA TIPE</option>
                        <option value="Standard">STANDARD</option>
                        <option value="Deluxe">DELUXE</option>
                        <option value="Suite">SUITE</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">URUTKAN:</span>
                    <select onchange="sortRooms(this.value)" class="text-xs font-bold uppercase tracking-wider border border-slate-200 rounded-xl px-3 py-1.5 bg-slate-50 text-slate-800 outline-none cursor-pointer">
                        <option value="nomor">NOMOR KAMAR</option>
                        <option value="harga_asc">HARGA TERENDAH</option>
                        <option value="harga_desc">HARGA TERTINGGI</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Room Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="room-grid">
            @foreach ($rooms as $room)
            @php
                $displayStatus = 'Kosong';
                $badgeBg = 'bg-emerald-50 text-emerald-800 border-emerald-300';
                
                if ($room->status === 'occupied') {
                    $displayStatus = 'Terisi';
                    $badgeBg = 'bg-slate-100 text-slate-800 border-slate-300';
                } elseif ($room->status === 'maintenance') {
                    $displayStatus = 'Perbaikan';
                    $badgeBg = 'bg-rose-50 text-rose-800 border-rose-300';
                }
            @endphp
            <div class="room-card group bg-white border border-slate-200 rounded-3xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between"
                    data-status="{{ $displayStatus }}"
                    data-tipe="{{ $room->room_type }}"
                    data-harga="{{ $room->price_per_month }}"
                    data-nomor="Kamar {{ $room->room_number }}">
                
                <!-- Room Image -->
                <div class="relative w-full h-44 bg-slate-100 overflow-hidden border-b border-slate-100">
                    @php
                        $photoUrl = $room->photo 
                            ? (str_starts_with($room->photo, 'http') ? $room->photo : (str_starts_with($room->photo, 'images/') ? asset($room->photo) : asset('storage/' . $room->photo)))
                            : asset('images/room_' . (($loop->index % 4) + 1) . '.jpg');
                    @endphp
                    <img src="{{ $photoUrl }}" alt="Foto Kamar {{ $room->room_number }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    
                    <!-- Floating status badge (Text-First) -->
                    <div class="absolute top-3 right-3">
                        <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md border shadow-xs bg-white/95 {{ $badgeBg }}">
                            {{ $displayStatus }}
                        </span>
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="mb-3">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block mb-0.5">TIPE {{ strtoupper($room->room_type ?: 'STANDARD') }}</span>
                            <h3 class="font-black text-slate-900 text-lg tracking-tight">Kamar {{ $room->room_number }}</h3>
                        </div>

                        <div class="mb-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            @if($displayStatus === 'Terisi')
                                <span class="text-slate-800 font-bold">STATUS: TERISI</span>
                            @elseif($displayStatus === 'Kosong')
                                <span class="text-emerald-700 font-bold">STATUS: SIAP HUNI</span>
                            @else
                                <span class="text-rose-700 font-bold">STATUS: DALAM PERBAIKAN</span>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 block">HARGA / BLN</span>
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($room->price_per_month, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('rooms.show', $room->id) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-[11px] font-bold uppercase tracking-wider rounded-lg transition-colors">
                                DETAIL
                            </a>
                            <a href="{{ route('rooms.edit', $room->id) }}" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-[11px] font-bold uppercase tracking-wider rounded-lg transition-colors">
                                EDIT
                            </a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kamar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 text-rose-600 hover:bg-rose-50 text-[11px] font-bold uppercase tracking-wider rounded-lg transition-colors">
                                    HAPUS
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Filter Javascript -->
    <script>
        let currentFilter = 'all';
        let currentType = 'all';
        let currentSort = 'nomor';

        function updateCounts() {
            const cards = document.querySelectorAll('.room-card');
            let total = cards.length;
            let terisi = 0;
            let kosong = 0;
            let perbaikan = 0;

            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (status === 'Terisi') terisi++;
                else if (status === 'Kosong') kosong++;
                else if (status === 'Perbaikan') perbaikan++;
            });

            document.getElementById('count-all').innerText = total;
            document.getElementById('count-Terisi').innerText = terisi;
            document.getElementById('count-Kosong').innerText = kosong;
            document.getElementById('count-Perbaikan').innerText = perbaikan;
        }

        function filterRooms(status) {
            currentFilter = status;
            
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-slate-900', 'text-white');
                btn.classList.add('text-slate-600');
            });
            const activeBtn = document.querySelector(`[data-filter="${status}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active', 'bg-slate-900', 'text-white');
                activeBtn.classList.remove('text-slate-600');
            }

            applyAllFilters();
        }

        function filterByType(type) {
            currentType = type;
            applyAllFilters();
        }

        function sortRooms(criteria) {
            currentSort = criteria;
            const grid = document.getElementById('room-grid');
            const cards = Array.from(grid.querySelectorAll('.room-card'));

            cards.sort((a, b) => {
                if (criteria === 'nomor') {
                    const numA = parseInt(a.getAttribute('data-nomor').replace(/\D/g, '')) || 0;
                    const numB = parseInt(b.getAttribute('data-nomor').replace(/\D/g, '')) || 0;
                    return numA - numB;
                } else if (criteria === 'harga_asc') {
                    return parseFloat(a.getAttribute('data-harga')) - parseFloat(b.getAttribute('data-harga'));
                } else if (criteria === 'harga_desc') {
                    return parseFloat(b.getAttribute('data-harga')) - parseFloat(a.getAttribute('data-harga'));
                }
            });

            cards.forEach(card => grid.appendChild(card));
        }

        function applyAllFilters() {
            const cards = document.querySelectorAll('.room-card');
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                const type = card.getAttribute('data-tipe');

                const matchStatus = (currentFilter === 'all' || status === currentFilter);
                const matchType = (currentType === 'all' || type === currentType);

                if (matchStatus && matchType) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCounts();
        });
        document.addEventListener('turbo:load', () => {
            updateCounts();
        });
    </script>
</x-app-layout>
