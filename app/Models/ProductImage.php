<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',      // Store Cloudinary URL
        'public_id',  // Store Cloudinary public ID for deletion
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the product that owns the image
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get optimized version of this image
     */
    public function getOptimizedUrl($width = null, $height = null)
    {
        if (!$this->public_id) {
            return $this->image;
        }

        $transformations = [];
        if ($width && $height) {
            $transformations[] = "c_fill,w_{$width},h_{$height}";
        }
        $transformations[] = 'q_auto';
        $transformations[] = 'f_auto';

        $transString = implode(',', $transformations);
        return "https://res.cloudinary.com/your-cloud-name/image/upload/{$transString}/{$this->public_id}";
    }
}
