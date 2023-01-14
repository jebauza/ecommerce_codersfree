<?php

namespace Database\Factories;

use App\Helpers\Image;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subcategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $publicPathDirectory = 'subcategories';
        $nameImagen = Image::fake(storage_path("app/public/$publicPathDirectory"), 640, 480, true, true);

        return [
            'image' => "$publicPathDirectory/$nameImagen", // imagen1.jpg
        ];
    }
}
