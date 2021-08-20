<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Form4Update extends Model
{
    //
    protected $table = 'form4_update';
    protected $primaryKey = 'form4_update_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id',
        'reason',
        'updated_by_user_id',
        'updated_at'
    ];

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }

    public function updated_by() {
        return $this->belongsTo('App\User', 'updated_by_user_id', 'user_id');
    }

}
