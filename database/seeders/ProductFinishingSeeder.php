<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductFinishing;

class ProductFinishingSeeder extends Seeder
{
    public function run(): void
    {
        ProductFinishing::create([
            'product_id' => 1,
            'name' => 'Eyelet',
            'description' => 'Banner eyelet finishing',
            'is_active' => true,
        ]);

        ProductFinishing::create([
            'product_id' => 1,
            'name' => 'Laminating',
            'description' => 'Glossy laminating',
            'is_active' => true,
        ]);

        ProductFinishing::create([
            'product_id' => 2,
            'name' => 'Cutting',
            'description' => 'Custom cutting sticker',
            'is_active' => true,
        ]);
    }
}
