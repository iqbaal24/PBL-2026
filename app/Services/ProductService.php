<?php

namespace App\Services;

class ProductService
{
    public static function all(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'banner',
                'nama' => 'Banner',
                'kategori' => 'Outdoor',
                'harga' => 25000,
                'deskripsi' => 'Banner berkualitas tinggi untuk promosi outdoor maupun indoor dengan hasil cetak tajam dan bahan tahan cuaca.',
                'image' => 'https://images.unsplash.com/photo-1515169067865-5387ec356754?auto=format&fit=crop&w=900&q=80',
                'detail' => 'Banner fleksibel dengan finishing rapi, cocok untuk pameran, promosi toko, atau event luar ruang.',
                'bahan' => ['Flexi Kain', 'Flexi China'],
            ],
            [
                'id' => 2,
                'slug' => 'stiker-vinyl',
                'nama' => 'Stiker Vinyl',
                'kategori' => 'Indoor',
                'harga' => 15000,
                'deskripsi' => 'Stiker vinyl custom untuk branding kendaraan, window sticker, dan packaging promosi.',
                'image' => 'https://images.unsplash.com/photo-1517638851339-4aa989a4ee10?auto=format&fit=crop&w=900&q=80',
                'detail' => 'Stiker tahan lama dengan hasil cetak warna cerah dan permukaan glossy atau matte.',
                'bahan' => ['Oracal 651', 'Staflite 4+'],
            ],
            [
                'id' => 3,
                'slug' => 'undangan-pernikahan',
                'nama' => 'Undangan Pernikahan',
                'kategori' => 'Percetakan',
                'harga' => 2500,
                'deskripsi' => 'Cetak undangan pernikahan elegan dengan pilihan kertas premium dan desain custom.',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80',
                'detail' => 'Undangan wedding dengan hasil cetak halus, siap dikirim untuk keperluan acara spesial Anda.',
                'bahan' => ['Art Paper 260gsm', 'Art Carton 310gsm'],
            ],
            [
                'id' => 4,
                'slug' => 'x-banner',
                'nama' => 'X-Banner',
                'kategori' => 'Indoor',
                'harga' => 75000,
                'deskripsi' => 'X-Banner portable untuk promosi event dan toko dengan penyangga ringkas dan mudah dipasang.',
                'image' => 'https://images.unsplash.com/photo-1511974035430-5de47d3b95da?auto=format&fit=crop&w=900&q=80',
                'detail' => 'X-Banner cocok untuk display indoor dan event marketing dengan tampilan profesional.',
                'bahan' => ['Flexi Kain', 'Allu + Stand'],
            ],
            [
                'id' => 5,
                'slug' => 'kalender',
                'nama' => 'Kalender',
                'kategori' => 'Percetakan',
                'harga' => 15000,
                'deskripsi' => 'Cetak kalender custom untuk kebutuhan bisnis dan promosi tahun berjalan.',
                'image' => 'https://images.unsplash.com/photo-1517430816045-df4b7de01ba9?auto=format&fit=crop&w=900&q=80',
                'detail' => 'Kalender meja atau dinding dengan desain eksklusif dan kertas tebal untuk kualitas cetak terbaik.',
                'bahan' => ['Art Paper 150gsm', 'Art Carton 260gsm'],
            ],
            [
                'id' => 6,
                'slug' => 'neon-box',
                'nama' => 'Neon Box',
                'kategori' => 'Outdoor',
                'harga' => 350000,
                'deskripsi' => 'Neon box untuk signage toko dengan pencahayaan LED yang terang dan desain modern.',
                'image' => 'https://images.unsplash.com/photo-1521120098173-3e7f2f69fa03?auto=format&fit=crop&w=900&q=80',
                'detail' => 'Neon box cocok untuk signage depan toko, mudah dipasang, tahan lama, dan menarik perhatian.',
                'bahan' => ['Acrylic + Aluminium Frame', 'Galaxy Frame'],
            ],
        ];
    }

    public static function findBySlug(string $slug): ?array
    {
        return collect(self::all())->firstWhere('slug', $slug);
    }

    public static function findById(int $id): ?array
    {
        return collect(self::all())->firstWhere('id', $id);
    }
}
