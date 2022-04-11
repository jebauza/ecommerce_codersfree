<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Builder;

class ColorProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::whereHas('subcategory', function (Builder $query) {
            $query->where('color', true)
                    ->where('size', false);
        })->get();

        $colorIds = Color::all()->pluck('id');

        foreach ($products as $product) {
            $data = [];
            foreach ($colorIds as $colorId) {
                $data[$colorId] = [
                    'quantity' => 10
                ];
            }

            $product->colors()->attach($data);
        }
    }
}
