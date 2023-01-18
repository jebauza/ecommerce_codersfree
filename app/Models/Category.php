<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name','slug','image','icon'];

    /**
     * Method getRouteKeyName (URL AMIGABLES)
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get all of the subcategories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }

    /**
     * The brands that belong to the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'brand_category', 'category_id', 'brand_id')
                    ->withPivot('id','brand_id','category_id')
                    ->withTimestamps();
    }

    /**
     * Get all of the products for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, Subcategory::class, 'category_id', 'subcategory_id', 'id', 'id');
    }
}
