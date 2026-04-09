<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class OrderItemObserver
{
    public function created(OrderItem $orderItem): void
    {
        if ($orderItem->order && $orderItem->order->status !== 'refunded') {
            Product::deductStockForOrderItem($orderItem->product_id, $orderItem->quantity);

            Log::info('Stock deducted for order item', [
                'order_item_id' => $orderItem->id,
                'order_id' => $orderItem->order_id,
                'product_id' => $orderItem->product_id,
                'quantity' => $orderItem->quantity,
            ]);
        }
    }

    public function deleted(OrderItem $orderItem): void
    {
        Product::restoreStockForOrderItem($orderItem->product_id, $orderItem->quantity);

        Log::info('Stock restored for deleted order item', [
            'order_item_id' => $orderItem->id,
            'order_id' => $orderItem->order_id,
            'product_id' => $orderItem->product_id,
            'quantity' => $orderItem->quantity,
        ]);
    }
}
