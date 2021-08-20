<?php

namespace App\CaseModel;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\MasterModel\MasterState;

class Inquiry extends Model
{
    //
    protected $table = 'inquiry';
    protected $primaryKey = 'inquiry_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inquiry_no',
        'branch_id',
        'inquiry_method_id',
        'inquiry_type_id',
        'created_by_user_id',
        'inquired_by_user_id',
        'opponent_user_extra_id',
        'inquiry_msg',
        'form1_id',
        'inquiry_form_status_id',
        'inquiry_feedback_id',
        'inquiry_feedback_msg',
        'jurisdiction_organization_id',
        'processed_by_user_id',
        'processed_at',
        'transaction_address',
        'transaction_postcode',
        'transaction_state',
        'transaction_district',
        'phone_no',
    ];

    public function branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id', 'branch_id');
    }

    public function state_branch() {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'transaction_state', 'branch_state_id');
    }

    public function method() {
        return $this->belongsTo('App\MasterModel\MasterInquiryMethod', 'inquiry_method_id', 'inquiry_method_id');
    }

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterInquiryType', 'inquiry_type_id', 'inquiry_type_id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function inquired_by() {
        return $this->belongsTo(User::class, 'inquired_by_user_id', 'user_id');
    }

    public function opponent() {
        return $this->belongsTo('App\SupportModel\UserExtra', 'opponent_user_extra_id', 'user_extra_id');
    }

    public function form1() {
        return $this->hasOne('App\CaseModel\Form1', 'form1_id', 'form1_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'inquiry_form_status_id', 'form_status_id');
    }

    public function feedback() {
        return $this->belongsTo('App\MasterModel\MasterInquiryFeedback', 'inquiry_feedback_id', 'inquiry_feedback_id');
    }

    public function organization() {
        return $this->belongsTo('App\MasterModel\MasterOrganization', 'jurisdiction_organization_id', 'jurisdiction_organization_id');
    }

    public function processed_by() {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStateIdAttribute() {

        if($this->inquiry_no) {
            $arr_inquiry = explode("-", $this->inquiry_no);
            $state_code = $arr_inquiry[1];
            $state = MasterState::where('code', $state_code)->get();

            if($state->count() > 0)
                return $state->first()->state_id;
            else return null;
        }
        else {
            return null;
        }
    }

    public function state()
    {
        return $this->belongsTo('App\MasterModel\MasterState', 'transaction_state');
    }

    public function district()
    {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'transaction_district');
    }
    

}
