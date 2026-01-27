<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Job extends Model
{
    use HasFactory;

    protected $table = 'all_jobs';
    public $timestamps = false;

    protected $fillable = [
        'job_name',
        'details',
        'date'
    ];
}
