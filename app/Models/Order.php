<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'total_amount',
        'order_status',
        'is_fake_order',
        'transection_id',
        'payment_status',
        'payment_method',
        'cashfree_order_ref',
        'refund_status',
        'refund_error',
        'paid_at',
        'address_1',
        'address_2',
        'state',
        'city',
        'pincode',
        'phone_no',
        'cancelled_at',
        'cancel_reason',
        'gst_percentage',
        'gst_amount',
        'special_discount',
        'special_discount_amount',
        'special_discount_id',
        'special_discount_name'
    ];


    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class, 'order_id');
    }

    public function reverseOrders(): HasMany
    {
        return $this->hasMany(ReverseOrder::class, 'order_id');
    }
}
