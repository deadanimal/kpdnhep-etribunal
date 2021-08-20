<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class CompanyROBModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'vw_syrkt_rob';
	//protected $primaryKey = 'id_syarikat';
	public $timestamps = false;

}
