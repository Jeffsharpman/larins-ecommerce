<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Orders')]
class MyOrdersPage extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.my-orders-page', [
            'orders' => $orders,
        ])->layout('components.layouts.app');
    }
}
