<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami - Harapan Jaya Printing</title>

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
        $whatsappConsultLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo Harapan Jaya Printing, saya ingin konsultasi produk.');
        $whatsappQuoteLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo Harapan Jaya Printing, saya ingin meminta penawaran harga.');
    @endphp

    <main id="main-content" class="bg-white">
        <section class="border-b border-[#4e3422]/10 bg-white pt-32 pb-12 sm:pt-36 sm:pb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Hubungi kami</span>
                        <h1 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                            Pilih jalur yang paling cepat untuk <strong class="font-semibold">kebutuhan cetak Anda</strong>
                        </h1>
                    </div>
                    <p class="max-w-md text-sm leading-relaxed text-[#4e3422]/70 lg:text-right">
                        Untuk pesanan baru, mulai dari katalog agar produk dan spesifikasi terbawa ke chat. Untuk kebutuhan khusus, kirim detail langsung ke admin.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white py-10 sm:py-12">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_20rem] lg:px-8">
                <div class="min-w-0 space-y-10">
                    <section class="border-b border-[#4e3422]/10 pb-10">
                        <div class="mb-6">
                            <span class="text-sm font-semibold text-[#dd7a21]">Jalur bantuan</span>
                            <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                Mau mulai dari mana?
                            </h2>
                        </div>

                        <div class="grid gap-4 md:grid-cols-3">
                            <article class="rounded-sm border border-[#4e3422]/10 bg-white p-5 transition hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)]">
                                <h3 class="text-base font-semibold tracking-tight text-[#4e3422]">Pesanan baru</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">
                                    Pilih produk dulu agar bahan, varian, dan harga acuan jelas sebelum chat admin.
                                </p>
                                <a href="{{ route('katalog.index') }}" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                    Buka katalog
                                </a>
                            </article>

                            <article class="rounded-sm border border-[#4e3422]/10 bg-white p-5 transition hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)]">
                                <h3 class="text-base font-semibold tracking-tight text-[#4e3422]">Kebutuhan khusus</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">
                                    Cocok untuk ukuran, bahan, finishing, atau deadline yang belum tersedia di katalog.
                                </p>
                                <a href="{{ $whatsappConsultLink }}" target="_blank" rel="noopener" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                    Konsultasi via WhatsApp
                                </a>
                            </article>

                            <article class="rounded-sm border border-[#4e3422]/10 bg-white p-5 transition hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)]">
                                <h3 class="text-base font-semibold tracking-tight text-[#4e3422]">Sudah punya pesanan?</h3>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">
                                    Gunakan nomor pesanan dan nomor WhatsApp untuk cek progres atau unduh nota digital.
                                </p>
                                <a href="{{ route('track-order') }}" class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                    Lacak pesanan
                                </a>
                            </article>
                        </div>
                    </section>

                    <section class="border-b border-[#4e3422]/10 pb-10">
                        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <span class="text-sm font-semibold text-[#dd7a21]">Minta penawaran</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                    Siapkan detail ini agar harga lebih cepat dihitung
                                </h2>
                            </div>
                            <a href="{{ $whatsappQuoteLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Minta penawaran
                            </a>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ([
                                'Nama produk atau contoh kebutuhan',
                                'Ukuran dan jumlah cetak',
                                'Bahan atau finishing yang diinginkan',
                                'Deadline pemakaian',
                                'File desain atau referensi gambar',
                                'Catatan khusus, jika ada',
                            ] as $item)
                                <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-4">
                                    <p class="text-sm leading-relaxed text-[#4e3422]/75">{{ $item }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section>
                        <div class="mb-6">
                            <span class="text-sm font-semibold text-[#dd7a21]">Datang ke toko</span>
                            <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                Lokasi dan jam operasional
                            </h2>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]">
                            <div class="rounded-sm border border-[#4e3422]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                                <h3 class="text-sm font-semibold text-[#4e3422]">Alamat toko</h3>
                                <div class="mt-3 space-y-1 text-sm leading-relaxed text-[#4e3422]/70">
                                    @foreach ($storefront['address_lines'] as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                </div>
                                <a href="{{ $storefront['maps_url'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#c86818] transition hover:text-[#aa5410] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Buka lokasi di Google Maps
                                </a>
                            </div>

                            <div class="rounded-sm border border-[#4e3422]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                                <h3 class="text-sm font-semibold text-[#4e3422]">Jam operasional</h3>
                                <div class="mt-3 divide-y divide-[#4e3422]/10 border-y border-[#4e3422]/10 text-sm">
                                    @foreach ($storefront['hours'] as $hour)
                                        <div class="flex items-center justify-between gap-4 py-3">
                                            <span class="text-[#4e3422]/65">{{ $hour['label'] }}</span>
                                            <span class="font-semibold text-[#4e3422]">{{ $hour['value'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                    <div class="rounded-sm border border-[#4e3422]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                        <h2 class="text-sm font-semibold text-[#4e3422]">Chat admin</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#4e3422]/70">
                            Admin akan lebih cepat membantu jika pesan Anda sudah berisi produk, ukuran, jumlah, dan deadline.
                        </p>
                        <div class="mt-5 grid gap-3">
                            <a href="{{ $whatsappConsultLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Konsultasi produk
                            </a>
                            <a href="{{ $whatsappQuoteLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Minta penawaran
                            </a>
                        </div>
                    </div>

                    <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                        <h2 class="text-sm font-semibold text-[#4e3422]">Kontak langsung</h2>
                        <div class="mt-4 space-y-4 text-sm leading-relaxed text-[#4e3422]/70">
                            <div>
                                <p class="font-semibold text-[#4e3422]">WhatsApp</p>
                                <a href="https://wa.me/{{ $storefront['whatsapp_number'] }}" target="_blank" rel="noopener" class="mt-1 inline-flex text-[#c86818] transition hover:text-[#aa5410] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                    {{ $storefront['whatsapp_display'] }}
                                </a>
                            </div>
                            <div>
                                <p class="font-semibold text-[#4e3422]">Email</p>
                                <a href="mailto:{{ $storefront['email'] }}" class="mt-1 inline-flex text-[#c86818] transition hover:text-[#aa5410] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
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
