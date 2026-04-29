<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
         body { font-family: 'Inter', sans-serif; background-color: #F8F9FA; color: #2C3E50; }
    </style>
</head>
<body class="antialiased py-12 px-4 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-sm border border-[#2C3E50]/10 text-center">
        <div class="w-20 h-20 bg-[#3498DB]/10 text-[#3498DB] rounded-full mx-auto flex items-center justify-center mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h1 class="text-2xl font-bold text-[#2C3E50] mb-2">Terima Kasih!</h1>
        <p class="text-[#2C3E50]/70 mb-8">{{ session('success', 'Pembayaran berhasil dikirim! Admin akan segera memverifikasinya.') }}</p>
        
        <a href="{{ url('/') }}" class="inline-block w-full px-6 py-3 rounded-full bg-[#3498DB] hover:bg-[#2980B9] text-white font-bold text-base transition-colors shadow-sm">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
