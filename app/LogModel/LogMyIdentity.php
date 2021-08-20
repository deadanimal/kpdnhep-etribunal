<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogMyIdentity extends Model
{
    //
    protected $table = 'log_myidentity';
    protected $primaryKey = 'log_myidentity_id';

    protected $fillable = [
        'ip_address',
    	'agency_code',
        'branch_code',
        'username',
        'transaction_code',
        'requested_at',
        'requested_ic',
        'request_indicator',
        'replied_at',
        'reply_indicator'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['reply_indicator_text', 'request_indicator_text', 'transaction_code_text'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getReplyIndicatorTextAttribute() {
        if($this->reply_indicator == "0")
            return __('new.error');
        else if($this->reply_indicator == "1")
            return __('new.successful');
        else
            return __('new.alert');
    }

    public function getRequestIndicatorTextAttribute() {
        if($this->request_indicator == "A")
            return __('new.basic_nonbasic_data');
        else
            return __('new.basic_nonbasic_dataphoto');
    }

    public function getTransactionCodeTextAttribute() {
        if($this->request_indicator == "T2")
            return __('new.agency_user');
        else
            return __('new.public_user');
    }

}
