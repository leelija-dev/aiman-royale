<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReverseOrderItem extends Model
{
    protected $table = 'reverse_order_items';

    protected $fillable = [
        'reverse_order_id',
        'order_product_id',
        'product_id',
        'variant_id',
        'sku_code',
        'sku_name',
        'quantity'
    ];

    public function reverseOrder(): BelongsTo
    {
        return $this->belongsTo(ReverseOrder::class, 'reverse_order_id');
    }

    public function orderProduct(): BelongsTo
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
