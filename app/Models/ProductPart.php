<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'part_name',
        'fabric',
        'work_type',
        'color',
        'pattern',
        'embroidery',
        'lining',
        'description',
        'order'
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the product that owns the part.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to order parts by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }
}
