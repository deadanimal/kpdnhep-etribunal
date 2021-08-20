<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHearingList extends Model
{
    protected $table = 'form4';
    protected $primaryKey = 'form4_id';

    protected $fillable = [
        'claim_case_id',
		'hearing_id',
		'form_status_id',
		'created_by_user_id'
		'hearing_id',
		'form_status_id',
		'created_by_user_id'
    ];

}
 