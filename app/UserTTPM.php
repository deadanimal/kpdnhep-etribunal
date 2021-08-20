<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTTPM extends Model
{
    protected $table = 'user_ttpm';
    protected $primaryKey = 'user_ttpm_id';
    //public $timestamps = false;

    protected $fillable = [
    	'user_ttpm_id',
        'user_id',
		'phone_mobile',
		'identification_no',
		'branch_id',
		'signature_blob',
        'signature_filename',
    ];

    public function branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id');
    }

    public function president() {
        return $this->hasOne('App\UserTTPMPresident', 'user_id', 'user_id');
    }
}
