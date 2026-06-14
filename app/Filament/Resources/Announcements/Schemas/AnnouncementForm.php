<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Content')->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('content')
                            ->label('Message')
                            ->required()
                            ->rows(4),

                        TextInput::make('link')
                            ->label('Link URL')
                            ->url()
                            ->nullable()
                            ->placeholder('https://example.com'),
                    ])->columns(1),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Appearance')->schema([
                        Radio::make('type')
                            ->label('Alert Type')
                            ->options([
                                'info' => 'Info (Blue)',
                                'success' => 'Success (Green)',
                                'warning' => 'Warning (Amber)',
                                'danger' => 'Danger (Red)',
                            ])
                            ->default('info')
                            ->inline(),
                    ]),

                    Section::make('Schedule')->schema([
                        DateTimePicker::make('starts_at')
                            ->label('Start Date')
                            ->nullable()
                            ->native(false),

                        DateTimePicker::make('ends_at')
                            ->label('End Date')
                            ->nullable()
                            ->native(false)
                            ->afterOrEqual('starts_at'),
                    ])->columns(1),

                    Section::make('Options')->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Toggle::make('dismissible')
                            ->label('Can be dismissed by users')
                            ->default(true),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
