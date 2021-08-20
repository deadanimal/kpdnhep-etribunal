<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterMonth extends Model
{
    protected $table = 'master_month';
    protected $primaryKey = 'month_id';

     protected $fillable = [
    	'month_en',
    	'month_my',
    	'is_active'
    ];

}
