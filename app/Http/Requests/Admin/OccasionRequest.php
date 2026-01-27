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
            'name' => ['required', 'string', 'max:100','unique:occasions,name,' . $id],
            'slug' => ['required', 'string', 'max:120', 'unique:occasions,slug,' . $id],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:occasions,id'],
            'is_active' => ['boolean'],
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
        ];
    }
}
