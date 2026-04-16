<?php

namespace App\Http\Requests\Admin\Messages;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('manage messages');
    }

    public function rules(): array
    {
        return [
            'is_read' => 'nullable|boolean',
        ];
    }
}