<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterDesignation extends Model
{
    protected $table = 'master_designation';
    protected $primaryKey = 'designation_id';

     protected $fillable = [
    	'designation_en',
    	'designation_my',
    	'is_active'
    ];

}
