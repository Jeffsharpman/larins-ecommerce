<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Brand')]
class BrandsPage extends Component
{
    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        return view('livewire.brands-page', [
            'brands' => $brands,
        ])->layout('components.layouts.app');
    }
}
