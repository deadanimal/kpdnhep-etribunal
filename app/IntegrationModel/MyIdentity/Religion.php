<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
   	protected $table = 'myidentity_religion';
    protected $primaryKey = 'religion_id';
    public $timestamps = false;
}
