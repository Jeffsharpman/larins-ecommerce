<?php

namespace App\Filament\Resources\Categories\Tables;

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
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Visual Lead: The Category Image
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->label('Image')
                    ->circular()
                    ->conversion('thumb')
                    ->toggleable(),

                // 2. Primary Data: Name with Slug as a subtitle
                TextColumn::make('name')
                    ->label('Brand')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->slug), // Puts the slug neatly under the name

                // 3. Status: Using a Checkmark with custom colors
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                // 4. Timestamps: Using "Since" for better readability
                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Activity')
                    ->since() // Shows "2 days ago" instead of raw numbers
                    ->color('gray')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // A clean "Three-state" filter for Active status
                TernaryFilter::make('is_active')
                    ->label('Visibility')
                    ->placeholder('All Brands')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only')
                    ->native(false), // Makes it a nice dropdown instead of a radio list
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
