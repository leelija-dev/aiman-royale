<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOccasionContent extends Model
{
    use HasFactory;

    protected $table = 'category_occasion_content';

    protected $fillable = [
        'category_id',
        'occasion_id',
        'content',
    ];

    protected $casts = [
        'content' => 'string',
    ];

    /**
     * Get the category that owns the content.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the occasion that owns the content.
     */
    public function occasion()
    {
        return $this->belongsTo(Occasion::class, 'occasion_id');
    }

    /**
     * Scope to get content by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to get content by occasion.
     */
    public function scopeByOccasion($query, $occasionId)
    {
        return $query->where('occasion_id', $occasionId);
    }

    /**
     * Get content for specific category and occasion.
     */
    public static function getContentForCategoryOccasion($categoryId, $occasionId)
    {
        return self::where('category_id', $categoryId)
                   ->where('occasion_id', $occasionId)
                   ->first();
    }
}
