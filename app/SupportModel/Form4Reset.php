<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Form4Reset extends Model
{
    //
    protected $table = 'form4_reset';
    protected $primaryKey = 'form4_reset_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id'
    ];

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id');
    }

}
