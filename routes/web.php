<?php

use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\PaymentOrder;
use App\Http\Livewire\ShoppingCart;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', WelcomeController::class);

Route::get('search', SearchController::class)->name('search');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');

Route::prefix('orders')->middleware(['auth'])->group(function () {
    Route::get('create', CreateOrder::class)->name('orders.create');
    Route::get('{order}/payment', PaymentOrder::class)->name('orders.payment');
    Route::get('{order}/show', [OrderController::class, 'show'])->name('orders.show');
    Route::get('{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
});

Route::post('webhooks', 'UserProfileController@show')->name('profile');

// Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
