<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class AttendanceRepresentative extends Model
{
    //
    protected $table = 'attendance_representative';
    protected $primaryKey = 'attendance_representative_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendance_representative_id',
        'attendance_id',
        'identification_no',
        'name',
        'relationship_id',
        'designation_id',
        'is_representing_claimant'
    ];

    public function attendance() {
        return $this->belongsTo('App\CaseModel\Attendance', 'attendance_id');
    }

    public function relationship() {
        return $this->belongsTo('App\MasterModel\MasterRelationship', 'relationship_id');
    }

    public function designation() {
        return $this->belongsTo('App\MasterModel\MasterDesignation', 'designation_id');
    }


}
