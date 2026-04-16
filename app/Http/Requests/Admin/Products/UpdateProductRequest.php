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
        return [
            'name' => 'required|string|max:255|unique:products,name,' . $this->route('product')->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable|in:on,off',
            'is_featured' => 'nullable|in:on,off',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
        ];
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