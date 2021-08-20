<?php

namespace App\HearingModel;

use Illuminate\Database\Eloquent\Model;

class Hearing extends Model
{
    protected $table = 'hearing';
    protected $primaryKey = 'hearing_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'president_user_id',
        'state_id',
        'branch_id',
        'district_id',
        'hearing_room_id',
        'hearing_date',
        'hearing_time',
        'created_by_user_id',
    ];

//    protected $dates = [
//        'hearing_date',
//    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function president() {
        return $this->belongsTo('App\User', 'president_user_id', 'user_id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id', 'state_id');
    }

    public function branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id', 'branch_id');
    }
    
    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id', 'district_id');
    }

    public function hearing_room() {
        return $this->belongsTo('App\MasterModel\MasterHearingRoom', 'hearing_room_id', 'hearing_room_id');
    }

    public function form4() {
        return $this->hasMany('App\CaseModel\Form4', 'hearing_id');
    }
}
