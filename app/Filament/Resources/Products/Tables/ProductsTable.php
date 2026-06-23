<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Primary Info: Name + Slug + Image
                // If you have a 'images' field, consider adding an ImageColumn here!
                TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->slug), // Keeps the table narrow by stacking

                // 2. Categories & Brands as Badges
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('brand.name')
                    ->label('Brand')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                ImageColumn::make('images')
                    ->circular(),

                // In ProductResource.php
                TextColumn::make('total_inventory')
                    ->label('Total Stock')
                    ->numeric()
                    ->sortable() // Now you can sort products by their total variant stock!
                    ->badge()
                    ->color(fn ($state) => $state > 5 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                    ->suffix(' units'),

                // 3. Pricing: Colored and formatted
                TextColumn::make('price')
                    ->money('NGN')
                    ->color('gray')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('old_price')
                    ->money('NGN')
                    ->color('danger')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sale_price')
                    ->money('NGN')
                    ->color('success')
                    ->weight('bold')
                    ->sortable(),

                // 4. Status Group: Using different icons/colors for each state
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->toggleable(),

                IconColumn::make('in_stock')
                    ->label('In Stock')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-s-star') // Solid star for featured
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->toggleable(),

                IconColumn::make('on_sale')
                    ->label('Sale')
                    ->boolean()
                    ->trueIcon('heroicon-o-tag')
                    ->trueColor('danger')
                    ->toggleable(),

                // 5. Timestamps
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Added useful filters for a product store
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('brand')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('in_stock')
                    ->label('Stock Status'),

                TernaryFilter::make('on_sale')
                    ->label('Discounted Items'),
            ])
            ->recordActions(
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]))
            ->toolbarActions([
                ActionGroup::make([
                    ExportAction::make()
                        ->exporter(ProductExporter::class),
                    ImportAction::make()
                        ->importer(ProductImporter::class),
                ]),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
