<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    
    protected $table = 'permission_role';
    protected $primaryKey = 'permission_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    	'permission_id',
        'role_id',
    ];
}
