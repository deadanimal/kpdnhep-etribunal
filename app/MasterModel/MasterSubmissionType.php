<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterSubmissionType extends Model
{
    protected $table = 'master_submission_type';
    protected $primaryKey = 'submission_type_id';
    // Display Field from DB
    protected $fillable = [
    	'type_en',
    	'type_my',
    	'is_active'
    ];
}

