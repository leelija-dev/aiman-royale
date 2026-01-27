<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Application extends Model
{
   use SoftDeletes;
   protected $table = 'user_application';
  
   protected $fillable =[        
            'name',
            'mobile_number',
            'email',
            'linkedin_profile',
            'job_role',
            'exprience',
            'uploadcv',
            'current_ctc',
            'expected_ctc',
            'cover_letter',
            'status',
            'vacancy_id'
   ];
    protected $dates = ['deleted_at'];
}
