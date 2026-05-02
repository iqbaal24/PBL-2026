<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = $request->string('kategori')->toString();

        $products = Product::query()
            ->with([
                'category:id,name,slug',
                'activeVariants:id,product_id,variant_name,price,weight,stock_status',
            ])
            ->when(
                $selectedCategory !== '',
                fn (Builder $query) => $query->whereHas(
                    'category',
                    fn (Builder $categoryQuery) => $categoryQuery->where('slug', $selectedCategory),
                ),
            )
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()
            ->select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();

        return view('katalog', compact('products', 'categories', 'selectedCategory'));
    }

    public function show(Product $product): View
    {
        $product->load([
            'category:id,name,slug',
            'activeVariants:id,product_id,variant_name,price,weight,stock_status',
        ]);

        return view('katalog-detail', compact('product'));
    }
}
