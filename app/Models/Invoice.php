<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoice';

    protected $fillable = [
        'bill_id',
        'bill_date',
        'total_amount',
        'total_items',
        'created_by',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'total_amount' => 'decimal:2',
        'total_items' => 'decimal:2',
        //'discount' => 'decimal:2'
    ];

    protected $dates = [
        'bill_date',
        'deleted_at',
    ];
    public function items()
    {
        return $this->hasMany(Bill::class, 'invoice_id', 'id');
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Add relation to fetch the shop using business key 'shop_id'
    // public function shop()
    // {
    //     return $this->belongsTo(Shop::class, 'shop_id', 'id');
    // }
    public function shop()
{
    return $this->belongsTo(Shop::class)->withTrashed();
}

}
