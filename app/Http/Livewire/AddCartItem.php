<?php

namespace App\Http\Livewire;

use App\Helpers\Utils;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItem extends Component
{
    public $product, $quantity;
    public $qty = 1;

    public function mount()
    {
        $this->quantity = Utils::qty_available($this->product->id);
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

    /**
     * Method addCartItem
     *
     * @return void
     */
    public function addCartItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 0,
            'options' => [
                'image' => ($imageFirst = $this->product->images->first()) ? Storage::url($imageFirst->url) : null,
            ]
        ]);

        $this->quantity = Utils::qty_available($this->product->id);

        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }
}
