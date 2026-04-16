<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'is_active' => 'required|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
        ];
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