<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
     protected $table = 'contact_reply';
      protected $fillable = [
        'contact_id',
        'reply',
        'subject'
    ];
}
