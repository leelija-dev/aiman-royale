<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationOtpHistory extends Model
{
    protected $table = 'registration_otp_history';

    protected $fillable = [
        'otp_send_to',
        'otp',
        'message',
        'status',
        'failed_reason',
    ];
}
