@php
    $storeProfile = null;
    $brandName = config('storefront.brand_name', 'Harapan Jaya Printing');
    $brandLogoUrl = null;

    try {
        $storeProfile = \App\Models\StoreProfile::query()->first(['name', 'logo']);

        if ($storeProfile?->name) {
            $brandName = $storeProfile->name;
        }

        if ($storeProfile?->logo) {
            $brandLogoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($storeProfile->logo);
        }
    } catch (\Throwable $exception) {
        $storeProfile = null;
    }

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

<nav data-site-header data-mobile-menu="closed" data-condensed="false" class="site-header fixed inset-x-0 top-0 z-50 border-b border-[#33302d]/10 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="site-header__bar flex min-h-16 sm:min-h-20 items-center justify-between gap-4">
            <div class="flex min-w-0 flex-1 items-center">
                <a href="{{ url('/') }}" class="site-brand inline-flex min-w-0 items-center gap-3 text-[#33302d] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                    @if ($brandLogoUrl)
                        <img
                            src="{{ $brandLogoUrl }}"
                            alt="{{ $brandName }}"
                            class="h-9 w-9 flex-shrink-0 rounded-sm object-cover sm:h-10 sm:w-10"
                        />
                    @endif
                    <span class="hidden max-w-[12rem] truncate text-base font-semibold tracking-tight sm:block">
                        {{ $brandName }}
                    </span>
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-6 xl:gap-8 ml-auto">
                <div class="flex items-center gap-6 xl:gap-8">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @if ($item['active']) aria-current="page" @endif
                            class="py-1 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] {{ $item['active'] ? 'text-[#d9782a]' : 'text-[#33302d]/75 hover:text-[#d9782a]' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                <div data-header-search-root class="site-search relative w-[14rem] xl:w-[16rem]">
                    <label for="desktop-header-search" class="sr-only">Cari produk</label>
                    <input
                        id="desktop-header-search"
                        type="text"
                        data-header-search-input
                        autocomplete="off"
                        placeholder="Cari produk..."
                        class="h-10 w-full rounded-sm border border-[#33302d]/12 bg-[#f7f7f5] pl-10 pr-4 text-sm text-[#33302d] placeholder-[#33302d]/40 outline-none transition-all duration-300 focus:border-[#d9782a] focus:bg-white focus:ring-1 focus:ring-[#d9782a]"
                    />
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#33302d]/45">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path>
                        </svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full z-20 mt-1.5 hidden overflow-hidden rounded-sm border border-[#33302d]/12 bg-[#f7f7f5] shadow-[0_8px_30px_rgb(78,52,34,0.06)]">
                        <ul data-search-results class="max-h-72 overflow-auto divide-y divide-stone-100"></ul>
                    </div>
                </div>

                <a
                    href="{{ route('track-order') }}"
                    @if (request()->routeIs('track-order')) aria-current="page" @endif
                    class="inline-flex h-10 items-center justify-center rounded-sm border border-[#33302d]/15 px-4 text-xs font-semibold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2 focus-visible:ring-offset-white ease-out-expo {{ request()->routeIs('track-order') ? 'bg-[#33302d] text-[#f7f7f5] border-[#33302d]' : 'bg-transparent text-[#33302d] hover:text-white hover:bg-[#d9782a] hover:border-[#d9782a]' }}"
                >
                    Lacak Pesanan
                </a>
            </div>

            <div class="relative z-10 flex items-center gap-2 lg:hidden">
                <a
                    href="{{ route('track-order') }}"
                    class="inline-flex h-9 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-3 text-xs font-semibold text-[#33302d] transition hover:border-[#d9782a] hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2 focus-visible:ring-offset-white"
                >
                    Lacak
                </a>
                <button
                    type="button"
                    data-mobile-menu-toggle
                    aria-expanded="false"
                    aria-controls="mobile-site-menu"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white text-[#33302d] transition hover:border-[#d9782a]/50 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a]"
                >
                    <span class="sr-only">Buka menu</span>
                    <svg data-menu-icon="open" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path>
                    </svg>
                    <svg data-menu-icon="close" class="hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-site-menu" data-mobile-panel aria-hidden="true" hidden class="site-mobile-panel relative z-0 lg:hidden">
            <div class="space-y-6 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-6 shadow-xl">
                <div data-header-search-root class="site-search relative">
                    <label for="mobile-header-search" class="sr-only">Cari produk</label>
                    <input
                        id="mobile-header-search"
                        type="text"
                        data-header-search-input
                        autocomplete="off"
                        placeholder="Cari produk..."
                        class="h-10 w-full rounded-sm border border-[#33302d]/12 bg-white pl-10 pr-4 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-1 focus:ring-[#d9782a]"
                    />
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#33302d]/45">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path>
                        </svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full z-20 mt-1.5 hidden overflow-hidden rounded-sm border border-[#33302d]/12 bg-[#f7f7f5] shadow-[0_8px_30px_rgb(78,52,34,0.06)]">
                        <ul data-search-results class="max-h-72 overflow-auto divide-y divide-stone-100"></ul>
                    </div>
                </div>

                <div class="grid gap-1">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @if ($item['active']) aria-current="page" @endif
                            class="flex items-center justify-between rounded-sm px-4 py-3 text-sm font-medium transition {{ $item['active'] ? 'text-[#d9782a] bg-[#f7f7f5]' : 'text-[#33302d] hover:bg-[#f7f7f5]' }}"
                        >
                            <span>{{ $item['label'] }}</span>
                            <svg class="h-3.5 w-3.5 text-[#33302d]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endforeach
                </div>

                <a
                    href="{{ route('track-order') }}"
                    class="inline-flex h-11 w-full items-center justify-center rounded-sm border border-[#33302d] bg-[#33302d] px-5 text-sm font-semibold text-[#f7f7f5] transition hover:bg-[#d9782a] hover:border-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a]"
                >
                    Lacak Pesanan
                </a>
            </div>
        </div>
    </div>
    <script type="application/json" id="product-search-data">@json($searchProducts)</script>
</nav>
