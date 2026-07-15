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
        'is_fake_order',
        'transection_id',
        'payment_status',
        'paid_at', 	
        'address_1',	
        'address_2',
        'state',	
        'city',	
        'pincode',	
        'phone_no',
        'cancelled_at',
        'cancel_reason'
    ];
    
    public function orderProducts(){
        return $this->hasMany(OrderProduct::class ,'order_id');
    }
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

}
