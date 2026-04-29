<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CatalogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/panduan', function () {
    return view('panduan');
})->name('panduan');

Route::get('/hubungi-kami', function () {
    return view('hubungi-kami');
})->name('hubungi-kami');

Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');

Route::get('/katalog', [CatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{slug}', [CatalogController::class, 'show'])->name('katalog.show');

Route::get('/checkout/form/{product}', [CheckoutController::class, 'form'])->name('checkout.form');
Route::post('/checkout/store/{product}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/submit/{order}', [CheckoutController::class, 'submit'])->name('checkout.submit');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
