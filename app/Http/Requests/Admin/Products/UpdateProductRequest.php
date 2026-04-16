<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locales = config('app.locales', [config('app.locale')]);
        $rules = [
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable|in:on,off',
            'is_featured' => 'nullable|in:on,off',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
        ];

        // Add translation rules for each locale
        foreach ($locales as $locale) {
            $rules["name_{$locale}"] = 'sometimes|string|max:255';
            $rules["description_{$locale}"] = 'nullable|string|max:1000';
        }

        return $rules;
    }

    public function prepareForValidation(): void
    {
        // Filter out empty tag strings
        if ($this->has('tags') && is_array($this->tags)) {
            $this->merge([
                'tags' => array_filter($this->tags, fn($tag) => trim($tag) !== ''),
            ]);
        }
    }
}