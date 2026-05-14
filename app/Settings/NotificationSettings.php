<?php 

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class NotificationSettings extends Settings
{
    public bool    $notify_admin_new_order;
    public bool    $notify_admin_new_message;
    public bool    $notify_admin_low_stock;
    public bool    $notify_customer_order_status_changed;
    public string  $admin_notification_email;

    public static function group(): string { return 'notification'; }
}