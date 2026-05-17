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
<body class="antialiased selection:bg-[#3498DB] selection:text-white">
    @include('partials.header')

    <main id="main-content">
        <section class="relative flex min-h-[58vh] items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-black/68"></div>
            <div class="relative z-10 mx-auto w-full max-w-7xl px-4 py-20 text-center sm:px-6 lg:px-8">
                <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-white/85">
                    Solusi Cetak Cepat untuk Kebutuhan Harian dan Usaha
                </span>
                <h1 class="mt-6 text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                    Katalog cetak yang jelas, pemesanan cepat lewat WhatsApp
                </h1>
                <p class="mx-auto mt-6 max-w-[52rem] text-base leading-relaxed text-white/80 sm:text-lg">
                    Jelajahi spesifikasi produk, pilih opsi yang paling dekat dengan kebutuhan Anda, lalu lanjutkan pemesanan bersama admin lewat jalur yang cepat dan jelas.
                </p>
                <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
                    <a href="{{ route('katalog.index') }}" class="inline-flex items-center justify-center rounded-full bg-[#2471A3] px-8 py-4 text-base font-bold text-white transition-colors hover:bg-[#1F618D]">Lihat Katalog</a>
                    <a href="{{ route('track-order') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/10 px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-white/20">Lacak Pesanan</a>
                </div>
            </div>
        </section>

        <section class="bg-[#F8F9FA] py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-14 text-center">
                    <p class="mb-3 text-2xl font-semibold uppercase tracking-[0.20em] text-[#3498DB] md:text-3xl">Produk Unggulan Kami</p>
                    <h2 class="text-lg font-normal text-[#2C3E50] md:text-xl">Solusi cetak profesional untuk kebutuhan pribadi, event, dan usaha lokal</h2>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm transition-shadow hover:shadow-md">
                        <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8"></path></svg>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#2C3E50]">Cetak Banner</h3>
                        <p class="text-sm text-[#2C3E50]/70">Banner berkualitas tinggi untuk promosi indoor maupun outdoor.</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm transition-shadow hover:shadow-md">
                        <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 4V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h7"></path></svg>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#2C3E50]">Undangan Custom</h3>
                        <p class="text-sm text-[#2C3E50]/70">Undangan cetak dengan detail bahan dan desain yang bisa disesuaikan.</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm transition-shadow hover:shadow-md">
                        <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#2C3E50]">Stiker & Vinyl</h3>
                        <p class="text-sm text-[#2C3E50]/70">Cocok untuk branding usaha, label produk, dan kebutuhan promosi cepat.</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm transition-shadow hover:shadow-md">
                        <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M7 7v10a1 1 0 001 1h8a1 1 0 001-1V7"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V5a3 3 0 016 0v2"></path></svg>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#2C3E50]">Neon Box</h3>
                        <p class="text-sm text-[#2C3E50]/70">Signage yang menonjol untuk toko, booth, dan kebutuhan display usaha.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[#EEF5FF] py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-14 text-center">
                    <p class="mb-3 text-2xl font-semibold uppercase tracking-[0.20em] text-[#3498DB] md:text-3xl">Cara Pemesanan</p>
                    <h2 class="text-lg font-normal text-[#2C3E50] md:text-xl">Jalur sederhana dari katalog ke produksi</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-4">
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-xl font-bold text-[#3498DB]">1</div>
                        <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Pilih Produk</h3>
                        <p class="text-sm text-[#2C3E50]/70">Lihat katalog dan buka detail produk yang paling sesuai dengan kebutuhan Anda.</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-xl font-bold text-[#3498DB]">2</div>
                        <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Cek Spesifikasi</h3>
                        <p class="text-sm text-[#2C3E50]/70">Bandingkan varian, harga acuan, dan catatan file sebelum mulai chat.</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-xl font-bold text-[#3498DB]">3</div>
                        <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Order via WhatsApp</h3>
                        <p class="text-sm text-[#2C3E50]/70">Kirim kebutuhan Anda lewat tombol WhatsApp dari halaman produk agar konteks pesanan ikut terbawa.</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-xl font-bold text-[#3498DB]">4</div>
                        <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Lacak dan Ambil</h3>
                        <p class="text-sm text-[#2C3E50]/70">Pantau status produksi dan unduh nota digital hingga pesanan selesai.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-[#F8F9FA] py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-14 text-center">
                    <p class="mb-3 text-2xl font-semibold uppercase tracking-[0.20em] text-[#3498DB] md:text-3xl">Apa Kata Pelanggan Kami</p>
                    <h2 class="text-lg font-normal text-[#2C3E50] md:text-xl">Pengalaman dari pelanggan lokal yang memakai layanan kami</h2>
                </div>
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                        <p class="mb-6 leading-relaxed text-[#2C3E50]/70">"Pelayanan cepat dan penjelasan spesifikasinya jelas. Sangat membantu untuk order acara kampus."</p>
                        <p class="font-semibold text-[#2C3E50]">Budi Santoso</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                        <p class="mb-6 leading-relaxed text-[#2C3E50]/70">"Admin responsif di WhatsApp dan hasil cetaknya rapi. Cocok untuk kebutuhan usaha kecil."</p>
                        <p class="font-semibold text-[#2C3E50]">Siti Nurhaliza</p>
                    </div>
                    <div class="rounded-xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                        <p class="mb-6 leading-relaxed text-[#2C3E50]/70">"Tracking pesanan dan nota digitalnya memudahkan saat order berulang untuk event."</p>
                        <p class="font-semibold text-[#2C3E50]">Ahmad Wijaya</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
