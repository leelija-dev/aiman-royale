<?php

namespace App\Models;

use App\Models\ProductImage;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'design_no',
        'category_id',
        'ocassion_id',
        'name',
        'slug',
        'description',
        'brand',
        'fabric',
        'fit',
        'price',
        'discount_price',
        'stock',
        'status',
        'featured_image',
        'is_featured',
        'meta_title',
        'keywords',
        'tags',
        'meta_description',
        'schema_markup',
        'ready_to_ship'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'status' => 'string',
        'is_featured' => 'boolean',
        'ready_to_ship' => 'boolean'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = $product->generateUniqueSlug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = $product->generateUniqueSlug($product->name);
            }
        });
    }

    /**
     * Generate a unique slug for the product.
     *
     * @param string $title
     * @return string
     */
    // private function generateUniqueSlug($title)
    // {
    //     $slug = Str::slug($title);
    //     $originalSlug = $slug;
    //     $counter = 1;

    //     while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
    //         $slug = $originalSlug . '-' . $counter;
    //         $counter++;
    //     }

    //     return $slug;
    // }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo('App\\Models\\Category','category_id');
    }

    /**
     * Get the occasion that owns the product.
     */
    public function occasion(): BelongsTo
    {
        return $this->belongsTo('App\\Models\\Occasion', 'ocassion_id');
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the images associated with the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /**
     * Get the variants associated with the product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany('App\\Models\\ProductVariant', 'product_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany('App\\Models\\Wishlist', 'product_id');
    }

    /**
     * Get the order products associated with the product.
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany('App\\Models\\OrderProduct', 'product_id');
    }
}
