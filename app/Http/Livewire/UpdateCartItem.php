<?php

namespace App\Http\Livewire;

use App\Helpers\Utils;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class UpdateCartItem extends Component
{
    public $rowId, $qty, $quantity;

    public function mount()
    {
        $itemCart = Cart::get($this->rowId);
        $this->qty = $itemCart->qty;

        if (!empty($itemCart->options['size'])) {
            $this->quantity = Utils::qty_available($itemCart->id, $itemCart->options['color']['id'], $itemCart->options['size']['id']);
        } elseif (!empty($itemCart->options['color'])) {
            $this->quantity = Utils::qty_available($itemCart->id, $itemCart->options['color']['id']);
        } else {
            $this->quantity = Utils::qty_available($itemCart->id);
        }
    }

    public function render()
    {
        return view('livewire.update-cart-item');
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

        Cart::update($this->rowId, $this->qty);
        $this->emit('render');
    }
}
