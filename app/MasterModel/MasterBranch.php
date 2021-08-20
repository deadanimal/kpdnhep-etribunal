<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterBranch extends Model
{
    protected $table = 'master_branch';
    protected $primaryKey = 'branch_id';

    protected $fillable = [
    	'branch_name',
    	'branch_code',
    	'branch_address',
    	'branch_address2',
    	'branch_address3',
        'branch_address_en',
        'branch_address2_en',
        'branch_address3_en',
        'branch_postcode',
        'branch_state_id',
        'branch_district_id',
        'branch_office_phone',
        'branch_office_fax',
    	'branch_emel',
    	'is_hq',
        'inquiry_counter'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['psus'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getPsusAttribute() {

        // if($this->case)
        //     return $this->case->state_id;

        $psus = \App\RoleUser::with('user.ttpm_data')->where('role_id', 18)->orWhere('role_id', 17)->orWhere('role_id', 10)->get()->where('user.ttpm_data.branch_id', $this->branch_id);

        //dd($psus->first()->attributes);

        $arr = array();
        foreach($psus as $psu) {
            if($psu->user->user_status_id == 1)
                array_push($arr, ['user_id' => $psu->user_id, 'name' => $psu->user->name]);
        }

        return $arr;

    }

    public function district() {
		return $this->belongsTo('App\MasterModel\MasterDistrict', 'branch_district_id');
	}

	public function state() {
		return $this->belongsTo(MasterState::class, 'branch_state_id');
	}

    public function hearings() {
        return $this->hasMany('App\HearingModel\Hearing', 'branch_id');
    }

    public function venues() {
        return $this->hasMany('App\MasterModel\MasterHearingVenue', 'branch_id');
    }
}
