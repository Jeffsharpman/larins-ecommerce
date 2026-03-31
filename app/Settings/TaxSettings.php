<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TaxSettings extends Settings
{
    public bool $tax_enabled = false;

    public float $default_tax_rate = 7.5;

    public string $tax_inclusive = 'exclusive';

    public bool $tax_per_product = false;

    public array $tax_classes = [];

    public string $tax_calculation = 'per_item';

    public static function group(): string
    {
        return 'tax';
    }
}
