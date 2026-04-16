<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.name', 'My E-Commerce Store');
        $this->migrator->add('general.email', 'admin@myecommercestore.com');
        $this->migrator->add('general.phone', '+1234567890');
        $this->migrator->add('general.address', '123 Main St, City, Country');
        $this->migrator->add('general.currency', 'USD');
        $this->migrator->add('general.currency_symbol', '$');
        $this->migrator->add('general.currency_position', 'before');
        $this->migrator->add('general.tax_rate', 0.14);
        $this->migrator->add('general.tax_included', false);
        $this->migrator->add('general.maintenance_mode', false);
        $this->migrator->add('general.items_per_page', 20);
        $this->migrator->add('general.logo', null);
        $this->migrator->add('general.favicon', null);
    }
};