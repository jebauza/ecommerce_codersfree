<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\EditProduct;
use App\Http\Livewire\Admin\ShowProducts;
use App\Http\Livewire\Admin\CreateProduct;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', ShowProducts::class)->name('admin.home');

Route::prefix('products')->group(function () {
    Route::get('create', CreateProduct::class)->name('admin.products.create');
    Route::get('{product}/edit', EditProduct::class)->name('admin.products.edit');
});
