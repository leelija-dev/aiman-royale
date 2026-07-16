<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerDetails extends Model
{

    protected $table = 'banner_details';
    protected $fillable = [
            'title',
            'offer',
            'short_description',
            'redirect_link',
            'position',
            'image',
            'public_id',
            'is_active'
    ];
     
}
