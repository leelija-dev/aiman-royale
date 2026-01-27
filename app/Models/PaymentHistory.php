<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';
    protected $fillable = [
        'shop_id',
        'paid_amount',
        'due_amount',
        'payment_from',
        'remark'
    ];
}
