<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLogin extends Model
{
    protected $table = 'admin_logins';
    public $timestamps = false;
    protected $primaryKey = 'al_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'al_id',
        'al_name',
        'al_user_name',
        'al_password',
        'created_at',
        'updated_at',
    ];

}
