<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'home' => 'Home',
                        'work_place' => 'Work Place',
                        'other' => 'Other',
                        default => $state,
                    }),

                TextEntry::make('street_address')
                    ->label('Street Address'),

                TextEntry::make('city')
                    ->label('City'),

                TextEntry::make('state')
                    ->label('State'),

                TextEntry::make('zip_code')
                    ->label('ZIP Code'),

                TextEntry::make('is_active')
                    ->label('Default')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'home' => 'Home',
                        'work_place' => 'Work Place',
                        'other' => 'Other',
                        default => $state,
                    }),

                TextColumn::make('street_address')
                    ->label('Address')
                    ->limit(30),

                TextColumn::make('city')
                    ->label('City'),

                TextColumn::make('state')
                    ->label('State'),

                TextColumn::make('zip_code')
                    ->label('ZIP'),

                BadgeColumn::make('is_active')
                    ->label('Default')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No'),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }
}
