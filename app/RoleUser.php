<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //
    protected $table = 'role_user';
    protected $primaryKey = 'role_user';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
    	'role_id',
        'user_type',
    ];

    public function role() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
