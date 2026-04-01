<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Customer Name with a Subtitle (Order Number)
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->description(fn ($record) => $record->order_number) // Shows ID under name
                    ->searchable()
                    ->sortable(),

                // Grand Total with formatting and a summary
                TextColumn::make('grand_total')
                    ->label('Total Amount')
                    ->money('NGN')
                    ->color('success')
                    ->weight('bold')
                    ->sortable()
                    ->summarize(Sum::make()
                        ->label('Total Revenue')
                        ->money('NGN')
                    ),

                // Payment Method as a Badge
                TextColumn::make('payment_method')
                    ->label('Payment')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                // Payment Status with dynamic colors
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                // Interactive Status Column (Change status directly from the table)
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->selectablePlaceholder(false)
                    ->afterStateUpdated(function ($record, $state) {
                        $record->update(['status' => $state]);

                        Notification::make()
                            ->title('Status Updated')
                            ->body('Order status updated to '.ucfirst($state))
                            ->success()
                            ->send();
                    }),

                TextColumn::make('shipping_method')
                    ->label('Shipping')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('payments_status')
                    ->label('Payment')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',
                        'failed' => 'Failed',
                    ]),
            ])
            ->recordActions(
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
