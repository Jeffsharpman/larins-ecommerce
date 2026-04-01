<?php

namespace App\Filament\Resources\Addresses\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Address Information')->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('title')
                            ->label('Address Type')
                            ->options([
                                'home' => 'Home',
                                'work_place' => 'Work Place',
                                'other' => 'Other',
                            ])
                            ->required(),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel(),
                    ])->columns(3),

                    Section::make('Street Address')->schema([
                        TextInput::make('street_address')
                            ->label('Street Address')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                    Section::make('Location')->schema([
                        TextInput::make('city')
                            ->label('City')
                            ->required(),

                        TextInput::make('state')
                            ->label('State')
                            ->required(),

                        TextInput::make('zip_code')
                            ->label('Postal Code'),
                    ])->columns(3),

                    Section::make('Default Address')->schema([
                        Select::make('is_active')
                            ->label('Set as Default')
                            ->options([
                                '1' => 'Yes',
                                '0' => 'No',
                            ])
                            ->default('0'),
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Summary')->schema([
                        Placeholder::make('full_name')
                            ->label('Full Name')
                            ->content(fn ($record) => $record ? $record->full_name : '-'),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
