<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPublicCompany extends Model
{
    protected $table = 'user_public_company';
    protected $primaryKey = 'user_public_company_id';
    //public $timestamps = false;

    protected $fillable = [
    	'user_id',
        'company_no',
		'representative_name',
		'representative_nationality_country_id',
		'representative_identification_no',
		'representative_designation_id',
		'representative_phone_home',
		'representative_phone_mobile',
    ];

    public function nationality() {
        return $this->belongsTo('App\MasterModel\MasterCountry', 'representative_nationality_country_id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'representative_designation_id');
    }

    public function user () {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
