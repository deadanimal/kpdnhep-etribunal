<?php

namespace App\PaymentModel;

use App\CaseModel\ClaimCaseOpponent;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payment';
    protected $primaryKey = 'payment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'claim_case_id',
        'claim_case_opponent_id',
        'form_no',
        'form_id',
        'amount',
        'payment_fpx_id',
        'fpx_created_at',
        'payment_postalorder_id',
        'is_payment_counter',
        'description',
        'payment_status_id',
        'receipt_no',
        'paid_at',
        'created_at',
        'updated_at'
    ];

    public function case() {
        return $this->belongsTo('App\CaseModel\ClaimCase', 'claim_case_id', 'claim_case_id');
    }

    public function fpx() {
        return $this->belongsTo('App\PaymentModel\PaymentFPX', 'payment_fpx_id', 'payment_fpx_id');
    }

    public function fpxs() {
        return $this->hasMany('App\PaymentModel\PaymentFPX', 'payment_id', 'payment_id');
    }

    public function postalorder() {
        return $this->belongsTo('App\PaymentModel\PaymentPostalOrder', 'payment_postalorder_id', 'payment_postalorder_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterPaymentStatus', 'payment_status_id', 'payment_status_id');
    }

    public function form1() {
        return $this->belongsTo('App\CaseModel\Form1', 'form_id', 'form1_id');
    }

    public function form2() {
        return $this->belongsTo('App\CaseModel\Form2', 'form_id', 'form2_id');
    }

    public function multiOpponents() {
        return $this->belongsTo(ClaimCaseOpponent::class, 'claim_case_opponent_id');
    }


}
