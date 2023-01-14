<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemSize extends Component
{
    public $product, $sizes;

    public function mount()
    {
        $this->sizes = $this->product->sizes;
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}
