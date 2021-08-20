<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterApplicationMethod extends Model
{
    protected $table = 'master_application_method';
    protected $primaryKey = 'application_method_id';
    // Display Field from DB
    protected $fillable = [
    	'method_en',
    	'method_my',
    	'is_active'
    ];
}

