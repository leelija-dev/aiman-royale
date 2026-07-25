<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offer';
    protected $fillable = [
        'name',
        'discount',
        'start_date',
        'end_date',
        'duration',    
        'apply_on',
        'is_active',
        'is_timer',

        ];

    public function offerProducts()
    {
        return $this->hasMany(OfferProducts::class);
    }

}
