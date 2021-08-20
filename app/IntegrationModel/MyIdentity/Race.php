<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $table = 'myidentity_race';
    protected $primaryKey = 'race_id';
    public $timestamps = false;
}
