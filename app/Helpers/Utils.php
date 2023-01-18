<?php

namespace App\Helpers;

use App\Models\Product;
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
}
