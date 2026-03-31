<?php

namespace App\Filament\Resources\ShippingMethods\Tables;

use App\Models\ShippingMethod;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ShippingMethodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Method')
                    ->searchable()
                    ->sortable(),
                // ->fontWeight('bold'),

                TextColumn::make('code')
                    ->label('Code')
                    ->color('gray')
                    ->fontFamily('mono'),

                TextColumn::make('base_cost')
                    ->label('Cost')
                    ->money('NGN')
                    ->sortable(),

                TextColumn::make('min_order_amount')
                    ->label('Min. Order')
                    ->formatStateUsing(fn (ShippingMethod $record): ?string => $record->min_order_amount
                        ? '₦'.number_format($record->min_order_amount, 2)
                        : 'None')
                    ->sortable(),

                TextColumn::make('deliveryTime')
                    ->label('Delivery')
                    ->sortable(),

                IconColumn::make('is_default')
                    ->label('Default')
                    ->boolean()
                    ->trueIcon('heroicon-m-star')
                    ->falseIcon('heroicon-m-star')
                    ->trueColor('warning')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),

                TernaryFilter::make('is_default')
                    ->label('Default'),
            ])
            ->recordActions([
                ActionGroup::make([
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
