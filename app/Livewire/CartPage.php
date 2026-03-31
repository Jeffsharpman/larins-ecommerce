<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
// use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart')]
class CartPage extends Component
{
    public $cart_items = [];

    public $grand_total;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    protected function dispatchUpdate($action = 'recalibrated')
    {
        // Update the Navbar counter based on the current local array
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);

        // Define the boutique-style messaging
        $title = $action === 'removed' ? 'Collection Updated' : 'Manifest Recalibrated';
        $message = $action === 'removed'
            ? 'The item has been withdrawn from your selection.'
            : 'Your quantities have been successfully adjusted.';

        $this->dispatch('swal:alert',
            icon: 'success',
            title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">'.$title.'</span>',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">'.$message.'</p>',
            position: 'bottom-end',
            timer: 3000,
            toast: true,
            timerProgressBar: true,
            showConfirmButton: false,
            customClass: [
                'popup' => 'border border-primary/20 bg-background/95 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-primary/5',
                'timerProgressBar' => 'bg-primary/40',
                'icon' => 'border-primary text-primary scale-75',
            ]
        );
    }

    // Updated methods to pass context to the alert
    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatchUpdate('increased');
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatchUpdate('decreased');
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatchUpdate('removed');
    }

    public function checkout()
    {
        // Optional: add logic to validate cart here
        return $this->redirect('/checkout', navigate: true);
    }

    public function render()
    {
        return view('livewire.cart-page')->layout('components.layouts.app');
    }
}
