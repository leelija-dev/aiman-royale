<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    //use HasFactory;
    protected $table = 'pages';
    protected $primaryKey = 'page_id';
    public $timestamps = false;
    protected $fillable = ['service_id', 'meta_title', 'meta_keyword', 'meta_tags', 'meta_description','schema', 'status'];
    
    // public function pageDetails(): HasMany
    // {
    //     return $this->hasMany(PageDetails::class, 'page_id', 'id')->orderBy('order');
    // } 
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function componentDetail(): HasMany
    {
        return $this->hasMany(ComponentDetails::class);
    }
    public function pageMetas(): HasMany
    {
        return $this->hasMany(MetaData::class,'page_id','id');
    }

    public function components()
{
    return $this->hasMany(Components::class, 'page_id', 'page_id');
}

    
   
}
