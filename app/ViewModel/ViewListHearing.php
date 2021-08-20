<?php

namespace App\ViewModel;

use App\CaseModel\ClaimCase;
use Illuminate\Database\Eloquent\Model;

class ViewListHearing extends Model
{
    //
    protected $table = 'view_listhearing';

    public function branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch', 'branch');
    }

    public function hearing_room() {
        return $this->belongsTo('App\MasterModel\MasterHearingRoom', 'hearing_room_id', 'hearing_room_id');
    }

    public function hearing_venue() {
        return $this->belongsTo('App\MasterModel\MasterHearingVenue', 'hearing_venue_id', 'hearing_venue_id');
    }

    public function president() {
        return $this->belongsTo('App\User', 'president_user_id', 'user_id');
    }

    public function f2_status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'f2_status_id', 'form_status_id');
    }

    public function f3_status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'f3_status_id', 'form_status_id');
    }

    public function claimCase() {
        return $this->belongsTo(ClaimCase::class, 'claim_case_id', 'claim_case_id');
    }
}