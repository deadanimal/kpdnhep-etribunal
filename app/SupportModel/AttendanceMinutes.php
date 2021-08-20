<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class AttendanceMinutes extends Model
{
    //
    protected $table = 'attendance_minutes';
    protected $primaryKey = 'attendance_minutes_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendance_minutes_id',
        'attendance_id',
        'form4_id',
        'psu_user_id'
    ];

    public function attendance() {
        return $this->belongsTo('App\SupportModel\Attendance', 'attendance_id');
    }

    public function psu() {
        return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }


}
