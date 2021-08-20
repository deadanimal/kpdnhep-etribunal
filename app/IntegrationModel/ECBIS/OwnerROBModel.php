<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class OwnerROBModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'vw_owner_rob';
	//protected $primaryKey = 'kod';
	public $timestamps = false;
}
