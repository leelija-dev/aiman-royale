<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category_id',
        'is_active',
        'sort_order'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];
    
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }
    
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
