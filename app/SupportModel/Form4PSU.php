<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Form4PSU extends Model
{
    //
    protected $table = 'form4_psu';
    protected $primaryKey = 'form4_psu_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id',
        'psu_user_id'
    ];

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id');
    }

    public function psu() {
        return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }

}
