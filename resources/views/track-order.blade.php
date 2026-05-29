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
<body class="bg-white antialiased selection:bg-[#d9782a] selection:text-white">
    @include('partials.header')

    <main id="main-content" class="pt-28 pb-24">
        <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-[44rem]">
                <h1 class="text-3xl font-bold text-[#33302d] sm:text-[2.6rem] sm:leading-tight">Lacak progres produksi dan unduh nota digital</h1>
                <p class="mt-4 text-base leading-relaxed text-[#33302d]/72">
                    Masukkan nomor pesanan dan nomor WhatsApp yang dipakai saat pemesanan untuk melihat status, timeline produksi, dan nota digital PDF.
                </p>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,0.88fr)_minmax(0,1.12fr)] lg:items-start">
                <div class="lg:sticky lg:top-28">
                    <div class="rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-6 shadow-sm sm:p-8">
                        <h2 class="text-xl font-bold text-[#33302d]">Cari pesanan</h2>
                        <p class="mt-2 text-base leading-relaxed text-[#33302d]/68">
                            Kombinasi nomor pesanan dan nomor WhatsApp dipakai untuk memastikan hasil hanya tampil kepada pemilik pesanan yang benar.
                        </p>

                        <form action="{{ route('track-order.lookup') }}" method="POST" class="mt-6 space-y-5" novalidate>
                            @csrf

                            <div>
                                <label for="order-number" class="mb-2 block text-sm font-semibold text-[#33302d]">Nomor pesanan</label>
                                <input
                                    id="order-number"
                                    name="order_number"
                                    type="text"
                                    value="{{ old('order_number', $formData['order_number'] ?? '') }}"
                                    autocapitalize="characters"
                                    autocomplete="off"
                                    placeholder="Contoh: ORD-DEMO-0001"
                                    spellcheck="false"
                                    class="h-12 w-full rounded-sm border border-[#33302d]/12 bg-[#f7f7f5] px-4 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-2 focus:ring-[#d9782a]/15"
                                />
                                @error('order_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="whatsapp-number" class="mb-2 block text-sm font-semibold text-[#33302d]">Nomor WhatsApp</label>
                                <input
                                    id="whatsapp-number"
                                    name="whatsapp_number"
                                    type="text"
                                    value="{{ old('whatsapp_number', $formData['whatsapp_number'] ?? '') }}"
                                    autocomplete="tel"
                                    inputmode="numeric"
                                    placeholder="Contoh: 08123456789"
                                    class="h-12 w-full rounded-sm border border-[#33302d]/12 bg-[#f7f7f5] px-4 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-2 focus:ring-[#d9782a]/15"
                                />
                                @error('whatsapp_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-sm bg-[#d9782a] px-6 text-sm font-semibold text-white transition hover:bg-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                                Tampilkan status pesanan
                            </button>
                        </form>

                        @if ($lookupState === 'error' && $lookupError)
                            <div class="mt-6 rounded-sm border border-red-200 bg-red-50 p-5">
                                <p class="text-sm font-semibold text-red-700">{{ $lookupError['title'] }}</p>
                                <p class="mt-2 text-base leading-relaxed text-red-700/85">{{ $lookupError['message'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    @if ($lookupState === 'success' && $result)
                        <div class="overflow-hidden rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] shadow-sm">
                            <div class="border-b border-[#33302d]/10 bg-[#f7f7f5] px-6 py-6 sm:px-8">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold tracking-wide text-[#33302d]/60">Status saat ini</p>
                                        <h2 class="mt-3 text-2xl font-bold text-[#33302d]">{{ $result['current_status']['label'] }}</h2>
                                        <p class="mt-2 max-w-[38ch] text-base leading-relaxed text-[#33302d]/78">{{ $result['current_status']['description'] }}</p>
                                    </div>
                                    <div class="rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] px-4 py-3 text-sm text-[#33302d]/70">
                                        <p>Pembaruan terakhir</p>
                                        <p class="mt-1 font-semibold text-[#33302d]">{{ $result['last_updated'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 sm:p-8">
                                <div class="grid gap-4 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-5 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-semibold tracking-wide text-[#33302d]/55">Nomor pesanan</p>
                                        <p class="mt-2 text-lg font-semibold text-[#33302d]">{{ $result['order_number'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold tracking-wide text-[#33302d]/55">Nomor WhatsApp</p>
                                        <p class="mt-2 text-lg font-semibold text-[#33302d]">{{ $result['whatsapp'] }}</p>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <div class="flex items-center justify-between gap-3">
                                        <h3 class="text-lg font-bold text-[#33302d]">Timeline produksi</h3>
                                        <span class="text-xs font-semibold tracking-wide text-[#33302d]/50">4 tahap utama</span>
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
                                                        ? 'border-[#d9782a]/30 bg-[#f7eadf] text-[#d9782a]'
                                                        : ($isDone
                                                            ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                                            : 'border-[#33302d]/12 bg-[#f7f7f5] text-[#33302d]/48'));
                                                $cardClasses = $isCurrent
                                                    ? 'border-[#d9782a]/20 bg-white'
                                                    : ($isException
                                                        ? 'border-amber-200 bg-amber-50'
                                                        : 'border-[#33302d]/10 bg-[#f7f7f5]');
                                            @endphp
                                            <li class="flex gap-4">
                                                <div class="flex flex-col items-center">
                                                    <div class="flex h-11 w-11 items-center justify-center rounded-sm border text-sm font-bold {{ $indicatorClasses }}">
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
                                                        <div class="mt-2 h-full w-px min-h-8 bg-[#33302d]/12"></div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 rounded-sm border p-4 {{ $cardClasses }}">
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        <h4 class="text-base font-semibold text-[#33302d]">{{ $step['label'] }}</h4>
                                                        @if ($isCurrent)
                                                            <span class="rounded-sm bg-white px-3 py-1 text-xs font-semibold tracking-wide text-[#d9782a]">Sedang berjalan</span>
                                                        @elseif ($isDone)
                                                            <span class="rounded-sm bg-white px-3 py-1 text-xs font-semibold tracking-wide text-emerald-700">Selesai dilalui</span>
                                                        @elseif ($isException)
                                                            <span class="rounded-sm bg-white px-3 py-1 text-xs font-semibold tracking-wide text-amber-700">Perlu tindakan</span>
                                                        @endif
                                                    </div>
                                                    <p class="mt-2 text-base leading-relaxed text-[#33302d]/72">{{ $step['description'] }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>

                                <div class="mt-8 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-5">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-[#33302d]">Ringkasan produk</h3>
                                            <p class="mt-2 text-base leading-relaxed text-[#33302d]/70">Daftar item yang tercatat pada pesanan ini.</p>
                                        </div>
                                        <a
                                            href="{{ route('track-order.receipt', ['order' => $result['id'], 'wa' => $formData['whatsapp_number']]) }}"
                                            class="inline-flex h-12 items-center justify-center rounded-sm bg-[#d9782a] px-6 text-sm font-semibold text-white transition hover:bg-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2"
                                        >
                                            Unduh nota digital (PDF)
                                        </a>
                                    </div>

                                    <div class="mt-5 space-y-3">
                                        @foreach ($result['items'] as $item)
                                            <div class="rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] px-4 py-4">
                                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                    <div>
                                                        <p class="text-base font-semibold text-[#33302d]">{{ $item['product_name'] }}</p>
                                                        <p class="mt-1 text-sm text-[#33302d]/68">{{ $item['variant_name'] }}</p>
                                                    </div>
                                                    <div class="flex items-center gap-4 text-sm text-[#33302d]/68">
                                                        <span>Qty {{ $item['quantity'] }}</span>
                                                        <span class="font-semibold text-[#33302d]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @php
                                    $reviewInput = $reviewInput ?? [];
                                    $reviewableProducts = collect($result['reviewable_products'] ?? []);
                                    $availableReviewProducts = $reviewableProducts->where('has_review', false)->values();
                                @endphp

                                <div class="mt-8 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-5">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-[#33302d]">Beri review produk</h3>
                                            <p class="mt-2 max-w-[42rem] text-base leading-relaxed text-[#33302d]/70">
                                                Review hanya bisa dikirim setelah nomor pesanan dan WhatsApp cocok. Admin dapat mengecek dan mengatur tampilannya dari dashboard.
                                            </p>
                                        </div>
                                        @if (isset($reviewSuccess))
                                            <span class="rounded-sm bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Review terkirim</span>
                                        @endif
                                    </div>

                                    @if (isset($reviewSuccess))
                                        <div class="mt-5 rounded-sm border border-emerald-200 bg-emerald-50 p-4">
                                            <p class="text-sm font-semibold text-emerald-800">{{ $reviewSuccess }}</p>
                                        </div>
                                    @endif

                                    @if ($reviewableProducts->isEmpty())
                                        <div class="mt-5 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-4">
                                            <p class="text-base leading-relaxed text-[#33302d]/70">
                                                Produk pada pesanan ini belum terhubung ke katalog, jadi review produk belum bisa dikirim dari halaman tracking.
                                            </p>
                                        </div>
                                    @elseif ($availableReviewProducts->isEmpty())
                                        <div class="mt-5 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] p-4">
                                            <p class="text-base leading-relaxed text-[#33302d]/70">
                                                Semua produk di pesanan ini sudah diberi review.
                                            </p>
                                        </div>
                                    @else
                                        <form action="{{ route('track-order.reviews.store', $result['id']) }}" method="POST" class="mt-5 space-y-5">
                                            @csrf
                                            <input type="hidden" name="whatsapp_number" value="{{ $formData['whatsapp_number'] }}">

                                            <div>
                                                <label for="review-product" class="mb-2 block text-sm font-semibold text-[#33302d]">Produk yang direview</label>
                                                <select
                                                    id="review-product"
                                                    name="product_id"
                                                    class="h-12 w-full rounded-sm border border-[#33302d]/15 bg-[#f7f7f5] px-4 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-2 focus:ring-[#d9782a]/15"
                                                >
                                                    <option value="">Pilih produk</option>
                                                    @foreach ($availableReviewProducts as $reviewProduct)
                                                        <option value="{{ $reviewProduct['product_id'] }}" @selected((string) ($reviewInput['product_id'] ?? '') === (string) $reviewProduct['product_id'])>
                                                            {{ $reviewProduct['product_name'] }}{{ $reviewProduct['variants'] ? ' - ' . $reviewProduct['variants'] : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <p class="mb-2 block text-sm font-semibold text-[#33302d]">Rating</p>
                                                <div class="grid gap-2 sm:grid-cols-5">
                                                    @for ($rating = 5; $rating >= 1; $rating--)
                                                        <label class="flex cursor-pointer items-center justify-between gap-2 rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] px-3 py-3 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/40">
                                                            <span>{{ $rating }} bintang</span>
                                                            <input
                                                                type="radio"
                                                                name="rating"
                                                                value="{{ $rating }}"
                                                                class="h-4 w-4 text-[#d9782a] focus:ring-[#d9782a]"
                                                                @checked((string) ($reviewInput['rating'] ?? '') === (string) $rating)
                                                            />
                                                        </label>
                                                    @endfor
                                                </div>
                                                @error('rating')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="review-comment" class="mb-2 block text-sm font-semibold text-[#33302d]">Review</label>
                                                <textarea
                                                    id="review-comment"
                                                    name="comment"
                                                    rows="4"
                                                    placeholder="Ceritakan kualitas hasil cetak, pelayanan, atau kecepatan pengerjaan."
                                                    class="w-full rounded-sm border border-[#33302d]/15 bg-[#f7f7f5] px-4 py-3 text-sm text-[#33302d] outline-none transition focus:border-[#d9782a] focus:ring-2 focus:ring-[#d9782a]/15"
                                                >{{ $reviewInput['comment'] ?? '' }}</textarea>
                                                @error('comment')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-sm bg-[#d9782a] px-6 text-sm font-semibold text-white transition hover:bg-[#c86818] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2 sm:w-auto">
                                                Kirim review
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-sm border border-dashed border-[#33302d]/16 bg-[#f7f7f5] p-8 shadow-sm sm:p-10">
                            <h2 class="text-2xl font-bold text-[#33302d]">Status pesanan akan tampil di sini</h2>
                            <p class="mt-3 max-w-[40ch] text-base leading-relaxed text-[#33302d]/70">
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
