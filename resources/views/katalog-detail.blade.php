<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product['nama'] }} - Digital Print Pro</title>

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
            <div class="mb-8">
                <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#2C3E50]/70 hover:text-[#3498DB] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Katalog
                </a>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1.4fr_0.9fr]">
                <section class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                    <div class="rounded-[2rem] overflow-hidden bg-gray-100 mb-8">
                        <img src="{{ $product['image'] }}" alt="{{ $product['nama'] }}" class="h-[420px] w-full object-cover" />
                    </div>
                    <div class="space-y-4">
                        <span class="inline-flex rounded-full bg-[#F1F7FF] px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-[#3498DB]">{{ $product['kategori'] }}</span>
                        <h1 class="text-3xl font-bold text-[#2C3E50]">{{ $product['nama'] }}</h1>
                        <p class="text-[#2C3E50]/70 leading-relaxed">{{ $product['deskripsi'] }}</p>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                <p class="text-sm text-[#2C3E50]/70">Harga mulai dari</p>
                                <p class="text-2xl font-bold text-[#2C3E50]">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-3xl border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                                <p class="text-sm text-[#2C3E50]/70">Pilihan bahan</p>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs text-[#2C3E50]/70">
                                    @foreach ($product['bahan'] as $bahan)
                                        <span class="rounded-full bg-white px-3 py-1 border border-[#2C3E50]/10">{{ $bahan }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="rounded-[2rem] border border-[#2C3E50]/10 bg-white p-8 shadow-sm">
                    <h2 class="text-2xl font-bold text-[#2C3E50] mb-4">Spesifikasi Pesanan</h2>
                    <div class="space-y-4 text-sm text-[#2C3E50]/80">
                        <div>
                            <label class="mb-2 block font-semibold text-[#2C3E50]">Pilih Bahan</label>
                            <select class="w-full rounded-2xl border border-[#2C3E50]/10 bg-[#F8F9FA] px-4 py-3 outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15 transition">
                                @foreach ($product['bahan'] as $bahan)
                                    <option>{{ $bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block font-semibold text-[#2C3E50]">Pilih Ukuran</label>
                            <select class="w-full rounded-2xl border border-[#2C3E50]/10 bg-[#F8F9FA] px-4 py-3 outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15 transition">
                                <option>Small</option>
                                <option>Medium</option>
                                <option>Large</option>
                                <option>Custom</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block font-semibold text-[#2C3E50]">Pilih Finishing</label>
                            <select class="w-full rounded-2xl border border-[#2C3E50]/10 bg-[#F8F9FA] px-4 py-3 outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15 transition">
                                <option>Matte</option>
                                <option>Glossy</option>
                                <option>UV Coating</option>
                                <option>Tanpa Finishing</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block font-semibold text-[#2C3E50]">Jumlah</label>
                            <input type="number" value="1" min="1" class="w-full rounded-2xl border border-[#2C3E50]/10 bg-[#F8F9FA] px-4 py-3 outline-none focus:border-[#3498DB] focus:ring-2 focus:ring-[#3498DB]/15 transition" />
                        </div>
                        <div class="rounded-3xl border border-[#2C3E50]/10 bg-[#F8F9FA] p-5">
                            <p class="text-sm text-[#2C3E50]/70">Total Harga</p>
                            <p class="mt-2 text-3xl font-bold text-[#2C3E50]">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('checkout.form', $product['id']) }}" class="inline-flex w-full items-center justify-center rounded-full bg-[#0f172a] px-6 py-4 text-base font-bold text-white transition hover:bg-[#2c3e50]">Tambah ke Keranjang</a>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
