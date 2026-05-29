<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Banner', 'slug' => 'banner'],
            ['name' => 'Sticker', 'slug' => 'sticker'],
            ['name' => 'Poster', 'slug' => 'poster'],
            ['name' => 'Brosur', 'slug' => 'brosur'],
            ['name' => 'Kartu Nama', 'slug' => 'kartu-nama'],
            ['name' => 'Dokumen', 'slug' => 'dokumen'],
            ['name' => 'Kemasan', 'slug' => 'kemasan'],
            ['name' => 'Merchandise', 'slug' => 'merchandise'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']],
            );
        }
    }
}
