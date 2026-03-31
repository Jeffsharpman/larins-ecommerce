<?php

namespace App\Filament\Pages;

use App\Settings\TaxSettings;
use BackedEnum;
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

class ManageTax extends SettingsPage
{
    use HasPageShield;

    protected static ?string $permissionPrefix = 'tax_settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string $settings = TaxSettings::class;

    public static function getPermissionSubPrefixes(): array
    {
        return ['view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'restore', 'restore_any', 'force_delete', 'force_delete_any', 'reorder', 'replicate'];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tax Settings')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-m-currency-dollar')
                            ->schema([
                                Section::make('Enable Tax')
                                    ->schema([
                                        Toggle::make('tax_enabled')
                                            ->label('Enable tax calculation')
                                            ->default(false),
                                    ]),

                                Section::make('Default Tax Rate')
                                    ->schema([
                                        TextInput::make('default_tax_rate')
                                            ->label('Default Tax Rate (%)')
                                            ->numeric()
                                            ->step(0.1)
                                            ->default(7.5)
                                            ->suffix('%'),
                                    ]),
                            ]),

                        Tab::make('Configuration')
                            ->icon('heroicon-m-adjustments')
                            ->schema([
                                Section::make('Tax Calculation')
                                    ->schema([
                                        Radio::make('tax_inclusive')
                                            ->label('Tax Method')
                                            ->options([
                                                'exclusive' => 'Tax Exclusive (add tax on top)',
                                                'inclusive' => 'Tax Inclusive (tax included in price)',
                                            ])
                                            ->default('exclusive')
                                            ->inline(),

                                        Radio::make('tax_calculation')
                                            ->label('Calculation Method')
                                            ->options([
                                                'per_item' => 'Per Item',
                                                'per_order' => 'Per Order',
                                            ])
                                            ->default('per_item')
                                            ->inline(),
                                    ]),

                                Section::make('Per-Product Tax')
                                    ->schema([
                                        Toggle::make('tax_per_product')
                                            ->label('Allow per-product tax rates')
                                            ->default(false)
                                            ->helperText('When enabled, each product can have its own tax rate'),
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
