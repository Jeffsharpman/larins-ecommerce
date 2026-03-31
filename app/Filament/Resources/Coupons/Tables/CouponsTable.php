<?php

namespace App\Filament\Resources\Coupons\Tables;

use App\Models\Coupon;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    // ->fontWeight('bold')
                    ->color('primary'),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'percentage' ? 'Percentage' : 'Fixed')
                    ->color(fn (string $state): string => $state === 'percentage' ? 'info' : 'warning'),

                TextColumn::make('value')
                    ->label('Value')
                    ->formatStateUsing(fn (Coupon $record): string => $record->type === 'percentage'
                        ? $record->value.'%'
                        : '₦'.number_format($record->value, 2))
                    ->sortable(),

                TextColumn::make('usage_limit')
                    ->label('Usage')
                    ->formatStateUsing(fn (Coupon $record): string => $record->usage_limit
                        ? "{$record->used_count} / {$record->usage_limit}"
                        : "{$record->used_count} / ∞")
                    ->sortable(),

                TextColumn::make('min_order_amount')
                    ->label('Min. Order')
                    ->formatStateUsing(fn (Coupon $record): ?string => $record->min_order_amount
                        ? '₦'.number_format($record->min_order_amount, 2)
                        : 'None')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->color(fn (Coupon $record): string => $record->expires_at?->isPast() ? 'danger' : 'gray'),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),

                SelectFilter::make('type')
                    ->label('Discount Type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
