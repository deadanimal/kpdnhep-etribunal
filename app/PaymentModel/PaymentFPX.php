<?php

namespace App\PaymentModel;

use Illuminate\Database\Eloquent\Model;

class PaymentFPX extends Model
{
    //
    protected $table = 'payment_fpx';
    protected $primaryKey = 'payment_fpx_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id',
        'paid_amount',
        'bank_id',
        'email',
        'fpx_status_id',
        'created_by_user_id',
        'fpx_transaction_no',
        'paid_at',
        'created_at',
        'updated_at',
    ];

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFPXStatus', 'fpx_status_id', 'fpx_status_id');
    }

    public function bank() {
        return $this->belongsTo('App\MasterModel\MasterBank', 'bank_id', 'bank_id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function payment() {
        return $this->belongsTo('App\PaymentModel\Payment', 'payment_id', 'payment_id');
    }

}
