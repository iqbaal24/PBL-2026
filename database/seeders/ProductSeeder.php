<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id', 'slug');

        $products = [
            [
                'category' => 'banner',
                'name' => 'Banner Flexi',
                'slug' => 'banner-flexi',
                'description' => 'Banner bahan flexi untuk promosi toko, event, backdrop, dan spanduk luar ruangan.',
                'base_price' => 25000,
                'is_active' => true,
            ],
            [
                'category' => 'banner',
                'name' => 'X Banner',
                'slug' => 'x-banner',
                'description' => 'Media promosi berdiri untuk booth, seminar, toko, dan acara kampus.',
                'base_price' => 85000,
                'is_active' => true,
            ],
            [
                'category' => 'banner',
                'name' => 'Roll Up Banner',
                'slug' => 'roll-up-banner',
                'description' => 'Banner portable dengan rangka roll up untuk presentasi dan promosi indoor.',
                'base_price' => 275000,
                'is_active' => true,
            ],
            [
                'category' => 'sticker',
                'name' => 'Vinyl Sticker',
                'slug' => 'vinyl-sticker',
                'description' => 'Stiker vinyl untuk label produk, dekorasi, kemasan, dan kebutuhan branding.',
                'base_price' => 15000,
                'is_active' => true,
            ],
            [
                'category' => 'sticker',
                'name' => 'Sticker Transparan',
                'slug' => 'sticker-transparan',
                'description' => 'Stiker bening untuk kaca, botol, label kemasan, dan tampilan minimal.',
                'base_price' => 18000,
                'is_active' => true,
            ],
            [
                'category' => 'poster',
                'name' => 'Art Paper Poster',
                'slug' => 'art-paper-poster',
                'description' => 'Poster art paper untuk promosi produk, event, menu, dan materi visual indoor.',
                'base_price' => 10000,
                'is_active' => true,
            ],
            [
                'category' => 'poster',
                'name' => 'Poster Photo Paper',
                'slug' => 'poster-photo-paper',
                'description' => 'Poster photo paper dengan hasil warna lebih tajam untuk foto dan display.',
                'base_price' => 15000,
                'is_active' => true,
            ],
            [
                'category' => 'brosur',
                'name' => 'Brosur Lipat',
                'slug' => 'brosur-lipat',
                'description' => 'Brosur promosi satu lipat atau dua lipat untuk menu, layanan, dan kampanye.',
                'base_price' => 1200,
                'is_active' => true,
            ],
            [
                'category' => 'brosur',
                'name' => 'Flyer A5',
                'slug' => 'flyer-a5',
                'description' => 'Flyer ringkas untuk promosi event, menu, diskon, dan informasi toko.',
                'base_price' => 900,
                'is_active' => true,
            ],
            [
                'category' => 'kartu-nama',
                'name' => 'Kartu Nama Premium',
                'slug' => 'kartu-nama-premium',
                'description' => 'Kartu nama art carton dengan pilihan laminasi doff atau glossy.',
                'base_price' => 45000,
                'is_active' => true,
            ],
            [
                'category' => 'dokumen',
                'name' => 'Print Dokumen Warna',
                'slug' => 'print-dokumen-warna',
                'description' => 'Cetak dokumen warna untuk proposal, laporan, portofolio, dan materi presentasi.',
                'base_price' => 1500,
                'is_active' => true,
            ],
            [
                'category' => 'dokumen',
                'name' => 'Jilid Buku',
                'slug' => 'jilid-buku',
                'description' => 'Jilid soft cover, spiral, dan lakban untuk laporan, skripsi, modul, dan buku kerja.',
                'base_price' => 8000,
                'is_active' => true,
            ],
            [
                'category' => 'kemasan',
                'name' => 'Label Kemasan',
                'slug' => 'label-kemasan',
                'description' => 'Label kemasan untuk botol, pouch, dus, jar, dan produk UMKM.',
                'base_price' => 12000,
                'is_active' => true,
            ],
            [
                'category' => 'kemasan',
                'name' => 'Hang Tag',
                'slug' => 'hang-tag',
                'description' => 'Hang tag untuk pakaian, hampers, produk handmade, dan aksesoris.',
                'base_price' => 350,
                'is_active' => true,
            ],
            [
                'category' => 'merchandise',
                'name' => 'Pin Custom',
                'slug' => 'pin-custom',
                'description' => 'Pin custom untuk komunitas, acara kampus, promosi brand, dan souvenir.',
                'base_price' => 5000,
                'is_active' => true,
            ],
            [
                'category' => 'merchandise',
                'name' => 'Mug Custom',
                'slug' => 'mug-custom',
                'description' => 'Cetak mug custom untuk hadiah, souvenir kantor, dan paket promosi.',
                'base_price' => 35000,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            $categoryId = $categoryIds[$product['category']] ?? null;

            if (! $categoryId) {
                continue;
            }

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $categoryId,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'base_price' => $product['base_price'],
                    'is_active' => $product['is_active'],
                ],
            );
        }
    }
}
