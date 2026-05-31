<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = Product::query()->pluck('id', 'slug');

        $variants = [
            'banner-flexi' => [
                ['variant_name' => 'Flexi 280 gsm 1 x 1 m'],
                ['variant_name' => 'Flexi 280 gsm 2 x 1 m'],
                ['variant_name' => 'Flexi 340 gsm 3 x 1 m'],
                ['variant_name' => 'Flexi Korea 3 x 1 m'],
            ],
            'x-banner' => [
                ['variant_name' => 'X Banner 60 x 160 cm'],
                ['variant_name' => 'X Banner 80 x 180 cm'],
            ],
            'roll-up-banner' => [
                ['variant_name' => 'Roll Up 60 x 160 cm'],
                ['variant_name' => 'Roll Up 80 x 200 cm'],
            ],
            'vinyl-sticker' => [
                ['variant_name' => 'A4 Vinyl Glossy'],
                ['variant_name' => 'A3 Vinyl Glossy'],
                ['variant_name' => 'Meteran Vinyl 1 m'],
            ],
            'sticker-transparan' => [
                ['variant_name' => 'A4 Transparan'],
                ['variant_name' => 'A3 Transparan'],
            ],
            'art-paper-poster' => [
                ['variant_name' => 'A4 Art Paper 150 gsm'],
                ['variant_name' => 'A3 Art Paper 150 gsm'],
                ['variant_name' => 'A3+ Art Paper 260 gsm'],
            ],
            'poster-photo-paper' => [
                ['variant_name' => 'A4 Photo Paper'],
                ['variant_name' => 'A3 Photo Paper'],
            ],
            'brosur-lipat' => [
                ['variant_name' => 'A4 Lipat 2 Art Paper 120 gsm'],
                ['variant_name' => 'A4 Lipat 3 Art Paper 150 gsm'],
            ],
            'flyer-a5' => [
                ['variant_name' => 'A5 Art Paper 120 gsm'],
                ['variant_name' => 'A5 Art Paper 150 gsm'],
            ],
            'kartu-nama-premium' => [
                ['variant_name' => '1 Box Isi 100 Art Carton 260 gsm'],
                ['variant_name' => '1 Box Isi 100 Linen'],
                ['variant_name' => '1 Box Isi 100 Laminasi Doff'],
            ],
            'print-dokumen-warna' => [
                ['variant_name' => 'A4 HVS 80 gsm Warna'],
                ['variant_name' => 'A4 HVS 80 gsm Hitam Putih'],
                ['variant_name' => 'A3 Warna'],
            ],
            'jilid-buku' => [
                ['variant_name' => 'Jilid Lakban'],
                ['variant_name' => 'Jilid Spiral Plastik'],
                ['variant_name' => 'Jilid Soft Cover'],
            ],
            'label-kemasan' => [
                ['variant_name' => 'Label A4 Kiss Cut'],
                ['variant_name' => 'Label A3 Kiss Cut'],
            ],
            'hang-tag' => [
                ['variant_name' => 'Art Carton 260 gsm 1 Sisi'],
                ['variant_name' => 'Art Carton 260 gsm 2 Sisi'],
            ],
            'pin-custom' => [
                ['variant_name' => 'Pin 44 mm'],
                ['variant_name' => 'Pin 58 mm'],
            ],
            'mug-custom' => [
                ['variant_name' => 'Mug Putih Standar'],
                ['variant_name' => 'Mug Warna Dalam'],
            ],
        ];

        foreach ($variants as $productSlug => $productVariants) {
            $productId = $productIds[$productSlug] ?? null;

            if (! $productId) {
                continue;
            }

            foreach ($productVariants as $variant) {
                ProductVariant::updateOrCreate(
                    [
                        'product_id' => $productId,
                        'variant_name' => $variant['variant_name'],
                    ],
                    [],
                );
            }
        }
    }
}
