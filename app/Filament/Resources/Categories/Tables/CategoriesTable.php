<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Visual Lead: The Brand Logo
                ImageColumn::make('image')
                    ->label('Logo')
                    ->circular() // Round logos look much more modern
                    ->disk('public') 
                    ->defaultImageUrl(url('/images/placeholder.png')) // Fallback for missing images
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
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
