<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/custom.js') }}"></script>
    <style>
         body { font-family: 'Inter', sans-serif; background-color: #f7f7f5; color: #33302d; }
    </style>
</head>
<body class="antialiased py-12 px-4 min-h-screen flex items-center justify-center">
    <div data-reveal="quiet" class="max-w-md w-full bg-white p-8 rounded-sm shadow-sm border border-[#33302d]/10 text-center">
        <div class="motion-check w-20 h-20 bg-[#d9782a]/10 text-[#d9782a] rounded-sm mx-auto flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-[#33302d] mb-2">Terima Kasih!</h1>
        <p class="text-[#33302d]/70 mb-8">{{ session('success', 'Pembayaran berhasil dikirim! Admin akan segera memverifikasinya.') }}</p>
        
        <a href="{{ url('/') }}" class="inline-block w-full px-6 py-3 rounded-sm bg-[#d9782a] hover:bg-[#c86818] text-white font-bold text-base transition-colors shadow-sm">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
