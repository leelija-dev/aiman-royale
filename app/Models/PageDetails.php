<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageDetails extends Model
{
    //use HasFactory;

    protected $fillable = [
        'page_id','section_name','page_data',
        'order', 'used_component',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

   
    public function componentDetails(): HasMany
    {
        return $this->hasMany(ComponentDetails::class, 'page_details_id', 'id')->orderBy('component_id');
    }

}
