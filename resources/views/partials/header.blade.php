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

<nav data-site-header data-mobile-menu="closed" data-condensed="false" class="site-header fixed inset-x-0 top-0 z-50 border-b border-[#4e3422]/10 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="site-header__bar flex min-h-16 sm:min-h-20 items-center justify-between gap-4">
            <div class="flex min-w-0 flex-1 items-center">
                <a href="{{ url('/') }}" class="site-brand inline-flex min-w-0 items-center text-[#4e3422] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                    @if ($brandLogoUrl)
                        <img
                            src="{{ $brandLogoUrl }}"
                            alt="{{ $brandName }}"
                            class="h-9 w-9 flex-shrink-0 rounded-sm object-cover sm:h-10 sm:w-10"
                        />
                    @endif
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-6 xl:gap-8 ml-auto">
                <div class="flex items-center gap-6 xl:gap-8">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @if ($item['active']) aria-current="page" @endif
                            class="py-1 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] {{ $item['active'] ? 'text-[#dd7a21]' : 'text-[#4e3422]/75 hover:text-[#dd7a21]' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                <div data-header-search-root class="site-search relative w-[18rem] xl:w-[20rem]">
                    <label for="desktop-header-search" class="sr-only">Cari produk</label>
                    <input
                        id="desktop-header-search"
                        type="text"
                        data-header-search-input
                        autocomplete="off"
                        placeholder="Cari produk..."
                        class="h-10 w-full rounded-sm border border-[#4e3422]/12 bg-[#fffdfa] pl-10 pr-4 text-sm text-[#4e3422] placeholder-[#4e3422]/40 outline-none transition-all duration-300 focus:border-[#dd7a21] focus:bg-white focus:ring-1 focus:ring-[#dd7a21]"
                    />
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4e3422]/45">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path>
                        </svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full z-20 mt-1.5 hidden overflow-hidden rounded-sm border border-[#4e3422]/12 bg-[#fffdfa] shadow-[0_8px_30px_rgb(78,52,34,0.06)]">
                        <ul data-search-results class="max-h-72 overflow-auto divide-y divide-slate-100"></ul>
                    </div>
                </div>

                <a
                    href="{{ route('track-order') }}"
                    @if (request()->routeIs('track-order')) aria-current="page" @endif
                    class="inline-flex h-10 items-center justify-center rounded-sm border border-[#4e3422]/15 px-4 text-xs font-semibold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2 focus-visible:ring-offset-white ease-out-expo {{ request()->routeIs('track-order') ? 'bg-[#4e3422] text-[#fffdfa] border-[#4e3422]' : 'bg-transparent text-[#4e3422] hover:text-white hover:bg-[#dd7a21] hover:border-[#dd7a21]' }}"
                >
                    Lacak Pesanan
                </a>
            </div>

            <div class="relative z-10 flex items-center gap-2 lg:hidden">
                <a
                    href="{{ route('track-order') }}"
                    class="inline-flex h-9 items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-3 text-xs font-semibold text-[#4e3422] transition hover:border-[#dd7a21] hover:text-[#dd7a21] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2 focus-visible:ring-offset-white"
                >
                    Lacak
                </a>
                <button
                    type="button"
                    data-mobile-menu-toggle
                    aria-expanded="false"
                    aria-controls="mobile-site-menu"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white text-[#4e3422] transition hover:border-[#dd7a21]/50 hover:text-[#dd7a21] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21]"
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
            <div class="space-y-6 rounded-sm border border-[#4e3422]/10 bg-[#fffdfa] p-6 shadow-xl">
                <div data-header-search-root class="site-search relative">
                    <label for="mobile-header-search" class="sr-only">Cari produk</label>
                    <input
                        id="mobile-header-search"
                        type="text"
                        data-header-search-input
                        autocomplete="off"
                        placeholder="Cari produk..."
                        class="h-10 w-full rounded-sm border border-[#4e3422]/12 bg-white pl-10 pr-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-1 focus:ring-[#dd7a21]"
                    />
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4e3422]/45">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"></path>
                        </svg>
                    </span>
                    <div data-search-dropdown class="absolute left-0 right-0 top-full z-20 mt-1.5 hidden overflow-hidden rounded-sm border border-[#4e3422]/12 bg-[#fffdfa] shadow-[0_8px_30px_rgb(78,52,34,0.06)]">
                        <ul data-search-results class="max-h-72 overflow-auto divide-y divide-slate-100"></ul>
                    </div>
                </div>

                <div class="grid gap-1">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @if ($item['active']) aria-current="page" @endif
                            class="flex items-center justify-between rounded-sm px-4 py-3 text-sm font-medium transition {{ $item['active'] ? 'text-[#dd7a21] bg-[#fffbf2]' : 'text-[#4e3422] hover:bg-[#fffdf7]' }}"
                        >
                            <span>{{ $item['label'] }}</span>
                            <svg class="h-3.5 w-3.5 text-[#4e3422]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endforeach
                </div>

                <a
                    href="{{ route('track-order') }}"
                    class="inline-flex h-11 w-full items-center justify-center rounded-sm border border-[#4e3422] bg-[#4e3422] px-5 text-sm font-semibold text-[#fffdfa] transition hover:bg-[#dd7a21] hover:border-[#dd7a21] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21]"
                >
                    Lacak Pesanan
                </a>
            </div>
        </div>
    </div>

    <script type="application/json" id="product-search-data">@json($searchProducts)</script>
    <script>
        (() => {
            const header = document.querySelector('[data-site-header]');

            if (!header) {
                return;
            }

            const menuButton = header.querySelector('[data-mobile-menu-toggle]');
            const mobilePanel = header.querySelector('[data-mobile-panel]');
            const openIcon = header.querySelector('[data-menu-icon="open"]');
            const closeIcon = header.querySelector('[data-menu-icon="close"]');

            if (!menuButton || !mobilePanel) {
                return;
            }

            const setMenuState = (isOpen) => {
                header.dataset.mobileMenu = isOpen ? 'open' : 'closed';
                menuButton.setAttribute('aria-expanded', String(isOpen));
                mobilePanel.setAttribute('aria-hidden', String(!isOpen));
                mobilePanel.hidden = !isOpen;

                if (openIcon && closeIcon) {
                    openIcon.classList.toggle('hidden', isOpen);
                    closeIcon.classList.toggle('hidden', !isOpen);
                }
            };

            setMenuState(false);

            if (menuButton.dataset.mobileMenuBound !== 'true') {
                menuButton.dataset.mobileMenuBound = 'true';

                menuButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    setMenuState(header.dataset.mobileMenu !== 'open');
                });
            }

            if (mobilePanel.dataset.mobileMenuLinksBound !== 'true') {
                mobilePanel.dataset.mobileMenuLinksBound = 'true';

                mobilePanel.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', () => setMenuState(false));
                });
            }

            document.addEventListener('click', (event) => {
                if (header.dataset.mobileMenu !== 'open') {
                    return;
                }

                if (!header.contains(event.target)) {
                    setMenuState(false);
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setMenuState(false);
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    setMenuState(false);
                }
            });
        })();
    </script>
</nav>
