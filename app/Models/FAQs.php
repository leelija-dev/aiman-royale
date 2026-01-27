<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use App\Models\Page;

class FAQs extends Model
{
    use SoftDeletes;
    protected $table='faqs';
    protected $fillable=[
        'page_id',
        'question',
        'answer',
        'status'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the FAQs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page(): BelongsTo {
        return $this->belongsTo(Page::class, 'page_id', 'page_id');
    }
}
