<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Bill extends Model
{
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_name',
        'product_sku',
        'brand',
        'category',
        'quantity',
        'unit_price',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function invoice()
    // {
    //     return $this->belongsTo(Invoice::class, 'invoice_id');
    // }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    // public function invoice()
    // {
    //     return $this->belongsTo(Invoice::class, 'bill_id', 'id');
    // }
}
