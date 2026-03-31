<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('city'),
                TextInput::make('state'),
                TextInput::make('zip_code'),
                Textarea::make('street_address')
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Use a clean, borderless layout for the modal
                Section::make('Shipping Details')
                    ->description('Delivery destination and recipient contact information.')
                    ->icon('heroicon-m-truck')
                    ->columnSpanFull() // Makes the section fill the entire modal width
                    ->columns(2)      // Internal grid for the fields below
                    ->schema([

                        // 1. Recipient Row (Split into 2 columns)
                        TextEntry::make('fullname')
                            ->label('Recipient')
                            ->weight('bold')
                            ->size('lg')
                            ->color('primary')
                            ->icon('heroicon-m-user')
                            ->columnSpan(1),

                        TextEntry::make('phone')
                            ->label('Phone Number')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->columnSpan(1),

                        // 2. Address Row (Full width because addresses are long)
                        TextEntry::make('street_address')
                            ->label('Delivery Address')
                            ->icon('heroicon-m-map-pin')
                            ->columnSpanFull()
                            ->copyable()
                            ->color('gray')
                            ->url(fn ($record) => 'https://www.google.com/maps/search/?api=1&query='.urlencode("{$record->street_address}, {$record->city}, {$record->state}"), true)
                            ->prose(),

                        // 3. Location Details Row
                        TextEntry::make('city')
                            ->label('City')
                            ->columnSpan(1),

                        // Nested Group to keep State and Zip together in the second column
                        Group::make([
                            TextEntry::make('state')
                                ->label('State')
                                ->badge()
                                ->color('info'),

                            TextEntry::make('zip_code')
                                ->label('Zip Code')
                                ->fontFamily('mono')
                                ->weight('bold'),
                        ])
                            ->columns(2)
                            ->columnSpan(1),

                        // 4. Subtle Footer for Metadata
                        Group::make([
                            TextEntry::make('created_at')
                                ->label('Created')
                                ->dateTime()
                                ->size('xs'),
                            TextEntry::make('updated_at')
                                ->label('Last Activity')
                                ->since()
                                ->size('xs'),
                        ])
                            ->columns(2)
                            ->columnSpanFull()
                        // This adds a thin line to separate the metadata from the main content
                            ->extraAttributes(['class' => 'mt-4 pt-4 border-t border-gray-100']),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('last_name')
            ->columns([
                // TextColumn::make('order_id')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('fullname')
                    ->searchable(),
                // TextColumn::make('last_name')
                //     ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('state')
                    ->searchable(),
                TextColumn::make('zip_code')
                    ->searchable()
                    ->numeric(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
