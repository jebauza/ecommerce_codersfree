<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemColor extends Component
{
    public $product, $colors;
    public $colorId = '';
    public $qty = 1;
    public $quantity = 0;

    public function mount()
    {
        $this->colors = $this->product->colors;
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }

    public function updatedColorId($colorId)
    {
        $this->colors = $this->product->colors()->get();

        if ($color = $this->colors->firstWhere('id', $colorId)) {
            $this->quantity = $color->pivot->quantity;
            $this->qty = $this->qty > $this->quantity ? $this->quantity : $this->qty;
        }
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
