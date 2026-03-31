<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart')]
class CartPage extends Component
{
    public $cart_items = [];

    public $grand_total;

    public $coupon_code = '';

    public $applied_coupon = null;

    public $discount = 0;

    public $subtotal = 0;

    public $shipping = 0;

    public $tax = 0;

    public $total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->coupon_code = CartManagement::getCouponCode();
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $totals = CartManagement::calculateTotalSummary($this->cart_items);

        $this->subtotal = $totals['subtotal'];
        $this->discount = $totals['discount'];
        $this->shipping = $totals['shipping'];
        $this->tax = $totals['tax'];
        $this->total = $totals['total'];
        $this->grand_total = $this->total;
    }

    public function applyCoupon()
    {
        if (empty($this->coupon_code)) {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Error</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">Please enter a coupon code.</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
                showConfirmButton: false,
            );

            return;
        }

        $result = CartManagement::applyCoupon($this->coupon_code);

        if ($result['success']) {
            $this->applied_coupon = $result['coupon'];
            $this->calculateTotals();
            $this->dispatch('swal:alert',
                icon: 'success',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Coupon Applied</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">'.$result['message'].'</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
                showConfirmButton: false,
            );
        } else {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: '<span class="text-[10px] font-black uppercase tracking-[0.3em] font-sans">Invalid Coupon</span>',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest text-muted-foreground">'.$result['message'].'</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
                showConfirmButton: false,
            );
        }
    }

    public function removeCoupon()
    {
        CartManagement::removeCoupon();
        $this->coupon_code = '';
        $this->applied_coupon = null;
        $this->calculateTotals();
    }

    protected function dispatchUpdate($action = 'recalibrated')
    {
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);

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

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantity($product_id);
        $this->calculateTotals();
        $this->dispatchUpdate('increased');
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantity($product_id);
        $this->calculateTotals();
        $this->dispatchUpdate('decreased');
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->calculateTotals();
        $this->dispatchUpdate('removed');
    }

    public function checkout()
    {
        return $this->redirect('/checkout', navigate: true);
    }

    public function render()
    {
        return view('livewire.cart-page')->layout('components.layouts.app');
    }
}
