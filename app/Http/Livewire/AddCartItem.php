<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItem extends Component
{
    public $product, $quantity;
    public $qty = 1;

    public function mount()
    {
        $this->quantity = $this->product->quantity;
    }

    public function render()
    {
        return view('livewire.add-cart-item');
    }

    /**
     * Method addAndRemoveItem
     *
     * @param string $operator [explicite description]
     *
     * @return void
     */
    public function incrementAndDecrement(string $operator): void
    {
        if ($operator == '+' && $this->qty < $this->quantity) {
            $this->qty++;
        } elseif ($operator == '-' && $this->qty > 1) {
            $this->qty--;
        }
    }
}
