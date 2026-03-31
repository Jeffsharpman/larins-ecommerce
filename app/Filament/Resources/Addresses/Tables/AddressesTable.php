<?php

namespace App\Filament\Resources\Addresses\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->fontWeight('bold'),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->tel(),

                TextColumn::make('street_address')
                    ->label('Address')
                    ->limit(30),

                TextColumn::make('city')
                    ->label('City')
                    ->sortable(),

                TextColumn::make('state')
                    ->label('State')
                    ->sortable(),

                TextColumn::make('zip_code')
                    ->label('ZIP')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->label('Filter by State')
                    ->searchable(),
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
