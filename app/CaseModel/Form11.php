<?php

namespace App\CaseModel;

use App\UserWitness;
use Illuminate\Database\Eloquent\Model;

class Form11 extends Model
{
    //
    protected $table = 'form11';
    protected $primaryKey = 'form11_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    
        'form4_id'
    ];
    
    public function form4 () {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id');
    }

    public function userWitness () {
        return $this->hasOne(UserWitness::class, 'form11_id', 'form11_id');
    }

}
