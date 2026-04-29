<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class CatalogController extends Controller
{
    public function index()
    {
        $products = ProductService::all();

        return view('katalog', compact('products'));
    }

    public function show(string $slug)
    {
        $product = ProductService::findBySlug($slug);

        if (! $product) {
            abort(404);
        }

        return view('katalog-detail', ['product' => $product]);
    }
}
