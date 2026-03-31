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
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Product')
                ->searchable()
                ->limit(30),

            TextColumn::make('stock')
                ->label('Stock')
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
