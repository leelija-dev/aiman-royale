<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ApplicationStatus extends Model
{
    use SoftDeletes;
    protected $table='app_status';
    protected $fillable =['status_id','status'];
    protected $dates = ['deleted_at'];
}
