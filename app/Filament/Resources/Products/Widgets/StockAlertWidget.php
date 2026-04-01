<?php

namespace App\Filament\Resources\Products\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StockAlertWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $lowStockCount = Product::where('is_active', true)
            ->where(function ($query) {
                $query->where('stock', '<=', 5)
                    ->orWhereExists(function ($subQuery) {
                        $subQuery->selectRaw(1)
                            ->from('product_variants')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->where('stock', '<=', 5);
                    });
            })->count();

        $outOfStockCount = Product::where('is_active', true)
            ->where(function ($query) {
                $query->where('stock', '<=', 0)
                    ->orWhereExists(function ($subQuery) {
                        $subQuery->selectRaw(1)
                            ->from('product_variants')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->where('stock', '<=', 0);
                    });
            })->count();

        return [
            Stat::make('Low Stock Products', $lowStockCount)
                ->description('Products with stock <= 5')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'warning' : 'success'),

            Stat::make('Out of Stock', $outOfStockCount)
                ->description('Products with no stock')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color($outOfStockCount > 0 ? 'danger' : 'success'),
        ];
    }
}
