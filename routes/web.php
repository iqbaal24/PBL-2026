<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TrackOrderController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/panduan', function () {
    return view('panduan');
})->name('panduan');

Route::get('/hubungi-kami', function () {
    return view('hubungi-kami');
})->name('hubungi-kami');

Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track-order');
Route::post('/track-order', [TrackOrderController::class, 'show'])->name('track-order.lookup');
Route::get('/track-order/{order}/receipt', [TrackOrderController::class, 'receipt'])->name('track-order.receipt');

Route::get('/keranjang', function () {
    return redirect()->route('katalog.index');
})->name('keranjang');

Route::get('/katalog', [CatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{product}', [CatalogController::class, 'show'])->name('katalog.show');

Route::get('/checkout/form/{product}', function (Product $product) {
    return redirect()->route('katalog.show', $product);
})->name('checkout.form');

Route::post('/checkout/store/{product}', function (Product $product) {
    return redirect()->route('katalog.show', $product);
})->name('checkout.store');

Route::get('/checkout/payment/{order}', function () {
    return redirect()->route('panduan');
})->name('checkout.payment');

Route::post('/checkout/submit/{order}', function () {
    return redirect()->route('panduan');
})->name('checkout.submit');

Route::get('/checkout/success', function () {
    return redirect()->route('track-order');
})->name('checkout.success');
