<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lacak Pesanan - Harapan Jaya Printing</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js', 'resources/js/custom.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <script src="{{ asset('js/custom.js') }}"></script>
    @endif
</head>
<body class="bg-white antialiased selection:bg-[#dd7a21] selection:text-white">
    @include('partials.header')

    <main id="main-content" class="pt-28 pb-24">
        <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-[44rem]">
                <h1 class="text-3xl font-bold text-[#4e3422] sm:text-[2.6rem] sm:leading-tight">Lacak progres produksi dan unduh nota digital</h1>
                <p class="mt-4 text-base leading-relaxed text-[#4e3422]/72">
                    Masukkan nomor pesanan dan nomor WhatsApp yang dipakai saat pemesanan untuk melihat status, timeline produksi, dan nota digital PDF.
                </p>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,0.88fr)_minmax(0,1.12fr)] lg:items-start">
                <div class="lg:sticky lg:top-28">
                    <div class="rounded-[2rem] border border-[#4e3422]/10 bg-[#fffdf7] p-6 shadow-sm sm:p-8">
                        <h2 class="text-xl font-bold text-[#4e3422]">Cari pesanan</h2>
                        <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/68">
                            Kombinasi nomor pesanan dan nomor WhatsApp dipakai untuk memastikan hasil hanya tampil kepada pemilik pesanan yang benar.
                        </p>

                        <form action="{{ route('track-order.lookup') }}" method="POST" class="mt-6 space-y-5" novalidate>
                            @csrf

                            <div>
                                <label for="order-number" class="mb-2 block text-sm font-semibold text-[#4e3422]">Nomor Pesanan</label>
                                <input
                                    id="order-number"
                                    name="order_number"
                                    type="text"
                                    value="{{ old('order_number', $formData['order_number'] ?? '') }}"
                                    autocapitalize="characters"
                                    autocomplete="off"
                                    placeholder="Contoh: ORD-DEMO-0001"
                                    spellcheck="false"
                                    class="h-12 w-full rounded-2xl border border-[#4e3422]/12 bg-[#fdf6e9] px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15"
                                />
                                @error('order_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="whatsapp-number" class="mb-2 block text-sm font-semibold text-[#4e3422]">Nomor WhatsApp</label>
                                <input
                                    id="whatsapp-number"
                                    name="whatsapp_number"
                                    type="text"
                                    value="{{ old('whatsapp_number', $formData['whatsapp_number'] ?? '') }}"
                                    autocomplete="tel"
                                    inputmode="numeric"
                                    placeholder="Contoh: 08123456789"
                                    class="h-12 w-full rounded-2xl border border-[#4e3422]/12 bg-[#fdf6e9] px-4 text-sm text-[#4e3422] outline-none transition focus:border-[#dd7a21] focus:ring-2 focus:ring-[#dd7a21]/15"
                                />
                                @error('whatsapp_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-full bg-[#6e3b12] px-6 text-sm font-semibold text-white transition hover:bg-[#8c4a12] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2">
                                Tampilkan Status Pesanan
                            </button>
                        </form>

                        @if ($lookupState === 'error' && $lookupError)
                            <div class="mt-6 rounded-[1.5rem] border border-red-200 bg-red-50 p-5">
                                <p class="text-sm font-semibold text-red-700">{{ $lookupError['title'] }}</p>
                                <p class="mt-2 text-sm leading-relaxed text-red-700/85">{{ $lookupError['message'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    @if ($lookupState === 'success' && $result)
                        <div class="overflow-hidden rounded-[2rem] border border-[#4e3422]/10 bg-[#fffdf7] shadow-sm">
                            <div class="bg-[#5a2f10] px-6 py-6 text-white sm:px-8">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/70">Status Saat Ini</p>
                                        <h2 class="mt-3 text-2xl font-bold">{{ $result['current_status']['label'] }}</h2>
                                        <p class="mt-2 max-w-[38ch] text-sm leading-relaxed text-white/78">{{ $result['current_status']['description'] }}</p>
                                    </div>
                                    <div class="rounded-[1.25rem] border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/76">
                                        <p>Pembaruan terakhir</p>
                                        <p class="mt-1 font-semibold text-white">{{ $result['last_updated'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 sm:p-8">
                                <div class="grid gap-4 rounded-[1.5rem] border border-[#4e3422]/10 bg-[#fff7d6] p-5 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#4e3422]/55">Nomor Pesanan</p>
                                        <p class="mt-2 text-lg font-semibold text-[#4e3422]">{{ $result['order_number'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#4e3422]/55">Nomor WhatsApp</p>
                                        <p class="mt-2 text-lg font-semibold text-[#4e3422]">{{ $result['whatsapp'] }}</p>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <div class="flex items-center justify-between gap-3">
                                        <h3 class="text-lg font-bold text-[#4e3422]">Timeline Produksi</h3>
                                        <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#4e3422]/50">4 Tahap Utama</span>
                                    </div>

                                    <ol class="mt-5 space-y-4">
                                        @foreach ($result['timeline'] as $step)
                                            @php
                                                $isCurrent = $step['state'] === 'current';
                                                $isDone = $step['state'] === 'done';
                                                $isException = $step['state'] === 'exception';
                                                $indicatorClasses = $isException
                                                    ? 'border-amber-300 bg-amber-100 text-amber-700'
                                                    : ($isCurrent
                                                        ? 'border-[#dd7a21]/30 bg-[#fff0c2] text-[#c86818]'
                                                        : ($isDone
                                                            ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                                            : 'border-[#4e3422]/12 bg-[#fffdf7] text-[#4e3422]/48'));
                                                $cardClasses = $isCurrent
                                                    ? 'border-[#dd7a21]/20 bg-[#fff7d6]'
                                                    : ($isException
                                                        ? 'border-amber-200 bg-amber-50'
                                                        : 'border-[#4e3422]/10 bg-[#fffdf7]');
                                            @endphp
                                            <li class="flex gap-4">
                                                <div class="flex flex-col items-center">
                                                    <div class="flex h-11 w-11 items-center justify-center rounded-full border text-sm font-bold {{ $indicatorClasses }}">
                                                        @if ($isDone)
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        @elseif ($isException)
                                                            !
                                                        @else
                                                            {{ $loop->iteration }}
                                                        @endif
                                                    </div>
                                                    @if (! $loop->last)
                                                        <div class="mt-2 h-full w-px min-h-8 bg-[#4e3422]/12"></div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 rounded-[1.5rem] border p-4 {{ $cardClasses }}">
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        <h4 class="text-base font-semibold text-[#4e3422]">{{ $step['label'] }}</h4>
                                                        @if ($isCurrent)
                                                            <span class="rounded-full bg-[#fffdf7] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#c86818]">Sedang Berjalan</span>
                                                        @elseif ($isDone)
                                                            <span class="rounded-full bg-[#fffdf7] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Selesai Dilalui</span>
                                                        @elseif ($isException)
                                                            <span class="rounded-full bg-[#fffdf7] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-amber-700">Perlu Tindakan</span>
                                                        @endif
                                                    </div>
                                                    <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/72">{{ $step['description'] }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>

                                <div class="mt-8 rounded-[1.5rem] border border-[#4e3422]/10 bg-[#fdf6e9] p-5">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-[#4e3422]">Ringkasan Produk</h3>
                                            <p class="mt-2 text-sm leading-relaxed text-[#4e3422]/70">Daftar item yang tercatat pada pesanan ini.</p>
                                        </div>
                                        <a
                                            href="{{ route('track-order.receipt', ['order' => $result['id'], 'wa' => $formData['whatsapp_number']]) }}"
                                            class="inline-flex h-12 items-center justify-center rounded-full bg-[#dd7a21] px-6 text-sm font-semibold text-white transition hover:bg-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#dd7a21] focus-visible:ring-offset-2"
                                        >
                                            Unduh Nota Digital (PDF)
                                        </a>
                                    </div>

                                    <div class="mt-5 space-y-3">
                                        @foreach ($result['items'] as $item)
                                            <div class="rounded-[1.25rem] border border-[#4e3422]/10 bg-[#fffdf7] px-4 py-4">
                                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                    <div>
                                                        <p class="text-base font-semibold text-[#4e3422]">{{ $item['product_name'] }}</p>
                                                        <p class="mt-1 text-sm text-[#4e3422]/68">{{ $item['variant_name'] }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-4 text-sm text-[#4e3422]/68">
                                                        <span>Qty {{ $item['quantity'] }}</span>
                                                        <span class="font-semibold text-[#4e3422]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-[2rem] border border-dashed border-[#4e3422]/16 bg-[#fffdf7] p-8 shadow-sm sm:p-10">
                            <h2 class="text-2xl font-bold text-[#4e3422]">Status pesanan akan tampil di sini</h2>
                            <p class="mt-3 max-w-[40ch] text-sm leading-relaxed text-[#4e3422]/70">
                                Setelah nomor pesanan dan WhatsApp cocok, halaman ini akan menampilkan progres produksi, ringkasan produk, dan tombol unduh nota digital.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
