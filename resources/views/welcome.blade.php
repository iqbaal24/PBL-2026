@php
    $storeProfile = null;
    $brandLogoUrl = null;
    $initials = '';
    try {
        $storeProfile = \App\Models\StoreProfile::query()->first();
        if ($storeProfile) {
            if ($storeProfile->logo) {
                $brandLogoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($storeProfile->logo);
            }
            // Generate initials
            $words = explode(' ', $storeProfile->name);
            foreach ($words as $w) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
            $initials = substr($initials, 0, 3);
        }
    } catch (\Throwable $e) {
        // Fallback
    }

    $featuredProducts = collect();
    try {
        $featuredProducts = \App\Models\Product::query()
            ->where('is_active', true)
            ->with(['category', 'activeVariants'])
            ->get();
    } catch (\Throwable $e) {
        // Safe fallback
    }

    if ($featuredProducts->isEmpty()) {
        $featuredProducts = collect([
            (object)[
                'name' => 'Banner Flexi',
                'slug' => 'banner-flexi',
                'description' => 'Cetak baliho, spanduk, dan backdrop dengan bahan tebal tahan air. Hasil tajam untuk kebutuhan promosi luar ruangan dan event.',
                'image_url' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=800&q=80',
                'category' => (object)['name' => 'Format Besar'],
                'starting_price' => 25000,
                'activeVariants' => collect([
                    (object)['variant_name' => 'Flexi 280g / 340g / Korchin'],
                    (object)['variant_name' => 'Mata Ayam / Kolong Kayu'],
                ]),
            ],
            (object)[
                'name' => 'Vinyl Sticker',
                'slug' => 'vinyl-sticker',
                'description' => 'Stiker kemasan anti air dengan daya rekat kuat. Sangat cocok untuk botol, stoples, cup kopi, dan label pengiriman.',
                'image_url' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80',
                'category' => (object)['name' => 'Labeling'],
                'starting_price' => 15000,
                'activeVariants' => collect([
                    (object)['variant_name' => 'Bahan Camel / Ritrama (Kiss/Die Cut)'],
                ]),
            ],
            (object)[
                'name' => 'Art Paper Poster',
                'slug' => 'art-paper-poster',
                'description' => 'Cetak poster, brosur, atau menu dengan kertas art paper berkilau. Resolusi tinggi menjamin warna cetak presisi.',
                'image_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
                'category' => (object)['name' => 'Dokumen'],
                'starting_price' => 10000,
                'activeVariants' => collect([
                    (object)['variant_name' => 'Kertas 150g - 260g (A4 / A3 / A3+)'],
                ]),
            ],
        ]);
    }

@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Harapan Jaya Printing - Katalog Cetak Digital</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="antialiased selection:bg-[#d9782a] selection:text-white">
    @include('partials.header')

    <main id="main-content">
        <section class="home-hero relative flex min-h-[68vh] items-center overflow-hidden pt-16 sm:min-h-[74vh] sm:pt-20">
            <div class="home-hero__image absolute inset-0 bg-[url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-[#151311]/82"></div>
            <div class="relative z-10 mx-auto w-full max-w-7xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8 lg:py-28">
                <div class="max-w-4xl">
                    <span data-hero-reveal class="inline-flex rounded-sm border border-white/15 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90">
                        Harapan Jaya Printing, Malang
                    </span>
                    <h1 data-hero-reveal class="mt-6 text-4xl font-light leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Cetak banner, stiker, dan poster tanpa <strong class="font-semibold text-[#f4e2d2]">bingung spesifikasi</strong>
                    </h1>
                    <p data-hero-reveal class="mt-6 max-w-2xl text-base leading-relaxed text-white/74 sm:text-base">
                        Cek pilihan bahan dan harga awal di katalog, lalu lanjutkan pemesanan lewat WhatsApp.
                    </p>
                    <div data-hero-reveal class="mt-10 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('katalog.index') }}" class="home-action inline-flex items-center justify-center rounded-sm bg-[#d9782a] px-8 py-4 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white hover:text-[#181715]">
                            Lihat katalog
                        </a>
                        <a href="{{ route('track-order') }}" class="home-action inline-flex items-center justify-center rounded-sm border border-white/20 bg-white/5 px-8 py-4 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white/10">
                            Lacak pesanan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        @if ($storeProfile && ($storeProfile->about || $brandLogoUrl))
        <section data-reveal-section class="bg-white py-16 sm:py-20 border-t border-[#33302d]/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">
                    
                    <!-- Left Column: Logo Frame -->
                    <div data-reveal class="order-2 lg:order-1 lg:col-span-5 flex justify-center">
                        <div class="w-full max-w-36 sm:max-w-44 lg:max-w-sm aspect-square bg-transparent flex flex-col items-center justify-center transition-all duration-300">
                            @if ($brandLogoUrl)
                                <img src="{{ $brandLogoUrl }}" alt="{{ $storeProfile->name }}" class="max-h-full max-w-full object-contain filter drop-shadow-sm" />
                            @else
                                <!-- Elegant Monogram Fallback -->
                                <div class="text-center">
                                    <span class="text-7xl font-light text-[#d9782a] font-serif block select-none">
                                        {{ $initials }}
                                    </span>
                                    <span class="mt-4 block text-xs font-medium text-[#33302d]/40">
                                        Est. {{ $storeProfile->created_at?->format('Y') ?? '2026' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Profile Info -->
                    <div data-reveal class="order-1 lg:order-2 lg:col-span-7">
                        <span class="text-sm font-semibold text-[#d9782a] block mb-3">Tentang kami</span>
                        <h2 class="text-3xl font-light tracking-tight text-[#33302d] sm:text-4xl leading-tight">
                            Profil <strong class="font-semibold text-[#33302d]">Harapan Jaya <span class="text-[#d9782a]">Printing</span></strong>
                        </h2>
                        
                        @if ($storeProfile->about)
                            <p class="mt-6 text-base leading-relaxed text-[#33302d]/80 whitespace-pre-line font-normal">
                                {{ $storeProfile->about }}
                            </p>
                        @endif

                        <!-- <p class="mt-6 text-sm font-semibold text-[#33302d]">
                            Malang dan sekitarnya. Pemesanan lewat katalog dan WhatsApp, status bisa dilacak online.
                        </p> -->
                    </div>
                    
                </div>
            </div>
        </section>
        @endif

        <section data-reveal-section class="bg-white py-16 sm:py-20 border-t border-[#33302d]/10 overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="text-sm font-semibold text-[#d9782a] block mb-2">Katalog pilihan</span>
                        <h2 class="text-2xl font-semibold tracking-tight text-[#33302d] sm:text-3xl">
                            Produk unggulan
                        </h2>
                    </div>
                    <div class="flex items-center justify-between gap-4 sm:justify-end">
                        <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-[#33302d] transition hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                            Lihat katalog
                        </a>
                        <div class="flex items-center gap-3">
                            <button data-carousel-prev class="flex h-11 w-11 items-center justify-center rounded-sm border border-[#33302d]/10 bg-transparent text-[#33302d] transition duration-200 hover:border-[#d9782a] hover:bg-[#d9782a] hover:text-white disabled:opacity-30 disabled:pointer-events-none" aria-label="Produk sebelumnya">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button data-carousel-next class="flex h-11 w-11 items-center justify-center rounded-sm border border-[#33302d]/10 bg-transparent text-[#33302d] transition duration-200 hover:border-[#d9782a] hover:bg-[#d9782a] hover:text-white disabled:opacity-30 disabled:pointer-events-none" aria-label="Produk berikutnya">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div data-carousel-track class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar pb-2 cursor-grab active:cursor-grabbing select-none" style="scroll-padding-left: 1rem;">
                        
                        @foreach ($featuredProducts as $product)
                            @php
                                $productRouteKey = $product instanceof \App\Models\Product ? $product : ($product->slug ?? '');
                            @endphp
                            <a data-reveal href="{{ route('katalog.show', $productRouteKey) }}" class="home-product-card group flex w-[62vw] shrink-0 snap-start flex-col overflow-hidden rounded-sm border border-[#33302d]/10 bg-white transition-all duration-300 hover:border-[#d9782a]/35 sm:w-[220px] md:w-[240px] lg:w-[260px]">
                                <div class="relative aspect-[16/10] w-full overflow-hidden bg-stone-50">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 ease-out-expo group-hover:scale-[1.03] select-none pointer-events-none" />
                                </div>
                                <div class="flex flex-1 flex-col border-t border-[#33302d]/5 p-4">
                                    <span class="text-xs font-semibold text-[#d9782a]">{{ $product->category?->name ?? 'Produk cetak' }}</span>
                                    <h3 class="mt-1.5 line-clamp-2 text-base font-semibold text-[#33302d] tracking-tight group-hover:text-[#d9782a] transition-colors duration-200">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="mt-4 border-t border-[#33302d]/8 pt-3">
                                        <span class="block text-[11px] font-semibold text-[#33302d]/45">Mulai dari</span>
                                        <span class="mt-1 block text-sm font-semibold text-[#33302d]">Rp{{ number_format($product->starting_price ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>

        <section data-reveal-section class="bg-[#f6f6f4] py-20 sm:py-28 border-t border-[#33302d]/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Section Header: Left-aligned, asymmetric, highly refined -->
                <div class="grid gap-10 lg:grid-cols-12 lg:items-start">
                    <div data-reveal class="max-w-2xl lg:col-span-5">
                        <span class="text-sm font-semibold text-[#d9782a] block mb-3">Langkah Mudah</span>
                        <h2 class="text-3xl font-light tracking-tight text-[#33302d] sm:text-4xl lg:text-5xl leading-tight">
                            Cara <strong class="font-semibold">Pesan</strong>
                        </h2>
                        <p class="mt-5 text-base leading-relaxed text-[#33302d]/70">
                            Semua dimulai dari halaman produk. Detail final dikonfirmasi admin lewat WhatsApp.
                        </p>
                    </div>
                    <ol class="lg:col-span-7 divide-y divide-[#33302d]/10 border-y border-[#33302d]/10">
                        <li data-reveal class="grid gap-3 py-5 sm:grid-cols-[3rem_1fr]">
                            <span class="text-sm font-semibold text-[#d9782a]">01</span>
                            <div>
                                <h3 class="text-base font-semibold text-[#33302d]">Pilih produk</h3>
                                <p class="mt-1 text-base leading-relaxed text-[#33302d]/70">Buka katalog dan pilih produk yang paling dekat dengan kebutuhan cetak.</p>
                            </div>
                        </li>
                        <li data-reveal class="grid gap-3 py-5 sm:grid-cols-[3rem_1fr]">
                            <span class="text-sm font-semibold text-[#d9782a]">02</span>
                            <div>
                                <h3 class="text-base font-semibold text-[#33302d]">Cek spesifikasi</h3>
                                <p class="mt-1 text-base leading-relaxed text-[#33302d]/70">Lihat bahan, harga awal, varian, dan catatan file sebelum menghubungi admin.</p>
                            </div>
                        </li>
                        <li data-reveal class="grid gap-3 py-5 sm:grid-cols-[3rem_1fr]">
                            <span class="text-sm font-semibold text-[#d9782a]">03</span>
                            <div>
                                <h3 class="text-base font-semibold text-[#33302d]">Pesan via WhatsApp</h3>
                                <p class="mt-1 text-base leading-relaxed text-[#33302d]/70">Kirim pilihan produk, jumlah, ukuran, dan catatan langsung dari halaman detail.</p>
                            </div>
                        </li>
                        <li data-reveal class="grid gap-3 py-5 sm:grid-cols-[3rem_1fr]">
                            <span class="text-sm font-semibold text-[#d9782a]">04</span>
                            <div>
                                <h3 class="text-base font-semibold text-[#33302d]">Lacak pesanan</h3>
                                <p class="mt-1 text-base leading-relaxed text-[#33302d]/70">Cek status pengerjaan ketika pesanan sudah dibuat.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
