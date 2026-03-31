<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Detail')]
class MyOrdersDetailPage extends Component
{
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        // 1. Fetch the single order (not paginated)
        // We add where('user_id', auth()->id()) so users can't see each other's orders
        $order = Order::where('id', $this->order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 2. Fetch ALL items for this specific order
        $order_items = OrderItem::where('order_id', $this->order_id)->get();

        $address = Address::where('order_id', $this->order_id)->first();

        return view('livewire.my-orders-detail-page', [
            'order' => $order,
            'order_items' => $order_items,
            'address' => $address,
        ])->layout('components.layouts.app');
    }
}
