<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class OwnerROCModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'vw_owner_rob';
	//protected $primaryKey = 'noid_syarikat';
	public $timestamps = false;
}
