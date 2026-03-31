<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
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
    public $grand_total;

    #[Rule('required|string|min:2|max:50')]
    public $first_name;

    #[Rule('required|string|min:2|max:50')]
    public $last_name;

    // Use regex to ensure it's a valid Nigerian format
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

    public function mount(){
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        if(count($this->cart_items) == 0){
            return redirect('/products');
        }
    }

    public function placeOrder()
    {
        $this->validate();

        $cart_items = CartManagement::getCartItemsFromCookie();
        $line_items = [];

        // 1. Prepare Stripe Line Items
        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'ngn',
                    'unit_amount' => $item['unit_amount'] * 100, // Stripe uses kobo/cents
                    'product_data' => [
                        'name' => $item['name'],
                    ]
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // 2. Initialize the Order (Don't save yet, we need the total)
        $order = new Order();
        $order->user_id = auth()->id();
        $order->order_number = 'ORD-' . strtoupper(Str::random(10));
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        // $order->currency = 'NGN';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order placed by ' . auth()->user()->name;

        // 3. Save to Database (In order: Order -> Address -> Items)
        $order->save();

        $redirect_url = '';

        // 4. Handle Stripe Logic
        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $sessionCheckout = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items, // <--- Added the items
                'mode' => 'payment',         // <--- Added the mode
                'success_url' => route('success', ['order_id' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);
            
            $redirect_url = $sessionCheckout->url;
        } else {
            $redirect_url = route('success', ['order_id' => $order->id]);
        }

        $address = new Address();
        $address->order_id = $order->id; // Now the ID exists!
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;
        $address->save();

        // Ensure your Order model has the items() relationship
        $order->items()->createMany($cart_items);

        CartManagement::clearCartItems();

        Mail::to(request()->user())->send(new OrderPlaced($order));
        return redirect($redirect_url);
    }
    
    public function render()
    {
        return view('livewire.checkout-page')->layout('components.layouts.app');
    }
}