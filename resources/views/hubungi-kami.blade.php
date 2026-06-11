@php
    $storefront = config('storefront');

    try {
        $storeProfile = \App\Models\StoreProfile::query()->first();
        if ($storeProfile?->name) {
            $storefront['brand_name'] = $storeProfile->name;
        }
        if ($storeProfile?->address) {
            $storefront['address_lines'] = collect(preg_split('/\r\n|\r|\n/', $storeProfile->address))
                ->map(fn (string $line): string => trim($line))
                ->filter()
                ->values()
                ->all();
            $storefront['maps_url'] = 'https://maps.google.com/?q=' . rawurlencode(str_replace(["\r", "\n"], ' ', $storeProfile->address));
        }
        if ($storeProfile?->maps_url) {
            $storefront['maps_url'] = $storeProfile->maps_url;
        }
        if ($storeProfile?->maps_embed_url) {
            $storefront['maps_embed_url'] = $storeProfile->maps_embed_url;
        }
        if ($storeProfile?->whatsapp_number) {
            $number = preg_replace('/[^0-9]/', '', $storeProfile->whatsapp_number) ?? '';
            $displayNumber = str_starts_with($number, '62') ? '0' . substr($number, 2) : $number;
            $storefront['whatsapp_number'] = str_starts_with($number, '0') ? '62' . substr($number, 1) : $number;
            $storefront['whatsapp_display'] = $displayNumber;
        }
        if ($storeProfile?->email) {
            $storefront['email'] = $storeProfile->email;
        }
    } catch (\Throwable $exception) {
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami - {{ $storefront['brand_name'] }}</title>
    @include('partials.favicon')

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="bg-white antialiased selection:bg-[#d9782a] selection:text-white">
    @include('partials.header')

    @php
        $whatsappConsultLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo ' . $storefront['brand_name'] . ', saya ingin konsultasi produk.');
        $whatsappQuoteLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo ' . $storefront['brand_name'] . ', saya ingin meminta penawaran harga.');
    @endphp

    <main id="main-content" class="bg-white">
        <section class="relative overflow-hidden border-b border-[#33302d]/10 pt-32 pb-12 sm:pt-36 sm:pb-16">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-white/92"></div>
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-white to-transparent"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold text-[#d9782a] block mb-3">Hubungi kami</span>
                        <h1 class="text-3xl font-light tracking-tight text-[#33302d] sm:text-4xl lg:text-5xl leading-tight">
                            Pilih jalur yang paling cepat untuk <strong class="font-semibold">kebutuhan cetak Anda</strong>
                        </h1>
                    </div>
                    <p class="mt-5 max-w-2xl text-base leading-relaxed text-[#33302d]/70">
                        Untuk pesanan baru, mulai dari katalog agar produk dan spesifikasi terbawa ke chat. Untuk kebutuhan khusus, kirim detail langsung ke admin.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 sm:py-16">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_21rem] lg:px-8">
                <div class="min-w-0 space-y-14">
                    <section class="border-b border-[#33302d]/10 pb-12">
                        <div class="grid gap-8 lg:grid-cols-[17rem_minmax(0,1fr)]">
                            <div>
                                <span class="text-sm font-semibold text-[#d9782a]">Jalur bantuan</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#33302d] sm:text-3xl">
                                    Mau mulai dari mana?
                                </h2>
                            </div>

                            <div class="divide-y divide-[#33302d]/10 border-y border-[#33302d]/10">
                                <article class="grid gap-4 py-6 first:pt-0 sm:grid-cols-[minmax(0,1fr)_12rem] sm:items-center">
                                    <div>
                                        <h3 class="text-xl font-semibold tracking-tight text-[#33302d]">Pesanan baru</h3>
                                        <p class="mt-2 max-w-2xl text-base leading-relaxed text-[#33302d]/70">
                                            Pilih produk dulu agar bahan, varian, dan harga acuan jelas sebelum chat admin.
                                        </p>
                                    </div>
                                    <a href="{{ route('katalog.index') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                        Buka katalog
                                    </a>
                                </article>

                                <article class="grid gap-4 py-6 sm:grid-cols-[minmax(0,1fr)_12rem] sm:items-center">
                                    <div>
                                        <h3 class="text-xl font-semibold tracking-tight text-[#33302d]">Kebutuhan khusus</h3>
                                        <p class="mt-2 max-w-2xl text-base leading-relaxed text-[#33302d]/70">
                                            Cocok untuk ukuran, bahan, finishing, atau deadline yang belum tersedia di katalog.
                                        </p>
                                    </div>
                                    <a href="{{ $whatsappConsultLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                        Konsultasi
                                    </a>
                                </article>

                                <article class="grid gap-4 py-6 last:pb-0 sm:grid-cols-[minmax(0,1fr)_12rem] sm:items-center">
                                    <div>
                                        <h3 class="text-xl font-semibold tracking-tight text-[#33302d]">Sudah punya pesanan?</h3>
                                        <p class="mt-2 max-w-2xl text-base leading-relaxed text-[#33302d]/70">
                                            Gunakan nomor pesanan dan nomor WhatsApp untuk cek progres atau unduh nota digital.
                                        </p>
                                    </div>
                                    <a href="{{ route('track-order') }}" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                        Lacak pesanan
                                    </a>
                                </article>
                            </div>
                        </div>
                    </section>

                    <section class="border-b border-[#33302d]/10 pb-12">
                        <div class="mb-7 grid gap-4 lg:grid-cols-[minmax(0,1fr)_12rem] lg:items-end">
                            <div>
                                <span class="text-sm font-semibold text-[#d9782a]">Minta penawaran</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#33302d] sm:text-3xl">
                                    Siapkan detail ini agar harga lebih cepat dihitung
                                </h2>
                            </div>
                            <a href="{{ $whatsappQuoteLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Minta penawaran
                            </a>
                        </div>

                        <div class="grid overflow-hidden rounded-sm border border-[#33302d]/10 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ([
                                'Nama produk atau contoh kebutuhan',
                                'Ukuran dan jumlah cetak',
                                'Bahan atau finishing yang diinginkan',
                                'Deadline pemakaian',
                                'File desain atau referensi gambar',
                                'Catatan khusus, jika ada',
                            ] as $index => $item)
                                <div class="border-b border-[#33302d]/10 p-5 last:border-b-0 sm:border-r sm:last:border-r-0 lg:[&:nth-child(3n)]:border-r-0 lg:[&:nth-last-child(-n+3)]:border-b-0">
                                    <span class="text-sm font-semibold text-[#d9782a]">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <p class="mt-2 text-base leading-relaxed text-[#33302d]/75">{{ $item }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section>
                        <div class="grid gap-8 lg:grid-cols-[17rem_minmax(0,1fr)]">
                            <div>
                                <span class="text-sm font-semibold text-[#d9782a]">Datang ke toko</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#33302d] sm:text-3xl">
                                    Lokasi dan jam operasional
                                </h2>
                            </div>

                            <div class="grid gap-6 lg:grid-cols-2">
                                <div class="border-y border-[#33302d]/10 py-5">
                                    <h3 class="text-base font-semibold text-[#33302d]">Alamat toko</h3>
                                    <div class="mt-4 space-y-1 text-base leading-relaxed text-[#33302d]/70">
                                    @foreach ($storefront['address_lines'] as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                    </div>
                                    <a href="{{ $storefront['maps_url'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#d9782a] transition hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Buka lokasi di Google Maps
                                    </a>
                                </div>

                                <div class="border-y border-[#33302d]/10 py-5">
                                    <h3 class="text-base font-semibold text-[#33302d]">Jam operasional</h3>
                                    <div class="mt-4 divide-y divide-[#33302d]/10 text-base">
                                        @foreach ($storefront['hours'] as $hour)
                                            <div class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0">
                                                <span class="text-[#33302d]/65">{{ $hour['label'] }}</span>
                                                <span class="font-semibold text-[#33302d]">{{ $hour['value'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-5 lg:sticky lg:top-28 lg:self-start">
                    <div class="rounded-sm bg-[#33302d] p-6 text-[#f7f7f5] shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                        <h2 class="text-lg font-semibold text-white">Chat admin</h2>
                        <p class="mt-3 text-base leading-relaxed text-white/70">
                            Admin akan lebih cepat membantu jika pesan Anda sudah berisi produk, ukuran, jumlah, dan deadline.
                        </p>
                        <div class="mt-5 grid gap-3">
                            <a href="{{ $whatsappConsultLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Konsultasi produk
                            </a>
                            <a href="{{ $whatsappQuoteLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Minta penawaran
                            </a>
                        </div>
                    </div>

                    <div class="rounded-sm border border-[#33302d]/10 bg-white p-6">
                        <h2 class="text-base font-semibold text-[#33302d]">Kontak langsung</h2>
                        <div class="mt-4 space-y-4 text-base leading-relaxed text-[#33302d]/70">
                            <div>
                                <p class="font-semibold text-[#33302d]">WhatsApp</p>
                                <a href="https://wa.me/{{ $storefront['whatsapp_number'] }}" target="_blank" rel="noopener" class="mt-1 inline-flex text-[#d9782a] transition hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                    {{ $storefront['whatsapp_display'] }}
                                </a>
                            </div>
                            <div>
                                <p class="font-semibold text-[#33302d]">Email</p>
                                <a href="mailto:{{ $storefront['email'] }}" class="mt-1 inline-flex text-[#d9782a] transition hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                    {{ $storefront['email'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
