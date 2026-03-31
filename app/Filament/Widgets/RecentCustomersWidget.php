<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentCustomersWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Customers';

    protected static ?int $sort = 4;

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->withCount('orders')
            ->latest()
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Customer')
                ->searchable()
                ->limit(20),

            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->limit(30)
                ->icon('heroicon-m-envelope'),

            BadgeColumn::make('orders_count')
                ->label('Orders')
                ->counts('orders')
                ->color('success'),

            TextColumn::make('created_at')
                ->label('Joined')
                ->dateTime('M j, Y')
                ->sortable(),
        ];
    }
}
