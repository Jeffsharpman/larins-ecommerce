<?php

namespace App\Filament\Resources\Products\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StockAlertWidget extends StatsOverviewWidget
{
    protected function getStats(): array
{
    $lowStockCount = \App\Models\Product::whereHas('variants', function ($query) {
        $query->where('stock', '<=', 5); // Adjust threshold as needed
    })->count();

    return [
        Stat::make('Low Stock Products', $lowStockCount)
            ->description('Products with variants running low')
            ->descriptionIcon('heroicon-m-exclamation-triangle')
            ->color($lowStockCount > 0 ? 'danger' : 'success'),
    ];
}
}
