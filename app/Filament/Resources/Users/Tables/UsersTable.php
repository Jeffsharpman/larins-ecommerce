<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Primary Identity: Name + Email as a subtitle
                TextColumn::make('name')
                    ->label('User')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->email), // Puts the email under the name

                // 2. Verification Status: Use a badge instead of a raw date
                TextColumn::make('email_verified_at')
                    ->label('Verification')
                    ->sortable()
                    ->dateTime('M j, Y')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->icon(fn ($state) => $state ? 'heroicon-m-check-badge' : 'heroicon-m-exclamation-triangle')
                    ->formatStateUsing(fn ($state) => $state ? 'Verified' : 'Unverified'),

                // 3. User Role (Example: adding a badge if they are an Admin)
                // You can add this if you have a role/is_admin column
                /*
                TextColumn::make('is_admin')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => $state ? 'danger' : 'gray')
                    ->formatStateUsing(fn (string $state): string => $state ? 'Admin' : 'Customer'),
                */

                // 4. Timestamps
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Last Activity')
                    ->since() // Shows "3 hours ago"
                    ->color('gray')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // A clean "Verified vs Unverified" filter
                TernaryFilter::make('email_verified_at')
                    ->label('Verification Status')
                    ->nullable() // Ternary uses nullable to check for verified (not null) vs unverified (null)
                    ->placeholder('All Users')
                    ->trueLabel('Verified Users')
                    ->falseLabel('Unverified Users'),
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
