<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class CategoryProducts extends Component
{
    public $category;
    public $products = [];

    public function loadPosts()
    {
        $this->products = $this->category->products->where('status', Product::PUBLISHED)->take(15);

        $this->emit('glider', $this->category->id);
    }

    public function render()
    {
        return view('livewire.category-products');
    }
}
