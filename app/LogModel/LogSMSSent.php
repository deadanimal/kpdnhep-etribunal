<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogSMSSent extends Model
{
    //
    protected $table = 'log_sms_sent';
    protected $primaryKey = 'log_sms_sent_id';

    protected $fillable = [
        'phone',
        'message',
        'sender_user_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function sender() {
        return $this->belongsTo('App\User', 'sender_user_id','user_id');
    }
}
