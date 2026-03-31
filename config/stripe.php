<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | Your Stripe API keys. You can find these in your Stripe dashboard
    | under Developers > API keys.
    |
    */

    'public_key' => env('STRIPE_KEY'),

    'secret_key' => env('STRIPE_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhook Secret
    |--------------------------------------------------------------------------
    |
    | The webhook signing secret from your Stripe dashboard. Used to verify
    | webhook signatures to ensure requests are from Stripe.
    |
    */

    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Environment
    |--------------------------------------------------------------------------
    |
    | Set this to 'live' in production or 'test' for development/testing.
    |
    */

    'environment' => env('APP_ENV', 'development'),

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Default currency for Stripe transactions.
    |
    */

    'currency' => 'ngn',

    'currency_symbol' => '₦',
];
