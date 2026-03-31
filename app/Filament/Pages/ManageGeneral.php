<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Illuminate\Support\Facades\Notification;

class ManageGeneral extends SettingsPage
{
    use HasPageShield;

    protected static ?string $permissionPrefix = 'general_settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    public static function getPermissionSubPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'restore',
            'restore_any',
            'force_delete',
            'force_delete_any',
            'reorder',
            'replicate',
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Premium Settings')
                    ->tabs([
                        // IDENTITY TAB
                        Tab::make('Identity')
                            ->icon('heroicon-m-home')
                            ->schema([
                                TextInput::make('site_name')->label('Shop Name')->required(),
                                TextInput::make('site_tagline')->label('Tagline'),
                                TextInput::make('contact_email')->email()->required(),
                                TextInput::make('phone'),
                                Textarea::make('site_description')->rows(2)->columnSpanFull(),
                                Textarea::make('address')->rows(2)->columnSpanFull(),
                            ])->columns(2),

                        // BRANDING TAB
                        Tab::make('Visuals')
                            ->icon('heroicon-m-paint-brush')
                            ->schema([
                                FileUpload::make('logo')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public')
                                    ->directory('site')
                                    ->columnSpanFull(),
                                FileUpload::make('favicon')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public')
                                    ->directory('site'),
                                ColorPicker::make('primary_color'),
                                ColorPicker::make('secondary_color'),
                            ])->columns(2),

                        // PAYMENTS TAB
                        Tab::make('Payments')
                            ->icon('heroicon-m-credit-card')
                            ->schema([
                                Section::make('Currency Settings')
                                    ->schema([
                                        TextInput::make('currency_code')->placeholder('NGN'),
                                        TextInput::make('currency_symbol')->placeholder('₦'),
                                    ])->columns(2),

                                Section::make('Paystack Gateway')
                                    ->description('Configure Paystack for local transactions.')
                                    ->schema([
                                        TextInput::make('paystack_merchant_email')->email(),
                                        TextInput::make('paystack_public_key')->password(),
                                        TextInput::make('paystack_secret_key')->password(),
                                    ])->columns(2),

                                Section::make('Stripe Gateway')
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('stripe_public_key')->password(),
                                        TextInput::make('stripe_secret_key')->password(),
                                    ])->columns(2),
                            ]),

                        // NAVIGATION TAB
                        Tab::make('Navigation')
                            ->icon('heroicon-m-link')
                            ->schema([
                                Textarea::make('footer_about')->rows(3)->columnSpanFull(),
                                TextInput::make('footer_copyright')->columnSpanFull(),
                                Repeater::make('social_links')
                                    ->label('Social Profiles')
                                    ->schema([
                                        Select::make('platform')->options([
                                            'facebook' => 'Facebook',
                                            'instagram' => 'Instagram',
                                            'twitter' => 'Twitter/X',
                                            'linkedin' => 'LinkedIn',
                                            'whatsapp' => 'WhatsApp',
                                        ])->required(),
                                        TextInput::make('url')->url()->required(),
                                    ])->columns(2)->grid(2),
                                Repeater::make('footer_links')
                                    ->label('Footer Navigation')
                                    ->schema([
                                        TextInput::make('label')->required(),
                                        TextInput::make('url')->url()->required(),
                                    ])->columns(2),
                            ]),

                        // SEO & TECHNICAL TAB
                        Tab::make('SEO & Technical')
                            ->icon('heroicon-m-globe-alt')
                            ->schema([
                                Toggle::make('maintenance_mode')->label('Enable Maintenance Mode'),
                                TextInput::make('seo_title'),
                                TextInput::make('seo_keywords'),
                                Textarea::make('seo_description')->rows(3),
                                TextInput::make('google_analytics_id')->placeholder('G-XXXXXXXX'),
                                Textarea::make('custom_head_scripts')->label('Head Scripts')->rows(4),
                                Textarea::make('custom_footer_scripts')->label('Footer Scripts')->rows(4),
                            ]),
                    ]),
            ])->columns(1);
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

    public static function canAccess(): bool
    {
        return auth()->user()->can('View:GeneralSettings');
    }

    public function canEdit(): bool
    {
        return auth()->user()->can('Update:GeneralSettings');
    }

    public function save(): void
    {
        if (! $this->canEdit()) {
            Notification::make()->danger()->title('Denied!')->send();

            return;
        }

        parent::save();
    }
}
