<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class ParameterROBModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'parametersrob';
	protected $primaryKey = 'srlkeycode';
	public $timestamps = false;
}
