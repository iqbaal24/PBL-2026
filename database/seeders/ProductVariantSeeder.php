<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        ProductVariant::create([
            'product_id' => 1,
            'name' => '2x1 Meter',
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => 1,
            'name' => '3x1 Meter',
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => 2,
            'name' => 'A4',
            'is_active' => true,
        ]);
    }
}
