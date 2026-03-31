<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Attributes\Title;
use Livewire\Component;

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
