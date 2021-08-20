<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;


class MasterHoliday extends Model
{
    //public $timestamps = false;
    protected $table = 'master_holiday';
    protected $primaryKey = 'holiday_id';

    protected $fillable = [
        'event',
        'holiday_event_id',
        'is_federal_holiday',
        'holiday_date',
        'state_id',
        'created_by_user_id',
    ];

    public function holiday_event (){
    	return $this->belongsTo('App\MasterModel\MasterHolidayEvent', 'holiday_event_id');
    }
}
 