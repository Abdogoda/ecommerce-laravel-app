<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileReqeust extends FormRequest{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        $id = Auth::id();
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:20|unique:users,phone,'.$id,
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }
}