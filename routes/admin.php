<?php

use Illuminate\Support\Facades\Route;
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
    Route::get('{product}/edit', ShowProducts::class)->name('admin.products.edit');
    Route::get('create', CreateProduct::class)->name('admin.products.create');
});
