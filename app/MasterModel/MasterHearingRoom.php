<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHearingRoom extends Model
{
    protected $table = 'master_hearing_room';
    protected $primaryKey = 'hearing_room_id';

    protected $fillable = [
    	'hearing_room',
    	'address',
        'hearing_venue_id',
    	'is_active'
    ];

    public function venue() {
        return $this->belongsTo('App\MasterModel\MasterHearingVenue', 'hearing_venue_id', 'hearing_venue_id');
    }

    public function hearings() {
        return $this->hasMany('App\HearingModel\Hearing', 'hearing_room_id');
    }

}
