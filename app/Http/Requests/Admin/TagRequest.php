<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->route('tag')?->id ?? null;
        return [
            'name' => ['required', 'string', 'max:255','unique:tags,name,' . $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tags,slug,' . $id],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a tag name!',
            'name.unique'   => 'Tag name already exists!',
            'slug.unique'   => 'Slug is already exists!',
        ];
    }
}
