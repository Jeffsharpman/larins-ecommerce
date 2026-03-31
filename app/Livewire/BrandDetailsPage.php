<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Brand Details')]
class BrandDetailsPage extends Component
{
    use WithPagination;

    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $brand = Brand::where('slug', $this->slug)->firstOrFail();
        
        $products = $brand->products()
            ->where('is_active', true)
            ->paginate(12);

        return view('livewire.brand-details-page', [
            'brand' => $brand,
            'products' => $products,
        ])->layout('components.layouts.app');
    }
}
