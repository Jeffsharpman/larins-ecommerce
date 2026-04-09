<?php

namespace App\Observers;

use App\Mail\OrderPlaced;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    public function created(Order $order): void
    {
        $this->deductStock($order);

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderPlaced($order));

                Log::info('Order placed email sent', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'user_email' => $order->user->email,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send order placed email', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function updating(Order $order): void
    {
        if ($order->isDirty('status')) {
            $previousStatus = $order->getOriginal('status');
            $newStatus = $order->status;

            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(
                        new OrderStatusUpdated($order, $previousStatus, $newStatus)
                    );

                    Log::info('Order status update email sent', [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'previous_status' => $previousStatus,
                        'new_status' => $newStatus,
                        'user_email' => $order->user->email,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send order status update email', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage(),
                ]);
            }

            if ($newStatus === 'refunded' && $previousStatus !== 'refunded') {
                $this->restoreStock($order);
            }
        }
    }

    protected function deductStock(Order $order): void
    {
        $order->load('items');

        foreach ($order->items as $item) {
            Product::deductStockForOrderItem($item->product_id, $item->quantity);

            Log::info('Stock deducted for order item', [
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }
    }

    protected function restoreStock(Order $order): void
    {
        $order->load('items');

        foreach ($order->items as $item) {
            Product::restoreStockForOrderItem($item->product_id, $item->quantity);

            Log::info('Stock restored for order item', [
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }
    }
}
