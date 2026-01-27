<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockHistory extends Model
{
    //
    use HasFactory;

    protected $table = 'stock_histories';

    // Fields that can be mass assigned
    protected $fillable = [
        'stock_id',
        'quantity',
        'purchase_price',
        'selling_price',
    ];

    /**
     * Relationship: Each stock history belongs to a stock
     */
    // app/Models/StockHistory.php
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
}
