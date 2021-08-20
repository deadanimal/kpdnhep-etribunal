<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterVisitorReason extends Model
{
    protected $table = 'master_visitor_reason';
    protected $primaryKey = 'visitor_reason_id';

    protected $fillable = [
    	'reason_en',
        'reason_my'
    ];

}
