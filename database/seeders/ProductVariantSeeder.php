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
                ['variant_name' => 'Flexi 280 gsm 1 x 1 m', 'price' => 25000, 'weight' => 300],
                ['variant_name' => 'Flexi 280 gsm 2 x 1 m', 'price' => 50000, 'weight' => 600],
                ['variant_name' => 'Flexi 340 gsm 3 x 1 m', 'price' => 90000, 'weight' => 1100],
                ['variant_name' => 'Flexi Korea 3 x 1 m', 'price' => 120000, 'weight' => 1300],
            ],
            'x-banner' => [
                ['variant_name' => 'X Banner 60 x 160 cm', 'price' => 85000, 'weight' => 900],
                ['variant_name' => 'X Banner 80 x 180 cm', 'price' => 125000, 'weight' => 1200],
            ],
            'roll-up-banner' => [
                ['variant_name' => 'Roll Up 60 x 160 cm', 'price' => 275000, 'weight' => 2500],
                ['variant_name' => 'Roll Up 80 x 200 cm', 'price' => 375000, 'weight' => 3200],
            ],
            'vinyl-sticker' => [
                ['variant_name' => 'A4 Vinyl Glossy', 'price' => 15000, 'weight' => 50],
                ['variant_name' => 'A3 Vinyl Glossy', 'price' => 28000, 'weight' => 90],
                ['variant_name' => 'Meteran Vinyl 1 m', 'price' => 65000, 'weight' => 250],
            ],
            'sticker-transparan' => [
                ['variant_name' => 'A4 Transparan', 'price' => 18000, 'weight' => 45],
                ['variant_name' => 'A3 Transparan', 'price' => 34000, 'weight' => 85],
            ],
            'art-paper-poster' => [
                ['variant_name' => 'A4 Art Paper 150 gsm', 'price' => 10000, 'weight' => 30],
                ['variant_name' => 'A3 Art Paper 150 gsm', 'price' => 18000, 'weight' => 60],
                ['variant_name' => 'A3+ Art Paper 260 gsm', 'price' => 28000, 'weight' => 120],
            ],
            'poster-photo-paper' => [
                ['variant_name' => 'A4 Photo Paper', 'price' => 15000, 'weight' => 45],
                ['variant_name' => 'A3 Photo Paper', 'price' => 30000, 'weight' => 90],
            ],
            'brosur-lipat' => [
                ['variant_name' => 'A4 Lipat 2 Art Paper 120 gsm', 'price' => 1800, 'weight' => 15],
                ['variant_name' => 'A4 Lipat 3 Art Paper 150 gsm', 'price' => 2400, 'weight' => 18],
            ],
            'flyer-a5' => [
                ['variant_name' => 'A5 Art Paper 120 gsm', 'price' => 900, 'weight' => 8],
                ['variant_name' => 'A5 Art Paper 150 gsm', 'price' => 1200, 'weight' => 10],
            ],
            'kartu-nama-premium' => [
                ['variant_name' => '1 Box Isi 100 Art Carton 260 gsm', 'price' => 45000, 'weight' => 250],
                ['variant_name' => '1 Box Isi 100 Linen', 'price' => 65000, 'weight' => 260],
                ['variant_name' => '1 Box Isi 100 Laminasi Doff', 'price' => 75000, 'weight' => 280],
            ],
            'print-dokumen-warna' => [
                ['variant_name' => 'A4 HVS 80 gsm Warna', 'price' => 1500, 'weight' => 5],
                ['variant_name' => 'A4 HVS 80 gsm Hitam Putih', 'price' => 500, 'weight' => 5],
                ['variant_name' => 'A3 Warna', 'price' => 4000, 'weight' => 10],
            ],
            'jilid-buku' => [
                ['variant_name' => 'Jilid Lakban', 'price' => 8000, 'weight' => 100],
                ['variant_name' => 'Jilid Spiral Plastik', 'price' => 12000, 'weight' => 150],
                ['variant_name' => 'Jilid Soft Cover', 'price' => 25000, 'weight' => 250],
            ],
            'label-kemasan' => [
                ['variant_name' => 'Label A4 Kiss Cut', 'price' => 12000, 'weight' => 40],
                ['variant_name' => 'Label A3 Kiss Cut', 'price' => 24000, 'weight' => 80],
            ],
            'hang-tag' => [
                ['variant_name' => 'Art Carton 260 gsm 1 Sisi', 'price' => 350, 'weight' => 3],
                ['variant_name' => 'Art Carton 260 gsm 2 Sisi', 'price' => 500, 'weight' => 4],
            ],
            'pin-custom' => [
                ['variant_name' => 'Pin 44 mm', 'price' => 5000, 'weight' => 20],
                ['variant_name' => 'Pin 58 mm', 'price' => 6500, 'weight' => 30],
            ],
            'mug-custom' => [
                ['variant_name' => 'Mug Putih Standar', 'price' => 35000, 'weight' => 450],
                ['variant_name' => 'Mug Warna Dalam', 'price' => 45000, 'weight' => 460],
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
                    [
                        'price' => $variant['price'],
                        'weight' => $variant['weight'],
                        'stock_status' => true,
                    ],
                );
            }
        }
    }
}
