<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Split::make([
                    Stack::make([
                        Section::make('Order Overview')
                            ->icon('heroicon-m-shopping-bag')
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
                            ])->columns(3),
                    ]),

                    Section::make('Status Timeline')
                        ->headerActions([
                            TextEntry::make('updated_at')
                                ->label('Last Update')
                                ->since()
                                ->color('gray'),
                        ])
                        ->schema([
                            Grid::make(5)->schema([
                                self::statusStep('new', 'Order Placed', 'heroicon-m-shopping-cart'),
                                self::statusStep('processing', 'Processing', 'heroicon-m-cog-6-tooth'),
                                self::statusStep('shipped', 'Shipped', 'heroicon-m-truck'),
                                self::statusStep('delivered', 'Delivered', 'heroicon-m-check-circle'),
                                self::statusStep('cancelled', 'Cancelled', 'heroicon-m-x-circle'),
                            ]),
                        ]),
                ])->columnSpanFull(),

                Split::make([
                    Section::make('Payment Details')
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
                ])->columnSpanFull(),

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

    protected static function statusStep(string $status, string $label, string $icon): array
    {
        return [
            IconEntry::make($status.'_icon')
                ->icon(fn (Order $record) => $record->status === $status ? $icon : 'heroicon-m-minus-circle')
                ->color(fn (Order $record) => self::getStatusColor($record->status, $status))
                ->label(fn (Order $record) => self::getStatusLabel($record->status, $label)),
        ];
    }

    protected static function getStatusColor(string $currentStatus, string $step): string
    {
        $statusOrder = ['new', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($currentStatus, $statusOrder);
        $stepIndex = array_search($step, $statusOrder);

        if ($currentStatus === 'cancelled') {
            return 'danger';
        }

        if ($step === 'cancelled') {
            return $currentStatus === 'cancelled' ? 'danger' : 'gray';
        }

        if ($currentIndex === false || $stepIndex === false) {
            return 'gray';
        }

        if ($stepIndex <= $currentIndex) {
            return 'success';
        }

        if ($stepIndex === $currentIndex + 1) {
            return 'warning';
        }

        return 'gray';
    }

    protected static function getStatusLabel(string $currentStatus, string $label): string
    {
        $statusOrder = ['new', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($currentStatus, $statusOrder);
        $stepIndex = array_search(explode('_', $label)[0] === 'Order' ? 'new' : $label, $statusOrder);

        if ($currentStatus === 'cancelled') {
            return $label;
        }

        if ($currentIndex !== false && $stepIndex !== false && $stepIndex <= $currentIndex) {
            return $label.' ✓';
        }

        return $label;
    }
}
