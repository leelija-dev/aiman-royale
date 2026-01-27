<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($keyword) {
            $keyword->slug = Str::slug($keyword->name);
        });

        static::updating(function ($keyword) {
            $keyword->slug = Str::slug($keyword->name);
        });
    }
}
