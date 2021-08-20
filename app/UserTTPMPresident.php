<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTTPMPresident extends Model
{
    protected $table = 'user_ttpm_president';
    protected $primaryKey = 'user_ttpm_president_id';
    //public $timestamps = false;

    protected $fillable = [
    	'user_id',
        'president_code',
		'is_appointed',
		'year_start',
		'year_end',
		'salutation_id'
    ];

    public function salutation() {
        return $this->belongsTo('App\MasterModel\MasterSalutation', 'salutation_id');
    }

    

}
