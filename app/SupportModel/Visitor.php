<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Visitor extends Model {

	use SoftDeletes;
    public $timestamps = false;
	protected $table = 'visitor';
    protected $primaryKey = 'visitor_id';

    public function reason() {
    	
    	return $this->belongsTo('App\MasterModel\MasterVisitorReason', 'visitor_reason_id','visitor_reason_id');
    }

    public function psu() {

    	return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }

    public function country() {
    	
    	return $this->belongsTo('App\MasterModel\MasterCountry', 'country_id', 'country_id');
    }

    protected $appends = ['state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStateIdAttribute() {

        if($this->psu)
            return $this->psu->ttpm_data->branch->branch_state_id;

        return false;
    }
	
}