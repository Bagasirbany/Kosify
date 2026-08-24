<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-xl font-bold text-xs text-slate-700 uppercase tracking-widest shadow-xs hover:bg-slate-50 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
