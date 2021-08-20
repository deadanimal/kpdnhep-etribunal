<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class RecordSeminar extends Model
{
    //
    protected $table = 'record_seminar';
    protected $primaryKey = 'seminar_record_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'state_id',
        'total_seminar',
        'total_participant',
        'modified_by_user_id'
    ];

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id');
    }

    public function modified_by() {
        return $this->belongsTo('App\User', 'modified_by_user_id', 'user_id');
    }


}
