<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    //
    protected $table = 'permission_user';
    protected $primaryKey = 'permission_user';
    public $timestamps = false;
}
