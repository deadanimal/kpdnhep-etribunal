<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHolidayRegion extends Model
{
    public $timestamps = false;
    protected $table = 'master_holiday_region';
    protected $primaryKey = 'holiday_region_id';

    protected $fillable = [
        'holiday_id',
        'holiday_region',
    ];
}
 