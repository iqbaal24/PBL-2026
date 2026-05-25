<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk - Harapan Jaya Printing</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="antialiased selection:bg-[#dd7a21] selection:text-white bg-white">
    @include('partials.header')

    <main id="main-content">
        <section class="bg-white pt-32 pb-12 border-b border-[#4e3422]/10 sm:pt-36 sm:pb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Katalog produk</span>
                        <h1 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                            Pilih kebutuhan cetak, <strong class="font-semibold">cek spesifikasi awal</strong>
                        </h1>
                    </div>
                    <div class="max-w-md lg:text-right">
                        <p class="text-sm leading-relaxed text-[#4e3422]/70">
                            Bandingkan bahan, harga acuan, dan opsi aktif sebelum lanjut ke halaman detail. Pesanan tetap dikunci lewat WhatsApp bersama admin.
                        </p>
                        <p data-product-count class="mt-4 text-sm font-medium text-[#4e3422]/55">
                            Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-10 sm:py-12">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[18rem_minmax(0,1fr)] lg:px-8">
                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <div class="border border-[#4e3422]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                        <div class="flex items-center justify-between gap-4 border-b border-[#4e3422]/10 pb-4">
                            <h2 class="text-sm font-semibold text-[#4e3422]">Filter katalog</h2>
                            @if ($selectedCategory)
                                <a href="{{ route('katalog.index') }}" class="text-xs font-semibold text-[#c86818] transition hover:text-[#aa5410] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-semibold text-[#4e3422] mb-3">Cari cepat</label>
                            <input data-search-input type="text" placeholder="Nama, bahan, varian..." class="h-12 w-full rounded-sm border border-[#4e3422]/15 bg-white px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15" />
                        </div>

                        <form method="GET" class="mt-6 border-t border-[#4e3422]/10 pt-5">
                            <label class="block text-sm font-semibold text-[#4e3422]">Kategori</label>
                            <select name="kategori" class="mt-3 h-12 w-full rounded-sm border border-[#4e3422]/15 bg-white px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="mt-4 inline-flex h-11 w-full items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Terapkan kategori
                            </button>
                        </form>
                    </div>
                </aside>

                <div class="min-w-0">
                    <div class="mb-6 flex flex-col gap-4 border-b border-[#4e3422]/10 pb-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold tracking-tight text-[#4e3422]">Semua produk cetak</h2>
                            <p class="mt-1 text-sm leading-relaxed text-[#4e3422]/65">Pilih produk untuk melihat detail bahan, varian, harga acuan, dan format file sebelum chat admin.</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-[#4e3422]/60">
                            @if ($selectedCategory)
                                <span class="rounded-sm border border-[#dd7a21]/25 px-3 py-2 text-[#c86818]">Kategori aktif</span>
                            @endif
                            <span class="rounded-sm border border-[#4e3422]/15 px-3 py-2">{{ $products->total() }} produk</span>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    @php
                        $activeVariants = $product->activeVariants;
                        $variantSearchText = $activeVariants->pluck('variant_name')->join(' ');
                        $searchText = strtolower($product->name . ' ' . $product->category->name . ' ' . $variantSearchText);
                        $averageRating = $product->visible_reviews_avg_rating ? round($product->visible_reviews_avg_rating, 1) : null;
                        $reviewCount = (int) ($product->visible_reviews_count ?? 0);
                    @endphp

                    <article data-product-card data-product-name="{{ strtolower($product->name) }}" data-product-search="{{ $searchText }}" data-product-category="{{ $product->category->name }}" class="group flex min-h-full flex-col overflow-hidden rounded-sm border border-[#4e3422]/10 bg-white transition-all duration-300 hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.03)]">
                        <div class="relative aspect-[4/5] overflow-hidden border-b border-[#4e3422]/5 bg-white">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 ease-out-expo group-hover:scale-105" />
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <span class="text-xs font-semibold text-[#dd7a21]">{{ $product->category->name }}</span>

                            <h2 class="mt-3 text-lg font-semibold tracking-tight text-[#4e3422] transition-colors group-hover:text-[#dd7a21]">{{ $product->name }}</h2>
                            <div class="mt-2 flex items-center gap-2 text-xs">
                                @if ($reviewCount > 0)
                                    <span class="flex items-center gap-1 font-semibold text-[#c86818]">
                                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($averageRating, 1) }}
                                    </span>
                                    <span class="text-[#4e3422]/50">{{ $reviewCount }} review</span>
                                @else
                                    <span class="text-[#4e3422]/45">Belum ada review</span>
                                @endif
                            </div>
                            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-[#4e3422]/70">{{ $product->description }}</p>

                            <div class="mt-5 flex items-end justify-between gap-4 border-t border-[#4e3422]/10 pt-4">
                                <div>
                                    <p class="text-xs font-medium text-[#4e3422]/50">Mulai dari</p>
                                    <p class="mt-1 text-base font-semibold text-[#4e3422]">
                                        @if ($product->starting_price !== null)
                                            Rp {{ number_format($product->starting_price, 0, ',', '.') }}
                                        @else
                                            Tanya admin
                                        @endif
                                    </p>
                                </div>
                                <p class="text-xs font-semibold text-[#4e3422]/55">
                                    {{ $activeVariants->count() ? $activeVariants->count() . ' opsi' : 'Konsultasi' }}
                                </p>
                            </div>

                            <div class="mt-auto pt-6">
                                <a href="{{ route('katalog.show', $product) }}" class="inline-flex w-full items-center justify-center rounded-sm bg-[#6e3b12] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                    Lihat detail
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="sm:col-span-2 xl:col-span-3 border border-dashed border-[#4e3422]/20 bg-white p-10 text-center text-[#4e3422]/70">
                        <h2 class="text-xl font-semibold text-[#4e3422]">Produk belum ditemukan</h2>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed">
                            Coba reset kategori atau hubungi admin jika Anda butuh bahan, ukuran, atau finishing khusus.
                        </p>
                        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                            <a href="{{ route('katalog.index') }}" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#4e3422]/12 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Reset katalog
                            </a>
                            <a href="{{ route('hubungi-kami') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Tanya admin
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

                @if ($products->isNotEmpty())
                <div data-search-empty-state hidden class="mt-6 border border-dashed border-[#4e3422]/20 bg-white p-10 text-center text-[#4e3422]/70">
                    <h2 class="text-xl font-semibold text-[#4e3422]">Tidak ada produk yang cocok</h2>
                    <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed">
                        Coba kata kunci lain, reset pencarian, atau tanya admin untuk kebutuhan bahan, ukuran, atau finishing khusus.
                    </p>
                    <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                        <button type="button" data-search-reset class="inline-flex h-11 items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                            Reset pencarian
                        </button>
                        <a href="{{ route('hubungi-kami') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                            Tanya admin
                        </a>
                    </div>
                </div>
                @endif

                @if ($products->hasPages())
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
