<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterOrganization extends Model
{
    protected $table = 'master_organization';
    protected $primaryKey = 'jurisdiction_organization_id';

    protected $fillable = [
        'jurisdiction_organization_id',
    	'organization',
    	'org_address',
    	'org_address2',
    	'org_address3',
    	'org_postcode',
        'org_state_id',
    	'org_district_id',
    	'org_office_phone',
    	'org_office_fax',
    	'org_email',
    	'org_description',
    ];

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'org_district_id', 'district_id');
    }
    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'org_state_id', 'state_id');
    }
}
