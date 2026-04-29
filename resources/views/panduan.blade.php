<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panduan Pemesanan - Digital Print Pro</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="antialiased selection:bg-[#3498DB] selection:text-white bg-[#F8F9FA]">
    @include('partials.header')

    <main class="pt-28 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm mb-16">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#2C3E50] mb-3">Panduan Pemesanan</h1>
                    <p class="text-lg text-[#2C3E50]/70">Ikuti panduan lengkap untuk memudahkan pemesanan digital printing dengan mudah</p>
                </div>
            </div>

            <div class="space-y-12">
                <!-- Format File yang Diterima -->
                <section class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-[#2C3E50]">Format File yang Diterima</h2>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach (['PDF', 'CDR (CorelDraw)', 'AI (Adobe Illustrator)', 'PSD (Photoshop)', 'JPG/PNG (minimal 300 DPI)'] as $format)
                            <span class="inline-flex items-center rounded-full bg-[#F1F7FF] px-4 py-2 text-sm font-semibold text-[#3498DB] border border-[#3498DB]/20">{{ $format }}</span>
                        @endforeach
                    </div>
                </section>

                <!-- Format File dan Cara Upload -->
                <div class="grid gap-8 lg:grid-cols-2">
                    <section class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Format File</h3>
                        </div>
                        <ul class="space-y-3 text-sm text-[#2C3E50]/80">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Gunakan file format vektor seperti PDF, CDR, AI (Untuk hasil terbaik)</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Resolusi minimal 300 DPI untuk hasil cetak terbaik</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Gunakan mode warna CMYK untuk hasil warna CMYK yang lebih akurat</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Pertimbangkan bleed 3mm untuk produk cetak yang presisi</span>
                            </li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Cara Upload</h3>
                        </div>
                        <ul class="space-y-3 text-sm text-[#2C3E50]/80">
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Login ke akun Anda terlebih dahulu</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Klik pilih yang ingin didesain dan banding</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Tambahkan spesifikasi Desain, ukuran, finishing</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600 text-xs">✓</span>
                                <span>Upload file desain dan pilih jumlah pesanan Anda</span>
                            </li>
                        </ul>
                    </section>
                </div>

                <!-- Pemesanan dan Proses Produksi -->
                <div class="grid gap-8 lg:grid-cols-2">
                    <section class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Pemesanan</h3>
                        </div>
                        <ul class="space-y-3 text-sm text-[#2C3E50]/80">
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">1.</span>
                                <span>Checkout dan verifikasi pesanan</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">2.</span>
                                <span>Pilih metode pembayaran (Virtual Account, OVO, E-Wallet)</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">3.</span>
                                <span>Selesaikan pembayaran dalam 24 jam</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">4.</span>
                                <span>Status pesanan otomatis berubah saat verifikasi konfirmasi pembayaran</span>
                            </li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-[#2C3E50]">Proses Produksi</h3>
                        </div>
                        <ul class="space-y-3 text-sm text-[#2C3E50]/80">
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">1.</span>
                                <span>Sudah dipreparasi, pemeriksa ulang proses desain</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">2.</span>
                                <span>Estimasi waktu produksi 1-3 hari untuk mencetak produk</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">3.</span>
                                <span>Anda akan menerima notifikasi saat status "Siap Diambil"</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="font-semibold text-[#3498DB]">4.</span>
                                <span>Pesan siap diambil untuk pickup ke lokasi kami</span>
                            </li>
                        </ul>
                    </section>
                </div>

                <!-- Perhatian untuk Pemesanan -->
                <section class="bg-amber-50 rounded-[2rem] border border-amber-200 p-8">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-amber-200 text-amber-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-amber-900">Perhatian untuk Pemesanan</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-amber-900/80">
                        <li class="flex items-start gap-3">
                            <span class="text-amber-700 font-bold">•</span>
                            <span>Perhatian desain sudah terupload dengan akurat, perubahan desain akan dikenakan biaya tambahan biaya tambahan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-amber-700 font-bold">•</span>
                            <span>Hasil produksi belakang perbedaan warna pemesanan dengan preview warna dalam produk hasil editing yang tidak dapat dihindari</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-amber-700 font-bold">•</span>
                            <span>Jika desain Anda menggunakan font/logo kustom, pastikan font sudah embed dalam file desain untuk mencegah kesalahan font</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-amber-700 font-bold">•</span>
                            <span>Uktur pesanan diatas jumlah pesanan minimal 10 pcs, jika kurang dari 10 pcs silakan hubungi kami untuk harga spesial</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-amber-700 font-bold">•</span>
                            <span>Pesanan yang sudah lunas tidak dapat dibatalkan atau diubah kecuali ada kesepakatan dengan tim kami</span>
                        </li>
                    </ul>
                </section>

                <!-- Istilah dan Ketentuan -->
                <section class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                    <h2 class="text-2xl font-bold text-[#2C3E50] mb-8">Istilah dan Ketentuan</h2>
                    <div class="space-y-8">
                        <div class="pb-8 border-b border-[#2C3E50]/10 last:border-b-0 last:pb-0">
                            <h3 class="text-lg font-bold text-[#2C3E50] mb-3 flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#3498DB] text-white text-sm font-bold">1</span>
                                Hak Cipta
                            </h3>
                            <p class="text-sm text-[#2C3E50]/70">Pelanggan bertanggung jawab penuh atas file cipta desain yang upload. Kami tidak akan bertanggung jawab atas permasalahan hukum atau copyright yang terjadi</p>
                        </div>
                        <div class="pb-8 border-b border-[#2C3E50]/10 last:border-b-0 last:pb-0">
                            <h3 class="text-lg font-bold text-[#2C3E50] mb-3 flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#3498DB] text-white text-sm font-bold">2</span>
                                Kebijakan Retur
                            </h3>
                            <p class="text-sm text-[#2C3E50]/70">Barang retur yang diterima dalam sesuatu. Hasil cetak kami akan di-check ulang dengan prosedur klaim untuk proses pengembalian uang klaim penghargaan dengan tim wireless produksi</p>
                        </div>
                        <div class="pb-8 border-b border-[#2C3E50]/10 last:border-b-0 last:pb-0">
                            <h3 class="text-lg font-bold text-[#2C3E50] mb-3 flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#3498DB] text-white text-sm font-bold">3</span>
                                Komplalin
                            </h3>
                            <p class="text-sm text-[#2C3E50]/70">Komplalin belum diterima maksimal 3 hari setelah pengiriman diterbit Selanjutnya kami tidak akan memproses klaim dalam proses yang dilakukan</p>
                        </div>
                        <div class="pb-8 border-b border-[#2C3E50]/10 last:border-b-0 last:pb-0">
                            <h3 class="text-lg font-bold text-[#2C3E50] mb-3 flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#3498DB] text-white text-sm font-bold">4</span>
                                Pengambilan Pesanan
                            </h3>
                            <p class="text-sm text-[#2C3E50]/70">Pesanan yang sudah siap wajib diambil dalam 14 hari. Pesanan yg tidak diambil 14 hari dinyatakan hangus atau kami akan memindahkan barang ke area lain</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
