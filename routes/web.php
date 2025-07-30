<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::delete('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
Route::resource('products', ProductController::class);
