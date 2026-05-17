<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja - Harapan Jaya Printing</title>

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

    <main id="main-content" class="pt-28 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-2xl md:text-3xl font-bold text-[#2C3E50]">Keranjang Belanja</h1>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1fr_380px]">
                <!-- Items Cart -->
                <div class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-6 shadow-sm">
                    <div class="space-y-6">
                        <!-- Cart Item 1 -->
                        <div class="flex gap-4 pb-6 border-b border-[#2C3E50]/10" data-cart-item data-item-id="1" data-item-price="29000">
                            <div class="flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1515169067865-5387ec356754?auto=format&fit=crop&w=150&q=80" alt="Banner" class="h-24 w-24 rounded-lg object-cover" />
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-4 mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-[#2C3E50]">Banner</h3>
                                        <p class="text-sm text-[#2C3E50]/70">Half Kertas • 80x120 cm • Matte Aquo</p>
                                        <p class="text-xs text-[#2C3E50]/60 mt-2">Desain: File Upload</p>
                                    </div>
                                    <button type="button" data-remove-item class="text-red-500 hover:text-red-700 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"></path></svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2 border border-[#2C3E50]/10 rounded-lg">
                                        <button type="button" data-qty-change="decrease" class="px-3 py-1 text-[#2C3E50]/60 hover:text-[#2C3E50]">−</button>
                                        <input type="number" value="1" min="1" data-item-qty class="w-10 text-center border-l border-r border-[#2C3E50]/10 py-1 outline-none" readonly />
                                        <button type="button" data-qty-change="increase" class="px-3 py-1 text-[#2C3E50]/60 hover:text-[#2C3E50]">+</button>
                                    </div>
                                    <span class="text-sm font-semibold text-[#3498DB]" data-item-total>Rp 29.000</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center py-12 hidden" data-empty-state>
                            <p class="text-[#2C3E50]/70 text-sm">Keranjang Anda kosong</p>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary Sidebar -->
                <div class="bg-white rounded-[2rem] border border-[#2C3E50]/10 p-6 shadow-sm h-fit">
                    <h2 class="text-lg font-bold text-[#2C3E50] mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-6 pb-6 border-b border-[#2C3E50]/10">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#2C3E50]/70">Subtotal (<span data-cart-count>1</span> item)</span>
                            <span class="text-[#2C3E50] font-semibold" data-subtotal>Rp 29.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-[#2C3E50]/70">Ongkos Kirim</span>
                            <span class="text-[#2C3E50] font-semibold">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-[#2C3E50]/70">Diskon</span>
                            <span class="text-[#2C3E50] font-semibold">-</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-baseline">
                            <span class="text-[#2C3E50]/70">Total:</span>
                            <span class="text-3xl font-bold text-[#3498DB]" data-total>Rp 29.000</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('checkout.form', 1) }}" class="block w-full bg-[#0f172a] text-white text-center py-3 rounded-full font-bold text-sm hover:bg-[#2c3e50] transition-colors">
                            Lanjut ke Pembayaran
                        </a>
                        <a href="{{ url('/katalog') }}" class="block w-full text-[#2C3E50]/60 text-center py-3 text-sm font-medium hover:text-[#3498DB] transition-colors">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
