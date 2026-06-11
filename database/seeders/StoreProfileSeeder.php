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
            'maps_url' => 'https://www.google.com/maps/place/Harapan+Jaya+Print+dan+Percetakan/@-7.9452481,112.613485,17z/data=!3m1!4b1!4m6!3m5!1s0x2e7882744f32587d:0x9975ecdae2a9d7bf!8m2!3d-7.9452534!4d112.6160599!16s%2Fg%2F11fy5666yy?hl=id&entry=ttu&g_ep=EgoyMDI2MDYwMy4xIKXMDSoASAFQAw%3D%3D',
            'whatsapp_number' => '082142117750',
            'email' => 'harapanjaya366@gmail.com',
            'instagram_url' => null,
        ]);
    }
}
