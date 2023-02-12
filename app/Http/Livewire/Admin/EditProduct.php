<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EditProduct extends Component
{
    public $product;
    public $categories;
    public $subcategories = [];
    public $brands = [];
    public $categoryId = '';
    public $slug = '';

    protected $rules = [
        'product.subcategory_id' => 'required|integer',
        'product.brand_id' => 'required|integer',
        'product.name' => 'required|string',
        'product.description' => 'required',
        'product.price' => 'required|numeric',
        'product.quantity' => 'integer',
    ];

    public function mount(Product $product)
    {
        $this->product = $product->fresh(['subcategory.category']);
        $subcategory = $this->product->subcategory;
        $category = $subcategory ? $subcategory->category : null;

        $this->categories = Category::all();
        $this->categoryId = $category ? $category->id : '';
        $this->subcategories = $category ? $category->subcategories : collect([]);
        $this->brands = $category ? $category->brands : collect([]);
        $this->slug = $this->product->slug;
    }

    public function render()
    {
        return view('livewire.admin.edit-product')->layout('layouts.admin');
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->product->subcategory_id);
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

        $this->product->subcategory_id = '';
        $this->product->brand_id = '';
        if (empty($this->subcategory) || $this->subcategory->color || $this->subcategory->size) {
            $this->product->quantity = '';
        }
    }

    public function updatedProductSubcategoriId($subcategoryId)
    {
        $this->categories = Category::with('subcategories','brands')->get();
        if ($category = $this->categories->firstWhere('id', $this->categoryId)) {
            $this->subcategories = $category->subcategories;
            $this->brands = $category->brands;
            if (!$subcategory = $this->subcategories->firstWhere('id', $subcategoryId)) {
                $this->product->subcategory_id = '';
            }
        } else {
            $this->reset(['categoryId','subcategories','brands']);
            $this->product->subcategory_id = '';
            $this->product->brand_id = '';
        };

        if (empty($this->subcategory) || $this->subcategory->color || $this->subcategory->size) {
            $this->product->quantity = '';
        }
    }

    public function updatedProductName($name)
    {
        $this->slug = Str::slug($name);
    }

    public function saveProduct()
    {
        $validatedData = $this->validate([
            'product.subcategory_id' => 'required|integer|in:' . $this->subcategories->pluck('id')->join(','),
            'product.brand_id' => 'required|integer|in:' . $this->brands->pluck('id')->join(','),
            'product.name' => 'required|string',
            'slug' => 'required|unique:products,slug,' . $this->product->id,
            'product.description' => 'required',
            'product.price' => 'required|numeric',
            'product.quantity' => [
                Rule::requiredIf(!empty($this->subcategory) && !$this->subcategory->color && !$this->subcategory->size),
                'nullable',
                'integer'
            ],
        ]);

        $this->product->slug = $validatedData['slug'];
        $this->product->save();

        $this->emit('saved');
    }
}
