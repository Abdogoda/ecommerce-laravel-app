<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order){}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Order #' . $this->order->id . ' Status Updated')
            ->line('Hello ' . $this->order->user->name . ',')
            ->line('The status of your order #' . $this->order->id . ' has been updated to: ' . ucfirst($this->order->status) . '.')
            ->line('You can view your order details and track its progress in your account dashboard.')
            ->action('View Order', route('orders.show', $this->order))
            ->line('Thank you for shopping with us!');
    }
}