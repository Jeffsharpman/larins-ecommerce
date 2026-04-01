<?php

namespace App\Filament\Resources\Addresses\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'home' => 'Home',
                        'work_place' => 'Work Place',
                        'other' => 'Other',
                        default => $state,
                    })
                    ->color('primary'),

                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

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

                BadgeColumn::make('is_active')
                    ->label('Default')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                    ->icons([
                        'heroicon-m-check-circle' => true,
                        'heroicon-m-x-circle' => false,
                    ]),

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
                SelectFilter::make('title')
                    ->label('Address Type')
                    ->options([
                        'home' => 'Home',
                        'work_place' => 'Work Place',
                        'other' => 'Other',
                    ]),
                SelectFilter::make('is_active')
                    ->label('Default Address')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No',
                    ]),
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
