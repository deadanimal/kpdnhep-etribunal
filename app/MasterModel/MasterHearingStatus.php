<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHearingStatus extends Model
{
    protected $table = 'master_hearing_status';
    protected $primaryKey = 'hearing_status_id';

    protected $fillable = [
        'hearing_status_id',
        'hearing_status_en',
        'hearing_status_my'
    ];

}
 