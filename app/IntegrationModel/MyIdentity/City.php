<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'myidentity_city';
    protected $primaryKey = 'city_id';
    public $timestamps = false;
}
