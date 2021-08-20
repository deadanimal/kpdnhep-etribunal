<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterHolidayEvent extends Model
{
    public $timestamps = false;
    protected $table = 'master_holiday_event';
    protected $primaryKey = 'holiday_event_id';

    protected $fillable = [
        'holiday_event_name_en',
        'holiday_event_name_my',
        'holiday_date',
        'created_by_user_id',
        
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }
}
 