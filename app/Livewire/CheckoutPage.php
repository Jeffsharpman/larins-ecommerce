<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Services\PaystackService;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public $active_address = null;

    #[Rule('required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10')]
    public $phone = '';

    #[Rule('required|string|min:5|max:255')]
    public $address = '';

    #[Rule('required|string|min:2|max:100')]
    public $city = '';

    #[Rule('required|string|min:2|max:100')]
    public $state = '';

    #[Rule('required|string|in:paystack,stripe')]
    public $payment_method = 'paystack';

    #[Rule('nullable|min:5|max:10')]
    public $zip_code = '';

    public $selected_shipping_method_id;

    /** @var Collection<int, ShippingMethod> */
    public $shipping_methods;

    public $processing_payment = false;

    public $no_address_error = false;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();

        if (count($this->cart_items) == 0) {
            return redirect('/products');
        }

        $this->shipping_methods = ShippingMethod::active()->orderBy('sort_order')->get();

        $this->coupon_code = CartManagement::getCouponCode() ?? '';
        if ($this->coupon_code) {
            $this->applied_coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper($this->coupon_code)])->first();
        }

        $this->selected_shipping_method_id = $this->shipping_methods->where('is_default', true)->first()?->id ?? $this->shipping_methods->first()?->id;

        $this->loadActiveAddress();
        $this->calculateTotals();
    }

    public function loadActiveAddress()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->active_address = $user->activeAddress();

            if ($this->active_address) {
                $this->phone = $this->active_address->phone ?? '';
                $this->address = $this->active_address->street_address ?? '';
                $this->city = $this->active_address->city ?? '';
                $this->state = $this->active_address->state ?? '';
                $this->zip_code = $this->active_address->zip_code ?? '';
            } else {
                $this->no_address_error = true;
                $this->phone = $user->phone ?? '';
            }
        }
    }

    public function calculateTotals()
    {
        $this->subtotal = CartManagement::calculateGrandTotal($this->cart_items);

        if ($this->applied_coupon) {
            $this->discount = $this->applied_coupon->calculateDiscount($this->subtotal);
        } else {
            $this->discount = 0;
        }

        $this->tax = CartManagement::getTaxAmount($this->subtotal, $this->discount);

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

    public function updated($property)
    {
        if (str_contains($property, 'shipping')) {
            $this->calculateTotals();
        }
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
            $this->coupon_code = $result['coupon']->code;
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
        $this->discount = 0;
        $this->calculateTotals();
    }

    public function processPayment()
    {
        if (! Auth::check() || ! Auth::user()->activeAddress()) {
            $this->no_address_error = true;
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Address Required',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">Please add a default address in your account before checkout.</p>',
                position: 'bottom-end',
                timer: 5000,
                toast: true,
            );

            return;
        }

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

            // Link to existing default address instead of creating new one
            if ($this->active_address) {
                $this->active_address->update(['order_id' => $order->id]);
                $address = $this->active_address;
            } else {
                // Fallback: create new address (should not happen due to earlier check)
                $address = Address::create([
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'phone' => $this->active_address?->phone ?? auth()->user()->phone ?? '',
                    'street_address' => $this->active_address?->street_address ?? '',
                    'city' => $this->active_address?->city ?? '',
                    'state' => $this->active_address?->state ?? '',
                    'zip_code' => $this->active_address?->zip_code ?? '',
                    'is_active' => false,
                ]);
            }

            $order->items()->createMany($cart_items);

            if ($this->applied_coupon) {
                $this->applied_coupon->increment('used_count');

                CouponUsage::create([
                    'coupon_id' => $this->applied_coupon->id,
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'used_at' => now(),
                ]);
            }

            if ($this->payment_method === 'paystack') {
                return $this->processPaystackPayment($order);
            }

            if ($this->payment_method === 'stripe') {
                return $this->processStripePayment($order, $cart_items);
            }

        } catch (\Exception $e) {
            Log::error('Checkout payment error: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $this->dispatch('swal:alert',
                icon: 'error',
                title: 'Payment Error',
                html: '<p class="text-[9px] font-medium uppercase tracking-widest">'.$e->getMessage().'</p>',
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
            'first_name' => auth()->user()->nameParts()['first'],
            'last_name' => auth()->user()->nameParts()['last'],
            'phone' => $this->active_address?->phone ?? auth()->user()->phone ?? '',
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
            'tax_amount' => $this->tax,
            'shipping_method' => $order->shipping_method,
            'success_url' => route('stripe.success', ['order_id' => $order->id]).'&session_id={CHECKOUT_SESSION_ID}',
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
        return view('livewire.checkout-page', [
            'user' => Auth::user(),
        ])->layout('components.layouts.app');
    }
}
