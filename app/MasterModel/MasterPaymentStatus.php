<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterPaymentStatus extends Model
{
    protected $table = 'master_payment_status';
    protected $primaryKey = 'payment_status_id';
}
