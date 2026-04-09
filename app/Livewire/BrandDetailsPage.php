<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

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
            ->active()
            ->paginate(12);

        $activeProductsCount = $brand->products()->active()->count();

        return view('livewire.brand-details-page', [
            'brand' => $brand,
            'products' => $products,
            'activeProductsCount' => $activeProductsCount,
        ])->layout('components.layouts.app');
    }
}
