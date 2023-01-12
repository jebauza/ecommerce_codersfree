<?php

namespace App\Models;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Image;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    const DRAFT_COPY = '1'; // BORRADOR
    const PUBLISHED = '2'; // PUBLICADO

    protected $table = 'products';

    protected $guarded = ['id','created_at','updated_at'];

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
     * Scope a query to only include status published.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::PUBLISHED);
    }

    /**
     * Get the subcategory that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    /**
     * Get the brand that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * The colors that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_product', 'product_id', 'color_id')
                    ->withPivot('id','color_id','product_id','quantity')
                    ->withTimestamps();
    }

    /**
     * Get all of the sizes for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class, 'product_id', 'id');
    }

    /**
     * Get all of the images product.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
