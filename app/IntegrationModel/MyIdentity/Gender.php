<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
   	protected $table = 'myidentity_gender';
    protected $primaryKey = 'gender_id';
    public $timestamps = false;
}
