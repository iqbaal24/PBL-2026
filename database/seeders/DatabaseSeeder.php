<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedLocations();

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'phone_number' => '081234567890',
                'address' => 'Jl. Merdeka No. 1',
                'default_city_id' => 501,
                'role' => 'admin',
                'is_active' => true,
            ],
        );

        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password'),
                'phone_number' => '089876543210',
                'address' => 'Jl. Sudirman No. 10',
                'default_city_id' => 501,
                'role' => 'customer',
                'is_active' => true,
            ],
        );

        $this->seedCatalog();
        $variants = ProductVariant::with('product')->get()->keyBy('variant_name');

        $this->seedCart($customer, $variants);
        $this->seedOrder($customer, $admin, $variants);
    }

    private function seedLocations(): void
    {
        $provinces = [
            ['id' => 5, 'name' => 'DI Yogyakarta'],
            ['id' => 6, 'name' => 'DKI Jakarta'],
            ['id' => 9, 'name' => 'Jawa Barat'],
        ];

        foreach ($provinces as $province) {
            Province::updateOrCreate(['id' => $province['id']], $province);
        }

        $cities = [
            ['id' => 501, 'province_id' => 5, 'name' => 'Yogyakarta', 'type' => 'Kota', 'postal_code' => '55222'],
            ['id' => 23, 'province_id' => 5, 'name' => 'Bantul', 'type' => 'Kabupaten', 'postal_code' => '55711'],
            ['id' => 151, 'province_id' => 6, 'name' => 'Jakarta Selatan', 'type' => 'Kota', 'postal_code' => '12110'],
            ['id' => 22, 'province_id' => 9, 'name' => 'Bandung', 'type' => 'Kota', 'postal_code' => '40111'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(['id' => $city['id']], $city);
        }
    }

    /**
     * @return array<string, Category>
     */
    private function seedCatalog(): array
    {
        $categories = [
            'print' => Category::updateOrCreate(
                ['slug' => 'print'],
                ['name' => 'Print', 'slug' => 'print'],
            ),
            'merchandise' => Category::updateOrCreate(
                ['slug' => 'merchandise'],
                ['name' => 'Merchandise', 'slug' => 'merchandise'],
            ),
            'packaging' => Category::updateOrCreate(
                ['slug' => 'packaging'],
                ['name' => 'Packaging', 'slug' => 'packaging'],
            ),
        ];

        $products = [
            [
                'category' => 'print',
                'name' => 'Kartu Nama',
                'slug' => 'kartu-nama',
                'description' => 'Kartu nama custom untuk kebutuhan bisnis dan personal branding.',
                'image_path' => 'products/kartu-nama.jpg',
                'variants' => [
                    ['variant_name' => 'Kartu Nama Art Carton 260gsm', 'price' => 45000, 'weight' => 250],
                    ['variant_name' => 'Kartu Nama Linen Premium', 'price' => 75000, 'weight' => 300],
                ],
            ],
            [
                'category' => 'print',
                'name' => 'Brosur',
                'slug' => 'brosur',
                'description' => 'Brosur promosi full color dengan pilihan lipatan.',
                'image_path' => 'products/brosur.jpg',
                'variants' => [
                    ['variant_name' => 'Brosur A5 1 Sisi', 'price' => 125000, 'weight' => 1000],
                    ['variant_name' => 'Brosur A4 2 Sisi', 'price' => 225000, 'weight' => 1800],
                ],
            ],
            [
                'category' => 'merchandise',
                'name' => 'Kaos Custom',
                'slug' => 'kaos-custom',
                'description' => 'Kaos sablon custom untuk event, komunitas, dan brand.',
                'image_path' => 'products/kaos-custom.jpg',
                'variants' => [
                    ['variant_name' => 'Kaos Cotton Combed Sablon DTF', 'price' => 85000, 'weight' => 220],
                    ['variant_name' => 'Kaos Oversize Sablon DTF', 'price' => 115000, 'weight' => 300],
                ],
            ],
            [
                'category' => 'packaging',
                'name' => 'Paper Bag',
                'slug' => 'paper-bag',
                'description' => 'Paper bag custom untuk kemasan retail dan hampers.',
                'image_path' => 'products/paper-bag.jpg',
                'variants' => [
                    ['variant_name' => 'Paper Bag Kraft Medium', 'price' => 95000, 'weight' => 1200],
                    ['variant_name' => 'Paper Bag Ivory Laminasi', 'price' => 165000, 'weight' => 1500],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                [
                    'category_id' => $categories[$productData['category']]->id,
                    'name' => $productData['name'],
                    'slug' => $productData['slug'],
                    'description' => $productData['description'],
                    'image_path' => $productData['image_path'],
                ],
            );

            foreach ($productData['variants'] as $variant) {
                ProductVariant::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'variant_name' => $variant['variant_name'],
                    ],
                    [
                        'price' => $variant['price'],
                        'weight' => $variant['weight'],
                        'stock_status' => true,
                    ],
                );
            }
        }

        return $categories;
    }

    /**
     * @param  Collection<string, ProductVariant>  $variants
     */
    private function seedCart(User $customer, Collection $variants): void
    {
        $cart = Cart::updateOrCreate(['user_id' => $customer->id], ['user_id' => $customer->id]);

        foreach ([
            'Kartu Nama Linen Premium' => 1,
            'Kaos Cotton Combed Sablon DTF' => 2,
        ] as $variantName => $quantity) {
            CartItem::updateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variants[$variantName]->id,
                ],
                [
                    'quantity' => $quantity,
                    'design_file_path' => "designs/demo-{$variants[$variantName]->id}.pdf",
                    'design_brief' => 'Gunakan warna brand dan pastikan logo terlihat jelas.',
                ],
            );
        }
    }

    /**
     * @param  Collection<string, ProductVariant>  $variants
     */
    private function seedOrder(User $customer, User $admin, Collection $variants): void
    {
        $orderItems = [
            ['variant' => $variants['Kartu Nama Art Carton 260gsm'], 'quantity' => 2],
            ['variant' => $variants['Paper Bag Kraft Medium'], 'quantity' => 1],
        ];

        $shippingCost = 18000;
        $itemsSubtotal = collect($orderItems)->sum(
            fn (array $item): float => (float) $item['variant']->price * $item['quantity'],
        );
        $totalWeight = collect($orderItems)->sum(
            fn (array $item): int => $item['variant']->weight * $item['quantity'],
        );

        $order = Order::updateOrCreate(
            ['order_number' => 'ORD-DEMO-0001'],
            [
                'user_id' => $customer->id,
                'total_amount' => $itemsSubtotal + $shippingCost,
                'current_status' => 'paid',
                'delivery_type' => 'shipping',
                'recipient_name' => $customer->name,
                'recipient_phone' => $customer->phone_number,
                'shipping_address' => $customer->address,
                'shipping_city_id' => $customer->default_city_id,
                'total_weight' => $totalWeight,
                'courier' => 'jne',
                'courier_service' => 'REG',
                'shipping_cost' => $shippingCost,
                'tracking_number' => 'JNE-DEMO-0001',
            ],
        );

        foreach ($orderItems as $item) {
            $variant = $item['variant']->loadMissing('product');

            OrderItem::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                ],
                [
                    'product_name' => $variant->product->name,
                    'variant_name' => $variant->variant_name,
                    'unit_price' => $variant->price,
                    'weight' => $variant->weight,
                    'quantity' => $item['quantity'],
                    'subtotal' => (float) $variant->price * $item['quantity'],
                    'design_file_path' => "designs/order-{$order->id}-{$variant->id}.pdf",
                    'design_brief' => 'Ikuti file desain dari customer.',
                ],
            );
        }

        foreach ([
            ['status' => 'pending', 'notes' => 'Pesanan dibuat oleh customer.'],
            ['status' => 'paid', 'notes' => 'Pembayaran diterima dan pesanan siap diproses.'],
        ] as $history) {
            OrderStatusHistory::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'status' => $history['status'],
                ],
                [
                    'notes' => $history['notes'],
                    'updated_by' => $admin->id,
                ],
            );
        }

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'amount' => $order->total_amount,
                'payment_method' => 'bank_transfer',
                'status' => 'paid',
                'transaction_id' => 'TRX-DEMO-0001',
                'paid_at' => now(),
            ],
        );

        Review::updateOrCreate(
            ['order_id' => $order->id],
            [
                'product_id' => $variants['Kartu Nama Art Carton 260gsm']->product_id,
                'user_id' => $customer->id,
                'rating' => 5,
                'comment' => 'Hasil cetak rapi dan pengiriman cepat.',
                'moderation_status' => 'approved',
            ],
        );
    }
}
