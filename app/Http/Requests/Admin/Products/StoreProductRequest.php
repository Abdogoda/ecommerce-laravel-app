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
        $locales = config('app.locales', [config('app.locale')]);
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:4096',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
        ];

        // Add translation rules for each locale
        foreach ($locales as $locale) {
            $rules["name_{$locale}"] = 'required|string|max:255';
            $rules["description_{$locale}"] = 'nullable|string|max:1000';
        }

        return $rules;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->is_active === '1' || $this->is_active === 1 ? true : false,
        ]);

        // Filter out empty tag strings
        if ($this->has('tags') && is_array($this->tags)) {
            $this->merge([
                'tags' => array_filter($this->tags, fn($tag) => trim($tag) !== ''),
            ]);
        }
    }
}