<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;

class BrandInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Header Section: Name & Logo
                Section::make('Brand Identity')
                    ->description('Primary visual assets and identification')
                    ->icon('heroicon-m-sparkles')
                    ->columns(2) // Safe way to create columns
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Official Logo')
                            ->square()
                            ->extraImgAttributes(['class' => 'shadow-lg ring-2 ring-primary-500'])
                            ->placeholder('No logo uploaded')
                            ->ring(2),

                        Section::make() // Nested clean section for text
                            ->schema([
                                TextEntry::make('name')
                                    ->weight('black')
                                    ->size('xl')
                                    ->color('primary')
                                    ->copyable(),

                                TextEntry::make('slug')
                                    ->label('URL Identifier')
                                    ->fontFamily('mono')
                                    ->color('gray')
                                    ->icon('heroicon-m-link')
                                    ->copyable(),
                            ])->columnSpan(1),
                    ]),

                // Status & Timeline Section
                Section::make('Operational Status & History')
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->schema([
                        // Status Card
                        Section::make('Status')
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Currently Active')
                                    ->boolean()
                                    ->size(IconSize::Large),
                            ])->columnSpan(1),

                        // Timeline Card
                        Section::make('Timeline')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Established On')
                                    ->dateTime('d M Y')
                                    ->icon('heroicon-m-calendar-days')
                                    ->color('gray'),

                                TextEntry::make('updated_at')
                                    ->label('Last System Update')
                                    ->since() // Attractive "3 days ago" format
                                    ->color('primary'),
                            ])->columnSpan(2),
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
