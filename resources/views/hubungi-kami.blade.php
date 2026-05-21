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

    <main id="main-content" class="pt-28 pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="rounded-[2rem] border border-[#4e3422]/10 bg-[#fffdf7] p-8 shadow-sm sm:p-10">
                <h1 class="text-3xl font-bold text-[#4e3422] sm:text-[2.5rem]">Hubungi tim Harapan Jaya Printing</h1>
                <p class="mt-4 max-w-[62ch] text-base leading-relaxed text-[#4e3422]/72">
                    Gunakan halaman ini untuk konsultasi produk, meminta penawaran, atau mencari jalur tercepat ke fitur pelacakan pesanan.
                </p>
            </section>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]">
                <div class="space-y-8">
                    <section class="rounded-[2rem] border border-[#4e3422]/10 bg-[#fffdf7] p-6 shadow-sm sm:p-8">
                        <h2 class="text-xl font-bold text-[#4e3422]">Lokasi dan kontak</h2>
                        <div class="mt-6 space-y-6 text-sm text-[#4e3422]/72">
                            <div>
                                <p class="font-semibold text-[#4e3422]">Alamat toko</p>
                                <div class="mt-2 space-y-1">
                                    @foreach ($storefront['address_lines'] as $line)
                                        <p>{{ $line }}</p>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold text-[#4e3422]">Telepon / WhatsApp</p>
                                <a href="https://wa.me/{{ $storefront['whatsapp_number'] }}" target="_blank" rel="noopener" class="mt-2 inline-flex text-[#c86818] transition hover:text-[#aa5410]">
                                    {{ $storefront['whatsapp_display'] }}
                                </a>
                            </div>
                            <div>
                                <p class="font-semibold text-[#4e3422]">Email</p>
                                <a href="mailto:{{ $storefront['email'] }}" class="mt-2 inline-flex text-[#c86818] transition hover:text-[#aa5410]">
                                    {{ $storefront['email'] }}
                                </a>
                            </div>
                        </div>

                        <a href="{{ $storefront['maps_url'] }}" target="_blank" rel="noopener" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#c86818] transition hover:text-[#aa5410]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Buka lokasi di Google Maps
                        </a>
                    </section>

                    <section class="rounded-[2rem] border border-[#4e3422]/10 bg-[#fffdf7] p-6 shadow-sm sm:p-8">
                        <h2 class="text-xl font-bold text-[#4e3422]">Jam operasional</h2>
                        <div class="mt-5 space-y-3 text-sm">
                            @foreach ($storefront['hours'] as $hour)
                                <div class="flex items-center justify-between gap-4 rounded-[1.25rem] border border-[#4e3422]/10 bg-[#fdf6e9] px-4 py-3">
                                    <span class="text-[#4e3422]/70">{{ $hour['label'] }}</span>
                                    <span class="font-semibold text-[#4e3422]">{{ $hour['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="space-y-8">
                    <section class="rounded-[2rem] border border-[#4e3422]/10 bg-[#fffdf7] p-6 shadow-sm sm:p-8">
                        <span class="inline-flex rounded-full bg-[#fff0c2] px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#dd7a21]">
                            Jalur Bantuan
                        </span>
                        <h2 class="mt-5 text-2xl font-bold text-[#4e3422]">Pilih kebutuhan Anda</h2>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-[1.5rem] border border-[#4e3422]/10 bg-[#fdf6e9] p-5">
                                <a href="{{ $whatsappConsultLink }}" target="_blank" rel="noopener" class="text-sm font-semibold text-[#c86818] transition hover:text-[#aa5410]">Konsultasi produk</a>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Cocok untuk tanya bahan, ukuran, finishing, atau rekomendasi produk sebelum memesan.</p>
                            </div>
                            <div class="rounded-[1.5rem] border border-[#4e3422]/10 bg-[#fdf6e9] p-5">
                                <a href="{{ $whatsappQuoteLink }}" target="_blank" rel="noopener" class="text-sm font-semibold text-[#c86818] transition hover:text-[#aa5410]">Minta penawaran harga</a>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Kirim spesifikasi kebutuhan Anda untuk memperoleh kisaran harga yang lebih tepat.</p>
                            </div>
                            <div class="rounded-[1.5rem] border border-[#4e3422]/10 bg-[#fdf6e9] p-5">
                                <a href="{{ route('track-order') }}" class="text-sm font-semibold text-[#c86818] transition hover:text-[#aa5410]">Lacak pesanan</a>
                                <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Gunakan nomor pesanan dan nomor WhatsApp untuk memantau progres produksi dan mengunduh nota digital.</p>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-[2rem] border border-[#dd7a21]/15 bg-[#fff7d6] p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-[#4e3422]">Pesan cepat via WhatsApp</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#4e3422]/72">
                            Untuk pemesanan baru, jalur paling cepat tetap melalui halaman detail produk. Tombol WhatsApp di sana akan membawa nama produk dan varian ke chat secara otomatis.
                        </p>
                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            <a href="{{ route('katalog.index') }}" class="inline-flex h-12 items-center justify-center rounded-full bg-[#6e3b12] px-6 text-sm font-semibold text-white transition hover:bg-[#8c4a12]">Buka Katalog</a>
                            <a href="https://wa.me/{{ $storefront['whatsapp_number'] }}" target="_blank" rel="noopener" class="inline-flex h-12 items-center justify-center rounded-full border border-[#4e3422]/12 bg-[#fffdf7] px-6 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818]">Chat WhatsApp</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
