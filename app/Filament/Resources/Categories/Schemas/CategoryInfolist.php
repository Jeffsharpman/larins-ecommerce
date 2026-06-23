<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize; // Added to fix the icon size error

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Primary Identity Section
                Section::make('Category Overview')
                    ->description('Essential details and visual identification.')
                    ->icon('heroicon-m-rectangle-group')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Banner / Icon')
                            ->square()
                            ->extraImgAttributes(['class' => 'rounded-xl shadow-md ring-1 ring-gray-200'])
                            ->placeholder('No category image')
                            ->ring(2),

                        Section::make()
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Category Name')
                                    ->weight('black')
                                    ->size('xl')
                                    ->color('primary'),

                                TextEntry::make('slug')
                                    ->fontFamily('mono')
                                    ->color('gray')
                                    ->icon('heroicon-m-link')
                                    ->size('sm'),
                            ])->columnSpan(1),
                    ]),

                // 2. Status & System Data
                Section::make('Configuration & Stats')
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        // Status Card
                        Section::make('Visibility')
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Active on Storefront')
                                    ->boolean()
                                    ->size(IconSize::Large), // Using the Enum to avoid the previous error
                            ])->columnSpan(1),

                        // Timeline Card
                        Section::make('System Metadata')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Date Created')
                                    ->dateTime('d M Y, H:i')
                                    ->icon('heroicon-m-calendar')
                                    ->color('gray'),

                                TextEntry::make('updated_at')
                                    ->label('Last Modification')
                                    ->since()
                                    ->badge()
                                    ->color('info'),
                            ])->columnSpan(1),
                    ]),

                Section::make('Operational Status & History')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->prose()
                            ->markdown()
                            ->placeholder('No description provided'),
                    ])->columnSpanFull(),
            ]);
    }
}
