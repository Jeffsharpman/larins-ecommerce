<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class AuditLogWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Activity';

    protected function getTableQuery(): Builder
    {
        return Activity::query()
            ->latest()
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')
                ->label('Time')
                ->dateTime('M j, g:i A')
                ->sortable()
                ->color('gray'),

            TextColumn::make('causer.name')
                ->label('User')
                ->searchable()
                ->limit(15),

            BadgeColumn::make('event')
                ->label('Action')
                ->color(fn (string $state): string => match ($state) {
                    'created' => 'success',
                    'updated' => 'warning',
                    'deleted' => 'danger',
                    default => 'gray',
                }),

            TextColumn::make('subject_type')
                ->label('Resource')
                ->formatStateUsing(fn (string $state): string => class_basename($state)),

            TextColumn::make('description')
                ->label('Details')
                ->limit(30)
                ->color('gray'),
        ];
    }
}
