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
        $settings = app(GeneralSettings::class);

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->emailVerification()
            ->colors([
                'primary' => $this->parseColor($settings->primary_color),
                'secondary' => $this->parseColor($settings->secondary_color),
            ])
            ->brandLogo(fn () => $settings->logo ? Storage::disk('public')->url($settings->logo) : asset('favicon.ico'))
            ->brandLogoHeight('2rem')
            ->favicon(fn () => $settings->favicon ? Storage::disk('public')->url($settings->favicon) : asset('favicon.ico'))
            ->brandName($settings->site_name ?: 'Larinstore Admin')

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

    protected function parseColor(string $hslColor): array
    {
        if (preg_match('/hsl\(\s*(\d+)\s*,\s*(\d+)%\s*,\s*(\d+)%\s*\)/', $hslColor, $matches)) {
            $h = (int) $matches[1];
            $s = (int) $matches[2];
            $l = (int) $matches[3];

            $rgb = $this->hslToRgb($h, $s, $l);

            return [
                50 => "rgb({$rgb['r']}, {$rgb['g']}, ".min(255, $rgb['b'] + 60).')',
                100 => "rgb({$rgb['r']}, {$rgb['g']}, ".min(255, $rgb['b'] + 50).')',
                200 => "rgb({$rgb['r']}, {$rgb['g']}, ".min(255, $rgb['b'] + 40).')',
                300 => "rgb({$rgb['r']}, {$rgb['g']}, ".min(255, $rgb['b'] + 30).')',
                400 => "rgb({$rgb['r']}, {$rgb['g']}, ".min(255, $rgb['b'] + 15).')',
                500 => "rgb({$rgb['r']}, {$rgb['g']}, {$rgb['b']})",
                600 => "rgb({$rgb['r']}, {$rgb['g']}, ".max(0, $rgb['b'] - 15).')',
                700 => "rgb({$rgb['r']}, {$rgb['g']}, ".max(0, $rgb['b'] - 30).')',
                800 => "rgb({$rgb['r']}, {$rgb['g']}, ".max(0, $rgb['b'] - 45).')',
                900 => "rgb({$rgb['r']}, {$rgb['g']}, ".max(0, $rgb['b'] - 60).')',
                950 => "rgb({$rgb['r']}, {$rgb['g']}, ".max(0, $rgb['b'] - 75).')',
            ];
        }

        return Color::Amber;
    }

    protected function hslToRgb(int $h, int $s, int $l): array
    {
        $s /= 100;
        $l /= 100;

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;

        if ($h >= 0 && $h < 60) {
            $r = $c;
            $g = $x;
            $b = 0;
        } elseif ($h >= 60 && $h < 120) {
            $r = $x;
            $g = $c;
            $b = 0;
        } elseif ($h >= 120 && $h < 180) {
            $r = 0;
            $g = $c;
            $b = $x;
        } elseif ($h >= 180 && $h < 240) {
            $r = 0;
            $g = $x;
            $b = $c;
        } elseif ($h >= 240 && $h < 300) {
            $r = $x;
            $g = 0;
            $b = $c;
        } else {
            $r = $c;
            $g = 0;
            $b = $x;
        }

        return [
            'r' => (int) round(($r + $m) * 255),
            'g' => (int) round(($g + $m) * 255),
            'b' => (int) round(($b + $m) * 255),
        ];
    }
}
