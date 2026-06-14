<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Wishlist')]
class WishlistPage extends Component
{
    public Collection $wishlistProducts;

    public string $sortBy = 'latest';

    public bool $isMovingToCart = false;

    public ?int $movingProductId = null;

    public function mount()
    {
        $this->wishlistProducts = collect();
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        $this->wishlistProducts = CartManagement::getWishlistProducts();

        if ($this->sortBy === 'price_asc') {
            $this->wishlistProducts = $this->wishlistProducts->sortBy('price');
        } elseif ($this->sortBy === 'price_desc') {
            $this->wishlistProducts = $this->wishlistProducts->sortByDesc('price');
        }
    }

    public function setSortBy(string $sort)
    {
        $this->sortBy = $sort;
        $this->loadWishlist();
    }

    public function moveToCart(int $productId)
    {
        $this->movingProductId = $productId;
        $this->isMovingToCart = true;

        try {
            CartManagement::addItemToCart($productId);
            CartManagement::removeFromWishlist($productId);
            $this->loadWishlist();

            $total_count = count(CartManagement::getCartItemsFromCookie());

            $this->dispatch('cartUpdated', count: $total_count);
            $this->dispatch('wishlistUpdated');
            $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

            $this->dispatch('cart-count-updated', count: $total_count);

            $this->dispatch('swal:alert',
                icon: 'success',
                title: 'Moved to Cart',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Item moved to your bag</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );
        } finally {
            $this->isMovingToCart = false;
            $this->movingProductId = null;
        }
    }

    public function removeFromWishlist(int $productId)
    {
        CartManagement::removeFromWishlist($productId);
        $this->loadWishlist();

        $this->dispatch('wishlistUpdated');

        $this->dispatch('swal:alert',
            icon: 'success',
            title: 'Removed',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">Removed from wishlist</p>',
            position: 'bottom-end',
            timer: 3000,
            toast: true,
        );
    }

    public function clearWishlist()
    {
        CartManagement::clearWishlist();
        $this->loadWishlist();

        $this->dispatch('wishlistUpdated');

        $this->dispatch('swal:alert',
            icon: 'success',
            title: 'Cleared',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">Your wishlist has been cleared</p>',
            position: 'bottom-end',
            timer: 3000,
            toast: true,
        );
    }

    public function getTotalValueProperty(): float|int
    {
        return $this->wishlistProducts->sum('price');
    }

    public function getItemCountProperty(): int
    {
        return $this->wishlistProducts->count();
    }

    public function render()
    {
        return view('livewire.wishlist-page');
    }
}
