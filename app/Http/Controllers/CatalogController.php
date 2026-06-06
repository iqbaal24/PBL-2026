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
            ->where('is_active', true)
            ->with([
                'category:id,name,slug',
                'activeVariants:id,product_id,variant_name',
            ])
            ->withAvg(['reviews as visible_reviews_avg_rating' => fn (Builder $query) => $query->where('is_visible', true)], 'rating')
            ->withCount(['reviews as visible_reviews_count' => fn (Builder $query) => $query->where('is_visible', true)])
            ->withCount('orderItems')
            ->when(
                $selectedCategory !== '',
                fn (Builder $query) => $query->whereHas(
                    'category',
                    fn (Builder $categoryQuery) => $categoryQuery->where('slug', $selectedCategory),
                ),
            )
            ->orderByDesc('order_items_count')
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
        abort_unless($product->is_active, 404);

        $product->load([
            'category:id,name,slug',
            'activeVariants:id,product_id,variant_name',
            'activeFinishings:id,product_id,name,description',
            'reviews' => fn ($query) => $query
                ->where('is_visible', true)
                ->latest()
                ->limit(6),
        ]);
        $product->loadAvg(['reviews as visible_reviews_avg_rating' => fn ($query) => $query->where('is_visible', true)], 'rating');
        $product->loadCount(['reviews as visible_reviews_count' => fn ($query) => $query->where('is_visible', true)]);

        return view('katalog-detail', compact('product'));
    }
}
