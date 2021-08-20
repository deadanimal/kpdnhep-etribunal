<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterSubmissionCategory extends Model
{
    protected $table = 'master_submission_category';
    protected $primaryKey = 'submission_category_id';
    // Display Field from DB
    protected $fillable = [
    	'category_en',
    	'category_my',
    	'is_active'
    ];
}

