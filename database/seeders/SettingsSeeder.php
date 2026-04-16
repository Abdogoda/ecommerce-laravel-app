<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Settings\GeneralSettings;
use App\Settings\OrderSettings;
use App\Settings\SocialSettings;
use App\Settings\NotificationSettings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Initialize General Settings
        $general = app(GeneralSettings::class);
        $general->name = config('app.name', 'E-Commerce Store');
        $general->email = config('mail.from.address', 'noreply@example.com');
        $general->phone = '1-800-000-0000';
        $general->address = '123 Business St, City, Country';
        $general->currency = 'EGP';
        $general->currency_symbol = 'ج.م';
        $general->currency_position = 'after';
        $general->tax_rate = 0.14;
        $general->tax_included = false;
        $general->maintenance_mode = false;
        $general->items_per_page = 25;
        $general->logo = null;
        $general->favicon = null;
        $general->save();

        // Initialize Order Settings
        $orders = app(OrderSettings::class);
        $orders->auto_confirm = false;
        $orders->cancel_after_minutes = 0;
        $orders->allow_guest_orders = true;
        $orders->free_shipping_above = 0;
        $orders->default_shipping_fee = 0;
        $orders->low_stock_threshold = 10;
        $orders->allow_out_of_stock = false;
        $orders->save();

        // Initialize Social Settings
        $social = app(SocialSettings::class);
        $social->facebook = null;
        $social->twitter = null;
        $social->instagram = null;
        $social->tiktok = null;
        $social->youtube = null;
        $social->whatsapp = null;
        $social->save();

        // Initialize Notification Settings
        $notifications = app(NotificationSettings::class);
        $notifications->notify_admin_new_order = true;
        $notifications->notify_admin_new_message = true;
        $notifications->notify_admin_low_stock = true;
        $notifications->notify_customer_order_confirmed = true;
        $notifications->notify_customer_order_shipped = true;
        $notifications->admin_notification_email = config('mail.from.address', 'admin@example.com');
        $notifications->save();
    }
}
<?php

namespace Database\Seeders;

use App\Settings\GeneralSettings;
use App\Settings\NotificationSettings;
use App\Settings\OrderSettings;
use App\Settings\SocialSettings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // General Settings
        $general = app(GeneralSettings::class);
        $general->name = 'E-commerce Store';
        $general->email = 'admin@myecommercestore.com';
        $general->phone = '+1234567890';
        $general->address = '123 Main St, City, Country';
        $general->currency = 'USD';
        $general->currency_symbol = '$';
        $general->currency_position = 'before';
        $general->tax_rate = 0.14;
        $general->tax_included = false;
        $general->maintenance_mode = false;
        $general->items_per_page = 20;  
        $general->logo = null;
        $general->favicon = null;
        $general->save();

        // Order Settings
        $order = app(OrderSettings::class);
        $order->auto_confirm = true;
        $order->cancel_after_minutes = 60;
        $order->allow_guest_orders = true;
        $order->free_shipping_above = 500.00;
        $order->default_shipping_fee = 50.00;
        $order->low_stock_threshold = 5;
        $order->allow_out_of_stock = false;
        $order->save();

        // Social Settings
        $social = app(SocialSettings::class);
        $social->facebook = null;
        $social->twitter = null;
        $social->instagram = null;
        $social->tiktok = null;
        $social->youtube = null;
        $social->whatsapp = null;
        $social->save();

        // Notification Settings
        $notification = app(NotificationSettings::class);
        $notification->notify_admin_new_order = true;
        $notification->notify_admin_new_message = true;
        $notification->notify_admin_low_stock = true;
        $notification->notify_customer_order_confirmed = true;
        $notification->notify_customer_order_shipped = true;
        $notification->admin_notification_email = 'admin@myecommercestore.com';
        $notification->save();
    }
}