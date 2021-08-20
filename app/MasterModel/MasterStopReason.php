<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterStopReason extends Model
{
    protected $table = 'master_stop_reason';
    protected $primaryKey = 'stop_reason_id';

    protected $fillable = [
    	'stop_reason_en',
    	'stop_reason_my'
    ];

}
