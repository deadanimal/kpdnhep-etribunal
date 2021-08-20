<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class RecordBrochure extends Model
{
    //
    protected $table = 'record_brochure';
    protected $primaryKey = 'brochure_record_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brochure_record_id',
        'year',
        'state_id',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'created_at',
        'updated_at',
    ];

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id');
    }


}
