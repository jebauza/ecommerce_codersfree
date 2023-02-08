<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        if (auth()->check()) {
            if ($countPending = auth()->user()->orders()->pending()->count()) {
                // session()->flash('flash.bannerStyle', 'danger');
                $message = __('You have :count orders pending payment. <a class="font-bold" href="'.route('orders.index', ['status'=>Order::STATUS_PENDING]).'">'.__('Go pay').'</a>', ['count'=>($countPending > 1 ? $countPending : '')]);
                session()->flash('flash.banner', $message);
            }
        }

        $categories = Category::with('products.images')->get();

        return view('welcome', compact('categories'));
    }
}
