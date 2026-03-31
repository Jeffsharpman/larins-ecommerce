<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('shipping.enable_shipping', true);
        $this->migrator->add('shipping.free_shipping_enabled', false);
        $this->migrator->add('shipping.free_shipping_threshold', null);
        $this->migrator->add('shipping.default_shipping_cost', 0);
        $this->migrator->add('shipping.show_shipping_at_checkout', true);
        $this->migrator->add('shipping.shipping_calculation', 'per_order');
    }
};
