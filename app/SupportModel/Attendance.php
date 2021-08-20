<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendance_id',
        'form4_id',
        'is_claimant_presence',
        'is_opponent_presence',
        'created_by_user_id'
    ];

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id');
    }
    

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function minutes() {
        return $this->hasMany('App\SupportModel\AttendanceMinutes', 'attendance_id');
    }

    public function representative() {
        return $this->hasMany('App\SupportModel\AttendanceRepresentative', 'attendance_id', 'attendance_id');
    }


}
