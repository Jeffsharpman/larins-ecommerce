<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Services\PaystackService;
use App\Services\StripeService;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Pest\Support\Str;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $cart_items = [];

    public $subtotal = 0;

    public $discount = 0;

    public $shipping = 0;

    public $tax = 0;

    public $grand_total = 0;

    public $coupon_code = '';

    public $applied_coupon = null;

    #[Rule('required|string|min:2|max:50')]
    public $first_name;

    #[Rule('required|string|min:2|max:50')]
    public $last_name;

    #[Rule('required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10')]
    public $phone;

    #[Rule('required|string|min:5|max:255')]
    public $address;

    #[Rule('required|string|min:2|max:100')]
    public $city;

    #[Rule('required|string|min:2|max:100')]
    public $state;

    #[Rule('required|string|in:paystack,stripe')]
    public $payment_method = 'paystack';

    #[Rule('required|numeric|digits:6')]
    public $zip_code;

    public $selected_shipping_method_id;

    /** @var Collection<int, ShippingMethod> */
    public $shipping_methods;

    public $processing_payment = false;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();

        if (count($this->cart_items) == 0) {
            return redirect('/products');
        }

        $this->shipping_methods = ShippingMethod::active()->orderBy('sort_order')->get();

        $this->coupon_code = CartManagement::getCouponCode() ?? '';
        if ($this->coupon_code) {
            $this->applied_coupon = Coupon::where('code', $this->coupon_code)->first();
        }

        $this->selected_shipping_method_id = $this->shipping_methods->where('is_default', true)->first()?->id ?? $this->shipping_methods->first()?->id;

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $totals = CartManagement::calculateTotal($this->cart_items);
        $this->subtotal = $totals['subtotal'];
        $this->discount = $totals['discount'];
        $this->tax = $totals['tax'];

        if ($this->selected_shipping_method_id) {
            $shippingMethod = $this->shipping_methods->firstWhere('id', $this->selected_shipping_method_id);
            if ($shippingMethod) {
                $this->shipping = $this->calculateShippingCost($shippingMethod);
            }
        }

        $this->grand_total = $this->subtotal - $this->discount + $this->shipping + $this->tax;
    }

    public function calculateShippingCost(ShippingMethod $method): float
    {
        if ($method->min_order_amount && $this->subtotal < $method->min_order_amount) {
            return 0;
        }

        if ($method->max_order_amount && $this->subtotal > $method->max_order_amount) {
            return 0;
        }

        return (float) $method->base_cost;
    }

    public function updatedSelectedShippingMethodId()
    {
        $this->calculateTotals();
    }

    public function applyCoupon()
    {
        if (empty($this->coupon_code)) {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Error',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Please enter a coupon code.</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );

            return;
        }

        $result = CartManagement::applyCoupon($this->coupon_code);

        if ($result['success']) {
            $this->applied_coupon = $result['coupon'];
            $this->calculateTotals();
            $this->dispatch('swal:alert',
                icon: 'success',
                title: 'Success',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Coupon applied successfully!</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
            );
        } else {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Error',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">'.$result['message'].'</p>',
                position: 'bottom-end',
                timer: 3000,
                toast: true,
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

    public function processPayment()
    {
        $this->validate();

        $this->processing_payment = true;

        try {
            $cart_items = CartManagement::getCartItemsFromCookie();
            $shippingMethod = $this->shipping_methods->firstWhere('id', $this->selected_shipping_method_id);

            $order = new Order;
            $order->user_id = auth()->id();
            $order->order_number = 'ORD-'.strtoupper(Str::random(10));
            $order->grand_total = $this->grand_total;
            $order->payment_method = $this->payment_method;
            $order->payment_status = 'pending';
            $order->status = 'new';
            $order->shipping_amount = $this->shipping;
            $order->shipping_method = $shippingMethod?->name ?? 'Standard';
            $order->notes = 'Order placed by '.auth()->user()->name;
            $order->save();

            $address = new Address;
            $address->order_id = $order->id;
            $address->first_name = $this->first_name;
            $address->last_name = $this->last_name;
            $address->phone = $this->phone;
            $address->street_address = $this->address;
            $address->city = $this->city;
            $address->state = $this->state;
            $address->zip_code = $this->zip_code;
            $address->save();

            $order->items()->createMany($cart_items);

            if ($this->applied_coupon) {
                $this->applied_coupon->increment('used_count');
            }

            if ($this->payment_method === 'paystack') {
                return $this->processPaystackPayment($order);
            }

            if ($this->payment_method === 'stripe') {
                return $this->processStripePayment($order, $cart_items);
            }

        } catch (\Exception $e) {
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Error',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">An error occurred. Please try again.</p>',
                position: 'bottom-end',
                timer: 5000,
                toast: true,
            );
        } finally {
            $this->processing_payment = false;
        }
    }

    protected function processPaystackPayment(Order $order)
    {
        $paystack = new PaystackService;

        $result = $paystack->initializeTransaction([
            'email' => auth()->user()->email,
            'amount' => $this->grand_total,
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'callback_url' => route('paystack.callback'),
            'currency' => 'NGN',
        ]);

        if ($result['success']) {
            return redirect()->away($result['authorization_url']);
        }

        $order->update(['payment_status' => 'failed']);

        $this->dispatch('swal:alert',
            icon: 'error',
            title: 'Payment Error',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">'.$result['message'].'</p>',
            position: 'bottom-end',
            timer: 5000,
            toast: true,
        );

        return null;
    }

    protected function processStripePayment(Order $order, array $cart_items)
    {
        $stripe = new StripeService;

        $items = array_map(function ($item) {
            return [
                'name' => $item['name'],
                'description' => 'Product purchase',
                'unit_amount' => $item['unit_amount'],
                'quantity' => $item['quantity'],
            ];
        }, $cart_items);

        $result = $stripe->createCheckoutSession([
            'items' => $items,
            'email' => auth()->user()->email,
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'shipping_amount' => $this->shipping,
            'shipping_method' => $order->shipping_method,
            'success_url' => route('stripe.success', ['order_id' => $order->id]).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        if ($result['success']) {
            return redirect()->away($result['url']);
        }

        $order->update(['payment_status' => 'failed']);

        $this->dispatch('swal:alert',
            icon: 'error',
            title: 'Payment Error',
            html: '<p class="text-[9px] font-medium uppercase tracking-widest">'.$result['message'].'</p>',
            position: 'bottom-end',
            timer: 5000,
            toast: true,
        );

        return null;
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('components.layouts.app');
    }
}
