<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:4096',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->is_active === '1' || $this->is_active === 1 ? true : false,
        ]);
    }
}