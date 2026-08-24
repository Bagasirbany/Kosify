<!-- ============ MODERN FOOTER ============ -->
<footer class="bg-white text-slate-600 relative overflow-hidden border-t border-slate-200 pt-20 pb-10">
    <!-- Background Glow Effects -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-100/50 rounded-full blur-3xl pointer-events-none transform -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-100/50 rounded-full blur-3xl pointer-events-none transform translate-y-1/2"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Branding -->
            <div class="lg:col-span-2">
                <div class="flex items-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto object-contain" alt="Kosify Logo">
                </div>
                <p class="text-slate-500 text-sm leading-relaxed max-w-sm mb-8">
                    Redefinisikan pengalaman ngekos Anda. Platform pencarian dan penyewaan kos paling modern, aman, dan transparan di Indonesia.
                </p>
                <!-- Social Links -->
                <div class="flex items-center gap-4">
                    <a href="https://instagram.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-900 hover:text-white hover:border-slate-900 hover:-translate-y-1 transition-all duration-300 shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 hover:-translate-y-1 transition-all duration-300 shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.693.072-2.18-.546-1.898-.788-3.125-2.73-3.22-2.857-.095-.127-.768-1.021-.768-1.948 0-.927.487-1.383.66-1.573.173-.19.378-.238.505-.238.127 0 .254.002.365.007.119.006.278-.045.435.333.161.388.549 1.341.597 1.439.048.098.08.213.016.34-.064.127-.096.206-.19.317-.095.111-.2.247-.285.333-.096.095-.196.198-.085.389.111.19.492.813 1.055 1.314.724.644 1.334.843 1.524.938.19.095.301.079.412-.048.111-.127.476-.556.603-.746.127-.19.254-.159.428-.095.175.063 1.11.523 1.301.618.19.095.317.143.365.222.048.079.048.46-.096.865z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Navigasi -->
            <div>
                <h4 class="text-slate-800 font-bold text-sm tracking-wider uppercase mb-6">Jelajahi</h4>
                <ul class="space-y-4 text-sm font-medium">
                    <li><a href="{{ route('catalog.index') }}" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Cari Kos</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Katalog Kamar</a></li>
                    <li><a href="{{ route('home') }}#keunggulan" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Keunggulan</a></li>
                    <li><a href="{{ route('home') }}#tentang-kami" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Tentang Kami</a></li>
                </ul>
            </div>

            <!-- Bantuan -->
            <div>
                <h4 class="text-slate-800 font-bold text-sm tracking-wider uppercase mb-6">Bantuan</h4>
                <ul class="space-y-4 text-sm font-medium">
                    <li><a href="{{ route('complaints.index') }}" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Lapor Kendala</a></li>
                    <li><a href="https://wa.me/6281234567890" target="_blank" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Hubungi Pengelola</a></li>
                    <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Portal Penyewa</a></li>
                    <li><a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-900 transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 rounded-full bg-slate-900/0 group-hover:bg-slate-900 transition-all duration-300"></span> Panel Admin</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-sm font-medium text-slate-500">&copy; 2026 Kosify Inc. Seluruh Hak Cipta Dilindungi.</p>
            
            <!-- Payment Methods Display -->
            <div class="flex items-center gap-3">
                <div class="h-8 px-3 bg-white rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:border-emerald-200 hover:bg-emerald-50 transition-all group cursor-default">
                    <span class="text-[10px] font-black text-slate-600 group-hover:text-blue-600 transition-colors">BCA</span>
                </div>
                <div class="h-8 px-3 bg-white rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:border-emerald-200 hover:bg-emerald-50 transition-all group cursor-default">
                    <span class="text-[10px] font-black text-slate-600 group-hover:text-orange-500 transition-colors">BNI</span>
                </div>
                <div class="h-8 px-3 bg-white rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:border-emerald-200 hover:bg-emerald-50 transition-all group cursor-default">
                    <span class="text-[9px] font-black text-slate-600 group-hover:text-blue-600 transition-colors">MANDIRI</span>
                </div>
                <div class="h-8 px-3 bg-white rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:border-emerald-200 hover:bg-emerald-50 transition-all group cursor-default">
                    <span class="text-[10px] font-black text-slate-600 group-hover:text-blue-500 italic transition-colors">GoPay</span>
                </div>
                <div class="h-8 px-3 bg-white rounded-lg flex items-center justify-center border border-slate-200 shadow-sm hover:border-emerald-200 hover:bg-emerald-50 transition-all group cursor-default">
                    <span class="text-[10px] font-black text-slate-600 group-hover:text-red-500 italic transition-colors">QRIS</span>
                </div>
            </div>
        </div>
    </div>
</footer>
