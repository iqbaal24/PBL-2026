<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hubungi Kami - Harapan Jaya Printing</title>

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
            <div class="mb-16">
                <h1 class="text-2xl md:text-3xl font-bold text-[#2C3E50] mb-3">Hubungi Kami</h1>
                <p class="text-lg text-[#2C3E50]/70">Apa pertanyaan? Tim kami siap membantu Anda dengan layanan terbaik</p>
            </div>

            <div class="grid gap-12 lg:grid-cols-[1fr_1.2fr]">
                <!-- Left Section -->
                <div class="space-y-8">
                    <!-- Lokasi Toko -->
                    <div class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-[#2C3E50]">Lokasi Toko</h3>
                        </div>
                        <div class="mb-6">
                            <p class="text-sm text-[#2C3E50]/70 mb-2">Jl. Printing Digital No. 123</p>
                            <p class="text-sm text-[#2C3E50]/70 mb-2">Kelapa Gading, Kota, Jakarta Selatan</p>
                            <p class="text-sm text-[#2C3E50]/70">DKI Jakarta 12123</p>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-[#3498DB] hover:text-[#2980B9] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Buka di Google Maps
                        </a>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-[#2C3E50]">Jam Operasional</h3>
                        </div>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-[#2C3E50]/70">Senin - Jumat</span>
                                <span class="text-[#2C3E50] font-semibold">08:00 - 17:00 WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#2C3E50]/70">Sabtu</span>
                                <span class="text-[#2C3E50] font-semibold">08:00 - 15:00 WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#2C3E50]/70">Minggu</span>
                                <span class="text-red-600 font-semibold">Tutup</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#3498DB]/10 text-[#3498DB]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-[#2C3E50]">Kontak</h3>
                        </div>
                        <div class="space-y-4">
                            <a href="tel:081234567890" class="flex items-center gap-3 text-sm text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors">
                                <svg class="w-5 h-5 text-[#3498DB]" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>081234567890</span>
                            </a>
                            <a href="mailto:info@digitalprint.id" class="flex items-center gap-3 text-sm text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors">
                                <svg class="w-5 h-5 text-[#3498DB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>info@digitalprint.id</span>
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp Button -->
                    <a href="https://wa.me/081234567890" target="_blank" class="flex w-full items-center justify-center gap-2 rounded-full bg-[#0f172a] px-6 py-4 text-sm font-bold text-white transition hover:bg-[#2c3e50]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-9.746 9.798c0 2.429.742 4.8 2.147 6.818l-2.289 6.369a.375.375 0 00.486.461l6.169-1.775c2.064 1.214 4.408 1.855 6.839 1.855 5.385 0 9.747-4.363 9.747-9.748 0-5.385-4.362-9.746-9.747-9.746"/></svg>
                        Chat via WhatsApp
                    </a>
                </div>

                <!-- Right Section -->
                <div class="space-y-8">
                    <!-- Image -->
                    <div class="rounded-[2rem] overflow-hidden border border-[#2C3E50]/10 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80" alt="Office Space" class="h-80 w-full object-cover" />
                    </div>
                    <p class="text-sm text-[#2C3E50]/70">Kunjungi toko kami untuk konsultasi langsung dan lihat sample hasil cetak kami</p>

                    <!-- Butuh Bantuan? -->
                    <div class="bg-[#E8F4FF] rounded-[2rem] border border-[#3498DB]/20 p-8">
                        <h3 class="text-xl font-bold text-[#2C3E50] mb-6">Butuh Bantuan?</h3>
                        <div class="space-y-4">
                            <div>
                                <a href="#" class="text-sm font-semibold text-[#3498DB] hover:text-[#2980B9] transition-colors">Konsultasi Gratis</a>
                                <p class="text-sm text-[#2C3E50]/70 mt-1">Dapatkan konsultasi gratis produk atau bahan yang tepat untuk kebutuhan Anda</p>
                            </div>
                            <div class="border-t border-[#3498DB]/20 pt-4">
                                <a href="#" class="text-sm font-semibold text-[#3498DB] hover:text-[#2980B9] transition-colors">Cek Harga</a>
                                <p class="text-sm text-[#2C3E50]/70 mt-1">Kirimkan spesifikasi kebutuhan Anda untuk mendapatkan penawaran harga terbaik</p>
                            </div>
                            <div class="border-t border-[#3498DB]/20 pt-4">
                                <a href="#" class="text-sm font-semibold text-[#3498DB] hover:text-[#2980B9] transition-colors">Status Pesanan</a>
                                <p class="text-sm text-[#2C3E50]/70 mt-1">Login ke akun Anda untuk melihat status pesanan real-time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
