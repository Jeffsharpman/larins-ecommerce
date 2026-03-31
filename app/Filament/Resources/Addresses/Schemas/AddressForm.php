<?php

namespace App\Filament\Resources\Addresses\Schemas;

use App\Models\Address;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Contact Information')->schema([
                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(100),
                    ])->columns(2),

                    Section::make('Address Details')->schema([
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required(),

                        TextInput::make('street_address')
                            ->label('Street Address')
                            ->required(),
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Location')->schema([
                        TextInput::make('city')
                            ->label('City')
                            ->required(),

                        TextInput::make('state')
                            ->label('State')
                            ->required(),

                        TextInput::make('zip_code')
                            ->label('Postal Code')
                            ->required(),
                    ])->columns(3),

                    Section::make('Summary')->schema([
                        Placeholder::make('full_name')
                            ->label('Full Name')
                            ->content(fn (Address $record): string => $record->full_name ?? '-'),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
