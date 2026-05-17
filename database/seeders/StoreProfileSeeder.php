<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoreProfile;

class StoreProfileSeeder extends Seeder
{
    public function run(): void
    {
        StoreProfile::create([
            'name' => 'Harapan Jaya Digital Printing',
            'about' => 'Melayani percetakan digital untuk banner, stiker, poster, dan kebutuhan cetak lainnya dengan kualitas terbaik.',
            'address' => 'Jl. Semanggi Barat 5C Jatimulyo',
            'whatsapp_number' => '082142117750',
            'email' => 'harapanjaya366@gmail.com',
            'instagram_url' => null,
        ]);
    }
}
