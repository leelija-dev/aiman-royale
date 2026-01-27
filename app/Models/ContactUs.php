<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ContactUs extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'contact';
    // public $timestamps = true;

    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'phone',
        'services',
        'message',
        'status'
    ];
    protected $dates = ['deleted_at'];
}
