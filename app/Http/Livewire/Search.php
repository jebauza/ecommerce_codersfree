<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Search extends Component
{
    public $search;
    public $open = false;

    public function render()
    {
        $products = !$this->search ? collect([]) : Product::with('category')
                                                            ->published()
                                                            ->search($this->search)
                                                            ->take(10)
                                                            ->get();

        return view('livewire.search', compact('products'));
    }

    public function updatedSearch($search)
    {
        $this->open = !empty($search);
    }
}
