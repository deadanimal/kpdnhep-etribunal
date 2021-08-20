<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class CounterClaim extends Model
{
    //
    protected $table = 'counterclaim';
    protected $primaryKey = 'counterclaim_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'counterclaim_amount',
        'counterclaim_statement',
    ];
}
