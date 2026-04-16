<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('order.auto_confirm', true);
        $this->migrator->add('order.cancel_after_minutes', 60);
        $this->migrator->add('order.allow_guest_orders', true);
        $this->migrator->add('order.free_shipping_above', 500.00);
        $this->migrator->add('order.default_shipping_fee', 50.00);
        $this->migrator->add('order.low_stock_threshold', 5);
        $this->migrator->add('order.allow_out_of_stock', false);
    }
};