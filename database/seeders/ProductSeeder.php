<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'category_id' => 1,
            'name' => 'Banner Flexi',
            'slug' => 'banner-flexi',
            'description' => 'High quality flexi banner printing',
            'base_price' => 25000,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => 2,
            'name' => 'Vinyl Sticker',
            'slug' => 'vinyl-sticker',
            'description' => 'Custom vinyl sticker printing',
            'base_price' => 15000,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => 3,
            'name' => 'Art Paper Poster',
            'slug' => 'art-paper-poster',
            'description' => 'Premium poster printing',
            'base_price' => 10000,
            'is_active' => true,
        ]);
    }
}
