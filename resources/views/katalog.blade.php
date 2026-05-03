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
<body class="antialiased selection:bg-[#3498DB] selection:text-white bg-[#F8F9FA]">
    @include('partials.header')

    <main class="pt-28 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-[#2C3E50]/10 p-8 shadow-sm mb-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <h2 class="text-2xl md:text-3xl font-bold text-[#2C3E50] mb-3">Katalog Produk</h2>
                        <p class="text-lg text-[#2C3E50]/70">Jelajahi berbagai produk digital printing berkualitas tinggi dengan harga kompetitif</p>
                    </div>
                    <div class="text-sm text-[#2C3E50]/70">
                        Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                    </div>
                </div>

                <div class="mt-8 grid gap-4 xl:grid-cols-[1.6fr_1fr]">
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                        <label class="block text-sm font-semibold text-[#2C3E50] mb-3">Cari Produk</label>
                        <input data-search-input type="text" placeholder="Cari nama produk..." class="w-full rounded-xl border border-[#2C3E50]/10 bg-white px-4 py-3 text-sm text-[#2C3E50] outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15 transition" />
                    </div>
                    <form method="GET" class="rounded-xl border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                        <label class="block text-sm font-semibold text-[#2C3E50] mb-3">Kategori</label>
                        <select name="kategori" onchange="this.form.submit()" class="w-full rounded-xl border border-[#2C3E50]/10 bg-white px-4 py-3 text-sm text-[#2C3E50] outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15 transition">
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
                    <article data-product-card data-product-name="{{ strtolower($product->name) }}" data-product-category="{{ $product->category->name }}" class="group rounded-xl border border-[#2C3E50]/10 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="overflow-hidden rounded-xl bg-gray-100 mb-5">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-52 w-full object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <span class="rounded-full bg-[#F1F7FF] px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-[#3498DB]">{{ $product->category->name }}</span>
                            <span class="text-sm text-[#2C3E50]/70">
                                @if ($product->starting_price !== null)
                                    Rp {{ number_format($product->starting_price, 0, ',', '.') }}
                                @else
                                    Harga belum tersedia
                                @endif
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold text-[#2C3E50] mb-3">{{ $product->name }}</h2>
                        <p class="text-sm text-[#2C3E50]/70 mb-6 leading-relaxed">{{ $product->description }}</p>
                        <div class="flex flex-wrap gap-2 mb-6 text-xs text-[#2C3E50]/70">
                            @forelse ($product->activeVariants as $variant)
                                <span class="rounded-full border border-[#2C3E50]/10 bg-[#F8F9FA] px-3 py-1">{{ $variant->variant_name }}</span>
                            @empty
                                <span class="rounded-full border border-[#2C3E50]/10 bg-[#F8F9FA] px-3 py-1">Belum ada varian aktif</span>
                            @endforelse
                        </div>
                        <a href="{{ route('katalog.show', $product) }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#0f172a] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#2c3e50]">Pesan Sekarang</a>
                    </article>
                @empty
                    <div class="sm:col-span-2 xl:col-span-3 rounded-xl border border-dashed border-[#2C3E50]/20 bg-white p-10 text-center text-[#2C3E50]/70">
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
