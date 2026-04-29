<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Print Pro - Printing Services</title>

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

    <section class="relative pt-28 pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1515169067865-5387ec356754?auto=format&fit=crop&w=1500&q=80')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-[#2C3E50]/85"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#3498DB]/20 px-4 py-2 text-xs font-semibold uppercase tracking-[0.35em] text-[#EAF5FF] mb-6">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#3498DB]"></span>
                    Promo Spesial - Diskon 20% untuk Pelanggan Baru
                </span>
                <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-white leading-tight">Digital Printing Berkualitas Tinggi</h1>
                <p class="mt-6 text-lg md:text-xl text-white/80">Solusi cetak digital profesional untuk kebutuhan bisnis dan pribadi Anda dengan harga terjangkau.</p>
                <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#produk" class="inline-flex items-center justify-center rounded-full bg-[#3498DB] px-8 py-4 text-base font-bold text-white transition-colors hover:bg-[#2980B9]">Lihat Katalog</a>
                    <a href="#kontak" class="inline-flex items-center justify-center rounded-full bg-white/10 border border-white/20 px-8 py-4 text-base font-semibold text-white transition-colors hover:bg-white/20">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <section id="produk" class="py-24 bg-[#F8F9FA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-sm uppercase tracking-[0.35em] text-[#3498DB] mb-3 font-semibold">Produk Unggulan Kami</p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#2C3E50]">Solusi cetak profesional yang siap memenuhi kebutuhan Anda</h2>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="bg-white rounded-3xl border border-[#2C3E50]/10 p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#2C3E50] mb-3">Cetak Banner</h3>
                    <p class="text-sm text-[#2C3E50]/70">Banner berkualitas tinggi untuk promosi outdoor maupun indoor.</p>
                </div>
                <div class="bg-white rounded-3xl border border-[#2C3E50]/10 p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 4V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h7"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#2C3E50] mb-3">Undangan Custom</h3>
                    <p class="text-sm text-[#2C3E50]/70">Cetak undangan dengan desain sesuai keinginan.</p>
                </div>
                <div class="bg-white rounded-3xl border border-[#2C3E50]/10 p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#2C3E50] mb-3">Stiker & Vinyl</h3>
                    <p class="text-sm text-[#2C3E50]/70">Stiker cutting untuk branding bisnis dan kebutuhan pribadi.</p>
                </div>
                <div class="bg-white rounded-3xl border border-[#2C3E50]/10 p-8 shadow-sm hover:shadow-md transition-shadow">
                    <div class="mb-5 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E8F4FF] text-[#3498DB]">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M7 7v10a1 1 0 001 1h8a1 1 0 001-1V7"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V5a3 3 0 016 0v2"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#2C3E50] mb-3">Neon Box</h3>
                    <p class="text-sm text-[#2C3E50]/70">Signage berkualitas dengan pencahayaan LED yang menonjol.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-sm uppercase tracking-[0.35em] text-[#3498DB] mb-3 font-semibold">Cara Pemesanan</p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#2C3E50]">Proses sederhana dalam 4 langkah</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-4">
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB] font-bold text-xl">1</div>
                    <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Pilih Produk</h3>
                    <p class="text-sm text-[#2C3E50]/70">Browse katalog dan pilih produk yang Anda butuhkan.</p>
                </div>
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB] font-bold text-xl">2</div>
                    <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Upload Desain</h3>
                    <p class="text-sm text-[#2C3E50]/70">Upload file desain atau gunakan jasa desain kami.</p>
                </div>
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB] font-bold text-xl">3</div>
                    <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Bayar</h3>
                    <p class="text-sm text-[#2C3E50]/70">Lakukan pembayaran melalui berbagai metode tersedia.</p>
                </div>
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB] font-bold text-xl">4</div>
                    <h3 class="mb-3 text-lg font-semibold text-[#2C3E50]">Ambil Pesanan</h3>
                    <p class="text-sm text-[#2C3E50]/70">Tunggu pesanan selesai dan ambil di toko kami.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-[#F8F9FA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-sm uppercase tracking-[0.35em] text-[#3498DB] mb-3 font-semibold">Apa Kata Pelanggan Kami</p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#2C3E50]">Testimoni kepuasan pelanggan</h2>
            </div>
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                    <p class="mb-6 text-[#2C3E50]/70 leading-relaxed">“Pelayanan cepat dan hasil cetakan sangat memuaskan!”</p>
                    <p class="font-semibold text-[#2C3E50]">Budi Santoso</p>
                </div>
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                    <p class="mb-6 text-[#2C3E50]/70 leading-relaxed">“Harga terjangkau, kualitas premium. Recommend!”</p>
                    <p class="font-semibold text-[#2C3E50]">Siti Nurhaliza</p>
                </div>
                <div class="rounded-3xl border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                    <p class="mb-6 text-[#2C3E50]/70 leading-relaxed">“Tim yang profesional dan selalu siap membantu.”</p>
                    <p class="font-semibold text-[#2C3E50]">Ahmad Wijaya</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-[#2C3E50] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-[#0b1622] p-12 shadow-xl border border-white/10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="max-w-2xl">
                    <p class="text-sm uppercase tracking-[0.35em] text-[#3498DB] mb-4 font-semibold">Siap Memulai Proyek Anda?</p>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Bergabunglah dengan ribuan pelanggan yang puas dengan layanan kami.</h2>
                    <p class="text-[#E5EAF2]/80">Dapatkan dukungan penuh dari tim profesional kami untuk setiap kebutuhan cetak Anda.</p>
                </div>
                <a href="#" class="inline-flex items-center justify-center rounded-full bg-[#3498DB] px-8 py-4 text-base font-bold text-white hover:bg-[#2980B9] transition-colors">Daftar Sekarang - Gratis!</a>
            </div>
        </div>
    </section>

    @include('partials.footer')
</body>
</html>
