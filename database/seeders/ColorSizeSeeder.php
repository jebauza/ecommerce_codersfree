<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ColorSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = Size::all();
        $colorIds = Color::pluck('id');

        foreach ($sizes as $size) {
            $attachColors = [];
            foreach ($colorIds as $colorId) {
                $attachColors[$colorId] = ['quantity' => random_int(1,10)];
            }
            $size->colors()->attach($attachColors);
        }
    }
}
