<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Banner',
            'slug' => 'banner',
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Sticker',
            'slug' => 'sticker',
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Poster',
            'slug' => 'poster',
            'is_active' => true,
        ]);
    }
}
