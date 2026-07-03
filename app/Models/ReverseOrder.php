<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReverseOrder extends Model
{
    protected $table = 'reverse_orders';

    protected $fillable = [
        'order_id',
        'requested_by_user_id',
        'reverse_order_number',
        'status',
        'return_contact_name',
        'return_phone_no',
        'return_address_1',
        'return_address_2',
        'return_city',
        'return_state',
        'return_pincode',
        'return_reason',
        'order_date'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReverseOrderItem::class, 'reverse_order_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by_user_id');
    }
}
