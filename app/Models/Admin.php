<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use HasRoles;
    protected $guard_name = 'admin'; // ✅ MUST be set
    protected $table = 'admin_users';
    protected $primaryKey = 'user_id';
    // App\Models\Admin.php

    // public $incrementing = false;
    // protected $keyType = 'string';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'last_logon',
        'no_logon',
        'fname',
        'lname',
        'address',
        'email',
        'image',
        'description',
        'created_at',
        'updated_at'
    ];
}
