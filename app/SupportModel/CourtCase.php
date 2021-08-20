<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class CourtCase extends Model
{
    //
    protected $table = 'court_case';
    protected $primaryKey = 'court_case_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'location',
        'status',
        'filing_date'
    ];

}
