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
<body class="bg-[#F8F9FA] antialiased selection:bg-[#3498DB] selection:text-white">
    @include('partials.header')

    @php
        $storefront = config('storefront');
        $whatsappLink = 'https://wa.me/' . $storefront['whatsapp_number'] . '?text=' . rawurlencode('Halo Harapan Jaya Printing, saya ingin konsultasi pemesanan.');
    @endphp

    <main id="main-content" class="pt-28 pb-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <section class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-8 shadow-sm sm:p-10">
                <span class="inline-flex rounded-full bg-[#E8F4FF] px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[#3498DB]">
                    Panduan
                </span>
                <h1 class="mt-6 text-3xl font-bold text-[#2C3E50] sm:text-[2.5rem] sm:leading-tight">Alur pemesanan yang singkat, jelas, dan berbasis WhatsApp</h1>
                <p class="mt-4 max-w-[64ch] text-base leading-relaxed text-[#2C3E50]/72">
                    Website ini berfungsi sebagai katalog dan pusat informasi. Pemesanan, pengiriman file, dan konfirmasi detail dilakukan melalui WhatsApp agar proses lebih cepat dan mudah dipandu oleh tim kami.
                </p>
            </section>

            <section class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['step' => '1', 'title' => 'Pilih produk', 'body' => 'Buka katalog, bandingkan spesifikasi, lalu masuk ke halaman detail produk yang sesuai dengan kebutuhan Anda.'],
                    ['step' => '2', 'title' => 'Lanjut ke WhatsApp', 'body' => 'Gunakan tombol Order via WhatsApp pada halaman detail produk agar nama produk dan varian ikut terbawa ke chat.'],
                    ['step' => '3', 'title' => 'Kirim file dan konfirmasi', 'body' => 'Kirim file desain, jumlah, ukuran, bahan, finishing, dan kebutuhan deadline langsung ke admin.'],
                    ['step' => '4', 'title' => 'Pantau progres', 'body' => 'Setelah pesanan dicatat, gunakan halaman Lacak Pesanan untuk memantau status produksi dan mengunduh nota digital.'],
                ] as $step)
                    <div class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-6 shadow-sm">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#E8F4FF] text-lg font-bold text-[#2471A3]">{{ $step['step'] }}</div>
                        <h2 class="mt-5 text-xl font-bold text-[#2C3E50]">{{ $step['title'] }}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#2C3E50]/70">{{ $step['body'] }}</p>
                    </div>
                @endforeach
            </section>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
                <section class="space-y-8">
                    <div class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="text-2xl font-bold text-[#2C3E50]">Format file yang diterima</h2>
                        <div class="mt-5 flex flex-wrap gap-3">
                            @foreach (['PDF', 'CDR', 'AI', 'PSD', 'JPG / PNG 300 DPI'] as $format)
                                <span class="inline-flex rounded-full border border-[#3498DB]/15 bg-[#EEF5FF] px-4 py-2 text-sm font-semibold text-[#2471A3]">{{ $format }}</span>
                            @endforeach
                        </div>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                <p class="text-sm font-semibold text-[#2C3E50]">Agar hasil cetak lebih aman</p>
                                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#2C3E50]/70">
                                    <li>Gunakan resolusi minimal 300 DPI.</li>
                                    <li>Pilih mode warna CMYK jika tersedia.</li>
                                    <li>Sisakan bleed 3 mm untuk produk yang perlu potong presisi.</li>
                                </ul>
                            </div>
                            <div class="rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                <p class="text-sm font-semibold text-[#2C3E50]">Jika belum punya file final</p>
                                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-[#2C3E50]/70">
                                    <li>Jelaskan ukuran, bahan, dan tujuan pemakaian.</li>
                                    <li>Kirim contoh referensi bila ada.</li>
                                    <li>Tim kami akan bantu arahkan opsi yang paling cocok.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="text-2xl font-bold text-[#2C3E50]">Tahap produksi yang akan Anda lihat</h2>
                        <div class="mt-6 space-y-4">
                            @foreach ([
                                ['title' => 'Pending', 'body' => 'Pesanan sudah dicatat dan menunggu aksi lanjutan, seperti pengecekan file atau konfirmasi detail.'],
                                ['title' => 'Proses Desain', 'body' => 'Tim sedang menyesuaikan desain atau menyiapkan file sebelum masuk ke mesin cetak.'],
                                ['title' => 'Dicetak', 'body' => 'Pesanan sudah masuk tahap produksi cetak.'],
                                ['title' => 'Selesai', 'body' => 'Pesanan selesai diproses dan siap diambil atau ditindaklanjuti sesuai kesepakatan.'],
                            ] as $stage)
                                <div class="flex gap-4 rounded-[1.5rem] border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                    <div class="mt-1 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-white text-sm font-bold text-[#2471A3]">{{ $loop->iteration }}</div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#2C3E50]">{{ $stage['title'] }}</h3>
                                        <p class="mt-2 text-sm leading-relaxed text-[#2C3E50]/70">{{ $stage['body'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <aside class="space-y-8">
                    <div class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="text-2xl font-bold text-[#2C3E50]">Catatan penting</h2>
                        <ul class="mt-5 space-y-3 text-sm leading-relaxed text-[#2C3E50]/72">
                            <li class="flex gap-3">
                                <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#3498DB]"></span>
                                Pastikan nama file dan isi desain sudah benar sebelum produksi dimulai.
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#3498DB]"></span>
                                Perbedaan warna kecil antara layar dan hasil cetak bisa terjadi karena karakter media dan mesin.
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#3498DB]"></span>
                                Untuk jumlah sedikit, kebutuhan mendesak, atau spesifikasi khusus, konsultasikan langsung agar estimasi tetap realistis.
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#3498DB]"></span>
                                Simpan nomor pesanan Anda. Nomor ini dipakai untuk tracking dan unduh nota digital.
                            </li>
                        </ul>
                    </div>

                    <div class="rounded-[2rem] border border-[#3498DB]/15 bg-[#EEF5FF] p-6 sm:p-8">
                        <h2 class="text-2xl font-bold text-[#2C3E50]">Butuh bantuan cepat?</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#2C3E50]/72">
                            Pilih salah satu jalur yang paling sesuai: lihat katalog, lanjut tracking, atau langsung konsultasi ke WhatsApp.
                        </p>
                        <div class="mt-6 grid gap-3">
                            <a href="{{ route('katalog.index') }}" class="inline-flex h-12 items-center justify-center rounded-full bg-[#0F172A] px-6 text-sm font-semibold text-white transition hover:bg-[#2C3E50]">Buka Katalog</a>
                            <a href="{{ route('track-order') }}" class="inline-flex h-12 items-center justify-center rounded-full border border-[#2C3E50]/12 bg-white px-6 text-sm font-semibold text-[#2C3E50] transition hover:border-[#3498DB]/30 hover:text-[#2471A3]">Lacak Pesanan</a>
                            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="inline-flex h-12 items-center justify-center rounded-full border border-[#2C3E50]/12 bg-white px-6 text-sm font-semibold text-[#2C3E50] transition hover:border-[#3498DB]/30 hover:text-[#2471A3]">Konsultasi via WhatsApp</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
