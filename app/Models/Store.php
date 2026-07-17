<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $fillable = [
            'name',
            'phone_number',
            'email',
            'address',
            'state',
            'country',
            'gst_number',
            'gst_percentage',
            'is_active',
    ];
}
