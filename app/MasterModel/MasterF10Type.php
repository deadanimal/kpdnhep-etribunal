<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterF10Type extends Model
{
    protected $table = 'master_f10_type';
    protected $primaryKey = 'f10_type_id';

    protected $fillable = [
        'type_en',
    	'type_my'
    ];
}
