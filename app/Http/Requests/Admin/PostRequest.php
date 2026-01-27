<?php

namespace App\Http\Requests\Admin;

// use Illuminate\Foundation\Http\FormRequest;

// class PostRequest extends FormRequest
// {
//     public function authorize(): bool
//     {
//         return auth('admin')->check();
//     }

//     public function rules(): array
//     {
//         $postId = $this->route('post')?->id ?? null;

//         return [
//             'title' => ['required', 'string', 'max:255'],
//             'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $postId],
//             'excerpt' => ['nullable', 'string', 'max:500'],
//             'content' => ['required', 'string'],
//             'featured_image' => ['nullable', 'image', 'max:4096'],
//             'status' => ['required', 'in:draft,published'],
//             'published_at' => ['nullable', 'date'],
//             'meta_title' => ['nullable', 'string', 'max:255'],
//             'meta_description' => ['nullable', 'string', 'max:500'],
//             'meta_keyword' => ['nullable', 'string', 'max:255'],
//             'schema' => ['nullable', 'string', 'max:255'],
//             'og_image' => ['nullable', 'image', 'max:4096'],
//             'categories' => ['nullable', 'array'],
//             'categories.*' => ['integer', 'exists:categories,id'],
//             'tags' => ['nullable', 'array'],
//             'tags.*' => ['integer', 'exists:tags,id'],
//         ];
//     }
// }



// namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ✅ allow everyone for now
    }

    public function rules(): array
    {
        $rules = [
            'status' => 'required|in:draft,published',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:posts,slug' . ($this->post ? ",{$this->post->id}" : ''),
            'image_alt' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'keywords' => 'nullable|array',
            'keywords.*' => 'string|max:100',
            'schema' => 'nullable|string',
        ];

        // Set featured image validation based on whether we're creating or updating
        if ($this->isMethod('post')) {
            // For create, require featured image when published
            $rules['featured_image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
            if ($this->status === 'published') {
                $rules['featured_image'] = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
            }
        } else {
            // For update, featured image is always optional
            $rules['featured_image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        // Apply required validation for other fields when status is 'published'
        if ($this->status === 'published') {
            $rules = array_merge($rules, [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'required|string|max:255|unique:posts,slug' . ($this->post ? ",{$this->post->id}" : ''),
                'image_alt' => 'required|string|max:255',
                'excerpt' => 'required|string|max:500',
                'categories' => 'required|array|min:1',
                'tags' => 'required|array|min:1',
                'meta_title' => 'required|string|max:255',
                'meta_description' => 'required|string|max:500',
                'keywords' => 'required|array|min:1',
                'schema' => 'nullable|string',
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title can not be blank!',
            'content.required' => 'The content can not be blank!',
            'status.required' => 'Please select a status.',
            'slug.required' => 'Slug is required.',
            'featured_image.required' => 'Please upload a featured image.',
            'categories.required' => 'Please select at least one category.',
            'tags.required' => 'Please select at least one tag.',
            'meta_title.required' => 'Meta title is required.',
            'meta_description.required' => 'Meta description is required.',
            'keywords.required' => 'Please provide at least one keyword.',
            'schema.required' => 'Schema is required.',
        ];
    }
}
