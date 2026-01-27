<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Backup extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use HasRoles;
    protected $guard_name = 'admin'; // ✅ MUST be set
    protected $table = 'backup_downloads';
    protected $primaryKey = 'id';
    // App\Models\Admin.php

    // public $incrementing = false;
    // protected $keyType = 'string';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'file_name',
        'downloaded_at',
        'created_at',
        'updated_at'
    ];
}
