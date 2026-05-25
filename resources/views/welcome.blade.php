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
    <title>Harapan Jaya Printing - Printing Services</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="antialiased selection:bg-[#dd7a21] selection:text-white">
    @include('partials.header')

    <main id="main-content">
        <section class="relative flex min-h-[60vh] items-center justify-center overflow-hidden pt-16 sm:min-h-[66vh] sm:pt-20">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-[#1c110b]/70"></div>
            <div class="relative z-10 mx-auto w-full max-w-7xl px-4 py-28 text-center sm:px-6 sm:py-32 lg:px-8 lg:py-36">
                <span class="inline-flex rounded-sm border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90">
                    Kualitas cetak tanpa kompromi
                </span>
                <h1 class="mt-6 text-4xl font-light leading-tight text-white sm:text-5xl lg:text-6xl tracking-tight">
                    Cetak Kebutuhan Visual dengan <strong class="font-semibold text-[#ffdfa9]">Warna yang Rapi</strong>
                </h1>
                <p class="mx-auto mt-6 max-w-3xl text-sm leading-relaxed text-white/70 sm:text-base">
                    Pilih produk, cek bahan dan ukuran, lalu kirim file lewat WhatsApp. Tim kami bantu pastikan hasil cetak sesuai kebutuhan Anda.
                </p>
                <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
                    <a href="{{ route('katalog.index') }}" class="inline-flex items-center justify-center rounded-sm bg-[#dd7a21] px-8 py-4 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white hover:text-[#1c110b]">
                        Lihat Katalog
                    </a>
                    <a href="{{ route('track-order') }}" class="inline-flex items-center justify-center rounded-sm border border-white/20 bg-white/5 px-8 py-4 text-sm font-semibold text-white transition-colors duration-200 hover:bg-white/10">
                        Lacak Pesanan
                    </a>
                </div>
            </div>
        </section>

        @if ($storeProfile && ($storeProfile->about || $brandLogoUrl))
        <section class="bg-white py-20 sm:py-24 border-t border-[#4e3422]/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    <!-- Left Column: Logo Frame -->
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="w-full max-w-sm aspect-square bg-transparent flex flex-col items-center justify-center transition-all duration-300">
                            @if ($brandLogoUrl)
                                <img src="{{ $brandLogoUrl }}" alt="{{ $storeProfile->name }}" class="max-h-full max-w-full object-contain filter drop-shadow-sm" />
                            @else
                                <!-- Elegant Monogram Fallback -->
                                <div class="text-center">
                                    <span class="text-7xl font-light text-[#dd7a21] font-serif block select-none">
                                        {{ $initials }}
                                    </span>
                                    <span class="mt-4 block text-xs font-medium text-[#4e3422]/40">
                                        Est. {{ $storeProfile->created_at?->format('Y') ?? '2026' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Profile Info -->
                    <div class="lg:col-span-7">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Tentang kami</span>
                        <h2 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl leading-tight">
                            Profil <strong class="font-semibold text-[#4e3422]">Harapan Jaya <span class="text-[#dd7a21]">Printing</span></strong>
                        </h2>
                        
                        @if ($storeProfile->about)
                            <p class="mt-6 text-sm leading-relaxed text-[#4e3422]/80 whitespace-pre-line font-normal">
                                {{ $storeProfile->about }}
                            </p>
                        @endif

                        <div class="mt-8">
                            <a href="{{ route('hubungi-kami') }}" class="inline-flex items-center justify-center rounded-sm border border-[#4e3422]/20 hover:border-[#dd7a21] bg-transparent px-6 py-3.5 text-sm font-semibold text-[#4e3422] transition-colors duration-200 hover:bg-[#dd7a21] hover:text-white">
                                Hubungi kami
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        @endif

        <section class="bg-white py-24 sm:py-32 border-t border-[#4e3422]/10 overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Section Header: Left-aligned, asymmetric, with Prev/Next buttons on the right -->
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8 mb-16">
                    <div class="max-w-2xl">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Katalog Pilihan</span>
                        <h2 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                            Produk Cetak <strong class="font-semibold">Unggulan</strong>
                        </h2>
                    </div>
                    <div class="flex items-end justify-between md:justify-end gap-6 w-full md:w-auto">
                        <div class="max-w-xs hidden lg:block text-right">
                            <p class="text-xs leading-relaxed text-[#4e3422]/70">
                                Geser untuk melihat pilihan bahan, ukuran, dan harga awal.
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button data-carousel-prev class="flex h-11 w-11 items-center justify-center rounded-sm border border-[#4e3422]/10 bg-transparent text-[#4e3422] transition duration-200 hover:border-[#dd7a21] hover:bg-[#dd7a21] hover:text-white disabled:opacity-30 disabled:pointer-events-none" aria-label="Previous slide">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button data-carousel-next class="flex h-11 w-11 items-center justify-center rounded-sm border border-[#4e3422]/10 bg-transparent text-[#4e3422] transition duration-200 hover:border-[#dd7a21] hover:bg-[#dd7a21] hover:text-white disabled:opacity-30 disabled:pointer-events-none" aria-label="Next slide">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Carousel Container -->
                <div class="relative">
                    <div data-carousel-track class="flex gap-6 md:gap-8 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar pb-8 cursor-grab active:cursor-grabbing select-none" style="scroll-padding-left: 2rem;">
                        
                        @foreach ($featuredProducts as $product)
                            <!-- Dynamic Card -->
                            <a href="{{ route('katalog.show', $product->slug) }}" class="group flex flex-col overflow-hidden border border-[#4e3422]/10 bg-[#fcfbf9] w-[75vw] sm:w-[300px] md:w-[340px] lg:w-[380px] shrink-0 snap-start transition-all duration-300 hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] rounded-sm">
                                <div class="relative aspect-[4/5] w-full overflow-hidden bg-stone-50">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 ease-out-expo group-hover:scale-105 select-none pointer-events-none" />
                                </div>
                                <div class="p-5 flex items-center justify-between border-t border-[#4e3422]/5">
                                    <h3 class="text-base font-semibold text-[#4e3422] tracking-tight group-hover:text-[#dd7a21] transition-colors duration-200">
                                        {{ $product->name }}
                                    </h3>
                                    <svg class="h-4 w-4 text-[#4e3422]/40 transition-transform duration-300 group-hover:translate-x-1 group-hover:text-[#dd7a21]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                        @endforeach

                        <!-- Card 4: Layanan Custom (Static highlight) -->
                        <a href="{{ route('hubungi-kami') }}" class="group flex flex-col overflow-hidden border border-[#4e3422]/15 bg-[#25170f] w-[75vw] sm:w-[300px] md:w-[340px] lg:w-[380px] shrink-0 snap-start transition-all duration-300 hover:shadow-[0_8px_30px_rgb(37,23,15,0.06)] rounded-sm">
                            <div class="relative aspect-[4/5] w-full overflow-hidden bg-stone-900">
                                <img src="https://images.unsplash.com/photo-1543857778-c4a1a3e0b2eb?auto=format&fit=crop&w=800&q=80" alt="Neon Box Harapan Jaya" class="absolute inset-0 h-full w-full object-cover opacity-60 transition-transform duration-700 ease-out-expo group-hover:scale-105 select-none pointer-events-none" />
                                <div class="absolute inset-0 bg-gradient-to-t from-[#25170f]/90 via-transparent to-transparent"></div>
                            </div>
                            <div class="p-5 flex items-center justify-between border-t border-white/10 bg-[#25170f]">
                                <h3 class="text-base font-light text-white tracking-tight group-hover:text-[#ffdfa9] transition-colors duration-200">
                                    Butuh cetakan khusus?
                                </h3>
                                <svg class="h-4 w-4 text-white/40 transition-transform duration-300 group-hover:translate-x-1 group-hover:text-[#ffdfa9]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>

                    </div>

                    <!-- Custom Progress Indicator -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="h-[2px] w-48 bg-[#4e3422]/10 relative">
                            <div data-carousel-progress class="absolute top-0 left-0 h-full w-0 bg-[#dd7a21] transition-all duration-150"></div>
                        </div>
                        <span class="text-xs font-medium text-[#4e3422]/40" data-carousel-counter>
                            Slide 1 / 4
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[#fffdfb] py-24 sm:py-32 border-t border-[#4e3422]/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Section Header: Left-aligned, asymmetric, highly refined -->
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-20">
                    <div class="max-w-2xl">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Langkah Mudah</span>
                        <h2 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                            Cara <strong class="font-semibold">Pesan</strong>
                        </h2>
                    </div>
                    <div class="max-w-md">
                        <p class="text-sm leading-relaxed text-[#4e3422]/70">
                            Mulai dari pilih produk sampai barang siap ambil, semua bisa dicek tanpa bolak-balik tanya manual.
                        </p>
                    </div>
                </div>

                <!-- Minimalist Timeline Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="group relative p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <span class="text-4xl font-extralight text-[#dd7a21]/50 block mb-6 font-serif">01</span>
                        <h3 class="text-lg font-medium text-[#4e3422] tracking-tight">Pilih produk</h3>
                        <p class="mt-3 text-xs leading-relaxed text-[#4e3422]/70">
                            Pilih produk di katalog cetak kami. Tentukan spesifikasi bahan awal sesuai panduan di halaman detail produk.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="group relative p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <span class="text-4xl font-extralight text-[#dd7a21]/50 block mb-6 font-serif">02</span>
                        <h3 class="text-lg font-medium text-[#4e3422] tracking-tight">Cek spesifikasi</h3>
                        <p class="mt-3 text-xs leading-relaxed text-[#4e3422]/70">
                            Bandingkan ukuran, jenis finishing, harga acuan, serta syarat file cetak sebelum mengirim berkas Anda.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="group relative p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <span class="text-4xl font-extralight text-[#dd7a21]/50 block mb-6 font-serif">03</span>
                        <h3 class="text-lg font-medium text-[#4e3422] tracking-tight">Pesan via WhatsApp</h3>
                        <p class="mt-3 text-xs leading-relaxed text-[#4e3422]/70">
                            Klik tombol pesan di halaman produk. Admin langsung menerima pilihan produk dan spesifikasinya.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="group relative p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <span class="text-4xl font-extralight text-[#dd7a21]/50 block mb-6 font-serif">04</span>
                        <h3 class="text-lg font-medium text-[#4e3422] tracking-tight">Lacak & ambil</h3>
                        <p class="mt-3 text-xs leading-relaxed text-[#4e3422]/70">
                            Pantau status pengerjaan, selesaikan pembayaran, lalu ambil barang saat pesanan selesai.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-24 sm:py-32 border-t border-[#4e3422]/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Section Header: Left-aligned, asymmetric, highly refined -->
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-20">
                    <div class="max-w-2xl">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Ulasan Pelanggan</span>
                        <h2 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                            Apa kata <strong class="font-semibold">Pelanggan kami</strong>
                        </h2>
                    </div>
                    <div class="max-w-md">
                        <p class="text-sm leading-relaxed text-[#4e3422]/70">
                            Beberapa cerita singkat dari pelanggan yang mencetak kebutuhan usaha, acara, dan promosi.
                        </p>
                    </div>
                </div>

                <!-- Minimalist Testimonial Cards -->
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Testimonial 1 -->
                    <div class="group flex flex-col justify-between p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <div>
                            <!-- Star Rating -->
                            <div class="flex gap-1 mb-6 text-[#dd7a21]">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm leading-relaxed text-[#4e3422]/80 font-serif italic mb-8">
                                "Responnya cepat dan penjelasan bahan cukup jelas. Kami jadi lebih mudah pesan kebutuhan acara kampus."
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-[#4e3422] block">Budi Santoso</span>
                            <span class="text-[10px] text-[#4e3422]/50 block mt-1">Panitia Event Kampus</span>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="group flex flex-col justify-between p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <div>
                            <!-- Star Rating -->
                            <div class="flex gap-1 mb-6 text-[#dd7a21]">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm leading-relaxed text-[#4e3422]/80 font-serif italic mb-8">
                                "Adminnya responsif di WhatsApp. Hasil stiker kemasan rapi dan warnanya konsisten untuk usaha kuliner kami."
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-[#4e3422] block">Siti Nurhaliza</span>
                            <span class="text-[10px] text-[#4e3422]/50 block mt-1">Pemilik UMKM Makanan</span>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="group flex flex-col justify-between p-8 bg-[#fcfbf9] border border-[#4e3422]/10 rounded-sm hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)] transition-all duration-300">
                        <div>
                            <!-- Star Rating -->
                            <div class="flex gap-1 mb-6 text-[#dd7a21]">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm leading-relaxed text-[#4e3422]/80 font-serif italic mb-8">
                                "Tracking pesanan dan invoice digital membantu kami saat rutin pesan media promosi."
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-[#4e3422] block">Ahmad Wijaya</span>
                            <span class="text-[10px] text-[#4e3422]/50 block mt-1">Event Organizer</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
