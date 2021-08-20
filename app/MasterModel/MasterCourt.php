<?php

namespace App\MasterModel;

use App\CaseModel\Form4;
use Illuminate\Database\Eloquent\Model;

class MasterCourt extends Model
{
    protected $table = 'master_court';
    protected $primaryKey = 'court_id';

    protected $fillable = [
    	'court_name',
        'court_name_en',
    	'address1',
    	'address2',
    	'postcode',
    	'district_id',
    	'state_id',
    	'branch_id',
    	'is_active',
        'is_magistrate',
        'is_hearing_result',
    ];

     public function district() {
		return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id');
	}

	public function state() {
		return $this->belongsTo('App\MasterModel\MasterState', 'state_id');
	}

	public function branch() {
		return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id');
	}

    public function form4() {
        return $this->hasMany(Form4::class, 'letter_court_id');
    }
}

