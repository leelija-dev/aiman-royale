<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BannerComponent extends Model
{
    protected $table = 'banner_component'; // ← if your table is singular (uncommon, but ok)

    // protected $primaryKey = 'id'; // default anyway
    // public $incrementing = true;
    // protected $keyType = 'int';   // default

    /**
     * Get all the offer banners that use this banner component.
     */
    public function offerBanners(): HasMany
    {
        return $this->hasMany(OfferBanner::class, 'banner_component_id', 'id');
    }

}