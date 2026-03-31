<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail')]
class ProductDetailPage extends Component
{
    public $slug;
    public $quantity = 1;

    public function mount($slug) {
        $this->slug = $slug;
    }
    
    public function increaseQty() {
        $this->quantity++;
    }

    public function decreaseQty() {
        if($this->quantity > 1){
            $this->quantity--;
        }
    }

    public function addToCart($product_id) 
{
    // Process the dynamic quantity from your component's $quantity property
    $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);

    // Update the Navbar counter
    $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

    // Boutique Style Alert with Quantity Context
    $this->dispatch('swal:alert', 
        icon: 'success', 
        title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Selection Logged</span>',
        html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">' . $this->quantity . ' units have been added to your curated collection.</p>',
        position: 'bottom-end',
        timer: 4000,
        toast: true,
        timerProgressBar: true,
        showConfirmButton: false,
        customClass: [
            'popup' => 'border border-primary/20 bg-background/95 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-primary/5',
            'timerProgressBar' => 'bg-primary/40',
            'icon' => 'border-primary text-primary scale-75'
        ]
    );
}

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ])->layout('components.layouts.app');
    }
}
