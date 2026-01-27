<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Components extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'components';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'component_name',
        'order',
        'title',
        'cards_data'
    ];

    // In ComponentDetail model
    // public function page()
    // {
    //     return $this->belongsTo(Page::class);
    // }
    public function page()
{
    return $this->belongsTo(Page::class, 'page_id', 'page_id');
}



    
}
