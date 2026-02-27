<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDimension extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'bust',
        'waist',
        'hip',
        'armhole',
        'color_code',
        'status',
    ];

    protected $casts = [
        'bust' => 'decimal:2',
        'waist' => 'decimal:2',
        'hip' => 'decimal:2',
        'armhole' => 'decimal:2',
    ];

    /**
     * Get the user that owns the custom dimension.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the custom dimension.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
