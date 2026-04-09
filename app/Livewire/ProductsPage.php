<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $is_featured;

    #[Url]
    public $on_sale;

    #[Url]
    public $price_range = 5000000;

    #[Url]
    public $sort = 'latest';

    public function addToCart($product_id)
    {
        $result = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $result['count'])->to(Navbar::class);

        if ($result['success']) {
            $this->dispatch('swal:alert',
                icon: 'success',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Acquisition Confirmed</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">The item has been added to your curated collection.</p>',
                position: 'bottom-end',
                timer: 4000,
                toast: true,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: [
                    'popup' => 'border border-primary/20 bg-background/95 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-primary/5',
                    'timerProgressBar' => 'bg-primary/40',
                    'icon' => 'border-primary text-primary scale-75',
                ]
            );
        } else {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Unable to Add</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">'.$result['message'].'</p>',
                position: 'bottom-end',
                timer: 4000,
                toast: true,
                timerProgressBar: true,
                showConfirmButton: false,
            );
        }
    }

    public function resetFilters()
    {
        $this->reset(['selected_categories', 'selected_brands', 'price_range', 'sort', 'is_featured', 'on_sale']);

        $this->resetPage();
    }

    public function render()
    {
        $productQuery = Product::active();

        if (! empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if (! empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }

        if ($this->is_featured) {
            $productQuery->where('is_featured', true);
        }

        if ($this->on_sale) {
            $productQuery->where('on_sale', true);
        }

        if ($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        if ($this->sort == 'latest') {
            $productQuery->latest();
        }

        if ($this->sort == 'price') {
            $productQuery->orderBy('price');
        }

        return view('livewire.products-page', [
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
            'products' => $productQuery->paginate(9),
        ])->layout('components.layouts.app');
    }
}
