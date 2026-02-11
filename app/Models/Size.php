<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Decimal;

class Size extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'sort_order',
        'chest_size',
        'neck_size',
        'waist_size'
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'sort_order' => 'integer',
        'chest_size'=>'decimal:2',
        'neck_size'=>'decimal:2',
        'waist_size'=>'decimal:2'
    ];

    /**
     * Get the products for the size.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes');
    }
}
