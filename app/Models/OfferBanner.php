<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferBanner extends Model
{
    protected $table = 'offer_banner';

    /**
     * Get the banner component that this offer banner belongs to / uses.
     */
    public function bannerComponent(): BelongsTo
    {
        return $this->belongsTo(BannerComponent::class, 'banner_component_id', 'id');
    }

}