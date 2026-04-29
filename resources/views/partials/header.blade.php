<nav class="fixed w-full z-50 bg-[#F8F9FA] border-b border-[#2C3E50]/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center gap-3">
                <span class="font-bold text-2xl tracking-tight text-[#2C3E50]">Harapan Jaya Printing</span>
            </div>
            <div class="hidden lg:flex items-center gap-10">
                <a href="{{ url('/') }}" class="text-[#2C3E50] font-medium text-sm">Beranda</a>
                <a href="{{ url('/katalog') }}" class="text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors font-medium text-sm">Katalog</a>
                <a href="{{ url('/panduan') }}" class="text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors font-medium text-sm">Panduan</a>
                <a href="{{ url('/hubungi-kami') }}" class="text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors font-medium text-sm">Hubungi Kami</a>
            </div>
            <div class="hidden lg:flex items-center gap-4">
                <div class="relative">
                    @php
                        $searchProducts = array_map(
                            fn($product) => ['name' => $product['nama'], 'slug' => $product['slug']],
                            \App\Services\ProductService::all()
                        );
                    @endphp
                    <input type="text" data-header-search-input placeholder="Cari produk..." class="h-11 w-72 rounded-full border border-[#2C3E50]/10 bg-white px-12 text-sm text-[#2C3E50] outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15" />
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#2C3E50]/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path></svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full mt-2 hidden overflow-hidden rounded-3xl border border-[#2C3E50]/10 bg-white shadow-lg z-50">
                        <ul data-search-results class="divide-y divide-slate-200 max-h-72 overflow-auto"></ul>
                    </div>
                    <script type="application/json" id="product-search-data">@json($searchProducts)</script>
                </div>
                <button class="text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors relative">
                    <a href="{{ route('keranjang') }}" class="text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-2 13H5L3 3zm5 16a2 2 0 104 0m4 0a2 2 0 104 0"></path></svg>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">1</span>
                </button>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </a>
            </div>
        </div>
    </div>
</nav>
