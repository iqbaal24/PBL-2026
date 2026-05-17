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
<body class="bg-[#F8F9FA] antialiased selection:bg-[#3498DB] selection:text-white">
    @include('partials.header')

    @php
        $storefront = config('storefront');
        $defaultVariant = $product->activeVariants->sortBy('price')->first();
        $minPrice = $product->activeVariants->min('price');
        $maxPrice = $product->activeVariants->max('price');
        $variantCount = $product->activeVariants->count();
        $minWeight = $product->activeVariants->filter(fn ($variant) => $variant->weight)->min('weight');
        $maxWeight = $product->activeVariants->filter(fn ($variant) => $variant->weight)->max('weight');
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

    <main id="main-content" class="pt-28 pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#2C3E50]/70 transition-colors hover:text-[#3498DB]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke katalog
                </a>
            </div>

            <div class="grid gap-8 lg:grid-cols-[minmax(0,1.35fr)_minmax(22rem,0.85fr)] xl:gap-10">
                <section class="space-y-10">
                    <div class="overflow-hidden rounded-[2rem] border border-[#2C3E50]/10 bg-white shadow-sm">
                        <div class="bg-[#EEF5FF] px-6 py-4 text-sm text-[#2C3E50]/72 sm:px-8">
                            Produk ini dipesan melalui WhatsApp. Tim kami akan bantu finalisasi spesifikasi, file, dan estimasi produksi.
                        </div>
                        <div class="grid gap-10 p-6 sm:p-8">
                            <div class="overflow-hidden rounded-[1.75rem] bg-[#F8F9FA]">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-[320px] w-full object-cover sm:h-[420px]" />
                            </div>

                            <div class="space-y-7">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="inline-flex rounded-full bg-[#E8F4FF] px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#3498DB]">
                                        {{ $product->category->name }}
                                    </span>
                                    <span class="inline-flex rounded-full border border-[#2C3E50]/10 bg-[#F8F9FA] px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#2C3E50]/62">
                                        {{ $variantCount }} varian aktif
                                    </span>
                                </div>

                                <div>
                                    <h1 class="text-3xl font-bold text-[#2C3E50] sm:text-[2.4rem] sm:leading-tight">{{ $product->name }}</h1>
                                    <p class="mt-4 max-w-[62ch] text-base leading-relaxed text-[#2C3E50]/72">
                                        {{ $product->description ?: 'Lihat ringkasan spesifikasi di bawah lalu lanjutkan ke WhatsApp untuk konfirmasi kebutuhan cetak, file desain, dan estimasi waktu pengerjaan.' }}
                                    </p>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                    <div class="rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#2C3E50]/55">Harga acuan</p>
                                        <p class="mt-2 text-lg font-semibold text-[#2C3E50]">{{ $priceRange ?? 'Konfirmasi via WhatsApp' }}</p>
                                    </div>
                                    <div class="rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#2C3E50]/55">Jumlah varian</p>
                                        <p class="mt-2 text-lg font-semibold text-[#2C3E50]">{{ $variantCount }} opsi aktif</p>
                                    </div>
                                    <div class="rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#2C3E50]/55">Rentang berat</p>
                                        <p class="mt-2 text-lg font-semibold text-[#2C3E50]">{{ $weightRange ?? 'Menunggu konfirmasi' }}</p>
                                    </div>
                                    <div class="rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#2C3E50]/55">File kerja</p>
                                        <p class="mt-2 text-lg font-semibold text-[#2C3E50]">PDF / CDR / AI</p>
                                    </div>
                                </div>

                                <div class="rounded-[1.75rem] bg-[#0F172A] px-6 py-5 text-sm leading-relaxed text-white/78 sm:px-7">
                                    Halaman ini dipakai untuk shortlist varian dan menyiapkan brief awal. Ukuran final, bahan, finishing, dan deadline tetap dikonfirmasi bersama admin sebelum produksi.
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-6 shadow-sm sm:p-8">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-[#2C3E50]">Detail teknis</h2>
                                <p class="mt-2 max-w-[52ch] text-sm leading-relaxed text-[#2C3E50]/70">
                                    Bandingkan varian aktif di sini, lalu lanjutkan ke WhatsApp untuk finalisasi ukuran, bahan, finishing, dan deadline.
                                </p>
                            </div>
                            <a href="{{ route('panduan') }}" class="inline-flex text-sm font-semibold text-[#2471A3] transition hover:text-[#1F618D]">Lihat panduan pemesanan</a>
                        </div>

                        <div class="mt-6 overflow-hidden rounded-[1.5rem] border border-[#2C3E50]/10">
                            <div class="hidden grid-cols-[minmax(0,1.45fr)_minmax(0,0.9fr)_minmax(0,0.75fr)_minmax(0,0.85fr)] gap-3 bg-[#EEF5FF] px-5 py-4 text-xs font-semibold uppercase tracking-[0.18em] text-[#2C3E50]/62 md:grid">
                                <span>Varian</span>
                                <span>Harga mulai</span>
                                <span>Berat</span>
                                <span>Status</span>
                            </div>
                            <div class="divide-y divide-[#2C3E50]/10 bg-white">
                                @forelse ($product->activeVariants as $variant)
                                    <div class="grid gap-3 px-5 py-5 text-sm text-[#2C3E50] md:grid-cols-[minmax(0,1.45fr)_minmax(0,0.9fr)_minmax(0,0.75fr)_minmax(0,0.85fr)] md:items-start">
                                        <div>
                                            <p class="font-semibold">{{ $variant->variant_name }}</p>
                                            <p class="mt-1 text-xs leading-relaxed text-[#2C3E50]/62">Harga awal per varian, detail final dikunci saat briefing.</p>
                                        </div>
                                        <div class="flex items-center justify-between gap-4 md:block">
                                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#2C3E50]/55 md:hidden">Harga</span>
                                            <span class="font-medium">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-4 md:block">
                                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#2C3E50]/55 md:hidden">Berat</span>
                                            <span>{{ $variant->weight ? number_format($variant->weight, 0, ',', '.') . ' gr' : '-' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between gap-4 md:block">
                                            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#2C3E50]/55 md:hidden">Status</span>
                                            <span class="inline-flex max-w-max rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                Aktif
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-5 py-6 text-sm text-[#2C3E50]/70">
                                        Data varian belum dipublikasikan. Hubungi admin untuk meminta detail spesifikasi terbaru.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-6 grid gap-4 lg:grid-cols-3">
                            <section class="rounded-[1.5rem] bg-[#F8F9FA] p-5">
                                <h3 class="text-base font-semibold text-[#2C3E50]">Sebelum chat</h3>
                                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#2C3E50]/72">
                                    <li>Siapkan nama produk, varian, dan jumlah perkiraan.</li>
                                    <li>Jika ada desain, kirim file PDF, CDR, AI, PSD, atau JPG/PNG resolusi tinggi.</li>
                                </ul>
                            </section>
                            <section class="rounded-[1.5rem] bg-[#F8F9FA] p-5">
                                <h3 class="text-base font-semibold text-[#2C3E50]">Yang admin konfirmasi</h3>
                                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#2C3E50]/72">
                                    <li>Ukuran final, bahan, finishing, dan deadline.</li>
                                    <li>Kesiapan file atau kebutuhan penyesuaian desain.</li>
                                </ul>
                            </section>
                            <section class="rounded-[1.5rem] bg-[#F8F9FA] p-5">
                                <h3 class="text-base font-semibold text-[#2C3E50]">Setelah dicatat</h3>
                                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#2C3E50]/72">
                                    <li>Status produksi muncul di <a href="{{ route('track-order') }}" class="font-semibold text-[#2471A3] hover:text-[#1F618D]">Lacak Pesanan</a>.</li>
                                    <li>Nota digital PDF tersedia dari halaman tracking.</li>
                                </ul>
                            </section>
                        </div>
                    </section>
                </section>

                <aside class="lg:sticky lg:top-28">
                    <div
                        data-whatsapp-builder
                        data-product-name="{{ $product->name }}"
                        data-product-category="{{ $product->category->name }}"
                        data-whatsapp-number="{{ $storefront['whatsapp_number'] }}"
                        class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-6 shadow-sm sm:p-8"
                    >
                        <span class="inline-flex rounded-full bg-[#E8F4FF] px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#3498DB]">
                            Order via WhatsApp
                        </span>
                        <h2 class="mt-5 text-2xl font-bold text-[#2C3E50]">Siapkan chat pemesanan</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#2C3E50]/70">
                            Pilih varian yang paling dekat dengan kebutuhan Anda. Admin akan membantu finalisasi ukuran, bahan, finishing, dan jadwal pengerjaan.
                        </p>

                        <div class="mt-6 space-y-4">
                            <div>
                                <label for="product-variant" class="mb-2 block text-sm font-semibold text-[#2C3E50]">Varian produk</label>
                                <select id="product-variant" data-whatsapp-variant class="h-12 w-full rounded-2xl border border-[#2C3E50]/12 bg-[#F8F9FA] px-4 text-sm text-[#2C3E50] outline-none transition focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15">
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
                                <label for="estimated-quantity" class="mb-2 block text-sm font-semibold text-[#2C3E50]">Jumlah perkiraan</label>
                                <input id="estimated-quantity" data-whatsapp-quantity type="number" min="1" value="1" class="h-12 w-full rounded-2xl border border-[#2C3E50]/12 bg-[#F8F9FA] px-4 text-sm text-[#2C3E50] outline-none transition focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15" />
                            </div>

                            <div>
                                <label for="product-note" class="mb-2 block text-sm font-semibold text-[#2C3E50]">Catatan singkat</label>
                                <textarea id="product-note" data-whatsapp-note rows="4" placeholder="Contoh: butuh untuk acara kampus minggu depan" class="w-full rounded-[1.5rem] border border-[#2C3E50]/12 bg-[#F8F9FA] px-4 py-3 text-sm text-[#2C3E50] outline-none transition focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#2C3E50]/55">Ringkasan chat</p>
                            <p data-whatsapp-preview class="mt-3 text-sm font-semibold text-[#2C3E50]">{{ $product->name }} • {{ $defaultVariant?->variant_name ?? 'Konsultasi produk' }} • 1</p>
                            <div class="mt-4 flex items-center justify-between gap-4 text-sm">
                                <span class="text-[#2C3E50]/68">Harga acuan</span>
                                <span data-whatsapp-price data-fallback="{{ $priceRange ?? 'Harga dikonfirmasi di WhatsApp' }}" class="font-semibold text-[#2C3E50]">
                                    {{ $defaultVariant ? 'Rp ' . number_format($defaultVariant->price, 0, ',', '.') : ($priceRange ?? 'Harga dikonfirmasi di WhatsApp') }}
                                </span>
                            </div>
                        </div>

                        <a data-whatsapp-cta href="https://wa.me/{{ $storefront['whatsapp_number'] }}" target="_blank" rel="noopener" class="mt-6 inline-flex h-12 w-full items-center justify-center rounded-full bg-[#0F172A] px-6 text-sm font-semibold text-white transition hover:bg-[#2C3E50] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#3498DB] focus-visible:ring-offset-2">
                            Order via WhatsApp
                        </a>

                        <p class="mt-4 text-sm leading-relaxed text-[#2C3E50]/68">
                            Pesan ini membawa konteks produk dan varian pilihan Anda. Final spesifikasi tetap dikonfirmasi bersama admin.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
