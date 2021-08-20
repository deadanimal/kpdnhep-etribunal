<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExtra extends Model
{
    //
    protected $primaryKey = 'user_extra_id';
    protected $table = 'user_extra';
    protected $fillable = [
        'name', 
        'identification_no', 
        'nationality_country_id',
    ];
}
