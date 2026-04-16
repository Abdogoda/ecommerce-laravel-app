<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cancel_after_minutes' => 'required|integer|min:10',
            'free_shipping_above'  => 'required|numeric|min:0',
            'default_shipping_fee' => 'required|numeric|min:0',
            'low_stock_threshold'  => 'required|integer|min:1',
        ];
    }
}