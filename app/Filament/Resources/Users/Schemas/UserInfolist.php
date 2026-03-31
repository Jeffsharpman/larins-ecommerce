<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        // Main Info Section (Left 2/3)
                        Section::make('Profile Information')
                            ->description('Customer account details and registration history.')
                            ->icon('heroicon-m-user-circle')
                            ->columnSpan([
                                'default' => 3,
                                'lg' => 2,
                            ])
                            ->columns(2) // Internal grid for side-by-side details
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Customer Name')
                                    ->weight('bold')
                                    ->size('lg')
                                    ->icon('heroicon-m-user')
                                    ->color('primary'),

                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->icon('heroicon-m-envelope')
                                    ->copyable() // Handy for admin tasks
                                    ->color('gray')
                                    ->tooltip('Click to copy email'),

                                TextEntry::make('created_at')
                                    ->label('Member Since')
                                    ->dateTime('M d, Y') // Cleaner date format (e.g., Mar 22, 2026)
                                    ->icon('heroicon-m-calendar-days')
                                    ->color('gray')
                                    ->badge() // Makes the date look like a tag
                                    ->color('success'),

                                // Add a "Status" entry if your model has it
                                TextEntry::make('status')
                                    ->default('Active Account')
                                    ->badge()
                                    ->color('info')
                                    ->icon('heroicon-m-check-badge'),
                        ])->columnSpan(3),

                        // Profile Picture Section (Right 1/3)
                        Section::make('Profile Picture')
                            ->description('Primary avatar')
                            ->columnSpan([
                                'default' => 3,
                                'lg' => 1,
                            ])
                            ->schema([
                                ImageEntry::make('avatar_url')
                                    ->label('')
                                    ->circular()
                                    ->extraAttributes([
                                        'class' => 'mx-auto ring-4 ring-primary-500/10 shadow-xl', 
                                    ])
                                    // ->defaultImageUrl(url('public/images/default-avatar.png'))
                                    ->imageHeight(200)         
                                    ->stacked()                
                                    ->circular()
                                    ->ring(2)
                                    ->disk('public')
                                    ->visibility('public')
                                    ->placeholder('No images uploaded')
                                    ->columnSpanFull(),
                                
                                // Add a centered label below the picture
                                TextEntry::make('fullname_sub')
                                    ->label('')
                                    ->state(fn ($record) => "Verified User")
                                    ->alignCenter()
                                    ->size('xs')
                                    ->color('gray'),
                        ])->columns(1),
                    ])->columns(4)
            ])->columns(1);
    }
}
