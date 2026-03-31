<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('tax.tax_enabled', false);
        $this->migrator->add('tax.default_tax_rate', 7.5);
        $this->migrator->add('tax.tax_inclusive', 'exclusive');
        $this->migrator->add('tax.tax_per_product', false);
        $this->migrator->add('tax.tax_classes', []);
        $this->migrator->add('tax.tax_calculation', 'per_item');
    }
};
