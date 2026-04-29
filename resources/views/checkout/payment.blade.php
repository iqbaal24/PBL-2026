<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - Order #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
         body { font-family: 'Inter', sans-serif; background-color: #F8F9FA; color: #2C3E50; }
    </style>
</head>
<body class="antialiased py-12 px-4">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#2C3E50] mb-2">Sistem Pembayaran</h1>
            <p class="text-[#2C3E50]/70">Silakan selesaikan pembayaran untuk order <span class="font-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-[#2C3E50]/10 overflow-hidden mb-6">
            <div class="bg-[#2C3E50] p-6 text-center text-white">
                <p class="text-white/70 text-sm font-medium mb-1">Total Tagihan:</p>
                <h2 class="text-4xl font-bold text-[#3498DB]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
            </div>
            <div class="p-8">
                <div class="mb-8">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#3498DB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Instruksi Transfer
                    </h3>
                    <div class="bg-[#F8F9FA] p-5 rounded-lg border border-[#2C3E50]/10">
                        <p class="text-sm text-[#2C3E50]/70 mb-2">Bank BCA</p>
                        <p class="text-2xl font-bold text-[#2C3E50] tracking-wider mb-1">123 456 7890</p>
                        <p class="text-sm font-medium text-[#2C3E50]">a.n PrintDigital Profesional</p>
                    </div>
                </div>
                
                <div class="border-t border-[#2C3E50]/10 pt-8">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#3498DB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload Bukti Pembayaran
                    </h3>
                    
                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-50 text-red-600 rounded drop-shadow-sm text-sm border border-red-200">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('checkout.submit', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <input type="file" name="payment_proof" required accept="image/*" class="w-full text-sm text-[#2C3E50]/70
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-[#3498DB]/10 file:text-[#3498DB]
                                hover:file:bg-[#3498DB]/20 transition-all cursor-pointer">
                        </div>
                        <button type="submit" class="w-full px-6 py-3.5 rounded-full bg-[#3498DB] hover:bg-[#2980B9] text-white font-bold text-base transition-colors shadow-sm">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center">
             <a href="{{ url('/') }}" class="text-sm font-medium text-[#2C3E50]/50 hover:text-[#3498DB] transition-colors">Bayar Nanti & Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
