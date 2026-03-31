<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersByStatusWidget extends ChartWidget
{
    protected ?string $heading = 'Orders by Status';

    protected function getData(): array
    {
        $statuses = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[] = Order::where('status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => [
                        '#3b82f6', // new - blue
                        '#f59e0b', // processing - amber
                        '#8b5cf6', // shipped - purple
                        '#10b981', // delivered - green
                        '#ef4444', // cancelled - red
                    ],
                ],
            ],
            'labels' => ['New', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
