<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Success')]
class SuccessPage extends Component
{
    #[Url()]
    public $session_id;

    public $order;

    public $order_items;

    public function render()
    {
        $latest_order = Order::with('address')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        if (! $latest_order) {
            return view('livewire.success-page', [
                'order' => null,
                'order_items' => collect(),
            ])->layout('components.layouts.app');
        }

        $this->order = $latest_order;
        $this->order_items = OrderItem::where('order_id', $latest_order->id)->with('product')->get();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session_info = Session::retrieve($this->session_id);

            if ($session_info->payment_status != 'paid') {
                $latest_order->payment_status = 'failed';
                $latest_order->save();

                return redirect()->route('cancel');
            } else {
                $latest_order->payment_status = 'paid';
                $latest_order->save();
            }
        }

        return view('livewire.success-page', [
            'order' => $latest_order,
            'order_items' => $this->order_items,
        ])->layout('components.layouts.app');
    }
}
