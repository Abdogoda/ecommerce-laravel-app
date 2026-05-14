<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('notification.notify_admin_new_order', true);
        $this->migrator->add('notification.notify_admin_new_message', true);
        $this->migrator->add('notification.notify_admin_low_stock', true);
        $this->migrator->add('notification.notify_customer_order_status_changed', true);
        $this->migrator->add('notification.admin_notification_email', 'admin@myecommercestore.com');
    }
};