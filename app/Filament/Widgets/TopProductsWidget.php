<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TopProductsWidget extends TableWidget
{
    protected static ?string $heading = 'Top Products';

    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder
    {
        return Product::query()
            ->withSum('orderItems', 'quantity')
            ->orderByDesc('order_items_sum_quantity')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('order_items_sum_quantity')
                ->label('Sold')
                ->sortable()
                ->numeric()
                ->alignCenter(),

            TextColumn::make('name')
                ->label('Product')
                ->searchable()
                ->limit(25),

            TextColumn::make('price')
                ->label('Price')
                ->money('NGN')
                ->sortable(),
        ];
    }
}
