<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class RecordBook extends Model
{
    //
    protected $table = 'record_book';
    protected $primaryKey = 'book_record_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_record_id',
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
