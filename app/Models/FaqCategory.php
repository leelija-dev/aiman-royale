<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table = 'faq_category';
    
    protected $fillable = [
        'category_name',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
