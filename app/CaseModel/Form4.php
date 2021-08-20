<?php

namespace App\CaseModel;

use App\MasterModel\MasterBranchAddress;
use App\MasterModel\MasterCourt;
use App\User;
use App\ViewModel\ViewForm4Before;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form4 extends Model
{
    use SoftDeletes;

    protected $table = 'form4';
    protected $primaryKey = 'form4_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'claim_case_id',
        'opponent_user_id',
        'claim_case_opponent_id',
        'hearing_id',
        'form_status_id',
        'created_by_user_id',
        'hearing_status_id',
        'hearing_position_id',
        'hearing_position_reason_id',
        'hearing_details',
        'letter_branch_address_id',
        'letter_court_id',
        'president_user_id',
        'award_id',
        'form12_id',
        'psu_user_id',
        'hearing_start_time',
        'hearing_end_time',
        'processed_by_user_id',
        'processed_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['state_id', 'award_type', 'f10_type', 'form4_next'];

    public function getForm4NextAttribute()
    {
        $form4 = Form4::where('claim_case_opponent_id', $this->claim_case_opponent_id)
            ->where('form4_id', '>', $this->form4_id);

        if (count($form4->get()) > 0) {
            return $form4->first();
        } else {
            return null;
        }
    }

    public function getStateIdAttribute()
    {

        $case = ClaimCase::find($this->claim_case_id);

        if ($case)
            if ($case->branch_id)
                return $case->branch->branch_state_id;

        return false;
    }

    public function getAwardTypeAttribute()
    {

        if ($this->award)
            return $this->award->award_type;

        return false;
    }

    public function getF10TypeAttribute()
    {

        if ($this->award)
            if ($this->award->f10_type_id)
                return $this->award->f10_type_id;

        return false;
    }


    // relationship

    public function opponent()
    {
        return $this->belongsTo(User::class, 'opponent_user_id', 'user_id');
    }

    public function processed_by()
    {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    public function updates()
    {
        return $this->hasMany('App\SupportModel\Form4Update', 'form4_id', 'form4_id');
    }

    /**
     * @deprecated
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function case()
    {
        return $this->belongsTo('App\CaseModel\ClaimCase', 'claim_case_id', 'claim_case_id');
    }

    public function claimCase()
    {
        return $this->belongsTo('App\CaseModel\ClaimCase', 'claim_case_id', 'claim_case_id');
    }

    public function claimCaseOpponent()
    {
        return $this->belongsTo(ClaimCaseOpponent::class, 'claim_case_opponent_id');
    }

    public function hearing()
    {
        return $this->belongsTo('App\HearingModel\Hearing', 'hearing_id', 'hearing_id');
    }

    public function status()
    {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id', 'form_status_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function president()
    {
        return $this->belongsTo('App\User', 'president_user_id', 'user_id');
    }

    public function psu()
    {
        return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }

    public function psus()
    {
        return $this->hasMany('App\SupportModel\Form4PSU', 'form4_id');
    }

    public function hearing_status()
    {
        return $this->belongsTo('App\MasterModel\MasterHearingStatus', 'hearing_status_id', 'hearing_status_id');
    }

    public function hearing_position()
    {
        return $this->belongsTo('App\MasterModel\MasterHearingPosition', 'hearing_position_id', 'hearing_position_id');
    }

    public function hearing_position_reason()
    {
        return $this->belongsTo('App\MasterModel\MasterHearingPositionReason', 'hearing_position_reason_id', 'hearing_position_reason_id');
    }

    public function award()
    {
        return $this->belongsTo('App\HearingModel\Award', 'award_id', 'award_id');
    }

    public function reset()
    {
        return $this->hasOne('App\SupportModel\Form4Reset', 'form4_id');
    }

    public function attendance()
    {
        return $this->hasOne('App\SupportModel\Attendance', 'form4_id');
    }

    public function award_disobey()
    {
        return $this->hasOne('App\CaseModel\AwardDisobey', 'form4_id');
    }

    public function judicial_review()
    {
        return $this->hasOne('App\CaseModel\JudicialReview', 'form4_id');
    }

    public function form11()
    {
        return $this->hasOne('App\CaseModel\Form11', 'form4_id');
    }

    public function form12()
    {
        return $this->hasOne('App\CaseModel\Form12', 'form4_id');
    }

    public function minutes()
    {
        return $this->hasMany('App\SupportModel\AttendanceMinutes', 'form4_id');
    }

    public function form4_before()
    {
        return $this->hasOne(ViewForm4Before::class, 'form4_id');
    }

    public function letterBranchAddress()
    {
        return $this->belongsTo(MasterBranchAddress::class, 'letter_branch_address_id');
    }

    public function letterCourt()
    {
        return $this->belongsTo(MasterCourt::class, 'letter_court_id');
    }

}
