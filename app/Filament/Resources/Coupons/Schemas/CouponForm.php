<?php

namespace App\Filament\Resources\Coupons\Schemas;

use App\Models\Coupon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Coupon Details')->schema([
                        TextInput::make('code')
                            ->label('Coupon Code')
                            ->required()
                            ->unique(Coupon::class, 'code', ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('e.g., SUMMER20'),

                        Radio::make('type')
                            ->label('Discount Type')
                            ->options([
                                'percentage' => 'Percentage (%)',
                                'fixed' => 'Fixed Amount (₦)',
                            ])
                            ->default('percentage')
                            ->inline()
                            ->required(),

                        TextInput::make('value')
                            ->label('Discount Value')
                            ->required()
                            ->numeric()
                            ->suffix(fn (callable $get) => $get('type') === 'percentage' ? '%' : '₦'),
                    ])->columns(2),

                    Section::make('Usage Limits')->schema([
                        TextInput::make('min_order_amount')
                            ->label('Minimum Order Amount')
                            ->numeric()
                            ->prefix('₦')
                            ->nullable(),

                        TextInput::make('max_discount')
                            ->label('Maximum Discount')
                            ->numeric()
                            ->prefix('₦')
                            ->nullable()
                            ->helperText('Leave empty for no limit'),
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Availability')->schema([
                        TextInput::make('usage_limit')
                            ->label('Usage Limit')
                            ->numeric()
                            ->nullable()
                            ->helperText('Leave empty for unlimited'),

                        TextInput::make('used_count')
                            ->label('Times Used')
                            ->numeric()
                            ->disabled(),
                    ])->columns(2),

                    Section::make('Schedule')->schema([
                        DateTimePicker::make('starts_at')
                            ->label('Start Date')
                            ->nullable()
                            ->native(false),

                        DateTimePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->nullable()
                            ->native(false)
                            ->afterOrEqual('starts_at'),
                    ])->columns(2),

                    Section::make('Status')->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Toggle::make('single_use_per_user')
                            ->label('One use per customer')
                            ->default(true)
                            ->helperText('When enabled, each customer can only use this coupon once'),
                    ]),
                ])->columnSpan(1),

                Group::make()->schema([
                    Section::make('Summary')->schema([
                        Placeholder::make('validation_status')
                            ->label('Status')
                            ->content(function (callable $get): string {
                                $coupon = new Coupon($get());

                                return $coupon->isValid() ? '✓ Valid' : '✗ Invalid';
                            }),
                    ]),
                ])->columnSpanFull(),
            ])->columns(3);
    }
}
