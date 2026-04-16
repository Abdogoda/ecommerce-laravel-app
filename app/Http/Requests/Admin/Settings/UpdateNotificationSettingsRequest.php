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
            'notify_admin_new_order' => 'boolean',
            'notify_admin_new_message' => 'boolean',
            'notify_admin_low_stock' => 'boolean',
            'notify_customer_order_confirmed' => 'boolean',
            'notify_customer_order_shipped' => 'boolean',
            'admin_notification_email' => 'required|email',
        ];
    }
}