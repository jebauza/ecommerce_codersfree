<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        $categories = Category::with('subcategories')->get();

        return view('livewire.navigation', compact('categories'));
    }
}
