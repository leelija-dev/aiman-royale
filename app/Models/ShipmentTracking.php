<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    //
    protected $table = 'shipment_trackings';

    protected $fillable = [
        'order_id',  // Add this
        'awb',
        'reference_no',
        'status',
        'status_type',
        'location',
        'remarks',
        'status_date',
        'payload',
    ];

    protected $casts = [
        'status_date' => 'datetime',
        'payload' => 'array',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
