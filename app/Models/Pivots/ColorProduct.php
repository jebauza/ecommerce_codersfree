<?php

namespace App\Models\Pivots;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ColorProduct extends Pivot
{
    protected $table = 'color_product';

    /**
     * Get color that the ColorProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    /**
     * Get color that the ColorProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
