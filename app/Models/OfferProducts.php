<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferProducts extends Model
{
    protected $table = 'offer_products';
    protected $fillable = [
        'offer_id',
        'product_id',
        'product_variant_id'
    ];
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
