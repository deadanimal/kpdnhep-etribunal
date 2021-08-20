<?php

namespace App\LogModel;

use Illuminate\Database\Eloquent\Model;

class LogCounter extends Model
{
    //
    protected $table = 'log_counter';
    protected $primaryKey = 'log_counter_id';

    protected $fillable = [
        'counter_key',
    	'counter_value',
        'created_at',
        'updated_at',
    ];
}
