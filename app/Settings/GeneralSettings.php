<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    // --- Identity ---
    public string $site_name = 'My Store';

    public ?string $site_tagline = null;

    public ?string $site_description = null;

    public string $contact_email = 'contact@example.com';

    public ?string $phone = null;

    public ?string $address = null;

    // --- Visuals ---
    public ?string $logo = null;

    public ?string $favicon = null;

    public string $primary_color = 'hsl(40 65% 50%)';

    public string $secondary_color = 'hsl(350 45% 95%)';

    // --- Payments (Unified for Larins) ---
    public string $currency_code = 'NGN';

    public string $currency_symbol = '₦';

    public ?string $paystack_public_key = null;

    public ?string $paystack_secret_key = null;

    public ?string $paystack_merchant_email = null;

    public ?string $stripe_public_key = null;

    public ?string $stripe_secret_key = null;

    // --- SEO & Technical ---
    public ?string $seo_title = null;

    public ?string $seo_description = null;

    public ?string $seo_keywords = null;

    public ?string $google_analytics_id = null;

    public ?string $custom_head_scripts = null;

    public ?string $custom_footer_scripts = null;

    public bool $maintenance_mode = false;

    // --- Navigation & Socials ---
    public ?string $footer_about = null;

    public string $footer_copyright = '';

    public array $footer_links = [];

    public array $social_links = [];

    public static function group(): string
    {
        return 'site';
    }

    public function getPrimaryHue(): float
    {
        return $this->extractHue($this->primary_color);
    }

    public function getSecondaryHue(): float
    {
        return $this->extractHue($this->secondary_color);
    }

    protected function extractHue(string $hsl): float
    {
        if (preg_match('/hsl\(\s*(\d+)\s*,/', $hsl, $matches)) {
            return (float) $matches[1];
        }

        return 220;
    }
}
