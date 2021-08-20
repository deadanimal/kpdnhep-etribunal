<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterStopMethod extends Model
{
    protected $table = 'master_stop_method';
    protected $primaryKey = 'stop_method_id';

    protected $fillable = [
    	'stop_method_en',
        'stop_method_my'
    ];

    // public function venue() {
    //     return $this->belongsTo('App\MasterModel\MasterHearingVenue', 'hearing_venue_id', 'hearing_venue_id');
    // }

}
