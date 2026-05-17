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
            'variant_name' => '2x1 Meter',
            'price' => 50000,
            'weight' => 600,
            'stock_status' => true,
        ]);

        ProductVariant::create([
            'product_id' => 1,
            'variant_name' => '3x1 Meter',
            'price' => 75000,
            'weight' => 900,
            'stock_status' => true,
        ]);

        ProductVariant::create([
            'product_id' => 2,
            'variant_name' => 'A4',
            'price' => 15000,
            'weight' => 50,
            'stock_status' => true,
        ]);
    }
}
