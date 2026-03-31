<?php

namespace App\Filament\Resources\Coupons\Schemas;

use App\Models\Coupon;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Schemas\Schema;

class CouponInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->infolist(
            Infolist::make()->schema([
                TextEntry::make('code')
                    ->label('Coupon Code')
                    ->fontWeight('bold')
                    ->size(TextEntry\TextEntrySize::Large),

                TextEntry::make('type')
                    ->label('Discount Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state === 'percentage' ? 'Percentage' : 'Fixed Amount'),

                TextEntry::make('value')
                    ->label('Discount Value')
                    ->formatStateUsing(fn (Coupon $record): string => $record->type === 'percentage'
                        ? $record->value.'%'
                        : '₦'.number_format($record->value, 2)),

                TextEntry::make('min_order_amount')
                    ->label('Minimum Order')
                    ->formatStateUsing(fn (Coupon $record): ?string => $record->min_order_amount
                        ? '₦'.number_format($record->min_order_amount, 2)
                        : 'No minimum'),

                TextEntry::make('max_discount')
                    ->label('Maximum Discount')
                    ->formatStateUsing(fn (Coupon $record): ?string => $record->max_discount
                        ? '₦'.number_format($record->max_discount, 2)
                        : 'No limit'),

                TextEntry::make('usage_limit')
                    ->label('Usage Limit')
                    ->formatStateUsing(fn (Coupon $record): string => $record->usage_limit
                        ? (string) $record->usage_limit
                        : 'Unlimited'),

                TextEntry::make('used_count')
                    ->label('Times Used'),

                TextEntry::make('starts_at')
                    ->label('Start Date')
                    ->dateTime('M j, Y g:i A'),

                TextEntry::make('expires_at')
                    ->label('Expiration Date')
                    ->dateTime('M j, Y g:i A'),

                IconEntry::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])->columns(3)
        );
    }
}
