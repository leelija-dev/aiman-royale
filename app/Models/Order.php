<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table='orders';
    protected $fillable=[
        'user_id',
        'total_amount',
        'order_status',
        'transection_id',
        'payment_status',
        'paid_at', 	
        'address_1',	
        'address_2',
        'state',	
        'city',	
        'pincode',	
        'phone_no'

    ];
    
    public function orderProducts(){
        return $this->hasMany(OrderProduct::class ,'order_id');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

}
