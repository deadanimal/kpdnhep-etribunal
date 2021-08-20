<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class CompanyROCModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'vw_syrkt_roc';
	protected $primaryKey = 'id_syarikat';
    public $incrementing = false;
	public $timestamps = false;
}
