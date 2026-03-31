<?php

namespace App\Filament\Resources\Coupons\Pages;

use App\Filament\Resources\Coupons\CouponResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCoupon extends ViewRecord
{
    protected static string $resource = CouponResource::class;

    protected static ?string $title = 'Coupon Details';

    public static function getRecordTitleAttribute(): ?string
    {
        return 'code';
    }

    public static function getRecordSubtitle(): ?string
    {
        $record = static::getRecord();

        return $record->type === 'percentage'
            ? $record->value.'% discount'
            : '₦'.number_format($record->value, 2).' discount';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
