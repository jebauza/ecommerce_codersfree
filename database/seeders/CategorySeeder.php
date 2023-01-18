<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Celulares y tablets',
                'slug' => Str::slug('Celulares y tablets'),
                'icon' => '<i class="fa-solid fa-mobile-screen-button"></i>',
            ],
            [
                'name' => 'TV, audio y video',
                'slug' => Str::slug('TV, audio y video'),
                'icon' => '<i class="fa-solid fa-tv"></i>',
            ],
            [
                'name' => 'Consola y videojuegos',
                'slug' => Str::slug('Consola y videojuegos'),
                'icon' => '<i class="fa-solid fa-gamepad"></i>',
            ],
            [
                'name' => 'Computación',
                'slug' => Str::slug('Computación'),
                'icon' => '<i class="fa-solid fa-laptop"></i>',
            ],
            [
                'name' => 'Moda',
                'slug' => Str::slug('Moda'),
                'icon' => '<i class="fa-solid fa-shirt"></i>',
            ]
        ];

        foreach ($categories as $c) {
            $category = Category::factory()->create($c);
            $brands = Brand::factory(4)->create();
            $category->brands()->saveMany($brands);
        }
    }
}
