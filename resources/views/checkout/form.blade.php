<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $product->name }}</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/custom.js') }}"></script>
    <style>
         body { font-family: 'Inter', sans-serif; background-color: #f7f7f5; color: #33302d; }
    </style>
</head>
<body class="antialiased py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div data-reveal="quiet" class="text-center mb-10">
            <h1 class="text-3xl font-bold text-[#33302d] mb-2">Formulir Pemesanan</h1>
            <p class="text-[#33302d]/70">Lengkapi data untuk pesanan produk <span class="font-semibold">{{ $product->name }}</span></p>
        </div>

        <div data-reveal="quiet" class="bg-white rounded-sm shadow-sm border border-[#33302d]/10 p-8">
            <div class="mb-8 pb-8 border-b border-[#33302d]/10 flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3 aspect-square bg-gray-100 rounded-sm overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="w-full md:w-2/3 flex flex-col justify-center">
                    <h2 class="text-2xl font-bold text-[#33302d] mb-2">{{ $product->name }}</h2>
                    <p class="text-xl font-medium text-[#d9782a] mb-4">Rp {{ number_format($product->starting_price ?? 0, 0, ',', '.') }} <span class="text-sm text-[#33302d]/50 font-normal">/ satuan</span></p>
                    <p class="text-sm text-[#33302d]/70 leading-relaxed">{{ $product->description }}</p>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-sm border border-red-200 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.store', $product) }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" name="customer_name" required class="w-full px-4 py-3 rounded-sm bg-[#f7f7f5] border border-[#33302d]/20 focus:outline-none focus:border-[#d9782a] focus:ring-1 focus:ring-[#d9782a] transition-all" placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nomor WhatsApp</label>
                        <input type="text" name="customer_phone" required class="w-full px-4 py-3 rounded-sm bg-[#f7f7f5] border border-[#33302d]/20 focus:outline-none focus:border-[#d9782a] focus:ring-1 focus:ring-[#d9782a] transition-all" placeholder="08123456789">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Alamat Pengiriman</label>
                    <textarea name="customer_address" required rows="3" class="w-full px-4 py-3 rounded-sm bg-[#f7f7f5] border border-[#33302d]/20 focus:outline-none focus:border-[#d9782a] focus:ring-1 focus:ring-[#d9782a] transition-all" placeholder="Alamat lengkap..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Jumlah / Kuantitas</label>
                        <input type="number" name="quantity" min="1" value="1" required class="w-full px-4 py-3 rounded-sm bg-[#f7f7f5] border border-[#33302d]/20 focus:outline-none focus:border-[#d9782a] focus:ring-1 focus:ring-[#d9782a] transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Catatan Khusus (Opsional)</label>
                        <input type="text" name="notes" class="w-full px-4 py-3 rounded-sm bg-[#f7f7f5] border border-[#33302d]/20 focus:outline-none focus:border-[#d9782a] focus:ring-1 focus:ring-[#d9782a] transition-all" placeholder="Contoh: Ukuran 3x4 meter">
                    </div>
                </div>

                <div class="pt-6 border-t border-[#33302d]/10 flex flex-col md:flex-row items-center justify-between">
                    <a href="{{ url('/') }}" class="text-[#33302d]/60 hover:text-[#d9782a] text-sm font-medium mb-4 md:mb-0 transition-colors">
                        Batal & Kembali
                    </a>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-sm bg-[#d9782a] hover:bg-[#c86818] text-white font-bold text-base transition-colors shadow-sm">
                        Proses Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
