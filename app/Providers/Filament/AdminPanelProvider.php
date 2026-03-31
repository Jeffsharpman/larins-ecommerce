<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Orders\Widgets\OrderStats;
use App\Http\Middleware\RedirectNonAdmins;
use App\Settings\GeneralSettings;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        FilamentColor::register([
            'primary' => $this->generatePalette($this->getPrimaryHex()),
        ]);
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(fn () => app(GeneralSettings::class)->logo ? Storage::disk('public')->url(app(GeneralSettings::class)->logo) : asset('favicon.ico'))
            ->brandLogoHeight('2rem')
            ->favicon(fn () => app(GeneralSettings::class)->favicon ? Storage::disk('public')->url(app(GeneralSettings::class)->favicon) : asset('favicon.ico'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                OrderStats::class,
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
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    protected function getPrimaryHex(): string
    {
        return app(GeneralSettings::class)->primary_color ?? '#cca050';
    }

    protected function generatePalette(string $hex): array
    {
        $rgb = $this->hexToRgb($hex);
        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;

        $oklch = $this->rgbToOklch($r, $g, $b);

        $baseL = $oklch['l'];
        $baseC = $oklch['c'];
        $baseH = $oklch['h'];

        return [
            50 => $this->oklchToColorString($baseL, $baseC * 0.2, $baseH, 0.04),
            100 => $this->oklchToColorString($baseL, $baseC * 0.3, $baseH, 0.08),
            200 => $this->oklchToColorString($baseL, $baseC * 0.4, $baseH, 0.16),
            300 => $this->oklchToColorString($baseL, $baseC * 0.5, $baseH, 0.32),
            400 => $this->oklchToColorString($baseL, $baseC * 0.65, $baseH, 0.48),
            500 => $this->oklchToColorString($baseL, $baseC * 0.8, $baseH, 0.64),
            600 => $this->oklchToColorString($baseL, $baseC * 0.9, $baseH, 0.76),
            700 => $this->oklchToColorString(max(0, $baseL - 0.05), $baseC * 0.95, $baseH, 0.84),
            800 => $this->oklchToColorString(max(0, $baseL - 0.10), $baseC, $baseH, 0.90),
            900 => $this->oklchToColorString(max(0, $baseL - 0.15), $baseC, $baseH, 0.94),
            950 => $this->oklchToColorString(max(0, $baseL - 0.20), $baseC, $baseH, 0.97),
        ];
    }

    protected function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    protected function rgbToOklch(float $r, float $g, float $b): array
    {
        $r = $this->pivotRgb($r);
        $g = $this->pivotRgb($g);
        $b = $this->pivotRgb($b);

        $l = 0.4122214708 * $r + 0.5363325363 * $g + 0.0514459929 * $b;
        $m = 0.2119034982 * $r + 0.6806995451 * $g + 0.1073969566 * $b;
        $s = 0.0883024619 * $r + 0.2817188376 * $g + 0.6299787005 * $b;

        $l = pow($l, 1 / 3);
        $m = pow($m, 1 / 3);
        $s = pow($s, 1 / 3);

        $l_ = $l;
        $c = (($l - $m) / ($l - $m)) ?: 0;
        $temp = max($l, $m);
        $s = $temp - ($temp * 0.5);

        $c = 0.5 * (($l + $m) > 0.5 ? ($l - $m) : 0);
        $h = $s > 0.00001 ? rad2deg(atan2($l - $m, $s)) : 0;

        if ($h < 0) {
            $h += 360;
        }

        return [
            'l' => $l_,
            'c' => $c,
            'h' => $h,
        ];
    }

    protected function pivotRgb(float $n): float
    {
        return $n > 0.04045 ? pow(($n + 0.055) / 1.055, 2.4) : $n / 12.92;
    }

    protected function oklchToColorString(float $l, float $c, float $h, float $opacity): string
    {
        $hRad = deg2rad($h);

        $a = $c * cos($hRad);
        $b = $c * sin($hRad);

        $l = max(0, min(1, $l));
        $a = max(-0.4, min(0.4, $a));
        $b = max(-0.4, min(0.4, $b));

        return sprintf('oklch(%.3f %.3f %.1f / %.2f)', $l, $c, $h, $opacity);
    }
}
