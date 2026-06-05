<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ContactUs extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'contact_us';
    // public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'inquiry_type',
        'message',
    ];
    // protected $dates = ['deleted_at'];
}
