<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:100',
            'email'             => 'required|email',
            'phone'             => 'nullable|string|max:30',
            'address'           => 'nullable|string|max:255',
            'currency'          => 'required|string|size:3',
            'currency_symbol'   => 'required|string|max:5',
            'currency_position' => 'required|in:before,after',
            'tax_rate'          => 'required|numeric|min:0|max:1',
            'tax_included'      => 'boolean',
            'maintenance_mode'  => 'boolean',
            'items_per_page'    => 'required|integer|min:5|max:100',
            'logo'              => 'nullable|image|max:2048',
            'favicon'           => 'nullable|image|max:1024',
        ];
    }
}