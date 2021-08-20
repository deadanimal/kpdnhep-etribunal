<?php

namespace App\CaseModel;

use Illuminate\Database\Eloquent\Model;

class StopNotice extends Model
{
    //
    protected $table = 'stop_notice';
    protected $primaryKey = 'stop_notice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'claim_case_id',
        'claim_case_opponent_id',
        'stop_notice_method_id',
        'stop_notice_reason_id',
        'stop_notice_reason_desc',
        'created_by_user_id',
        'requested_by_user_id',
        'stop_notice_date',
        'processed_at',
        'processed_by_user_id',
        'form_status_id'
    ];
    
    public function case() {
        return $this->belongsTo(ClaimCase::class, 'claim_case_id', 'claim_case_id');
    }

    public function method() {
        return $this->belongsTo('App\MasterModel\MasterStopMethod', 'stop_notice_method_id', 'stop_method_id');
    }

    public function reason() {
        return $this->belongsTo('App\MasterModel\MasterStopReason', 'stop_notice_reason_id', 'stop_reason_id');
    }

    public function psu() {
        return $this->belongsTo('App\User', 'psu_id', 'user_id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function requested_by() {
        return $this->belongsTo('App\User', 'requested_by_user_id', 'user_id');
    }

    public function processed_by() {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id');
    }

    public function multiOpponents() {
        return $this->belongsTo(ClaimCaseOpponent::class, 'claim_case_opponent_id');
    }

    protected $appends = ['state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStateIdAttribute() {

        if($this->case->branch_id)
            return $this->case->branch->branch_state_id;

        return false;
    }
}
