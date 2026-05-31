<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panduan Pemesanan - Harapan Jaya Printing</title>
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
        $storefront = config('storefront');
        $whatsappLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo Harapan Jaya Printing, saya ingin konsultasi pemesanan.');
    @endphp

    <main id="main-content" class="bg-white">
        <section class="relative overflow-hidden border-b border-[#33302d]/10 pt-32 pb-12 sm:pt-36 sm:pb-16">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-white/88"></div>
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-white to-transparent"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold text-[#d9782a] block mb-3">Panduan pemesanan</span>
                        <h1 class="text-3xl font-light tracking-tight text-[#33302d] sm:text-4xl lg:text-5xl leading-tight">
                            Alur cetak dari katalog sampai <strong class="font-semibold">pesanan selesai</strong>
                        </h1>
                    </div>
                    <p class="mt-5 max-w-2xl text-base leading-relaxed text-[#33302d]/70">
                        Website ini dipakai untuk memilih produk, memahami spesifikasi awal, dan melacak progres. Detail order tetap dikunci lewat WhatsApp bersama admin.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white py-12 sm:py-16">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_21rem] lg:px-8">
                <div class="min-w-0 space-y-14">
                    <section class="rounded-sm bg-white px-5 py-8 sm:px-8 sm:py-10">
                        <div class="mb-7 border-b border-[#33302d]/10 pb-6">
                            <div>
                                <span class="text-sm font-semibold text-[#d9782a]">Mulai dari sini</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#33302d] sm:text-3xl">
                                    Cara pesan
                                </h2>
                            </div>
                            <p class="mt-3 max-w-2xl text-base leading-relaxed text-[#33302d]/65">
                                Ikuti urutan ini jika Anda baru pertama kali pesan cetak lewat website.
                            </p>
                        </div>

                        <div class="divide-y divide-[#33302d]/10">
                            @foreach ([
                                ['step' => '01', 'title' => 'Pilih produk', 'body' => 'Buka katalog, bandingkan bahan, harga acuan, dan opsi aktif. Masuk ke halaman detail produk yang paling sesuai.'],
                                ['step' => '02', 'title' => 'Pesan via WhatsApp', 'body' => 'Gunakan tombol pesan di halaman detail agar nama produk dan spesifikasi ikut terbawa ke chat admin.'],
                                ['step' => '03', 'title' => 'Kirim file dan konfirmasi', 'body' => 'Kirim file desain, jumlah, ukuran, bahan, finishing, dan kebutuhan deadline. Admin akan mengecek sebelum produksi.'],
                                ['step' => '04', 'title' => 'Lacak progres', 'body' => 'Setelah pesanan dicatat, gunakan halaman lacak pesanan untuk melihat status produksi dan mengunduh nota digital.'],
                            ] as $step)
                                <article class="grid gap-4 py-7 first:pt-0 last:pb-0 sm:grid-cols-[5rem_minmax(0,1fr)]">
                                    <span class="font-serif text-4xl font-light leading-none text-[#d9782a]/65">{{ $step['step'] }}</span>
                                    <div>
                                        <h3 class="text-xl font-semibold tracking-tight text-[#33302d]">{{ $step['title'] }}</h3>
                                        <p class="mt-2 max-w-3xl text-base leading-relaxed text-[#33302d]/70">{{ $step['body'] }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-sm bg-white px-5 py-8 sm:px-8 sm:py-10">
                        <div class="mb-7 border-b border-[#33302d]/10 pb-6">
                            <span class="text-sm font-semibold text-[#d9782a]">Sebelum kirim file</span>
                            <h2 class="mt-2 text-2xl font-light tracking-tight text-[#33302d] sm:text-3xl">
                                Format dan checklist desain
                            </h2>
                        </div>

                        <div class="grid gap-8 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
                            <div class="border-y border-[#33302d]/10 py-5">
                                <h3 class="text-base font-semibold text-[#33302d]">File yang bisa dikirim</h3>
                                <div class="mt-5 flex flex-wrap gap-2">
                                    @foreach (['PDF', 'CDR', 'AI', 'PSD', 'JPG', 'PNG'] as $format)
                                        <span class="rounded-sm border border-[#33302d]/15 px-3 py-2 text-xs font-semibold text-[#33302d]/70">{{ $format }}</span>
                                    @endforeach
                                </div>
                                <p class="mt-4 text-base leading-relaxed text-[#33302d]/65">
                                    Jika ragu, kirim file yang Anda punya. Admin akan bantu cek apakah file sudah aman untuk dicetak.
                                </p>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="rounded-sm bg-[#f7f7f5] p-5">
                                    <h3 class="text-base font-semibold text-[#33302d]">Agar hasil lebih aman</h3>
                                    <ul class="mt-4 space-y-3 text-sm leading-relaxed text-[#33302d]/70">
                                        <li>Resolusi 300 DPI jika tersedia, supaya gambar tidak pecah.</li>
                                        <li>Mode warna CMYK untuk warna cetak yang lebih siap produksi.</li>
                                        <li>Bleed 3 mm, area lebih untuk hasil potong yang rapi.</li>
                                    </ul>
                                </div>
                                <div class="rounded-sm bg-[#f7f7f5] p-5">
                                    <h3 class="text-base font-semibold text-[#33302d]">Jika belum punya file final</h3>
                                    <ul class="mt-4 space-y-3 text-sm leading-relaxed text-[#33302d]/70">
                                        <li>Jelaskan ukuran, bahan, dan tujuan pemakaian.</li>
                                        <li>Kirim contoh referensi bila ada.</li>
                                        <li>Sebutkan deadline sejak awal agar estimasi lebih realistis.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-sm bg-white px-5 py-8 sm:px-8 sm:py-10">
                        <div class="grid gap-8 lg:grid-cols-[17rem_minmax(0,1fr)]">
                            <div>
                                <span class="text-sm font-semibold text-[#d9782a]">Status produksi</span>
                                <h2 class="mt-2 text-2xl font-light tracking-tight text-[#33302d] sm:text-3xl">
                                    Arti status di halaman tracking
                                </h2>
                            </div>
                            <div class="divide-y divide-[#33302d]/10 border-y border-[#33302d]/10">
                            @foreach ([
                                ['title' => 'Pending', 'body' => 'Pesanan sudah dicatat dan menunggu pengecekan file atau konfirmasi detail.'],
                                ['title' => 'Proses desain', 'body' => 'Tim sedang menyesuaikan desain atau menyiapkan file sebelum masuk mesin cetak.'],
                                ['title' => 'Dicetak', 'body' => 'Pesanan sudah masuk tahap produksi cetak. Perubahan detail biasanya sudah tidak bisa dilakukan.'],
                                ['title' => 'Selesai', 'body' => 'Pesanan siap diambil atau ditindaklanjuti sesuai kesepakatan dengan admin.'],
                            ] as $stage)
                                <article class="grid gap-2 py-5 sm:grid-cols-[9rem_minmax(0,1fr)] sm:gap-6">
                                    <h3 class="text-base font-semibold tracking-tight text-[#33302d]">{{ $stage['title'] }}</h3>
                                    <p class="text-base leading-relaxed text-[#33302d]/70">{{ $stage['body'] }}</p>
                                </article>
                            @endforeach
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-5 lg:sticky lg:top-28 lg:self-start">
                    <div class="rounded-sm bg-[#33302d] p-6 text-[#f7f7f5] shadow-[0_1px_0_rgb(78,52,34,0.04)]">
                        <h2 class="text-lg font-semibold text-white">Siap mulai?</h2>
                        <p class="mt-3 text-base leading-relaxed text-white/70">
                            Untuk pesanan baru, mulai dari katalog. Jika kebutuhan Anda khusus, langsung konsultasi lewat WhatsApp.
                        </p>
                        <div class="mt-5 grid gap-3">
                            <a href="{{ route('katalog.index') }}" class="inline-flex h-11 items-center justify-center rounded-sm bg-[#d9782a] px-5 text-sm font-semibold text-white transition hover:bg-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Buka katalog
                            </a>
                            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Konsultasi via WhatsApp
                            </a>
                            <a href="{{ route('track-order') }}" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-5 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/30 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Lacak pesanan
                            </a>
                        </div>
                    </div>

                    <div class="rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-5">
                        <h2 class="text-sm font-semibold text-[#33302d]">Catatan penting</h2>
                        <ul class="mt-4 space-y-3 text-sm leading-relaxed text-[#33302d]/70">
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
