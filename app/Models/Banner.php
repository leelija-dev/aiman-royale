<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'discount',
        'filter',
        'filters',
        'filter_type',
        'type',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'filters' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMain($query)
    {
        return $query->where('type', 'main');
    }

    public function scopeSecondary($query)
    {
        return $query->where('type', 'secondary');
    }

    public function scopeEditor($query)
    {
        return $query->where('type', 'editor');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'asc');
    }
}
