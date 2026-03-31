<?php

namespace App\Filament\Pages;

use App\Settings\ShippingSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ManageShipping extends SettingsPage
{
    use HasPageShield;

    protected static ?string $permissionPrefix = 'shipping_settings';

    protected static string $settings = ShippingSettings::class;

    public static function getPermissionSubPrefixes(): array
    {
        return ['view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'restore', 'restore_any', 'force_delete', 'force_delete_any', 'reorder', 'replicate'];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Shipping Settings')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-m-truck')
                            ->schema([
                                Section::make('Enable Shipping')
                                    ->schema([
                                        Toggle::make('enable_shipping')
                                            ->label('Enable shipping functionality')
                                            ->default(true),
                                    ]),

                                Section::make('Default Rates')
                                    ->schema([
                                        TextInput::make('default_shipping_cost')
                                            ->label('Default Shipping Cost')
                                            ->numeric()
                                            ->prefix('₦')
                                            ->nullable(),

                                        Radio::make('shipping_calculation')
                                            ->label('Calculation Method')
                                            ->options([
                                                'per_order' => 'Per Order (flat rate)',
                                                'per_item' => 'Per Item',
                                            ])
                                            ->default('per_order')
                                            ->inline(),
                                    ]),
                            ]),

                        Tab::make('Free Shipping')
                            ->icon('heroicon-m-gift')
                            ->schema([
                                Section::make('Free Shipping Configuration')
                                    ->schema([
                                        Toggle::make('free_shipping_enabled')
                                            ->label('Enable free shipping')
                                            ->default(false),

                                        TextInput::make('free_shipping_threshold')
                                            ->label('Free shipping threshold')
                                            ->numeric()
                                            ->prefix('₦')
                                            ->nullable()
                                            ->helperText('Free shipping when order exceeds this amount'),
                                    ]),
                            ]),

                        Tab::make('Display')
                            ->icon('heroicon-m-eye')
                            ->schema([
                                Section::make('Checkout Display')
                                    ->schema([
                                        Toggle::make('show_shipping_at_checkout')
                                            ->label('Show shipping options at checkout')
                                            ->default(true),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([
            EmbeddedSchema::make('form'),
        ])
            ->id('form')
            ->livewireSubmitHandler($this->getSubmitFormLivewireMethodName())
            ->extraAttributes(['novalidate' => 'novalidate'])
            ->footer([
                $this->getFormActionsContentComponent(),
            ]);
    }
}
