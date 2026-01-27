<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
   use SoftDeletes;
   protected $table = 'services';
   protected $fillable = [
      'name',
      'slug',
      'image',
      'description',
      'status',
      'accept_lead',
      'parent_id'
   ];
   protected $dates = ['deleted_at'];

   public function parent()
   {
      return $this->belongsTo(self::class, 'parent_id');
   }

   // public function children()          // 1‑level children
   // {
   //    return $this->hasMany(self::class, 'parent_id')
   //       ->orderBy('name');   // optional ordering
   // }

   public function children()
   {
      return $this->hasMany(self::class, 'parent_id')->with('children');  // Recursive call
   }

   // If you ever need infinite depth:
   public function childrenRecursive()
   {
      return $this->children()->with('childrenRecursive');
   }

   public function page()
   {
      return $this->hasOne(Page::class, 'service_id');
   }

   // If you sometimes need “how many pages?”
   public function pages()
   {
      return $this->hasMany(Page::class, 'service_id');
   }
}
