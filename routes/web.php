<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TrackOrderController;

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
Route::post('/track-order/{order}/reviews', [TrackOrderController::class, 'storeReview'])->name('track-order.reviews.store');
Route::get('/track-order/{order}/receipt', [TrackOrderController::class, 'receipt'])->name('track-order.receipt');

Route::get('/katalog', [CatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{product}', [CatalogController::class, 'show'])->name('katalog.show');
