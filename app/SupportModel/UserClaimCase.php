<?php

namespace App\SupportModel;

use App\MasterModel\MasterSubdistrict;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserClaimCase extends Model
{
    //
    protected $table = 'user_claimcase';
    protected $primaryKey = 'user_claimcase_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'is_company',
        'name',
        'identification_no',
        'nationality_country_id',
        'street_1',
        'street_2',
        'street_3',
        'postcode',
        'subdistrict_id',
        'district_id',
        'state_id',
        'phone_home',
        'phone_mobile',
        'phone_fax',
        'phone_office',
        'email',
        'age',
        'created_by_user_id',
        'created_at',
        'updated_at'
    ];

    public function subdistrict() {
        return $this->belongsTo(MasterSubdistrict::class);
    }

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id');
    }

    public function district2() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id');
    }

    public function nationality() {
        return $this->belongsTo('App\MasterModel\MasterCountry', 'nationality_country_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
