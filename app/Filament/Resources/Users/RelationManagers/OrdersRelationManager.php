<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('order_number')
                //     ->required(),
                // TextInput::make('grand_total')
                //     ->numeric(),
                // TextInput::make('payments_method'),
                // TextInput::make('payments_status'),
                // TextInput::make('status')
                //     ->required()
                //     ->default('pending'),
                // TextInput::make('currency'),
                // TextInput::make('shipping_amount')
                //     ->numeric(),
                // TextInput::make('shipping_method'),
                // Textarea::make('notes')
                //     ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
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

                                TextEntry::make('payments_method')
                                    ->label('Method')
                                    ->badge(),

                                TextEntry::make('payments_status')
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_number')
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
                TextColumn::make('payments_method')
                    ->label('Payment')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                // Payment Status with dynamic colors
                TextColumn::make('payments_status')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),

                // Interactive Status Column (Change status directly from the table)
                TextColumn::make('status')
                    ->badge()
                    ->icon(fn (string $state): string => match ($state) {
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-badge',
                        'cancelled' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'success',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
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
