<?php

namespace App\Services;

use Illuminate\Support\Str;

class Service
{
    public static function generate_slug($slug)
    {
        return Str::slug($slug);
    }

    public static function generate_schema($data)
    {
        // dd($data);
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? '',
            'image' => isset($data['featured_image']) ? asset('storage/' . $data['featured_image']) : '',
            'author' => [
                '@type' => $data['author']['type'] ?? 'Person',
                'name' => $data['author'] ?? ''
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Leelija',//$data['publisher']['name'] ?? config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $data['publisher']['logo']['url'] ?? ''
                ]
            ],
            'datePublished' => $data['datePublished'] ?? now()->toIso8601String(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current()
            ]
        ];

        // Remove empty values
        $schemaData = array_filter($schemaData, function($value) {
            return $value !== null && $value !== '' && $value !== [];
        });

        return '<script type="application/ld+json">' . json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}
