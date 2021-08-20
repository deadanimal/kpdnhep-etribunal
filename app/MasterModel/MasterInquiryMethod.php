<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterInquiryMethod extends Model
{
    protected $table = 'master_inquiry_method';
    protected $primaryKey = 'inquiry_method_id';

    protected $fillable = [
	        'method_en',
	        'method_my',
	        'code',
	        'is_active'
    ];

}
