<div class="flex flex-col h-full bg-white font-sans" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
            <img src="{{ asset('images/favicon-circle.png') }}" alt="Kosify" class="w-8 h-8 object-contain rounded-full shadow-xs">
            <div class="flex flex-col">
                <span class="text-xs font-black tracking-tight text-slate-900 group-hover:text-black">KOSIFY</span>
                <span class="text-[9px] font-extrabold uppercase tracking-widest text-slate-400">ADMIN PANEL</span>
            </div>
        </a>
        <span class="px-2 py-0.5 rounded-md bg-slate-900 text-white text-[9px] font-black tracking-wider uppercase">PRO</span>
    </div>
    
    <nav class="flex-1 px-3 py-4 space-y-1 text-xs font-bold uppercase tracking-wider overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span>Dashboard</span>
            </div>
            @if(request()->routeIs('dashboard'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>

        <a href="{{ route('rooms.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('rooms.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('rooms.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
                <span>Kamar Kos</span>
            </div>
            @if(request()->routeIs('rooms.*'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>

        <a href="{{ route('tenants.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('tenants.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('tenants.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Penyewa</span>
            </div>
            @if(request()->routeIs('tenants.*'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>

        <a href="{{ route('bookings.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('bookings.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('bookings.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
                <span>Booking & Sewa</span>
            </div>
            @if(request()->routeIs('bookings.*'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>

        <a href="{{ route('finance.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('finance.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('finance.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                <span>Keuangan</span>
            </div>
            @if(request()->routeIs('finance.*'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>

        <a href="{{ route('reports.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('reports.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                <span>Laporan</span>
            </div>
            @if(request()->routeIs('reports.*'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>

        <a href="{{ route('admin.complaints.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.complaints.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('admin.complaints.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                <span>Lapor Kendala</span>
            </div>
            @php
                $pendingComplaints = \App\Models\Complaint::where('status', 'pending')->count();
            @endphp
            @if($pendingComplaints > 0)
                <span class="px-2 py-0.5 text-[9px] font-black rounded-md bg-amber-500 text-white">
                    {{ $pendingComplaints }} BARU
                </span>
            @endif
        </a>

        <a href="{{ route('settings.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('settings.*') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 {{ request()->routeIs('settings.*') ? 'text-white' : 'text-slate-400' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                <span>Pengaturan Web</span>
            </div>
            @if(request()->routeIs('settings.*'))
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            @endif
        </a>
    </nav>
    
    <div class="border-t border-slate-100 p-3 shrink-0 space-y-1.5">
        <a href="{{ route('catalog.index') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-3 text-center rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-bold uppercase tracking-wider transition-all">
            <span>Website Utama</span>
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        </a>

        <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full py-2 px-3 text-center rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-[11px] font-bold uppercase tracking-wider transition-all">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>Keluar (Logout)</span>
        </a>
    </div>
</div>
