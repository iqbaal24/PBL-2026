<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFinishing;
use Illuminate\Database\Seeder;

class ProductFinishingSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = Product::query()->pluck('id', 'slug');

        $finishings = [
            'banner-flexi' => [
                ['name' => 'Mata Ayam', 'description' => 'Lubang ring untuk pemasangan tali pada banner.'],
                ['name' => 'Kolong Kayu', 'description' => 'Finishing lipat dengan kayu untuk spanduk gantung.'],
                ['name' => 'Lem Pinggir', 'description' => 'Penguatan bagian tepi agar banner lebih rapi.'],
            ],
            'x-banner' => [
                ['name' => 'Rangka X Banner', 'description' => 'Paket cetak dengan rangka portable.'],
                ['name' => 'Laminasi Doff', 'description' => 'Lapisan doff agar permukaan tidak terlalu memantulkan cahaya.'],
            ],
            'roll-up-banner' => [
                ['name' => 'Rangka Roll Up', 'description' => 'Paket dengan rangka roll up dan tas pembawa.'],
                ['name' => 'Laminasi Glossy', 'description' => 'Lapisan glossy untuk warna yang lebih hidup.'],
            ],
            'vinyl-sticker' => [
                ['name' => 'Kiss Cut', 'description' => 'Potong mengikuti bentuk stiker tanpa memotong backing.'],
                ['name' => 'Die Cut', 'description' => 'Potong putus mengikuti bentuk desain.'],
                ['name' => 'Laminasi Glossy', 'description' => 'Lapisan pelindung mengilap untuk stiker.'],
                ['name' => 'Laminasi Doff', 'description' => 'Lapisan pelindung matte untuk stiker.'],
            ],
            'sticker-transparan' => [
                ['name' => 'Kiss Cut', 'description' => 'Potong bentuk label transparan.'],
                ['name' => 'White Ink Area', 'description' => 'Area putih tambahan untuk desain transparan tertentu.'],
            ],
            'art-paper-poster' => [
                ['name' => 'Laminasi Doff', 'description' => 'Lapisan matte untuk poster indoor.'],
                ['name' => 'Laminasi Glossy', 'description' => 'Lapisan glossy untuk warna lebih kontras.'],
            ],
            'poster-photo-paper' => [
                ['name' => 'Glossy Photo', 'description' => 'Permukaan mengilap untuk cetak foto.'],
                ['name' => 'Matte Photo', 'description' => 'Permukaan matte untuk display yang lebih lembut.'],
            ],
            'brosur-lipat' => [
                ['name' => 'Lipat 2', 'description' => 'Brosur satu lipatan.'],
                ['name' => 'Lipat 3', 'description' => 'Brosur tiga panel.'],
                ['name' => 'Laminasi Doff', 'description' => 'Lapisan matte untuk brosur premium.'],
            ],
            'flyer-a5' => [
                ['name' => 'Potong Rapi', 'description' => 'Potong final sesuai ukuran A5.'],
                ['name' => 'Bundling', 'description' => 'Pengelompokan flyer per paket.'],
            ],
            'kartu-nama-premium' => [
                ['name' => 'Laminasi Doff', 'description' => 'Finishing matte untuk kartu nama.'],
                ['name' => 'Laminasi Glossy', 'description' => 'Finishing glossy untuk warna lebih terang.'],
                ['name' => 'Sudut Rounded', 'description' => 'Potong sudut membulat.'],
            ],
            'print-dokumen-warna' => [
                ['name' => 'Staples', 'description' => 'Satukan dokumen dengan staples.'],
                ['name' => 'Map Plastik', 'description' => 'Tambahan map plastik untuk dokumen.'],
            ],
            'jilid-buku' => [
                ['name' => 'Cover Mika', 'description' => 'Cover mika bening depan.'],
                ['name' => 'Cover Buffalo', 'description' => 'Cover buffalo warna untuk bagian belakang.'],
                ['name' => 'Cetak Cover', 'description' => 'Cover full color untuk jilid soft cover.'],
            ],
            'label-kemasan' => [
                ['name' => 'Kiss Cut', 'description' => 'Potong label tanpa melepas backing.'],
                ['name' => 'Laminasi Anti Air', 'description' => 'Lapisan tambahan untuk label kemasan.'],
            ],
            'hang-tag' => [
                ['name' => 'Lubang Tali', 'description' => 'Punch hole untuk tali hang tag.'],
                ['name' => 'Tali Gantung', 'description' => 'Tambahan tali untuk hang tag.'],
            ],
            'pin-custom' => [
                ['name' => 'Packaging Plastik', 'description' => 'Pin dikemas plastik satuan.'],
                ['name' => 'Desain Satuan', 'description' => 'Cetak beberapa desain dalam satu batch.'],
            ],
            'mug-custom' => [
                ['name' => 'Box Mug', 'description' => 'Box satuan untuk mug.'],
                ['name' => 'Cetak Full Wrap', 'description' => 'Cetak desain melingkar pada mug.'],
            ],
        ];

        foreach ($finishings as $productSlug => $productFinishings) {
            $productId = $productIds[$productSlug] ?? null;

            if (! $productId) {
                continue;
            }

            foreach ($productFinishings as $finishing) {
                ProductFinishing::updateOrCreate(
                    [
                        'product_id' => $productId,
                        'name' => $finishing['name'],
                    ],
                    [
                        'description' => $finishing['description'],
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}
