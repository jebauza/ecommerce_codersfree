<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryFilter extends Component
{
    use WithPagination;

    public $category, $searchSubcategoryId, $searchBrandId;
    public $view = 'grid';

    public function render()
    {
        $products = $this->category->products()
                                    ->published()
                                    ->when($this->searchSubcategoryId, function (Builder $query) {
                                        return $query->where('products.subcategory_id', $this->searchSubcategoryId);
                                    })
                                    ->when($this->searchBrandId, function (Builder $query) {
                                        return $query->where('products.brand_id', $this->searchBrandId);
                                    })
                                    ->paginate(20);

        return view('livewire.category-filter', compact('products'));
    }

    /**
     * Method clear
     *
     * @return void
     */
    public function clear()
    {
        $this->reset(['searchSubcategoryId', 'searchBrandId']);
    }
}
