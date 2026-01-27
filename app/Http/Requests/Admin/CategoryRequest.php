<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id ?? null;
        return [
            'name' => ['required', 'string', 'max:100','unique:categories,name,' . $id],
            'slug' => ['required', 'string', 'max:120', 'unique:categories,slug,' . $id],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a category name.',
            'name.unique'   => 'Category name already exists!',
            'slug.required' => 'Please enter a slug.',
            'slug.unique'   => 'Slug already exists!',
            'parent_id.exists' => 'Selected parent category does not exist.',
        ];
    }
}
