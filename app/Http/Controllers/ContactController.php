<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function __invoke(StoreMessageRequest $request)
    {
        $validated = $request->validated();

        $message = Message::create($validated);

        $adminEmail = app(\App\Settings\NotificationSettings::class)->admin_notification_email;
        if ($adminEmail) {
            Notification::route('mail', $adminEmail)->notify(new NewMessageNotification($message));
        }

        return redirect()
            ->route('home')
            ->with('success', 'Thank you for your message! We will get back to you soon.')
            ->withFragment('get-in-touch');
    }
}