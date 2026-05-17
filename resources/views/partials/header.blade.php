@php
    $searchProducts = [];

    try {
        $searchProducts = \App\Models\Product::query()
            ->orderBy('name')
            ->get(['name', 'slug'])
            ->map(fn($product) => ['name' => $product->name, 'slug' => $product->slug])
            ->all();
    } catch (\Throwable $exception) {
        $searchProducts = [];
    }

    $navItems = [
        ['label' => 'Beranda', 'href' => url('/'), 'active' => request()->is('/')],
        ['label' => 'Katalog', 'href' => route('katalog.index'), 'active' => request()->routeIs('katalog.*')],
        ['label' => 'Panduan', 'href' => route('panduan'), 'active' => request()->routeIs('panduan')],
        ['label' => 'Hubungi Kami', 'href' => route('hubungi-kami'), 'active' => request()->routeIs('hubungi-kami')],
    ];
@endphp

<a href="#main-content" class="site-skip-link">Lewati ke konten utama</a>

<nav data-site-header data-mobile-menu="closed" data-condensed="false" class="site-header fixed inset-x-0 top-0 z-50 border-b border-[#2C3E50]/10 bg-[#F8F9FA]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="site-header__bar flex min-h-20 items-center justify-between gap-4">
            <div class="flex min-w-0 items-center gap-4">
                <a href="{{ url('/') }}" class="site-brand inline-flex min-w-0 items-center text-[#2C3E50] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2 focus-visible:ring-offset-[#F8F9FA]">
                    <span class="truncate text-lg font-bold tracking-tight sm:text-2xl">Harapan Jaya Printing</span>
                </a>

                <div class="hidden lg:flex items-center gap-2 xl:gap-3">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @if ($item['active']) aria-current="page" @endif
                            class="site-nav-link inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2 focus-visible:ring-offset-[#F8F9FA] {{ $item['active'] ? 'bg-white text-[#2C3E50] shadow-sm ring-1 ring-[#2C3E50]/10' : 'text-[#2C3E50]/72 hover:text-[#3498DB]' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden lg:flex items-center gap-3">
                <div data-header-search-root class="site-search relative w-[18rem] xl:w-[20rem]">
                    <label for="desktop-header-search" class="sr-only">Cari produk</label>
                    <input
                        id="desktop-header-search"
                        type="text"
                        data-header-search-input
                        autocomplete="off"
                        placeholder="Cari produk..."
                        class="h-11 w-full rounded-full border border-[#2C3E50]/10 bg-white pl-11 pr-4 text-sm text-[#2C3E50] outline-none transition focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15"
                    />
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#2C3E50]/55">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path>
                        </svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full z-20 mt-2 hidden overflow-hidden rounded-2xl border border-[#2C3E50]/10 bg-white shadow-lg">
                        <ul data-search-results class="max-h-72 overflow-auto divide-y divide-slate-200"></ul>
                    </div>
                </div>

                <a
                    href="{{ route('track-order') }}"
                    @if (request()->routeIs('track-order')) aria-current="page" @endif
                    class="inline-flex h-11 items-center justify-center rounded-full bg-[#0F172A] px-5 text-sm font-semibold text-white transition hover:bg-[#2C3E50] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2 focus-visible:ring-offset-[#F8F9FA]"
                >
                    Lacak Pesanan
                </a>
            </div>

            <div class="flex items-center gap-2 lg:hidden">
                <a
                    href="{{ route('track-order') }}"
                    class="inline-flex h-10 items-center justify-center rounded-full bg-[#0F172A] px-4 text-sm font-semibold text-white transition hover:bg-[#2C3E50] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2 focus-visible:ring-offset-[#F8F9FA]"
                >
                    Lacak
                </a>
                <button
                    type="button"
                    data-mobile-menu-toggle
                    aria-expanded="false"
                    aria-controls="mobile-site-menu"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#2C3E50]/10 bg-white text-[#2C3E50] transition hover:border-[#3498DB]/30 hover:text-[#3498DB] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2 focus-visible:ring-offset-[#F8F9FA]"
                >
                    <span class="sr-only">Buka menu</span>
                    <svg data-menu-icon="open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path>
                    </svg>
                    <svg data-menu-icon="close" class="hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-site-menu" data-mobile-panel aria-hidden="true" class="site-mobile-panel lg:hidden">
            <div class="space-y-5 rounded-[1.5rem] border border-[#2C3E50]/10 bg-white p-4 shadow-lg">
                <div data-header-search-root class="site-search relative">
                    <label for="mobile-header-search" class="sr-only">Cari produk</label>
                    <input
                        id="mobile-header-search"
                        type="text"
                        data-header-search-input
                        autocomplete="off"
                        placeholder="Cari produk..."
                        class="h-12 w-full rounded-full border border-[#2C3E50]/10 bg-[#F8F9FA] pl-11 pr-4 text-sm text-[#2C3E50] outline-none transition focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15"
                    />
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#2C3E50]/55">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path>
                        </svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full z-20 mt-2 hidden overflow-hidden rounded-2xl border border-[#2C3E50]/10 bg-white shadow-lg">
                        <ul data-search-results class="max-h-72 overflow-auto divide-y divide-slate-200"></ul>
                    </div>
                </div>

                <div class="grid gap-2">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @if ($item['active']) aria-current="page" @endif
                            class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium transition {{ $item['active'] ? 'bg-[#E8F4FF] text-[#2C3E50]' : 'text-[#2C3E50] hover:bg-[#F8F9FA]' }}"
                        >
                            <span>{{ $item['label'] }}</span>
                            <svg class="h-4 w-4 text-[#2C3E50]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endforeach
                </div>

                <a
                    href="{{ route('track-order') }}"
                    class="inline-flex h-12 w-full items-center justify-center rounded-full bg-[#0F172A] px-5 text-sm font-semibold text-white transition hover:bg-[#2C3E50] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2"
                >
                    Lacak Pesanan
                </a>
            </div>
        </div>
    </div>

    <script type="application/json" id="product-search-data">@json($searchProducts)</script>
</nav>
