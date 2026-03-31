<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry; // New Import
use Filament\Infolists\Components\TextEntry;      // New Import
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Top Header: Identity & Status
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

                // 2. Timeline
                Section::make('Timeline')
                    ->compact()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Placed At')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Last Activity')
                            ->since(),
                    ]),

                // 3. Financials & Logistics
                Section::make()
                    ->columns(2)
                    ->schema([
                        Section::make('Payment Details')
                            ->columnSpan(1)
                            ->icon('heroicon-m-credit-card')
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
                            ->columnSpan(1)
                            ->icon('heroicon-m-truck')
                            ->schema([
                                TextEntry::make('shipping_method')
                                    ->icon('heroicon-m-map-pin'),

                                TextEntry::make('shipping_amount')
                                    ->label('Shipping Cost')
                                    ->money('NGN'),

                                TextEntry::make('notes')
                                    ->placeholder('No customer notes.'),
                                // ->italic(),
                            ]),
                    ]),

                // 4. THE ORDER ITEMS SECTION (The dynamic list of products)
                Section::make('Items Ordered')
                    ->icon('heroicon-m-list-bullet')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            // We use 6 columns now for better distribution
                            ->columns(6)
                            ->schema([
                                // Restyled Image: Smaller and aligned to the left
                                ImageEntry::make('product.images')
                                    ->label('') // Remove label to save vertical space
                                    ->circular()
                                    // DECREASED SIZE: 60x60 is standard for list thumbnails
                                    ->imageHeight(60)
                                    ->imageWidth(60)
                                    // ->ring(1) // Optional subtle ring
                                    ->disk('public')
                                    ->placeholder('No Photo')
                                    ->columnSpan(1) // Takes up 1 of 6 columns
                                    ->alignLeft()
                                    ->state(function ($record) {
                                        $images = $record->product?->images;
                                        if (is_array($images) && count($images) > 0) {
                                            return $images[0];
                                        }

                                        return is_string($images) ? $images : null;
                                    }),

                                // Product Name: Given more space to breathe
                                TextEntry::make('product.name')
                                    ->label('Product Description')
                                    ->weight('bold')
                                    ->color('gray')
                                    // Give name 2 columns so it doesn't wrap immediately
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
