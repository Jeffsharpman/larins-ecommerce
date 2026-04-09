<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Component;

class WishlistButton extends Component
{
    public int $productId;

    public bool $isInWishlist = false;

    protected $listeners = ['wishlistUpdated' => 'checkWishlist'];

    public function mount()
    {
        $this->checkWishlist();
    }

    public function checkWishlist()
    {
        $this->isInWishlist = CartManagement::isInWishlist($this->productId);
    }

    public function toggleWishlist()
    {
        if ($this->isInWishlist) {
            CartManagement::removeFromWishlist($this->productId);
            $this->dispatch('swal:alert',
                icon: 'success',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Removed from favorites</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">Removed from favorites</p>',
                position: 'bottom-end',
                timer: 4000,
                toast: true,
                timerProgressBar: true,
                showConfirmButton: false,
            );
        } else {
            CartManagement::addToWishlist($this->productId);
            $this->dispatch('swal:alert',
                icon: 'success',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Added to favorites</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">Added to favorites</p>',
                position: 'bottom-end',
                timer: 4000,
                toast: true,
                timerProgressBar: true,
                showConfirmButton: false,
            );
        }

        $this->isInWishlist = ! $this->isInWishlist;
        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        return view('components.wishlist-button');
    }
}
