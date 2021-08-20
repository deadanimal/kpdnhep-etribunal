<?php

namespace App\IntegrationModel\MyIdentity;

use Illuminate\Database\Eloquent\Model;

class StatusRecord extends Model
{
    protected $table = 'myidentity_status_record';
    protected $primaryKey = 'status_record_id';
    public $timestamps = false;
}
