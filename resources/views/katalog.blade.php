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

    <main id="main-content" class="pt-28 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#fffdf7] rounded-xl border border-[#4e3422]/10 p-8 shadow-sm mb-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <h2 class="text-2xl md:text-3xl font-bold text-[#4e3422] mb-3">Katalog Produk</h2>
                        <p class="text-lg text-[#4e3422]/70">Jelajahi produk, bandingkan spesifikasi, lalu lanjutkan pemesanan melalui WhatsApp dari halaman detail produk.</p>
                    </div>
                    <div class="text-sm text-[#4e3422]/70">
                        Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                    </div>
                </div>

                <div class="mt-8 grid gap-4 xl:grid-cols-[1.6fr_1fr]">
                    <div class="rounded-xl border border-[#4e3422]/10 bg-[#fff7d6] p-5">
                        <label class="block text-sm font-semibold text-[#4e3422] mb-3">Cari Produk</label>
                        <input data-search-input type="text" placeholder="Cari nama produk..." class="w-full rounded-xl border border-[#4e3422]/10 bg-[#fffdf7] px-4 py-3 text-sm text-[#4e3422] outline-none focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15 transition" />
                    </div>
                    <form method="GET" class="rounded-xl border border-[#4e3422]/10 bg-[#fff7d6] p-5">
                        <label class="block text-sm font-semibold text-[#4e3422] mb-3">Kategori</label>
                        <select name="kategori" onchange="this.form.submit()" class="w-full rounded-xl border border-[#4e3422]/10 bg-[#fffdf7] px-4 py-3 text-sm text-[#4e3422] outline-none focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15 transition">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    <article data-product-card data-product-name="{{ strtolower($product->name) }}" data-product-category="{{ $product->category->name }}" class="group rounded-xl border border-[#4e3422]/10 bg-[#fffdf7] p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="overflow-hidden rounded-xl bg-gray-100 mb-5">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-52 w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <span class="rounded-full bg-[#fff4cf] px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-[#c86818]">{{ $product->category->name }}</span>
                            <span class="text-sm text-[#4e3422]/70">
                                @if ($product->starting_price !== null)
                                    Rp {{ number_format($product->starting_price, 0, ',', '.') }}
                                @else
                                    Harga belum tersedia
                                @endif
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold text-[#4e3422] mb-3">{{ $product->name }}</h2>
                        <p class="text-sm text-[#4e3422]/70 mb-6 leading-relaxed">{{ $product->description }}</p>
                        <div class="flex flex-wrap gap-2 mb-6 text-xs text-[#4e3422]/70">
                            @forelse ($product->activeVariants as $variant)
                                <span class="rounded-full border border-[#4e3422]/10 bg-[#fdf6e9] px-3 py-1">{{ $variant->variant_name }}</span>
                            @empty
                                <span class="rounded-full border border-[#4e3422]/10 bg-[#fdf6e9] px-3 py-1">Belum ada varian aktif</span>
                            @endforelse
                        </div>
                        <a href="{{ route('katalog.show', $product) }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#6e3b12] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#8c4a12]">Lihat Detail Produk</a>
                    </article>
                @empty
                    <div class="sm:col-span-2 xl:col-span-3 rounded-xl border border-dashed border-[#4e3422]/20 bg-[#fffdf7] p-10 text-center text-[#4e3422]/70">
                        Produk untuk kategori ini belum tersedia.
                    </div>
                @endforelse
            </div>

            @if ($products->hasPages())
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
