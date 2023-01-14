<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemSize extends Component
{
    public $product, $sizes;
    public $sizeId = '';
    public $colorId = '';
    public $colors = [];
    public $qty = 1;
    public $quantity = 0;

    public function mount()
    {
        $this->sizes = $this->product->sizes;
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }

    public function updatedSizeId($sizeId)
    {
        $this->sizes = $this->product->sizes()->with('colors')->get();

        if ($size = $this->sizes->firstWhere('id', $sizeId)) {
            $this->colors = $size->colors;
            $this->colorId = '';
            $this->qty = 1;
            $this->quantity = 0;
        } else {
            $this->sizeId = '';
            $this->colors = [];
        }
    }

    public function updatedColorId($colorId)
    {
        $this->sizes = $this->product->sizes()->with('colors')->get();

        if ($size = $this->sizes->firstWhere('id', $this->sizeId)) {
            $this->colors = $size->colors;

            if ($color = $this->colors->firstWhere('id', $colorId)) {
                $this->quantity = $color->pivot->quantity;
                $this->qty = $this->qty > $this->quantity ? $this->quantity : $this->qty;
            } else {
                $this->colorId = '';
                $this->qty = 1;
                $this->quantity = 0;
            }
        } else {
            $this->sizeId = '';
            $this->colors = [];
            $this->qty = 1;
            $this->quantity = 0;
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
