<?php

namespace App\CaseModel;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Form2 extends Model
{
    //
    protected $table = 'form2';
    protected $primaryKey = 'form2_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form1_id',
        'counterclaim_id',
        'claim_case_opponent_id',
        'opponent_user_id',
        'defence_statement',
        'payment_id',
        'form_status_id',
        'filing_date',
        'matured_date',
        'form3_id',
        'is_printed',
        'created_by_user_id',
        'processed_by_user_id',
        'processed_at'
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function processed_by() {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    public function form3() {
        return $this->hasOne('App\CaseModel\Form3', 'form3_id', 'form3_id');
    }

    public function payment() {
        return $this->belongsTo('App\PaymentModel\Payment', 'payment_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id');
    }

    public function counterclaim() {
        return $this->belongsTo('App\SupportModel\CounterClaim', 'counterclaim_id');
    }

    public function form1() {
        return $this->hasOne('App\CaseModel\Form1', 'form2_id', 'form2_id');
    }

    public function form1Inv() {
        return $this->belongsTo(Form1::class, 'form1_id', 'form1_id');
    }

    public function opponent() {
        return $this->belongsTo(User::class, 'opponent_user_id', 'user_id');
    }

    public function claimCaseOpponent() {
        return $this->belongsTo(ClaimCaseOpponent::class, 'claim_case_opponent_id', 'id');
    }

    protected $appends = ['state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStateIdAttribute() {

        if($this->form1)
            return $this->form1->case->state_id;

        return false;
    }
}
