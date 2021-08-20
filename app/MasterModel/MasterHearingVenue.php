<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHearingVenue extends Model
{
    protected $table = 'master_hearing_venue';
    protected $primaryKey = 'hearing_venue_id';

    protected $fillable = [
    	'hearing_venue',
    	'branch_id',
    	'is_active'
    ];

    public function branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id', 'branch_id');
    }

    public function rooms() {
        return $this->hasMany('App\MasterModel\MasterHearingRoom', 'hearing_venue_id');
    }

}
