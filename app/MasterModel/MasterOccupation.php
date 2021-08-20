<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\Master\OccupationController;

class MasterOccupation extends Model
{
    protected $table = 'master_occupation';
    protected $primaryKey = 'occupation_id';

    protected $fillable = [
    		'occupation_id',
	    	'occupation_en',
            'occupation_my'
    ];
}
