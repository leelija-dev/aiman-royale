<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReverseOrder extends Model
{
    use HasFactory;
    protected $table = 'reverse_orders';

    protected $fillable = [
        'order_id',
        'requested_by_user_id',
        'reverse_order_number',
        'waybill',  // ✅ Add this
        'delhivery_response',  // ✅ Add this
        'awb_status',  // ✅ Add this
        'status',
        'return_contact_name',
        'return_phone_no',
        'return_address_1',
        'return_address_2',
        'return_city',
        'return_state',
        'return_pincode',
        'return_reason',
        'order_date',
    ];

    protected $casts = [
        'delhivery_response' => 'array',  // ✅ Cast to array
        'order_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship with reverse order items
    public function items(): HasMany
    {
        return $this->hasMany(ReverseOrderItem::class, 'reverse_order_id');
    }

    // Accessor for status color
    public function getStatusColorAttribute()
    {
        $colors = [
            'ready_for_pickup' => 'warning',
            'in_transit' => 'info',
            'out_for_delivery' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'secondary',
            'failed' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    // Check if waybill is available
    public function hasWaybill()
    {
        return !empty($this->waybill);
    }

    // Get waybill URL (if you have a tracking page)
    public function getTrackingUrlAttribute()
    {
        if ($this->waybill) {
            return 'https://www.delhivery.com/track/' . $this->waybill;
        }
        return null;
    }

       public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by_user_id');
    }
}