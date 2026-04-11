<?php

use App\Http\Controllers\Ecom\ProductController;
use Illuminate\Support\Facades\Route;

// ecom
Route::get('/products', [ProductController::class, 'index']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');