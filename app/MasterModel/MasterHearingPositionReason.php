<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHearingPositionReason extends Model
{
    protected $table = 'master_hearing_position_reason';
    protected $primaryKey = 'hearing_position_reason_id';

    protected $fillable = [
        'hearing_position_reason_id',
        'hearing_position_reason_en',
        'hearing_position_reason_my',
        'hearing_position_id'
    ];

    public function position (){
    	return $this->belongsTo('App\MasterModel\MasterHearingPosition', 'hearing_position_id');
    }
}
 