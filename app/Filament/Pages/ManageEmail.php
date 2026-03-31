<?php

namespace App\Filament\Pages;

use App\Settings\EmailSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Placeholder;
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

class ManageEmail extends SettingsPage
{
    use HasPageShield;

    protected static ?string $permissionPrefix = 'email_settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string $settings = EmailSettings::class;

    public static function getPermissionSubPrefixes(): array
    {
        return ['view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'restore', 'restore_any', 'force_delete', 'force_delete_any', 'reorder', 'replicate'];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Email Settings')
                    ->tabs([
                        Tab::make('SMTP Configuration')
                            ->icon('heroicon-m-envelope')
                            ->schema([
                                Section::make('Mail Driver')
                                    ->schema([
                                        Radio::make('mail_driver')
                                            ->options([
                                                'smtp' => 'SMTP',
                                                'mailgun' => 'Mailgun',
                                                'ses' => 'Amazon SES',
                                                'log' => 'Log (Development)',
                                            ])
                                            ->inline(),
                                    ]),

                                Section::make('SMTP Settings')
                                    ->schema([
                                        TextInput::make('mail_host')
                                            ->label('SMTP Host')
                                            ->placeholder('smtp.mailtrap.io'),

                                        TextInput::make('mail_port')
                                            ->label('SMTP Port')
                                            ->numeric()
                                            ->placeholder('587'),

                                        TextInput::make('mail_username')
                                            ->label('Username')
                                            ->autocomplete('off'),

                                        TextInput::make('mail_password')
                                            ->label('Password')
                                            ->password()
                                            ->autocomplete('off'),
                                    ])->columns(2),
                            ]),

                        Tab::make('Mailgun')
                            ->icon('heroicon-m-shield-check')
                            ->schema([
                                Section::make('Mailgun API')
                                    ->schema([
                                        TextInput::make('mailgun_domain')
                                            ->label('Domain')
                                            ->placeholder('mg.yourdomain.com'),

                                        TextInput::make('mailgun_secret')
                                            ->label('Secret Key')
                                            ->password(),
                                    ])->columns(2),
                            ]),

                        Tab::make('Amazon SES')
                            ->icon('heroicon-m-cloud')
                            ->schema([
                                Section::make('AWS Credentials')
                                    ->schema([
                                        TextInput::make('ses_key')
                                            ->label('Access Key ID'),

                                        TextInput::make('ses_secret')
                                            ->label('Secret Access Key')
                                            ->password(),
                                    ])->columns(2),
                            ]),

                        Tab::make('Sender Details')
                            ->icon('heroicon-m-user')
                            ->schema([
                                Section::make('From Address')
                                    ->schema([
                                        TextInput::make('mail_from_address')
                                            ->label('Email Address')
                                            ->email()
                                            ->required(),

                                        TextInput::make('mail_from_name')
                                            ->label('From Name')
                                            ->placeholder('Your Store Name'),
                                    ])->columns(2),

                                Section::make('Additional')
                                    ->schema([
                                        Toggle::make('queue_emails')
                                            ->label('Queue emails for background processing')
                                            ->default(true),
                                    ]),
                            ]),

                        Tab::make('Testing')
                            ->icon('heroicon-m-paper-airplane')
                            ->schema([
                                Placeholder::make('test_info')
                                    ->label('Test Configuration')
                                    ->content('Use the "Log" driver during development to see emails in storage/logs/laravel.log'),
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
