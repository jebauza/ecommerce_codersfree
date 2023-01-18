<?php

namespace Database\Factories;

use App\Helpers\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $publicPathDirectory = 'products';

        // $nameImagen = $this->faker->image('public/storage/products', 640, 480, null, false);
        $nameImagen = Image::fake(
            storage_path("app/public/$publicPathDirectory"),
            /** width: */ 640,
            /** height: */ 480,
            /** randomizeColors: */ true,
            /** randomizeTxt: */ true
        );

        return [
            'url' => "$publicPathDirectory/$nameImagen"
        ];
    }
}
