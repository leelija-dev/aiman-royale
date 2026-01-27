<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';   // if your table is singular
    public $timestamps = false;         // ✅ disable created_at, updated_at

    protected $fillable = ['departments', 'status'];
}
