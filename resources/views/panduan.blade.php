<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panduan Pemesanan - Harapan Jaya Printing</title>

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
        $whatsappLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo Harapan Jaya Printing, saya ingin konsultasi pemesanan.');
    @endphp

    <main id="main-content" class="bg-white">
        <section class="border-b border-[#4e3422]/10 bg-white pt-32 pb-12 sm:pt-36 sm:pb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold text-[#dd7a21] block mb-3">Panduan pemesanan</span>
                        <h1 class="text-3xl font-light tracking-tight text-[#4e3422] sm:text-4xl lg:text-5xl leading-tight">
                            Alur cetak dari katalog sampai <strong class="font-semibold">pesanan selesai</strong>
                        </h1>
                    </div>
                    <p class="max-w-md text-sm leading-relaxed text-[#4e3422]/70 lg:text-right">
                        Website ini dipakai untuk memilih produk, memahami spesifikasi awal, dan melacak progres. Detail order tetap dikunci lewat WhatsApp bersama admin.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white py-10 sm:py-12">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_20rem] lg:px-8">
                <div class="min-w-0 space-y-10">
                    <section class="border-b border-[#4e3422]/10 pb-10">
                        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <span class="text-sm font-semibold text-[#dd7a21]">Mulai dari sini</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                    Cara pesan
                                </h2>
                            </div>
                            <p class="max-w-sm text-sm leading-relaxed text-[#4e3422]/65">
                                Ikuti urutan ini jika Anda baru pertama kali pesan cetak lewat website.
                            </p>
                        </div>

                        <div class="divide-y divide-[#4e3422]/10 border-y border-[#4e3422]/10">
                            @foreach ([
                                ['step' => '01', 'title' => 'Pilih produk', 'body' => 'Buka katalog, bandingkan bahan, harga acuan, dan opsi aktif. Masuk ke halaman detail produk yang paling sesuai.'],
                                ['step' => '02', 'title' => 'Pesan via WhatsApp', 'body' => 'Gunakan tombol pesan di halaman detail agar nama produk dan spesifikasi ikut terbawa ke chat admin.'],
                                ['step' => '03', 'title' => 'Kirim file dan konfirmasi', 'body' => 'Kirim file desain, jumlah, ukuran, bahan, finishing, dan kebutuhan deadline. Admin akan mengecek sebelum produksi.'],
                                ['step' => '04', 'title' => 'Lacak progres', 'body' => 'Setelah pesanan dicatat, gunakan halaman lacak pesanan untuk melihat status produksi dan mengunduh nota digital.'],
                            ] as $step)
                                <article class="grid gap-4 py-6 sm:grid-cols-[4rem_minmax(0,1fr)]">
                                    <span class="font-serif text-3xl font-light text-[#dd7a21]/60">{{ $step['step'] }}</span>
                                    <div>
                                        <h3 class="text-lg font-semibold tracking-tight text-[#4e3422]">{{ $step['title'] }}</h3>
                                        <p class="mt-2 max-w-2xl text-sm leading-relaxed text-[#4e3422]/70">{{ $step['body'] }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section class="border-b border-[#4e3422]/10 pb-10">
                        <div class="mb-6">
                            <span class="text-sm font-semibold text-[#dd7a21]">Sebelum kirim file</span>
                            <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                Format dan checklist desain
                            </h2>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
                            <div class="rounded-sm border border-[#4e3422]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                                <h3 class="text-sm font-semibold text-[#4e3422]">File yang bisa dikirim</h3>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach (['PDF', 'CDR', 'AI', 'PSD', 'JPG', 'PNG'] as $format)
                                        <span class="rounded-sm border border-[#4e3422]/15 px-3 py-2 text-xs font-semibold text-[#4e3422]/70">{{ $format }}</span>
                                    @endforeach
                                </div>
                                <p class="mt-4 text-sm leading-relaxed text-[#4e3422]/65">
                                    Jika ragu, kirim file yang Anda punya. Admin akan bantu cek apakah file sudah aman untuk dicetak.
                                </p>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                    <h3 class="text-sm font-semibold text-[#4e3422]">Agar hasil lebih aman</h3>
                                    <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#4e3422]/70">
                                        <li>Resolusi 300 DPI jika tersedia, supaya gambar tidak pecah.</li>
                                        <li>Mode warna CMYK untuk warna cetak yang lebih siap produksi.</li>
                                        <li>Bleed 3 mm, area lebih untuk hasil potong yang rapi.</li>
                                    </ul>
                                </div>
                                <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                                    <h3 class="text-sm font-semibold text-[#4e3422]">Jika belum punya file final</h3>
                                    <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#4e3422]/70">
                                        <li>Jelaskan ukuran, bahan, dan tujuan pemakaian.</li>
                                        <li>Kirim contoh referensi bila ada.</li>
                                        <li>Sebutkan deadline sejak awal agar estimasi lebih realistis.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="mb-6">
                            <span class="text-sm font-semibold text-[#dd7a21]">Status produksi</span>
                            <h2 class="mt-2 text-2xl font-light tracking-tight text-[#4e3422] sm:text-3xl">
                                Arti status di halaman tracking
                            </h2>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach ([
                                ['title' => 'Pending', 'body' => 'Pesanan sudah dicatat dan menunggu pengecekan file atau konfirmasi detail.'],
                                ['title' => 'Proses desain', 'body' => 'Tim sedang menyesuaikan desain atau menyiapkan file sebelum masuk mesin cetak.'],
                                ['title' => 'Dicetak', 'body' => 'Pesanan sudah masuk tahap produksi cetak. Perubahan detail biasanya sudah tidak bisa dilakukan.'],
                                ['title' => 'Selesai', 'body' => 'Pesanan siap diambil atau ditindaklanjuti sesuai kesepakatan dengan admin.'],
                            ] as $stage)
                                <article class="rounded-sm border border-[#4e3422]/10 bg-white p-5 transition hover:border-[#dd7a21]/40 hover:shadow-[0_8px_30px_rgb(78,52,34,0.02)]">
                                    <h3 class="text-base font-semibold tracking-tight text-[#4e3422]">{{ $stage['title'] }}</h3>
                                    <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">{{ $stage['body'] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>

                <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                    <div class="rounded-sm border border-[#4e3422]/10 bg-white p-5 shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                        <h2 class="text-sm font-semibold text-[#4e3422]">Siap mulai?</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#4e3422]/70">
                            Untuk pesanan baru, mulai dari katalog. Jika kebutuhan Anda khusus, langsung konsultasi lewat WhatsApp.
                        </p>
                        <div class="mt-5 grid gap-3">
                            <a href="{{ route('katalog.index') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#6e3b12] px-5 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Buka katalog
                            </a>
                            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Konsultasi via WhatsApp
                            </a>
                            <a href="{{ route('track-order') }}" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#4e3422]/15 bg-white px-5 text-sm font-semibold text-[#4e3422] transition hover:border-[#dd7a21]/30 hover:text-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Lacak pesanan
                            </a>
                        </div>
                    </div>

                    <div class="rounded-sm border border-[#4e3422]/10 bg-[#fcfbf9] p-5">
                        <h2 class="text-sm font-semibold text-[#4e3422]">Catatan penting</h2>
                        <ul class="mt-4 space-y-3 text-sm leading-relaxed text-[#4e3422]/70">
                            <li>Pastikan nama file dan isi desain sudah benar sebelum produksi dimulai.</li>
                            <li>Perbedaan warna kecil antara layar dan hasil cetak bisa terjadi.</li>
                            <li>Untuk jumlah sedikit, deadline dekat, atau spesifikasi khusus, konsultasikan dulu.</li>
                            <li>Simpan nomor pesanan untuk tracking dan unduh nota digital.</li>
                        </ul>
                    </div>
                </aside>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
