<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OccasionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->route('occasion')?->id ?? null;
        return [
            'name' => ['required', 'string', 'max:100','unique:ocassions,name,' . $id],
            'slug' => ['required', 'string', 'max:120', 'unique:ocassions,slug,' . $id],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:ocassions,id'],
            'is_active' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'meta_tags' => ['nullable', 'string', 'max:255'],
            'schema_markup' => ['nullable', 'string'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter an occasion name.',
            'name.unique'   => 'Occasion name already exists!',
            'slug.required' => 'Please enter a slug.',
            'slug.unique'   => 'Slug already exists!',
            'parent_id.exists' => 'Selected parent occasion does not exist.',
            'meta_title.max' => 'Meta title must not exceed 255 characters.',
            'meta_description.max' => 'Meta description must not exceed 500 characters.',
            'meta_keywords.max' => 'Meta keywords must not exceed 255 characters.',
            'meta_tags.max' => 'Meta tags must not exceed 255 characters.',
        ];
    }
}
