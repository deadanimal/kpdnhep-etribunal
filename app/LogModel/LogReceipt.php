<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogReceipt extends Model
{
    protected $fillable = [
        'receipt_number',
        'payment_id',
        'txn_type',
    ];
}
