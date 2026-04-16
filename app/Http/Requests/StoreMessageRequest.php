<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string|min:10|max:5000',
        ];
    }

    public function prepareForValidation(): void
    {
        if (auth()->check()) {
            $this->merge([
                'user_id' => auth()->id(),
                'name' => $this->name ?: auth()->user()->name,
                'email' => $this->email ?: auth()->user()->email,
            ]);
        }
    }
}