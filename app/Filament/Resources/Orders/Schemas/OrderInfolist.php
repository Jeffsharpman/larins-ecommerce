<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Overview')
                    ->icon('heroicon-m-shopping-bag')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('order_number')
                            ->label('Order Reference')
                            ->weight('black')
                            ->size('lg')
                            ->color('primary')
                            ->icon('heroicon-m-hashtag'),

                        TextEntry::make('user.name')
                            ->label('Customer')
                            ->icon('heroicon-m-user')
                            ->weight('bold'),

                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'new' => 'info',
                                'processing' => 'warning',
                                'shipped', 'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                    ]),

                Section::make('Payment Details')
                    ->icon('heroicon-m-credit-card')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('grand_total')
                            ->label('Total Amount')
                            ->money('NGN')
                            ->weight('black')
                            ->size('xl')
                            ->color('success'),

                        TextEntry::make('payment_method')
                            ->label('Method')
                            ->badge(),

                        TextEntry::make('payment_status')
                            ->label('Payment Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                default => 'danger',
                            }),
                    ]),

                Section::make('Shipping Details')
                    ->icon('heroicon-m-truck')
                    ->schema([
                        TextEntry::make('shipping_method')
                            ->icon('heroicon-m-map-pin'),

                        TextEntry::make('shipping_amount')
                            ->label('Shipping Cost')
                            ->money('NGN'),

                        TextEntry::make('notes')
                            ->placeholder('No customer notes.'),
                    ]),

                Section::make('Items Ordered')
                    ->icon('heroicon-m-list-bullet')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->columns(6)
                            ->schema([
                                ImageEntry::make('product.images')
                                    ->label('')
                                    ->circular()
                                    ->imageHeight(60)
                                    ->imageWidth(60)
                                    ->disk('public')
                                    ->placeholder('No Photo')
                                    ->columnSpan(1)
                                    ->alignLeft()
                                    ->state(function ($record) {
                                        $images = $record->product?->images;
                                        if (is_array($images) && count($images) > 0) {
                                            return $images[0];
                                        }

                                        return is_string($images) ? $images : null;
                                    }),

                                TextEntry::make('product.name')
                                    ->label('Product Description')
                                    ->weight('bold')
                                    ->color('gray')
                                    ->columnSpan(2),

                                TextEntry::make('quantity')
                                    ->label('Qty')
                                    ->alignCenter()
                                    ->badge()
                                    ->color('gray')
                                    ->columnSpan(1),

                                TextEntry::make('unit_amount')
                                    ->label('Unit Price')
                                    ->money('NGN')
                                    ->columnSpan(1),

                                TextEntry::make('total_amount')
                                    ->label('Subtotal')
                                    ->money('NGN')
                                    ->weight('black')
                                    ->color('primary')
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }
}
