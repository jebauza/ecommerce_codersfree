<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ColorProduct extends Component
{
    use LivewireAlert;

    public $product;
    public $colors;
    public $colorId;
    public $quantity;
    public $modalOpen = false;
    public $modalColorId;
    public $modalColorOldId;
    public $modalQuantity;

    public function mount()
    {
        $this->colors = Color::all();
    }

    public function render()
    {
        $productColors = $this->product->colors;

        return view('livewire.admin.color-product', compact('productColors'));
    }

    public function saveColor()
    {
        $validatedData = $this->validate([
            'colorId' => 'required|integer|in:' . $this->colors->pluck('id')->join(','),
            'quantity' => 'required|integer',
        ]);

        if ($color = $this->product->colors()->where('colors.id', $this->colorId)->first()) {
            // $this->product->colors()->updateExistingPivot($this->colorId, ['quantity' => $this->quantity]);
            $color->pivot->quantity = $this->quantity;
            $color->pivot->save();
        } else {
            $this->product->colors()->attach($this->colorId, ['quantity' => $this->quantity]);
        }

        $this->reset(['colorId', 'quantity']);

        $this->product = $this->product->fresh();

        $this->alert('success', __('The :element was edited successfully.', ['element'=>__('product')]));
    }

    public function showModal(int $colorId)
    {
        $this->product = $this->product->fresh();

        if ($color = $this->product->colors()->where('colors.id', $colorId)->first()) {
            $this->modalColorId = $color->id;
            $this->modalColorOldId = $this->modalColorId;
            $this->modalQuantity = $color->pivot->quantity;
            $this->modalOpen = true;
        }
    }

    public function updateColor()
    {
        if ($this->modalColorOldId != $this->modalColorId) {
            $this->product->colors()->detach($this->modalColorOldId);
        }

        if ($color = $this->product->colors()->where('colors.id', $this->modalColorId)->first()) {
            $color->pivot->quantity = $this->modalQuantity;
            $color->pivot->save();
        } else {
            $this->product->colors()->attach($this->modalColorId, ['quantity' => $this->modalQuantity]);
        }

        $this->product = $this->product->fresh();

        $this->modalOpen = false;

        $this->alert('success', __('The :element was edited successfully.', ['element'=>__('product')]));
    }
}
