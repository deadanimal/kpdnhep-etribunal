<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class ParameterROCModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'parametersroc';
	protected $primaryKey = 'srlkeycode';
	public $timestamps = false;
}
