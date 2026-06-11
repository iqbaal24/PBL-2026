<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::where('status', 'completed')->get();
        
        if ($orders->isEmpty()) {
            return;
        }

        $comments = [
            5 => [
                'Hasil cetak sangat memuaskan, warna tajam!',
                'Pelayanan ramah dan pengerjaan cepat. Recommended!',
                'Kualitas bahan bagus sekali, sesuai pesanan.',
                'Sangat puas dengan hasilnya, bakal langganan di sini.',
            ],
            4 => [
                'Bagus, tapi pengerjaan sedikit lebih lama dari estimasi.',
                'Hasil cetak oke, cuma packingnya bisa ditingkatkan lagi.',
                'Pelayanan baik, kualitas produk juga mantap.',
                'Cukup memuaskan, harga bersaing.',
            ],
            3 => [
                'Hasil standar, tidak ada masalah berarti.',
                'Warna agak sedikit beda dari desain, tapi masih oke.',
            ]
        ];

        foreach ($orders as $order) {
            $rating = rand(4, 5); // Mostly good reviews
            $possibleComments = $comments[$rating];
            
            Review::create([
                'customer_name' => $order->customer_name,
                'order_id' => $order->id,
                'product_id' => $order->items->first()?->product_id,
                'rating' => $rating,
                'comment' => $possibleComments[array_rand($possibleComments)],
                'is_visible' => true,
            ]);
        }
    }
}
