@php
    $storefront = config('storefront');
    $brandName = config('storefront.brand_name', 'Harapan Jaya Printing');
    $brandLogoUrl = null;

    try {
        $storeProfile = \App\Models\StoreProfile::query()->first(['name', 'logo']);
        if ($storeProfile?->name) {
            $brandName = $storeProfile->name;
        }
        if ($storeProfile?->logo) {
            $brandLogoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($storeProfile->logo);
        }
    } catch (\Throwable $exception) {
    }
@endphp

<footer id="kontak" class="bg-[#181715] text-white pt-20 pb-12 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-4">
            <div>
                <div class="flex items-center gap-3">
                    @if ($brandLogoUrl)
                        <img src="{{ $brandLogoUrl }}" alt="{{ $brandName }}" class="h-10 w-10 flex-shrink-0 rounded-sm object-cover bg-white" />
                    @endif
                    <span class="text-lg font-semibold text-white tracking-tight">
                        Harapan Jaya <span class="text-[#e5a35d]">Printing</span>
                    </span>
                </div>
                <p class="mt-5 text-sm leading-relaxed text-white/70 max-w-sm font-normal">
                    Solusi cetak digital terpercaya untuk kebutuhan bisnis dan pribadi Anda. Berkualitas, transparan, dan responsif.
                </p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#f0c79d] mb-5 block">Navigasi</h3>
                <ul class="space-y-3 text-sm text-white/70">
                    <li><a href="{{ url('/') }}" class="transition-colors hover:text-[#e5a35d]">Beranda</a></li>
                    <li><a href="{{ url('/katalog') }}" class="transition-colors hover:text-[#e5a35d]">Katalog</a></li>
                    <li><a href="{{ url('/panduan') }}" class="transition-colors hover:text-[#e5a35d]">Panduan</a></li>
                    <li><a href="{{ route('track-order') }}" class="transition-colors hover:text-[#e5a35d]">Lacak Pesanan</a></li>
                    <li><a href="{{ url('/hubungi-kami') }}" class="transition-colors hover:text-[#e5a35d]">Hubungi Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#f0c79d] mb-5 block">Kontak</h3>
                <ul class="space-y-3 text-sm text-white/70 leading-relaxed">
                    @foreach ($storefront['address_lines'] as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                    <li class="pt-3 border-t border-white/5 text-white/80">
                        <span class="block text-xs text-[#f0c79d]/60 mb-0.5">Telepon</span>
                        {{ $storefront['phone_display'] }}
                    </li>
                    <li class="text-white/80">
                        <span class="block text-xs text-[#f0c79d]/60 mb-0.5">Email</span>
                        {{ $storefront['email'] }}
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#f0c79d] mb-5 block">Jam Operasional</h3>
                <ul class="space-y-3 text-sm text-white/70">
                    @foreach ($storefront['hours'] as $hour)
                        <li class="flex justify-between gap-4">
                            <span class="text-white/40">{{ $hour['label'] }}</span>
                            <span class="text-white/85">{{ $hour['value'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-16 border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/50">
            <div>
                &copy; 2026 Harapan Jaya Printing. All rights reserved.
            </div>
            <div class="flex items-center gap-2 text-xs text-white/30">
                <span>Digital &amp; Offset Printing</span>
                <span class="h-1 w-1 rounded-sm bg-white/20"></span>
                <span>Fast Service</span>
            </div>
        </div>
    </div>
</footer>
