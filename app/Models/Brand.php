<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the products associated with the brand.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the number of products for this brand.
     * 
     * @return int
     */
    public function getProductsCountAttribute()
    {
        return $this->products ? $this->products->count() : 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = \Illuminate\Support\Str::slug($brand->name);
            }
        });

        static::updating(function ($brand) {
            if (empty($brand->slug) || $brand->isDirty('name')) {
                $brand->slug = \Illuminate\Support\Str::slug($brand->name);
            }
        });
    }
}
