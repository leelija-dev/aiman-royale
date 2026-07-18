<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';
    protected $fillable = [
        'name',
        'code',
        'discount',
        'code_type',
        'minimum_amount',
        'code_for',
        'validity',
        'is_active',
        'expiry_date'
    ];
}
