<?php

namespace App\Helpers;

use App\Models\Size;
use App\Models\Product;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;

class Utils
{
    /**
     * Method quantity
     *
     * @param int $productId [explicite description]
     * @param int $colorId [explicite description]
     * @param int $sizeId [explicite description]
     *
     * @return int
     */
    public static function quantity(int $productId, int $colorId = null, int $sizeId = null)
    {
        $product = Product::find($productId);

        if ($sizeId) {
            $size = $product->sizes()->find($sizeId);
            return $size->colors()->find($colorId)->pivot->quantity;
        } elseif ($colorId) {
            return $product->colors()->find($colorId)->pivot->quantity;
        } else {
            return $product->quantity;
        }
    }

    /**
     * Method qty_added
     *
     * @param int $productId [explicite description]
     * @param int $colorId [explicite description]
     * @param int $sizeId [explicite description]
     *
     * @return int
     */
    public static function qty_added(int $productId, int $colorId = null, int $sizeId = null)
    {
        $cartItems = Cart::content();

        $item = $cartItems->where('id', $productId)
                            ->when($colorId, function ($collection) use ($colorId) {
                                return $collection->where('options.color.id', $colorId);
                            })
                            ->when($sizeId, function ($collection) use ($sizeId) {
                                return $collection->where('options.size.id', $sizeId);
                            })
                            ->first();

        return $item ? $item->qty : 0;
    }

    /**
     * Method qty_available
     *
     * @param int $productId [explicite description]
     * @param int $colorId [explicite description]
     * @param int $sizeId [explicite description]
     *
     * @return int
     */
    public static function qty_available(int $productId, int $colorId = null, int $sizeId = null)
    {
        return self::quantity($productId, $colorId, $sizeId) - self::qty_added($productId, $colorId, $sizeId);
    }

    /**
     * Method discount
     *
     * @param Gloudemans\Shoppingcart\CartItem $item
     *
     * @return void
     */
    public static function discount(CartItem $item)
    {
        $product = Product::with('sizes')->find($item->id);
        $colorId = !empty($item->options['color']) ? $item->options['color']['id'] : null;
        $sizeId = !empty($item->options['size']) ? $item->options['size']['id'] : null;

        $qtyAvailable = self::qty_available($product->id, $colorId, $sizeId);

        if ($sizeId && $colorId && ($size = $product->sizes->firstWhere('id', $sizeId))) {
            $size->colors()->updateExistingPivot($colorId, ['quantity' => $qtyAvailable]);
        } elseif ($colorId) {
            $product->colors()->updateExistingPivot($colorId, ['quantity' => $qtyAvailable]);
        } else {
            $product->quantity = $qtyAvailable;
            $product->save();
        }
    }
}
