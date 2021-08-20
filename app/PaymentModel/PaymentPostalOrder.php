<?php

namespace App\PaymentModel;

use Illuminate\Database\Eloquent\Model;

class PaymentPostalOrder extends Model
{
    //
    protected $table = 'payment_postalorder';
    protected $primaryKey = 'payment_postalorder_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'postalorder_no',
        'paid_at',
        'created_by_user_id',
        'created_at',
        'updated_at',
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

}
