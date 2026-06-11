<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->pluck('id');
        $products = Product::all();

        if ($admins->isEmpty() || $products->isEmpty()) {
            return;
        }

        $orders = [
            [
                'customer_name' => 'Budi Santoso',
                'customer_phone' => '081234567890',
                'customer_address' => 'Jl. Mawar No. 12, Malang',
                'status' => 'completed',
                'payment_status' => 'paid',
            ],
            [
                'customer_name' => 'Siti Aminah',
                'customer_phone' => '082345678901',
                'customer_address' => 'Jl. Melati No. 5, Malang',
                'status' => 'production',
                'payment_status' => 'partial',
            ],
            [
                'customer_name' => 'Andi Wijaya',
                'customer_phone' => '083456789012',
                'customer_address' => 'Jl. Kamboja No. 8, Batu',
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ],
            [
                'customer_name' => 'Dewi Lestari',
                'customer_phone' => '084567890123',
                'customer_address' => 'Jl. Anggrek No. 3, Malang',
                'status' => 'ready',
                'payment_status' => 'paid',
            ],
            [
                'customer_name' => 'Eko Prasetyo',
                'customer_phone' => '085678901234',
                'customer_address' => 'Jl. Tulip No. 7, Malang',
                'status' => 'cancelled',
                'payment_status' => 'unpaid',
            ],
        ];

        foreach ($orders as $index => $orderData) {
            $orderCode = 'ORD-' . date('YmdHis') . '-' . strtoupper(Str::random(4));
            
            $order = Order::create([
                'order_code' => $orderCode,
                'customer_name' => $orderData['customer_name'],
                'customer_phone' => $orderData['customer_phone'],
                'customer_address' => $orderData['customer_address'],
                'deadline' => Carbon::now()->addDays(rand(3, 7)),
                'pickup_method' => rand(0, 1) ? 'Ambil di toko' : 'Kirim',
                'design_file_status' => rand(0, 1) ? 'Sudah siap' : 'Perlu dibantu desain',
                'status' => $orderData['status'],
                'payment_status' => $orderData['payment_status'],
                'admin_id' => $admins->random(),
                'shipping_fee' => $orderData['status'] === 'Kirim' ? 10000 : 0,
                'design_fee' => rand(0, 1) ? 25000 : 0,
                'total_price' => 0, // Will update after items
                'paid_amount' => $orderData['payment_status'] === 'paid' ? 0 : ($orderData['payment_status'] === 'partial' ? 50000 : 0),
            ]);

            $totalPrice = $order->shipping_fee + $order->design_fee;
            $itemCount = rand(1, 3);
            
            for ($i = 0; $i < $itemCount; $i++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = $product->base_price;
                $subtotal = $unitPrice * $quantity;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'specification' => 'Spesifikasi standar untuk ' . $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
                
                $totalPrice += $subtotal;
            }

            $order->update([
                'total_price' => $totalPrice,
                'paid_amount' => $orderData['payment_status'] === 'paid' ? $totalPrice : $order->paid_amount,
            ]);
        }
    }
}
