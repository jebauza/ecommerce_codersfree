<?php

namespace App\Http\Livewire;

use App\Helpers\Utils;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItemSize extends Component
{
    public $product, $sizes;
    public $sizeId = '';
    public $colors = [];
    public $colorId = '';
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
            $this->reset(['colorId','qty','quantity']);
        } else {
            $this->reset(['sizeId','colors','colorId','qty','quantity']);
        }
    }

    public function updatedColorId($colorId)
    {
        $this->sizes = $this->product->sizes()->with('colors')->get();

        if ($size = $this->sizes->firstWhere('id', $this->sizeId)) {
            $this->colors = $size->colors;

            if ($color = $this->colors->firstWhere('id', $colorId)) {
                $this->quantity = Utils::qty_available($this->product->id, $color->id, $size->id);
                $this->qty = $this->qty > $this->quantity ? $this->quantity : $this->qty;
            } else {
                $this->reset(['colorId','qty','quantity']);
            }
        } else {
            $this->reset(['sizeId','colors','colorId','qty','quantity']);
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
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 0,
            'options' => [
                'image' => ($imageFirst = $this->product->images->first()) ? Storage::url($imageFirst->url) : null,
                'size' => ($size = $this->sizes->firstWhere('id', $this->sizeId)) ? $size->transform(['id','name','product_id']) : null,
                'color' => ($color = $this->colors->firstWhere('id', $this->colorId)) ? $color->transform(['id','name']) : null
            ]
        ]);

        if ($color && $size) {
            $this->quantity = Utils::qty_available($this->product->id, $color->id, $size->id);
        }

        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    /**
     * Method resetData
     *
     * @param array $nameVariables [explicite description]
     *
     * @return void
     */
    // private function resetData(array $nameVariables): void
    // {
    //     $reset = [
    //         'sizeId' => '',
    //         'colorId' => '',
    //         'colors' => [],
    //         'qty' => 1,
    //         'quantity' => 0,
    //     ];

    //     foreach ($nameVariables as $nVariable) {
    //         if (isset($reset[$nVariable]) && isset($this->$nVariable)) {
    //             $this->$nVariable = $reset[$nVariable];
    //         }
    //     }
    // }
}
