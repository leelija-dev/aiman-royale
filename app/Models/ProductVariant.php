<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ProductImage;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = ['images'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'color_code',
        'sku',
        'price',
        'coupon_id',
        'fixed_price',
        'final_price',
        'discount',
        'discount_price',
        'stock',
        'video_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id' => 'integer',
        'size' => 'string',
        'color' => 'string',
        'sku' => 'string',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'video_url' => 'string',
    ];

    /**
     * Get the product that owns the variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color associated with the variant.
     */
    public function colorModel()
    {
        return $this->belongsTo(Color::class, 'color', 'name');
    }

    /**
     * Get the size associated with the variant.
     */
    public function sizeModel()
    {
        return $this->belongsTo(Size::class, 'size', 'name');
    }

    /**
     * Scope to get variants in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Get the effective price (discount price if available, otherwise regular price).
     */
    public function getEffectivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Get the variant display name.
     */
    public function getDisplayNameAttribute()
    {
        $parts = [];
        if ($this->color) $parts[] = $this->color;
        if ($this->size) $parts[] = $this->size;
        
        return $this->product->name . ($parts ? ' - ' . implode(' / ', $parts) : '');
    }
    public function images()
{
    return $this->hasMany(ProductImage::class, 'variant_id');
}

}
