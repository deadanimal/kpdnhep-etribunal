<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterAgeRange extends Model
{
    protected $table = 'master_age_range';
    protected $primaryKey = 'age_id';

    protected $fillable = [
    	'age_en',
    	'age_my',
    	'age_range',
    	'is_active'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
}
