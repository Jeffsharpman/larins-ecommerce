<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Category Details')]
class CategoryDetailsPage extends Component
{
    use WithPagination;

    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $category = Category::where('slug', $this->slug)->where('is_active', true)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);

        return view('livewire.category-details-page', [
            'category' => $category,
            'products' => $products,
        ])->layout('components.layouts.app');
    }
}
