<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - Harapan Jaya Printing</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="bg-white antialiased selection:bg-[#dd7a21] selection:text-white">
    @include('partials.header')

    @php
        $storefront = config('storefront');
        $defaultVariant = $product->activeVariants->sortBy('price')->first();
        $minPrice = $product->activeVariants->min('price');
        $maxPrice = $product->activeVariants->max('price');
        $variantCount = $product->activeVariants->count();
        $minWeight = $product->activeVariants->filter(fn ($variant) => $variant->weight)->min('weight');
        $maxWeight = $product->activeVariants->filter(fn ($variant) => $variant->weight)->max('weight');
        $averageRating = $product->visible_reviews_avg_rating ? round($product->visible_reviews_avg_rating, 1) : null;
        $reviewCount = (int) ($product->visible_reviews_count ?? 0);
        $priceRange = null;
        $weightRange = null;

        if ($minPrice !== null && $maxPrice !== null) {
            $priceRange = $minPrice === $maxPrice
                ? 'Rp ' . number_format($minPrice, 0, ',', '.')
                : 'Rp ' . number_format($minPrice, 0, ',', '.') . ' - Rp ' . number_format($maxPrice, 0, ',', '.');
        }

        if ($minWeight !== null && $maxWeight !== null) {
            $weightRange = $minWeight === $maxWeight
                ? number_format($minWeight, 0, ',', '.') . ' gr'
                : number_format($minWeight, 0, ',', '.') . ' - ' . number_format($maxWeight, 0, ',', '.') . ' gr';
        }
    @endphp

    <main id="main-content" class="bg-white pt-28 pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#4e3422]/70 transition-colors hover:text-[#dd7a21] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke katalog
                </a>
            </div>

            <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_22rem] xl:grid-cols-[minmax(0,1fr)_24rem]">
                <div class="min-w-0 space-y-10">
                    <section class="grid gap-8 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:items-start">
                        <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9]">
                            <div class="relative aspect-[4/5] overflow-hidden bg-[#fcfbf9] sm:aspect-[5/4] lg:aspect-[4/5]">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover" />
                            </div>
                        </div>

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-sm border border-[#dd7a21]/25 px-3 py-2 text-xs font-semibold text-[#c86818]">
                                    {{ $product->category->name }}
                                </span>
                                <span class="rounded-sm border border-[#4e3422]/15 px-3 py-2 text-xs font-semibold text-[#4e3422]/60">
                                    {{ $variantCount }} opsi
                                </span>
                                @if ($reviewCount > 0)
                                    <span class="inline-flex items-center gap-1 rounded-sm border border-[#dd7a21]/25 px-3 py-2 text-xs font-semibold text-[#c86818]">
                                        <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($averageRating, 1) }} dari {{ $reviewCount }} review
                                    </span>
                                @endif
                            </div>

                            <h1 class="mt-5 text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                                {{ $product->name }}
                            </h1>
                            <p class="mt-4 max-w-[65ch] text-sm leading-relaxed text-[#4e3422]/72 sm:text-base">
                                {{ $product->description ?: 'Cek spesifikasi awal, pilih varian terdekat, lalu lanjutkan ke WhatsApp untuk konfirmasi kebutuhan cetak dan file desain.' }}
                            </p>

                            <dl class="mt-7 grid gap-4 border-y border-[#4e3422]/10 py-5 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs font-medium text-[#4e3422]/50">Harga acuan</dt>
                                    <dd class="mt-1 text-lg font-semibold text-[#4e3422]">{{ $priceRange ?? 'Konfirmasi via WhatsApp' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-[#4e3422]/50">Rentang berat</dt>
                                    <dd class="mt-1 text-lg font-semibold text-[#4e3422]">{{ $weightRange ?? 'Menunggu konfirmasi' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-[#4e3422]/50">File yang bisa dikirim</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#4e3422]">PDF, CDR, AI, PSD, JPG, PNG</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-[#4e3422]/50">Cara pesan</dt>
                                    <dd class="mt-1 text-sm font-semibold text-[#4e3422]">Final lewat WhatsApp</dd>
                                </div>
                            </dl>

                            <div class="mt-6 rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                <h2 class="text-sm font-semibold text-[#4e3422]">Sebelum pesan</h2>
                                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#4e3422]/70">
                                    <li>Siapkan varian, jumlah perkiraan, ukuran, dan deadline.</li>
                                    <li>Kirim file desain atau referensi jika sudah ada.</li>
                                    <li>Admin akan memastikan bahan, finishing, harga final, dan estimasi produksi.</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <section class="border-t border-[#4e3422]/10 pt-10">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <span class="text-sm font-semibold text-[#dd7a21]">Pilihan varian</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                    Bandingkan opsi yang tersedia
                                </h2>
                            </div>
                            <a href="{{ route('panduan') }}" class="inline-flex text-sm font-semibold text-[#c86818] transition hover:text-[#aa5410] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">Lihat panduan pemesanan</a>
                        </div>

                        <div class="mt-6 overflow-hidden rounded-sm border border-[#4e3422]/10">
                            <div class="hidden grid-cols-[minmax(0,1.55fr)_minmax(0,0.9fr)_minmax(0,0.75fr)] gap-3 border-b border-[#4e3422]/10 bg-[#fcfbf9] px-5 py-4 text-xs font-semibold text-[#4e3422]/55 md:grid">
                                <span>Varian</span>
                                <span>Harga mulai</span>
                                <span>Berat</span>
                            </div>
                            <div class="divide-y divide-[#4e3422]/10 bg-white">
                                @forelse ($product->activeVariants as $variant)
                                    <div class="grid gap-3 px-5 py-5 text-sm text-[#4e3422] md:grid-cols-[minmax(0,1.55fr)_minmax(0,0.9fr)_minmax(0,0.75fr)] md:items-start">
                                        <div>
                                            <p class="font-semibold">{{ $variant->variant_name }}</p>
                                            <p class="mt-1 text-xs leading-relaxed text-[#4e3422]/62">Harga awal, detail final dikonfirmasi bersama admin.</p>
                                        </div>
                                        <div class="flex items-center justify-between gap-4 md:block">
                                            <span class="text-xs font-medium text-[#4e3422]/50 md:hidden">Harga mulai</span>
                                            <span class="font-medium">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-4 md:block">
                                            <span class="text-xs font-medium text-[#4e3422]/50 md:hidden">Berat</span>
                                            <span>{{ $variant->weight ? number_format($variant->weight, 0, ',', '.') . ' gr' : '-' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col items-center justify-center gap-3 px-5 py-12 text-center text-[#4e3422]">
                                        <svg class="h-8 w-8 text-[#4e3422]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <p class="text-sm font-medium">Data varian belum dipublikasikan</p>
                                        <p class="text-sm text-[#4e3422]/70">Hubungi admin untuk meminta detail spesifikasi terbaru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    <section class="border-t border-[#4e3422]/10 pt-10">
                        <div class="grid gap-4 md:grid-cols-3">
                            <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                <h3 class="text-sm font-semibold text-[#4e3422]">File desain</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Kirim file resolusi tinggi jika ada. Admin akan cek apakah file siap cetak.</p>
                            </div>
                            <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                <h3 class="text-sm font-semibold text-[#4e3422]">Konfirmasi admin</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Ukuran, bahan, finishing, harga final, dan deadline dikunci sebelum produksi.</p>
                            </div>
                            <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                <h3 class="text-sm font-semibold text-[#4e3422]">Setelah dicatat</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Status produksi dan nota digital tersedia di <a href="{{ route('track-order') }}" class="font-semibold text-[#c86818] hover:text-[#aa5410]">Lacak pesanan</a>.</p>
                            </div>
                        </div>
                    </section>

                    <section class="border-t border-[#4e3422]/10 pt-10">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <span class="text-sm font-semibold text-[#dd7a21]">Review pelanggan</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                    Pengalaman setelah pesanan selesai
                                </h2>
                            </div>
                            @if ($reviewCount > 0)
                                <div class="flex items-center gap-2 text-sm text-[#4e3422]/65">
                                    <span class="flex items-center gap-1 font-semibold text-[#c86818]">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($averageRating, 1) }}
                                    </span>
                                    <span>{{ $reviewCount }} review ditampilkan</span>
                                </div>
                            @endif
                        </div>

                        @if ($product->reviews->isNotEmpty())
                            <div class="mt-6 grid gap-4 md:grid-cols-2">
                                @foreach ($product->reviews as $review)
                                    <article class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-sm font-semibold text-[#4e3422]">{{ $review->customer_name }}</h3>
                                                <p class="mt-1 text-xs text-[#4e3422]/50">{{ $review->created_at?->translatedFormat('d M Y') }}</p>
                                            </div>
                                            <div class="flex items-center gap-1 text-sm font-semibold text-[#c86818]">
                                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                {{ $review->rating }}
                                            </div>
                                        </div>
                                        <p class="mt-4 text-sm leading-relaxed text-[#4e3422]/72">{{ $review->comment }}</p>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-6 flex flex-col items-center justify-center gap-3 rounded-sm border border-dashed border-[#4e3422]/20 bg-[#fcfbf9] p-10 text-center text-[#4e3422]">
                                <svg class="h-8 w-8 text-[#4e3422]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-sm font-medium">Belum ada review</p>
                                <p class="text-sm text-[#4e3422]/70">Review dari pelanggan akan muncul setelah pesanan selesai dan dicek admin.</p>
                            </div>
                        @endif
                    </section>
                </div>

                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <div
                        data-whatsapp-builder
                        data-product-name="{{ $product->name }}"
                        data-product-category="{{ $product->category->name }}"
                        data-whatsapp-number="{{ $storefront['whatsapp_number'] }}"
                        class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]"
                    >
                        <span class="text-sm font-semibold text-[#dd7a21]">Pesan via WhatsApp</span>
                        <h2 class="mt-2 text-xl font-semibold tracking-tight text-[#4e3422]">Siapkan chat pemesanan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#4e3422]/70">
                            Pilih varian dan jumlah perkiraan. Pesan otomatis akan membawa konteks produk ke admin.
                        </p>

                        <div class="mt-5 space-y-4">
                            <div>
                                <label for="product-variant" class="mb-2 block text-sm font-semibold text-[#4e3422]">Varian produk</label>
                                <select id="product-variant" data-whatsapp-variant class="h-12 w-full rounded-sm border border-[#4e3422]/15 bg-white px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15">
                                    @forelse ($product->activeVariants as $variant)
                                        <option
                                            value="{{ $variant->id }}"
                                            data-variant-label="{{ $variant->variant_name }}"
                                            data-variant-price="Rp {{ number_format($variant->price, 0, ',', '.') }}"
                                            @selected($defaultVariant && $defaultVariant->id === $variant->id)
                                        >
                                            {{ $variant->variant_name }}
                                        </option>
                                    @empty
                                        <option value="" data-variant-label="Konsultasi produk">Konsultasi produk</option>
                                    @endforelse
                                </select>
                            </div>

                            <div>
                                <label for="estimated-quantity" class="mb-2 block text-sm font-semibold text-[#4e3422]">Jumlah perkiraan</label>
                                <input id="estimated-quantity" data-whatsapp-quantity type="number" min="1" value="1" class="h-12 w-full rounded-sm border border-[#4e3422]/15 bg-white px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15" />
                            </div>

                            <div>
                                <label for="estimated-size" class="mb-2 block text-sm font-semibold text-[#4e3422]">Ukuran</label>
                                <input id="estimated-size" data-whatsapp-size type="text" placeholder="Contoh: A3, 60 x 160 cm, 3 x 1 m" class="h-12 w-full rounded-sm border border-[#4e3422]/15 bg-white px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15" />
                            </div>

                            <div>
                                <label for="product-note" class="mb-2 block text-sm font-semibold text-[#4e3422]">Catatan singkat</label>
                                <textarea id="product-note" data-whatsapp-note rows="4" placeholder="Contoh: butuh untuk acara kampus minggu depan" class="w-full rounded-sm border border-[#4e3422]/15 bg-white px-4 py-3 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15"></textarea>
                            </div>
                        </div>

                        <div class="mt-5 rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-4">
                            <p class="text-xs font-medium text-[#4e3422]/50">Ringkasan chat</p>
                            <p data-whatsapp-preview class="mt-2 text-sm font-semibold text-[#4e3422]">{{ $product->name }} • {{ $defaultVariant?->variant_name ?? 'Konsultasi produk' }} • 1</p>
                            <div class="mt-3 flex items-center justify-between gap-4 text-sm">
                                <span class="text-[#4e3422]/68">Harga acuan</span>
                                <span data-whatsapp-price data-fallback="{{ $priceRange ?? 'Harga dikonfirmasi di WhatsApp' }}" class="font-semibold text-[#4e3422]">
                                    {{ $defaultVariant ? 'Rp ' . number_format($defaultVariant->price, 0, ',', '.') : ($priceRange ?? 'Harga dikonfirmasi di WhatsApp') }}
                                </span>
                            </div>
                        </div>

                        <a data-whatsapp-cta href="https://wa.me/{{ $storefront['whatsapp_number'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex h-12 w-full items-center justify-center rounded-sm bg-[#6e3b12] px-6 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                            Pesan via WhatsApp
                        </a>

                        <p class="mt-4 text-sm leading-relaxed text-[#4e3422]/68">
                            Final spesifikasi tetap dikonfirmasi bersama admin sebelum produksi.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
