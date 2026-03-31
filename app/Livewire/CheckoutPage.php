<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Pest\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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

    #[Rule('required|string|in:cod,stripe,paystack')]
    public $payment_method = 'cod';

    #[Rule('required|numeric|digits:6')]
    public $zip_code;

    public $selected_shipping_method_id;

    public $shipping_methods = [];

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
            $shippingMethod = $this->shipping_methods->find($this->selected_shipping_method_id);
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

    public function placeOrder()
    {
        $this->validate();

        $cart_items = CartManagement::getCartItemsFromCookie();
        $line_items = [];

        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'ngn',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $order = new Order;
        $order->user_id = auth()->id();
        $order->order_number = 'ORD-'.strtoupper(Str::random(10));
        $order->grand_total = $this->grand_total;
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';

        $shippingMethod = $this->shipping_methods->find($this->selected_shipping_method_id);
        $order->shipping_amount = $this->shipping;
        $order->shipping_method = $shippingMethod?->name ?? 'Standard';
        $order->notes = 'Order placed by '.auth()->user()->name;

        $order->save();

        $redirect_url = '';

        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success', ['order_id' => $order->id]).'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);

            $redirect_url = $sessionCheckout->url;
        } else {
            $redirect_url = route('success', ['order_id' => $order->id]);
        }

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

        CartManagement::clearCartItems();

        Mail::to(request()->user())->send(new OrderPlaced($order));

        return redirect($redirect_url);
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('components.layouts.app');
    }
}
