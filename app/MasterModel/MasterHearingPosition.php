<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHearingPosition extends Model
{
    protected $table = 'master_hearing_position';
    protected $primaryKey = 'hearing_position_id';

    protected $fillable = [
        'hearing_position_id',
        'hearing_position_en',
        'hearing_position_my',
        'hearing_status_id'
    ];

    public function status (){
    	return $this->belongsTo('App\MasterModel\MasterHearingStatus', 'hearing_status_id');
    }
}
 