<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOccasion extends Model
{
    protected $table = 'product_occasions';

    protected $fillable = [
        'product_id',
        'occasion_id',
    ];

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the occasion
     */
    public function occasion()
    {
        return $this->belongsTo(Occasion::class);
    }
}