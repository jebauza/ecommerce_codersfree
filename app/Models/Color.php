<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    protected $fillable = ['name'];

    /**
     * The products that belong to the Color
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'color_product', 'color_id', 'product_id')
                    ->withPivot('id','color_id','product_id','quantity')
                    ->withTimestamps();
    }

    /**
     * The sizes that belong to the Color
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'color_size', 'color_id', 'size_id')
                    ->withPivot('id','color_id','size_id')
                    ->withTimestamps();
    }
}
