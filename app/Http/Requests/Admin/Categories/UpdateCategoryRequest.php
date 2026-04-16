<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locales = config('app.locales', [config('app.locale')]);
        $rules = [
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'is_active' => 'sometimes|boolean',
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