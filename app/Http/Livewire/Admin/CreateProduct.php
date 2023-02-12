<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CreateProduct extends Component
{
    public $categories;
    public $subcategories = [];
    public $brands = [];
    public $categoryId = '';
    public $subcategory_id = '';
    public $brand_id = '';
    public $name = '';
    public $slug = '';
    public $description = '';
    public $price;
    public $quantity;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.admin.create-product')->layout('layouts.admin');
    }

    public function updatedCategoryId($categoryId)
    {
        $this->categories = Category::with('subcategories','brands')->get();
        if ($category = $this->categories->firstWhere('id', $categoryId)) {
            $this->subcategories = $category->subcategories;
            $this->brands = $category->brands;
        } else {
            $this->reset(['categoryId','subcategories','brands']);
        }
        $this->reset(['subcategory_id','brand_id','quantity']);
    }

    public function updatedSubcategoriId($subcategoryId)
    {
        $this->categories = Category::with('subcategories','brands')->get();
        if ($category = $this->categories->firstWhere('id', $this->categoryId)) {
            $this->subcategories = $category->subcategories;
            $this->brands = $category->brands;
            if (!$subcategory = $this->subcategories->firstWhere('id', $subcategoryId)) {
                $this->reset(['subcategory_id']);
            }
        } else {
            $this->reset(['categoryId','subcategories','brands','subcategory_id','brand_id']);
        }

        $this->reset(['quantity']);
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->subcategory_id);
    }

    public function updatedName($name)
    {
        $this->slug = Str::slug($name);
    }

    public function saveProduct()
    {
        $validatedData = $this->validate([
            'subcategory_id' => 'required|integer|in:' . $this->subcategories->pluck('id')->join(','),
            'brand_id' => 'required|integer|in:' . $this->brands->pluck('id')->join(','),
            'name' => 'required|string',
            'slug' => 'required|unique:products,slug',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => [
                Rule::requiredIf(!empty($this->subcategory) && !$this->subcategory->color && !$this->subcategory->size),
                'nullable',
                'integer'
            ],
        ]);

        $newProduct = new Product($validatedData);
        $newProduct->save();

        return redirect()->route('admin.products.edit', $newProduct);
    }
}
