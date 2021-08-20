<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;

class ViewListHearingAttendance extends Model
{
    //
    protected $table = 'view_listhearing_attendance';

    public function branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch', 'branch');
    }

    public function case() {
        return $this->belongsTo('App\CaseModel\ClaimCase', 'claim_case_id', 'claim_case_id');
    }

    public function hearing_room() {
        return $this->belongsTo('App\MasterModel\MasterHearingRoom', 'hearing_room_id', 'hearing_room_id');
    }

    public function hearing_venue() {
        return $this->belongsTo('App\MasterModel\MasterHearingVenue', 'hearing_venue_id', 'hearing_venue_id');
    }

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }

    public function f12_status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'f12_status_id', 'form_status_id');
    }

    public function f2_status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'f2_status_id', 'form_status_id');
    }

    public function f3_status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'f3_status_id', 'form_status_id');
    }
}