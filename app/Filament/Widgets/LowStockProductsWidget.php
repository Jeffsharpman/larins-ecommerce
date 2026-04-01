<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LowStockProductsWidget extends TableWidget
{
    protected static ?string $heading = 'Low Stock Alert';

    protected function getTableQuery(): Builder
    {
        return Product::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('stock', '<=', 10)
                    ->orWhereExists(function ($subQuery) {
                        $subQuery->selectRaw(1)
                            ->from('product_variants')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->where('stock', '<=', 10);
                    });
            })
            ->orderByRaw('CASE 
                WHEN (SELECT SUM(stock) FROM product_variants WHERE product_id = products.id) > 0 
                THEN (SELECT SUM(stock) FROM product_variants WHERE product_id = products.id) 
                ELSE products.stock END ASC')
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Product')
                ->searchable()
                ->limit(30),

            TextColumn::make('total_inventory')
                ->label('Total Stock')
                ->sortable()
                ->color(fn (int $state): string => $state <= 5 ? 'danger' : 'warning'),

            TextColumn::make('price')
                ->label('Price')
                ->money('NGN'),

            IconColumn::make('in_stock')
                ->label('In Stock')
                ->boolean()
                ->trueIcon('heroicon-m-check-circle')
                ->falseIcon('heroicon-m-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),
        ];
    }
}
