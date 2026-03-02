<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table='ordered_products';
    protected $fillable=[
        'user_id',
        'order_id', 
        'product_id', 
        'variant_id', 
        'quantity',	
        'price',	
        'total',
        'request_id',
        'status',
        'payment_status',
        'order_date',
        'custom_measurements'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
