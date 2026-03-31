<?php

namespace App\Filament\Resources\ShippingMethods\Schemas;

use App\Models\ShippingMethod;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShippingMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Basic Information')->schema([
                        TextInput::make('name')
                            ->label('Method Name')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('e.g., Standard Shipping'),

                        TextInput::make('code')
                            ->label('Code')
                            ->required()
                            ->unique(ShippingMethod::class, 'code', ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('e.g., standard')
                            ->helperText('Unique identifier for this shipping method'),

                        TextInput::make('description')
                            ->label('Description')
                            ->maxLength(255),
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Pricing')->schema([
                        TextInput::make('base_cost')
                            ->label('Base Cost')
                            ->required()
                            ->numeric()
                            ->prefix('₦')
                            ->default(0),

                        TextInput::make('min_order_amount')
                            ->label('Minimum Order Amount')
                            ->numeric()
                            ->prefix('₦')
                            ->nullable()
                            ->helperText('Free shipping above this amount'),

                        TextInput::make('max_order_amount')
                            ->label('Maximum Order Amount')
                            ->numeric()
                            ->prefix('₦')
                            ->nullable()
                            ->helperText('Only apply to orders below this amount'),
                    ])->columns(1),

                    Section::make('Delivery Time')->schema([
                        TextInput::make('delivery_days_min')
                            ->label('Min. Delivery Days')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('delivery_days_max')
                            ->label('Max. Delivery Days')
                            ->numeric()
                            ->nullable(),
                    ])->columns(2),

                    Section::make('Status')->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Toggle::make('is_default')
                            ->label('Default Method')
                            ->default(false)
                            ->helperText('Set as the default shipping option'),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
