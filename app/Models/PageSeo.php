<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    //
    protected $table = 'page_seo';
    protected $fillable = [
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_tags',
        'schema_markup',
        'is_active'
    ];
}
