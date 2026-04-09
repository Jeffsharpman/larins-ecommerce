<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Resources\Products\Widgets\StockAlertWidget;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;       // ← Better for images
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
{
    protected function getHeaderWidgets(): array
    {
        return [
            StockAlertWidget::class,
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1) // default to 1 column on small screens; override per section
            ->components([
                // Main product details – prominent at the top
                Section::make('Product Information')
                    ->description('Core product details')
                    ->collapsible() // optional: allow collapsing
                    ->schema([
                        TextEntry::make('name')
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpanFull(),

                        TextEntry::make('slug')
                            ->weight('bold')
                            ->size('lg')
                            ->columnSpanFull()
                            ->icon('heroicon-o-link')
                            ->color('gray'),
                    ]),

                // Metadata (category, brand, status flags) – side-by-side on larger screens
                Section::make('Metadata & Status')
                    ->columns([
                        'default' => 1,
                        'md' => 2,     // 2 columns on medium+
                        'lg' => 3,     // 3 on large+
                    ])
                    ->schema([
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('brand.name')
                            ->label('Brand')
                            ->badge()
                            ->color('success'),

                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),

                        IconEntry::make('is_featured')
                            ->label('Featured')
                            ->boolean(),

                        IconEntry::make('in_stock')
                            ->label('In Stock')
                            ->boolean(),

                        IconEntry::make('on_sale')
                            ->label('On Sale')
                            ->boolean(),
                    ]),

                Section::make('Visuals & Description')
                    ->columnSpanFull()
                    ->schema([
                        ImageEntry::make('images')
                            ->label('Product Images')
                            ->imageHeight(200)          // or ->imageSize(180) for square
                            ->stacked()                 // recommended for multiple images
                            ->circular()
                            ->ring(2)
                            ->disk('public')
                            ->visibility('public')
                            ->placeholder('No images uploaded')
                            ->columnSpanFull(),

                        TextEntry::make('description')
                            ->label('Description')
                            ->prose()
                            ->markdown()
                            ->placeholder('No description provided')
                            ->columnSpanFull(),
                    ]),

                // Pricing & timestamps – compact row
                Section::make('Pricing & Timestamps')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('price')
                            ->label('Price')
                            ->money('ngn')
                            ->weight('bold')
                            ->size('xl')
                            ->color(fn ($record) => $record->on_sale ? 'danger' : 'success')
                            ->placeholder('-'),

                        TextEntry::make('old_price')
                            ->label('Old Price')
                            ->money('ngn')
                            ->color('danger')
                            ->size('lg')
                            ->placeholder('-'),

                        TextEntry::make('sale_price')
                            ->label('Sale Price')
                            ->money('ngn')
                            ->weight('bold')
                            ->size('xl')
                            ->color('success')
                            ->placeholder('-'),

                        TextEntry::make('total_stock')
                            ->label('Stock')
                            ->numeric()
                            ->suffix(' units')
                            ->badge()
                            ->color(fn ($state) => $state > 5 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
