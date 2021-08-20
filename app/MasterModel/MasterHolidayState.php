<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHolidayState extends Model
{
    public $timestamps = false;
    protected $table = 'master_holiday_state';
    protected $primaryKey = 'holiday_state_id';

    protected $fillable = [
        'holiday_id',
        'holiday_state',
    ];
}
 