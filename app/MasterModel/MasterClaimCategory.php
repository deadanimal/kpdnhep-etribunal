<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterClaimCategory extends Model
{
    protected $table = 'master_claim_category';
    protected $primaryKey = 'claim_category_id';
    // Display Field from DB
    protected $fillable = [
    	'category_en',
    	'category_my',
    	'category_code',
    	'is_active'
    ];
}

