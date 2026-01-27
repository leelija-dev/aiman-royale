<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'sku',
        'price',
        'discount_price',
        'stock',
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
}
