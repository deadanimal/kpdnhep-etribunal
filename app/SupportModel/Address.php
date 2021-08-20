<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $table = 'address';
    protected $primaryKey = 'address_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'street_1',
        'street_2',
        'street_3',
        'postcode',
        'district_id',
        'state_id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id');
    }

}
