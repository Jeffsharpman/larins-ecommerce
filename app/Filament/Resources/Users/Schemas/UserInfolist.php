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
                                    ->copyable()
                                    ->color('gray')
                                    ->tooltip('Click to copy email'),

                                TextEntry::make('phone')
                                    ->label('Phone')
                                    ->icon('heroicon-m-phone')
                                    ->color('gray'),

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
                                ImageEntry::make('profile_picture')
                                    ->label('')
                                    ->circular()
                                    ->extraAttributes([
                                        'class' => 'mx-auto ring-4 ring-primary-500/10 shadow-xl',
                                    ])
                                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&background=667eea&color=fff&bold=true&size=200')
                                    ->imageHeight(200)
                                    ->stacked()
                                    ->circular()
                                    ->ring(2)
                                    ->disk('public')
                                    ->visibility('public')
                                    ->placeholder('No images uploaded')
                                    ->columnSpanFull(),

                                TextEntry::make('fullname_sub')
                                    ->label('')
                                    ->state(fn ($record) => $record->email_verified_at ? 'Verified User' : 'Unverified')
                                    ->alignCenter()
                                    ->size('xs')
                                    ->color(fn ($record) => $record->email_verified_at ? 'success' : 'warning'),
                            ])->columns(1),
                    ])->columns(4),
            ])->columns(1);
    }
}
