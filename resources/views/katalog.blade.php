@php
    $storefront = config('storefront');

    try {
        $storeProfile = \App\Models\StoreProfile::query()->first();
        if ($storeProfile?->name) {
            $storefront['brand_name'] = $storeProfile->name;
        }
    } catch (\Throwable $exception) {
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk - {{ $storefront['brand_name'] }}</title>
    @include('partials.favicon')

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="antialiased selection:bg-[#d9782a] selection:text-white bg-white">
    @include('partials.header')

    <main id="main-content">
        <section class="relative overflow-hidden border-b border-[#33302d]/10 pt-32 pb-12 sm:pt-36 sm:pb-16">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-[#151311]/78"></div>
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-[#151311]/45 to-transparent"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold text-[#ffdfa9] block mb-3">Katalog produk</span>
                        <h1 class="text-3xl font-light tracking-tight text-white sm:text-4xl lg:text-5xl leading-tight">
                            Pilih kebutuhan cetak, <strong class="font-semibold text-[#ffdfa9]">cek spesifikasi awal</strong>
                        </h1>
                    </div>
                    <div class="mt-5 max-w-2xl">
                        <p class="text-base leading-relaxed text-white/75">
                            Eksplorasi bahan dan estimasi harga kami sekarang. Temukan yang paling sesuai, lalu selesaikan pesanan Anda lewat WhatsApp!
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-10 sm:py-12">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[18rem_minmax(0,1fr)] lg:px-8">
                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <div class="rounded-sm border border-[#33302d]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                        <div class="flex items-center justify-between gap-4 border-b border-[#33302d]/10 pb-4">
                            <h2 class="text-sm font-semibold text-[#33302d]">Filter katalog</h2>
                            @if ($selectedCategory)
                                <a href="{{ route('katalog.index') }}" class="text-xs font-semibold text-[#d9782a] transition hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-semibold text-[#33302d] mb-3">Cari cepat</label>
                            <input data-search-input type="text" placeholder="Nama, bahan, varian..." class="h-12 w-full rounded-sm border border-[#33302d]/15 bg-white px-4 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-2 focus:ring-[#d9782a]/15" />
                        </div>

                        <form method="GET" class="mt-6 border-t border-[#33302d]/10 pt-5">
                            <label class="block text-sm font-semibold text-[#33302d]">Kategori</label>
                            <select name="kategori" class="mt-3 h-12 w-full rounded-sm border border-[#33302d]/15 bg-white px-4 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-2 focus:ring-[#d9782a]/15">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="mt-4 inline-flex h-11 w-full items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Terapkan kategori
                            </button>
                        </form>
                    </div>
                </aside>

                <div class="min-w-0">
                    <div class="mb-6 flex flex-col gap-4 border-b border-[#33302d]/10 pb-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold tracking-tight text-[#33302d]">Semua produk cetak</h2>
                            <p class="mt-1 text-base leading-relaxed text-[#33302d]/65">Pilih produk untuk melihat detail bahan, varian, harga acuan, dan format file sebelum chat admin.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-[#33302d]/60">
                            @if ($selectedCategory)
                                <span class="rounded-sm border border-[#d9782a]/25 px-3 py-2 text-[#d9782a]">Kategori aktif</span>
                            @endif
                            <span class="rounded-sm border border-[#33302d]/15 px-3 py-2">{{ $products->total() }} produk</span>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($products as $product)
                    @php
                        $activeVariants = $product->activeVariants;
                        $variantSearchText = $activeVariants->pluck('variant_name')->join(' ');
                        $searchText = strtolower($product->name . ' ' . $product->category->name . ' ' . $variantSearchText);
                    @endphp

                    <article data-product-card data-product-name="{{ strtolower($product->name) }}" data-product-search="{{ $searchText }}" data-product-category="{{ $product->category->name }}" class="group flex min-h-full flex-col overflow-hidden rounded-sm border border-[#33302d]/10 bg-white transition-all duration-300 hover:border-[#d9782a]/35">
                        <div class="relative aspect-[4/3] overflow-hidden border-b border-[#33302d]/5 bg-white">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover transition duration-500 ease-out-expo group-hover:scale-[1.03]" />
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <span class="text-xs font-semibold text-[#d9782a]">{{ $product->category->name }}</span>

                            <h2 class="mt-2 line-clamp-2 text-lg font-semibold tracking-tight text-[#33302d] transition-colors group-hover:text-[#d9782a]">{{ $product->name }}</h2>
                            @if ($product->visible_reviews_count > 0)
                                <div class="mt-3 flex items-center gap-2 text-sm text-[#33302d]/70">
                                    <span class="flex items-center gap-0.5 text-[#d9782a]" aria-hidden="true">
                                        @for ($star = 1; $star <= 5; $star++)
                                            <svg class="h-4 w-4 {{ $star <= round($product->visible_reviews_avg_rating) ? 'fill-current' : 'fill-none text-[#33302d]/25' }}" viewBox="0 0 20 20" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linejoin="round" d="M10 1.8 12.47 6.8l5.53.8-4 3.9.94 5.5L10 14.4 5.06 17l.94-5.5-4-3.9 5.53-.8L10 1.8Z" />
                                            </svg>
                                        @endfor
                                    </span>
                                    <span class="font-semibold text-[#33302d]">{{ number_format($product->visible_reviews_avg_rating, 1, ',', '.') }}</span>
                                    <span>({{ $product->visible_reviews_count }} ulasan)</span>
                                </div>
                            @endif
                            <div class="mt-4 flex items-end justify-between gap-3 border-t border-[#33302d]/10 pt-4">
                                <div>
                                    <p class="text-[11px] font-medium text-[#33302d]/50">Mulai dari</p>
                                    <p class="mt-0.5 text-sm font-semibold text-[#33302d]">
                                        @if ($product->starting_price !== null)
                                            Rp {{ number_format($product->starting_price, 0, ',', '.') }}
                                        @else
                                            Tanya admin
                                        @endif
                                    </p>
                                </div>
                                <p class="shrink-0 text-xs font-semibold text-[#33302d]/55">
                                    {{ $activeVariants->count() ? $activeVariants->count() . ' opsi' : 'Konsultasi' }}
                                </p>
                            </div>

                            <div class="mt-auto pt-5">
                                <a href="{{ route('katalog.show', $product) }}" class="inline-flex h-11 w-full items-center justify-center rounded-sm bg-[#d9782a] px-4 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                    Lihat detail
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 2xl:col-span-4 rounded-sm border border-dashed border-[#33302d]/20 bg-white p-10 text-center text-[#33302d]/70">
                        <h2 class="text-xl font-semibold text-[#33302d]">Produk belum ditemukan</h2>
                        <p class="mx-auto mt-3 max-w-md text-base leading-relaxed">
                            Coba reset kategori atau hubungi admin jika Anda butuh bahan, ukuran, atau finishing khusus.
                        </p>
                        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                            <a href="{{ route('katalog.index') }}" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/12 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Reset katalog
                            </a>
                            <a href="{{ route('hubungi-kami') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Tanya admin
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

                @if ($products->isNotEmpty())
                <div data-search-empty-state hidden class="mt-6 rounded-sm border border-dashed border-[#33302d]/20 bg-white p-10 text-center text-[#33302d]/70">
                    <h2 class="text-xl font-semibold text-[#33302d]">Tidak ada produk yang cocok</h2>
                    <p class="mx-auto mt-3 max-w-md text-base leading-relaxed">
                        Coba kata kunci lain, reset pencarian, atau tanya admin untuk kebutuhan bahan, ukuran, atau finishing khusus.
                    </p>
                    <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                        <button type="button" data-search-reset class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                            Reset pencarian
                        </button>
                        <a href="{{ route('hubungi-kami') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                            Tanya admin
                        </a>
                    </div>
                </div>
                @endif

                @if ($products->hasPages())
                <div class="mt-10">
                    {{ $products->links('vendor.pagination.print-shop') }}
                </div>
                @endif
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
