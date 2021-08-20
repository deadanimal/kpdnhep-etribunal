<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserPublicIndividual extends Model
{
    protected $table = 'user_public_individual';
    protected $primaryKey = 'user_public_individual_id';
    //public $timestamps = false;

    protected $fillable = [
    	'user_id',
        'nationality_country_id',
		'identification_no',
		'gender_id',
		'date_of_birth',
		'race_id',
		'occupation_id',
		'phone_home',
		'phone_mobile',
		'is_tourist',
    ];


    protected $appends = ['branch_id', 'age'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */


    public function getBranchIdAttribute() {

        $cases = \App\CaseModel\ClaimCase::where('claimant_user_id', $this->user_id)->orWhere('opponent_user_id', $this->user_id);

        if($cases->get()->count() > 0) {

            $cases = $cases->get();

            if($cases->last()->branch_id)
                return $cases->last()->branch_id;
            else
                return $cases->first()->branch_id;
        }
        else {
            return null;
        }
        
    }

    public function getAgeAttribute() {

        if($this->date_of_birth)
            return Carbon::createFromFormat('Y-m-d', $this->date_of_birth)->age;
        else
            return 0;
        
    }

    public function nationality() {
        return $this->belongsTo('App\MasterModel\MasterCountry', 'nationality_country_id');
    }

    public function gender() {
        return $this->belongsTo('App\MasterModel\MasterGender', 'gender_id');
    }

    public function race() {
        return $this->belongsTo('App\MasterModel\MasterRace', 'race_id');
    }

    public function occupation() {
        return $this->belongsTo('App\MasterModel\MasterOccupation', 'occupation_id');
    }

    public function user_public () {
        return $this->belongsTo('App\UserPublic', 'user_id', 'user_id');
    }
}
