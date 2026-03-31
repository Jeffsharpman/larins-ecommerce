<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            // 1. New Orders - High Priority (Warning/Info)
            Stat::make('New Orders', Order::where('status', 'new')->count())
                ->description('Waiting to start')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info')
                ->chart([5, 10, 8, 12, 7, 15])
                ->icon('heroicon-m-sparkles'),

            // 2. Processing - Active Work (Orange/Warning)
            Stat::make('Processing', Order::where('status', 'processing')->count())
                ->description('In the kitchen/warehouse')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning')
                ->chart([2, 4, 3, 6, 4, 8])
                ->icon('heroicon-m-cog-6-tooth'),

            // 3. Shipped - Progressing (Success/Green)
            Stat::make('Shipped', Order::where('status', 'shipped')->count())
                ->description('Out for delivery')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success')
                ->chart([15, 12, 18, 14, 20, 25])
                ->icon('heroicon-m-rocket-launch'),

            // 4. Average Ticket Size (Calculated)
            Stat::make('Average Order', '₦'.number_format(Order::avg('grand_total') ?? 0, 2))
                ->description('Per customer spend')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color('gray')
                ->icon('heroicon-m-calculator'),

            // 5. Total Revenue - The Big Goal
            Stat::make('Total Revenue', '₦'.number_format(Order::sum('grand_total'), 2))
                ->description('Total earnings to date')
                ->descriptionIcon('heroicon-m-arrow-trending-up') // Updated Name            ->color('success')
                ->icon('heroicon-m-banknotes'),
        ];
    }
}
