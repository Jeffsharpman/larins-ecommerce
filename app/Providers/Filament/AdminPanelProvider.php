<?php

namespace App\Providers\Filament;

use App\Filament\Pages\ManageEmail;
use App\Filament\Pages\ManageGeneral;
use App\Filament\Pages\ManageLogs;
use App\Filament\Pages\ManageShipping;
use App\Filament\Pages\ManageTax;
use App\Filament\Resources\Orders\Widgets\OrderStats;
use App\Filament\Widgets\AuditLogWidget;
use App\Filament\Widgets\LowStockProductsWidget;
use App\Filament\Widgets\OrdersByStatusWidget;
use App\Filament\Widgets\RecentCustomersWidget;
use App\Filament\Widgets\RecentOrdersWidget;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\SalesByMonthWidget;
use App\Filament\Widgets\TopProductsWidget;
use App\Http\Middleware\RedirectNonAdmins;
use App\Http\Middleware\SecurityHeaders;
use App\Settings\GeneralSettings;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->emailVerification()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(fn () => app(GeneralSettings::class)->logo ? Storage::disk('public')->url(app(GeneralSettings::class)->logo) : asset('favicon.ico'))
            ->brandLogoHeight('2rem')
            ->favicon(fn () => app(GeneralSettings::class)->favicon ? Storage::disk('public')->url(app(GeneralSettings::class)->favicon) : asset('favicon.ico'))

            // Registering Resources/Pages/Widgets
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                ManageGeneral::class,
                ManageEmail::class,
                ManageShipping::class,
                ManageTax::class,
                ManageLogs::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                OrderStats::class,
                RevenueChartWidget::class,
                SalesByMonthWidget::class,
                OrdersByStatusWidget::class,
                TopProductsWidget::class,
                RecentCustomersWidget::class,
                RecentOrdersWidget::class,
                LowStockProductsWidget::class,
                AuditLogWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                RedirectNonAdmins::class,
                SecurityHeaders::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            /* |--------------------------------------------------------------------------
             | Custom CSS Injection
             |--------------------------------------------------------------------------
             | This injects your slideUp animation into the head of every admin page.
             */
            ->renderHook(
                'panels::head.end',
                fn () => Blade::render('
                    <style>
                        @keyframes slideUp {
                            from { opacity: 0; transform: translateY(10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        .animate-in {
                            animation: slideUp 0.5s ease-out forwards;
                        }
                        
                        /* Refined Scrollbars for that modern boutique look */
                        ::-webkit-scrollbar { width: 5px; height: 5px; }
                        ::-webkit-scrollbar-track { background: transparent; }
                        ::-webkit-scrollbar-thumb { 
                            background: rgba(var(--primary-500), 0.2); 
                            border-radius: 10px; 
                        }
                        ::-webkit-scrollbar-thumb:hover { background: rgba(var(--primary-500), 0.5); }
                    </style>
                ')
            );
    }
}
