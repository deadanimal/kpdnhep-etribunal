<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterFeedbackType extends Model
{
    protected $table = 'master_inquiry_feedback';
    protected $primaryKey = 'inquiry_feedback_id';

    protected $fillable = [
	    	'inquiry_feedback_id',
	        'feedback',
	        'is_active'
    ];

}
