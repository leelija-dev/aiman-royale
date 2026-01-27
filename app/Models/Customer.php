<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'customer_type',
        'member_id',
        'user_name',
        'email',
        'password',
        'billing_name',
        'fname',
        'lname',
        'gender',
        'dob',
        'status',
        'image',
        'brief',
        'description',
        'organization',
        'featured',
        'profession',
        'sort_order',
        'verification_no',
        'acc_verified',
        'verified_by',
        'verified_on',
        'discount_offered',
    ];

   
    protected $casts = [
        'dob' => 'date', 
        'verified_on' => 'datetime', 
        'discount_offered' => 'float', 
    ];

    

}
