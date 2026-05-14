<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    public function __construct(public Product $product){}

    public function via(object $notifiable): array
    {
        $notificationSettings = app(\App\Settings\NotificationSettings::class);
        return $notificationSettings->notify_admin_low_stock ? ['database', 'mail'] : ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert')
            ->line("{$this->product->name} is running low on stock.")
            ->line("Current stock: {$this->product->stock}")
            ->action('View Product', url("/admin/products/{$this->product->slug}"))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock',
            'title' => 'Low Stock Alert',
            'message' => "{$this->product->name} is low in stock. Only {$this->product->stock} left.",
            'url' => route('admin.products.index'),
        ];
    }
}