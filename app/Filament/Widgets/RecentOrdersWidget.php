<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentOrdersWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Orders';

    protected function getTableQuery(): Builder
    {
        return Order::query()
            ->with('user')
            ->latest()
            ->limit(8);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('order_number')
                ->label('Order')
                ->searchable()
                ->color('primary'),

            TextColumn::make('user.name')
                ->label('Customer')
                ->searchable()
                ->limit(15),

            TextColumn::make('grand_total')
                ->label('Total')
                ->money('NGN'),

            BadgeColumn::make('status')
                ->label('Status')
                ->color(fn (string $state): string => match ($state) {
                    'new' => 'info',
                    'processing' => 'warning',
                    'shipped' => 'purple',
                    'delivered' => 'success',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),

            TextColumn::make('created_at')
                ->label('Date')
                ->dateTime('M j, g:i A')
                ->sortable(),
        ];
    }
}
