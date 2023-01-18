<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShoppingCart extends Component
{
    protected $listeners = ['render'];

    public function render()
    {
        return view('livewire.shopping-cart');
    }

    /**
     * Method destroy
     *
     * @return void
     */
    public function destroy()
    {
        Cart::destroy();

        $this->emitTo('dropdown-cart', 'render');
    }

    /**
     * Method destroy
     *
     * @return void
     */
    public function delete(string $rowId)
    {
        Cart::remove($rowId);

        $this->emitTo('dropdown-cart', 'render');
    }
}
