<?php

use App\Http\Controllers\Ecom\CartController;
use App\Http\Controllers\Ecom\ProductController;
use Illuminate\Support\Facades\Route;

// ecom
// --- product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{slug}', [ProductController::class, 'show']);
// --- cart
Route::get('/cart', [CartController::class, 'cart']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::delete('/cart/decrement', [CartController::class, 'decrement']);
Route::delete('/cart/removeItem', [CartController::class, 'removeItem']);
Route::delete('/cart/removeCart', [CartController::class, 'removeCart']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');