<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPackageType extends Model
{
    protected $fillable = ['package_type'];
    public $timestamps = true;

    /**
     * Get the stocks for the package type.
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_package_id');
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
