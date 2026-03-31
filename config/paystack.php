<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paystack API Keys
    |--------------------------------------------------------------------------
    |
    | Your Paystack API keys. You can find these in your Paystack dashboard
    | under Settings > API Keys & Webhooks.
    |
    */

    'public_key' => env('PAYSTACK_PUBLIC_KEY'),

    'secret_key' => env('PAYSTACK_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Paystack Environment
    |--------------------------------------------------------------------------
    |
    | Set this to 'live' in production or 'test' for development/testing.
    |
    */

    'environment' => env('PAYSTACK_ENVIRONMENT', 'test'),

    /*
    |--------------------------------------------------------------------------
    | Merchant Email
    |--------------------------------------------------------------------------
    |
    | The email associated with your Paystack account.
    |
    */

    'merchant_email' => env('PAYSTACK_MERCHANT_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Payment Callback URL
    |--------------------------------------------------------------------------
    |
    | The URL Paystack will redirect to after payment.
    |
    */

    'callback_url' => env('PAYSTACK_CALLBACK_URL'),
];
