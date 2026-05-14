<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order){}

    public function via(object $notifiable): array
    {
        $notificationSettings = app(\App\Settings\NotificationSettings::class);
        return $notificationSettings->notify_admin_new_order ? ['database', 'mail'] : ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Placed')
            ->line("A new order has been placed by {$this->order->customer_name}.")
            ->line("Order ID: {$this->order->id}")
            ->action('View Order', url("admin/orders/{$this->order->id}"))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_order',
            'title' => 'New Order Placed',
            'message' => "A new order has been placed by {$this->order->customer_name}. Order ID: {$this->order->id}",
            'url' => url("admin/orders/{$this->order->id}"),
        ];
    }
}