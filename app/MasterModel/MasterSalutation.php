<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterSalutation extends Model
{
    protected $table = 'master_salutation';
    protected $primaryKey = 'salutation_id';

    protected $fillable = [
    	'salutation_id',
    	'salutation_en',
        'salutation_my',
    	'is_active'
    ];

    // public function venue() {
    //     return $this->belongsTo('App\MasterModel\MasterHearingVenue', 'hearing_venue_id', 'hearing_venue_id');
    // }

}
