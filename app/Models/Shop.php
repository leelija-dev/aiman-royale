<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Shop extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'shop_name',
        'shop_address',
        'mobile_number',
        'due_amount'
    ];

    public static $rules = [
        'shop_name' => 'required|string|max:255',
        'shop_address' => 'nullable|string',
        'mobile_number' => 'nullable|string|max:20'
    ];

    protected $casts = [
        'due_amount' => 'decimal:2'
    ];
}
