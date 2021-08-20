<?php

namespace App;

use App\MasterModel\MasterSubdistrict;
use Illuminate\Database\Eloquent\Model;

class UserPublic extends Model
{
    protected $table = 'user_public';
    protected $primaryKey = 'user_public_id';
    //public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_public_type_id',
        'address_street_1',
        'address_street_2',
        'address_street_3',
        'address_postcode',
        'address_subdistrict_id',
        'address_district_id',
        'address_state_id',
        'address_mailing_street_1',
        'address_mailing_street_2',
        'address_mailing_street_3',
        'address_mailing_postcode',
        'address_mailing_subdistrict_id',
        'address_mailing_district_id',
        'address_mailing_state_id',
        'notification_method_id',
    ];

    /*
     * Relationship
     */
    public function company()
    {
        return $this->hasOne('App\UserPublicCompany', 'user_id', 'user_id');
    }

    public function addressSubdistrict()
    {
        return $this->belongsTo(MasterSubdistrict::class, 'address_subdistrict_id');
    }

    public function district()
    {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'address_district_id');
    }

    public function individual()
    {
        return $this->hasOne(UserPublicIndividual::class, 'user_id', 'user_id');
    }

    public function addressMailingSubdistrict()
    {
        return $this->belongsTo(MasterSubdistrict::class, 'address_mailing_subdistrict_id');
    }

    public function mailing_district()
    {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'address_mailing_district_id');
    }

    public function mailing_state()
    {
        return $this->belongsTo('App\MasterModel\MasterState', 'address_mailing_state_id');
    }

    public function notification()
    {
        return $this->belongsTo('App\MasterModel\MasterNotificationMethod', 'notification_method_id');
    }

    public function state()
    {
        return $this->belongsTo('App\MasterModel\MasterState', 'address_state_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function user_public_type()
    {
        return $this->belongsTo('App\MasterModel\MasterUserPublicType', 'user_public_type_id');
    }
}
