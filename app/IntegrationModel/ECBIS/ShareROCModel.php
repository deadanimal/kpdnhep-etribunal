<?php

namespace App\IntegrationModel\ECBIS;

use Illuminate\Database\Eloquent\Model;

class ShareROCModel extends Model
{
    //
    protected $connection = 'mysql2';
	protected $table = 'vw_share_roc';
	public $timestamps = false;
}
