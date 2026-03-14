<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class FalseReview extends Model
{
    use HasFactory;

    protected $table = 'false_reviews';
    
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'review_text',
        'admin_notes',
        'review_date'
    ];

    protected $casts = [
        'rating' => 'integer',
        'review_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $dates = [
        'review_date',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Accessors for formatted dates
    public function getReviewDateFormattedAttribute()
    {
        return $this->review_date ? $this->review_date->format('M d, Y h:i A') : 'N/A';
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format('M d, Y h:i A') : 'N/A';
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('M d, Y h:i A') : 'N/A';
    }

    // Scopes for common queries
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Helper method for helpful percentage
    public function getHelpfulPercentageAttribute()
    {
        if ($this->total_count > 0) {
            return round(($this->helpful_count / $this->total_count) * 100, 1);
        }
        return 0;
    }

    // Helper method for rating stars
    public function getRatingStarsAttribute()
    {
        return str_repeat('⭐', $this->rating);
    }
}
