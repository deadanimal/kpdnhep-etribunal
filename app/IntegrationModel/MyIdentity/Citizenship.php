<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class Citizenship extends Model
{
    protected $table = 'myidentity_citizenship';
    protected $primaryKey = 'citizenship_id';
    public $timestamps = false;
}
