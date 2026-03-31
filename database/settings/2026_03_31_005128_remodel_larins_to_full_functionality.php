<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // --- Identity ---
        $this->migrator->add('site.site_name', 'Larins');
        $this->migrator->add('site.site_tagline', 'Excellence in Every Detail');
        $this->migrator->add('site.site_description', 'Curated premium goods for the modern connoisseur. Experience a new standard of digital shopping.');
        $this->migrator->add('site.contact_email', 'hello@larins.com');
        $this->migrator->add('site.phone', '+234 800 000 0000');
        $this->migrator->add('site.address', 'Lagos, Nigeria');

        // --- Visuals (Matching your HSL Tailwind Theme) ---
        $this->migrator->add('site.logo', null);
        $this->migrator->add('site.favicon', null);
        $this->migrator->add('site.primary_color', 'hsl(40 65% 50%)'); // Your Gold
        $this->migrator->add('site.secondary_color', 'hsl(30 30% 98%)'); // Your Cream

        // --- Payments ---
        $this->migrator->add('site.currency_code', 'NGN');
        $this->migrator->add('site.currency_symbol', '₦');
        $this->migrator->add('site.paystack_public_key', null);
        $this->migrator->add('site.paystack_secret_key', null);
        $this->migrator->add('site.paystack_merchant_email', 'billing@larins.com');
        $this->migrator->add('site.stripe_public_key', null);
        $this->migrator->add('site.stripe_secret_key', null);

        // --- SEO & Technical ---
        $this->migrator->add('site.seo_title', 'Larins | Premium Curated Collections');
        $this->migrator->add('site.seo_description', 'Shop the exclusive Larins collection. Premium quality goods delivered to your doorstep.');
        $this->migrator->add('site.seo_keywords', 'luxury, ecommerce, premium goods, fashion, lifestyle');
        $this->migrator->add('site.google_analytics_id', null);
        $this->migrator->add('site.custom_head_scripts', null);
        $this->migrator->add('site.custom_footer_scripts', null);
        $this->migrator->add('site.maintenance_mode', false);

        // --- Navigation & Socials (Default Arrays) ---
        $this->migrator->add('site.footer_about', 'Larins is a boutique digital flagship dedicated to quality and timeless style.');
        $this->migrator->add('site.footer_copyright', '© '.date('Y').' Larins Ltd. All rights reserved.');

        $this->migrator->add('site.footer_links', [
            ['label' => 'Privacy Policy', 'url' => 'http://larins_ecommerce.test//privacy'],
            ['label' => 'Terms of Service', 'url' => 'http://larins_ecommerce.test//terms'],
            ['label' => 'Shipping Info', 'url' => 'http://larins_ecommerce.test/shipping'],
        ]);

        $this->migrator->add('site.social_links', [
            ['platform' => 'instagram', 'url' => 'https://instagram.com/larins'],
            ['platform' => 'twitter', 'url' => 'https://twitter.com/larins'],
            ['platform' => 'facebook', 'url' => 'https://facebook.com/larins'],
        ]);
    }
};
