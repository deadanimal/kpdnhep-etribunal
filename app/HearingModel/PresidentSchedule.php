<?php

namespace App\HearingModel;

use Illuminate\Database\Eloquent\Model;

class PresidentSchedule extends Model
{
    //
    protected $table = 'president_schedule';
    protected $primaryKey = 'president_schedule_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'president_user_id',
        'suggest_date',
        'created_by_user_id',
    ];

    public function president() {
        return $this->belongsTo('App\User', 'president_user_id', 'user_id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }
}
