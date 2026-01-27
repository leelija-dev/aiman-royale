<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JobVacancy extends Model
{
    use SoftDeletes;

   
    protected $table = 'job_vacancy';
    protected $fillable = ['job_role','exprience','location','skills','description','department','status'];
    protected $dates = ['deleted_at'];
}


