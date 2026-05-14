<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notify_admin_new_order' => 'nullable|in:on,off',
            'notify_admin_new_message' => 'nullable|in:on,off',
            'notify_admin_low_stock' => 'nullable|in:on,off',
            'notify_customer_order_status_changed' => 'nullable|in:on,off',
            'admin_notification_email' => 'required|email',
        ];
    }
}