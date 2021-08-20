<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'myidentity_state';
    protected $primaryKey = 'state_id';
    public $timestamps = false;
}
