<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterOffenceType extends Model
{
    protected $table = 'master_offence_type';
    protected $primaryKey = 'offence_type_id';
    
    protected $fillable = [
    	'offence_code',
    	'offence_description_en',
    	'offence_description_my',
    	'is_active'
    ];
}
