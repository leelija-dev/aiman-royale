<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'purchase_price',
        'selling_price',
        'product_package_id',
        'product_package_quantity',
        'unit_amount',
        'unit_id',
        'quantity_in_stock'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'unit_amount' => 'decimal:2',
        'product_package_quantity' => 'decimal:2',
        'quantity_in_stock' => 'decimal:2'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // public function packageType(): BelongsTo
    // {
    //     return $this->belongsTo(ProductPackageType::class, 'product_package_id');
    // }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'product_package_id', 'id');
    }

    public function updateStock(int $quantity, string $type = 'in'): void
    {
        if ($type === 'in') {
            $this->increment('product_package_quantity', $quantity);
        } else {
            $this->decrement('product_package_quantity', $quantity);
        }
        $this->save();
    }

    // In Stock.php
    // app/Models/Stock.php
    public function histories()
    {
        return $this->hasMany(StockHistory::class, 'stock_id', 'id');
    }
}
