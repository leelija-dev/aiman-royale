<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_in';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id' => 'integer',
        'product_variant_id' => 'integer',
        'stock' => 'integer',
    ];

    /**
     * Get the product that owns the stock entry.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the stock entry.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Scope to get stock entries for products only.
     */
    public function scopeProductOnly($query)
    {
        return $query->whereNotNull('product_id');
    }

    /**
     * Scope to get stock entries for variants only.
     */
    public function scopeVariantOnly($query)
    {
        return $query->whereNotNull('product_variant_id');
    }

    /**
     * Get the display name (product name or variant name).
     */
    public function getDisplayNameAttribute()
    {
        if ($this->productVariant) {
            return $this->productVariant->display_name ?? 'Unknown Variant';
        }
        
        return $this->product->name ?? 'Unknown Product';
    }

    /**
     * Get the stock type description.
     */
    public function getStockTypeAttribute()
    {
        return $this->productVariant ? 'Product Variant' : 'Product';
    }
}
