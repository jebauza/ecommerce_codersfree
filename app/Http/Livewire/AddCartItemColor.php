<?php

namespace App\Http\Livewire;

use App\Helpers\Utils;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

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
            $this->quantity = Utils::qty_available($this->product->id, $color->id);
            $this->qty = $this->qty > $this->quantity ? $this->quantity : $this->qty;
        } else {
            $this->reset(['colorId','qty','quantity']);
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

    /**
     * Method addCartItem
     *
     * @return void
     */
    public function addCartItem()
    {
        // Utils::qty_added(15, 1);
        // Utils::qty_added(15, 3);
        Utils::qty_added(16, 1, 1);

        // dd(Cart::content());


        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 0,
            'options' => [
                'image' => ($imageFirst = $this->product->images->first()) ? $imageFirst->link : null,
                'color' => ($color = $this->colors->firstWhere('id', $this->colorId)) ? $color->transform(['id','name']) : null
            ]
        ]);

        if ($color) {
            $this->quantity = Utils::qty_available($this->product->id, $color->id);
        }

        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }
}
