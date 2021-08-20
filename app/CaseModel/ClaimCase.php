<?php

namespace App\CaseModel;

use App\SupportModel\UserClaimCase;
use App\User;
use App\UserExtra;
use App\ViewModel\ViewCaseSequence;
use App\ViewModel\ViewForm4Latest;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaimCase extends Model
{
    use SoftDeletes;

    protected $table = 'claim_case';
    protected $primaryKey = 'claim_case_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_no',
        'form1_no',
        'inquiry_id',
        'claimant_user_id',
        'claimant_address_id',
        'opponent_user_id',
        'opponent_address_id',
        'form1_id',
        'branch_id',
        'transfer_branch_id',
        'psu_user_id',
        'hearing_venue_id',
        'filing_date',
        'case_status_id',
        'is_finished',
        'created_by_user_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_form2_lock', 'state_id', 'date_diff', 'district_id', 'category_id', 'classification_id', 'is_online_purchased', 'award_type', 'last_form4'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getIsForm2LockAttribute()
    {
        if ($this->form1_id && !$this->form1->form2_id) {
            return false;
        }

        return true;
    }

    public function getAwardTypeAttribute()
    {
        if (count($this->form4) > 0 && $this->form4->last()->award) {
            return $this->form4->last()->award->award_type;
        }

        return false;
    }

    public function getLastForm4Attribute()
    {
        return Form4::where('claim_case_id', $this->claim_case_id)
            ->orderBy('form4_id', 'desc')
            ->first();
    }

    public function getStateIdAttribute()
    {
        if ($this->branch_id) {
            return $this->branch->branch_state_id;
        }

        return false;
    }

    public function getDateDiffAttribute()
    {
        if ($this->case_status_id == 1) {
            return null;
        }

        $start = Carbon::createFromFormat('Y-m-d', $this->form1->filing_date);
        $end = Carbon::parse($this->updated_at);

        return $start->diffInDays($end);
    }

    public function getDistrictIdAttribute()
    {
        if ($this->branch_id) {
            return $this->branch->branch_district_id;
        }

        return false;
    }

    public function getCategoryIdAttribute()
    {

        if ($this->form1_id && $this->form1->claim_classification_id) {
            return $this->form1->classification->category_id;
        }

        return false;
    }

    public function getClassificationIdAttribute()
    {

        if ($this->form1_id && $this->form1->claim_classification_id) {
            return $this->form1->claim_classification_id;
        }

        return false;
    }

    public function getIsOnlinePurchasedAttribute()
    {
        if ($this->form1_id) {
            return $this->form1->is_online_purchased;
        }

        return false;
    }

    public function inquiry()
    {
        return $this->belongsTo('App\CaseModel\Inquiry', 'inquiry_id', 'inquiry_id');
    }

    public function claimant()
    {
        return $this->belongsTo(User::class, 'claimant_user_id', 'user_id');
    }

    public function claimant_address()
    {
        return $this->belongsTo(UserClaimCase::class, 'claimant_address_id', 'user_claimcase_id');
    }

    public function opponent()
    {
        return $this->belongsTo('App\User', 'opponent_user_id', 'user_id');
    }

    public function opponent_address()
    {
        return $this->belongsTo(UserClaimCase::class, 'opponent_address_id', 'user_claimcase_id');
    }

    public function extra_claimant()
    {
        return $this->hasOne('App\SupportModel\UserExtra', 'user_extra_id', 'extra_claimant_id');
    }

    public function extraClaimant()
    {
        return $this->hasOne(UserExtra::class, 'user_extra_id', 'extra_claimant_id');
    }

    public function form1()
    {
        return $this->hasOne('App\CaseModel\Form1', 'form1_id', 'form1_id')
            ->orderBy('filing_date');
    }

    public function branch()
    {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id', 'branch_id');
    }

    public function transfer_branch()
    {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'transfer_branch_id', 'branch_id');
    }

    public function psu()
    {
        return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }

    public function status()
    {
        return $this->belongsTo('App\MasterModel\MasterCaseStatus', 'case_status_id', 'case_status_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function form4()
    {
        return $this->hasMany('App\CaseModel\Form4', 'claim_case_id');
    }

    public function form4Latest()
    {
        return $this->hasOne(ViewForm4Latest::class, 'claim_case_id');
    }

    public function form4_latest()
    {
        return $this->hasOne('App\ViewModel\ViewForm4Latest', 'claim_case_id');
    }

    public function submission()
    {
        return $this->hasMany('App\SupportModel\ClaimSubmission', 'claim_case_id', 'claim_case_id');
    }

    public function stop_notice()
    {
        return $this->hasOne('App\CaseModel\StopNotice', 'claim_case_id');
    }

    public function venue()
    {
        return $this->belongsTo('App\MasterModel\MasterHearingVenue', 'hearing_venue_id', 'hearing_venue_id');
    }

    public function sequence()
    {
        return $this->hasOne(ViewCaseSequence::class, 'case_id', 'claim_case_id');
    }

    public function multiOpponents()
    {
        return $this->hasMany(ClaimCaseOpponent::class, 'claim_case_id', 'claim_case_id')
            ->with('opponent_address');
    }
}
