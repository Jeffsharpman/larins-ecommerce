<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ShippingSettings extends Settings
{
    public bool $enable_shipping = true;

    public bool $free_shipping_enabled = false;

    public ?float $free_shipping_threshold = null;

    public ?float $default_shipping_cost = null;

    public bool $show_shipping_at_checkout = true;

    public string $shipping_calculation = 'per_order';

    public static function group(): string
    {
        return 'shipping';
    }
}
