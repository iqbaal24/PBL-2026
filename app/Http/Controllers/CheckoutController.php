<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function form(Product $product)
    {
        $product->load([
            'activeVariants:id,product_id,variant_name,price,weight,stock_status',
        ]);

        abort_if($product->activeVariants->isEmpty(), 404);

        return view('checkout.form', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $product->load([
            'activeVariants:id,product_id,variant_name,price,weight,stock_status',
        ]);

        abort_if($product->activeVariants->isEmpty(), 404);

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:1000',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $unitPrice = $product->starting_price ?? 0;

        $order = (object) [
            'id' => rand(1000, 9999),
            'product' => (object) [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'image_url' => $product->image_url,
                'starting_price' => $unitPrice,
            ],
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'quantity' => $data['quantity'],
            'notes' => $data['notes'] ?? null,
            'total_price' => $unitPrice * $data['quantity'],
        ];

        Session::put('checkout_order', $order);

        return redirect()->route('checkout.payment', $order->id);
    }

    public function payment(int $order)
    {
        $orderSession = Session::get('checkout_order');

        if (! $orderSession) {
            abort(404);
        }

        // Convert to object if array
        if (is_array($orderSession)) {
            $orderSession = (object) $orderSession;
        }

        if ($orderSession->id !== $order) {
            abort(404);
        }

        return view('checkout.payment', ['order' => $orderSession]);
    }

    public function submit(Request $request, int $order)
    {
        $orderSession = Session::get('checkout_order');

        if (! $orderSession) {
            abort(404);
        }

        // Convert to object if array
        if (is_array($orderSession)) {
            $orderSession = (object) $orderSession;
        }

        if ($orderSession->id !== $order) {
            abort(404);
        }

        $request->validate([
            'payment_proof' => 'required|file|image|max:2048',
        ]);

        Session::flash('success', 'Bukti pembayaran berhasil dikirim.');

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('checkout.success');
    }
}
