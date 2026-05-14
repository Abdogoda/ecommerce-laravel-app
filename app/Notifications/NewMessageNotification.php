<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public function __construct(public Message $message){}

    public function via(object $notifiable): array
    {
        $notificationSettings = app(\App\Settings\NotificationSettings::class);
        return $notificationSettings->notify_admin_new_message ? ['database', 'mail'] : ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Message Received')
            ->line("You have a new message from {$this->message->name}.")
            ->action('View Message', url("admin/messages/{$this->message->id}"))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_message',
            'title' => 'New Message Received',
            'message' => "You have a new message from {$this->message->name}.",
            'url' => url("admin/messages/{$this->message->id}"),
        ];
    }
}