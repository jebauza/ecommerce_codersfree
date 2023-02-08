<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url','imageable_id','imageable_type'];

    /**
     * Get link imagen.
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        return Storage::exists($this->url) ? Storage::url($this->url) : asset('img/image-does-not-exist.jpg');
    }

    /**
     * Get the parent imageable model (product).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
