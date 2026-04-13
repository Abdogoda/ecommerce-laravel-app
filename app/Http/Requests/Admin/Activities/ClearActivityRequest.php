<?php

namespace App\Http\Requests\Admin\Activities;

use Illuminate\Foundation\Http\FormRequest;

class ClearActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_date' => 'nullable|date|before_or_equal:today',
            'to_date' => 'nullable|date|after_or_equal:from_date|before_or_equal:today',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}