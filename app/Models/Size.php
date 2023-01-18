<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes';

    protected $fillable = ['name','product_id'];

    /**
     * Get the product that owns the Size
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * The colors that belong to the Size
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_size', 'size_id', 'color_id')
                    ->withPivot('id','color_id','size_id','quantity')
                    ->withTimestamps();
    }

    /**
     * Method transform
     *
     * @param array<string> $nameValues [explicite description]
     * @param string $type [explicite description]
     *
     * @return array|object
     */
    public function transform(array $nameValues = [], string $type = 'array')
    {
        $toArray = $this->toArray();
        if (empty($nameValues)) {
            $data = $toArray;
        } else {
            $data = [];
            foreach ($nameValues as $nValue) {
                if (isset($toArray[$nValue])) {
                    $data[$nValue] = $toArray[$nValue];
                }
            }
        }

        switch ($type) {
            case 'object':
                return (object) $data;
                break;

            default:
                return $data;
                break;
        }
    }
}
