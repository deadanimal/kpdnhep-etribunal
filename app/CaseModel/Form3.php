<?php

namespace App\CaseModel;

use Illuminate\Database\Eloquent\Model;

class Form3 extends Model
{
    //
    protected $table = 'form3';
    protected $primaryKey = 'form3_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'defence_counterclaim_statement',
        'form_status_id',
        'filing_date',
        'created_by_user_id',
        'processed_by_user_id',
        'processed_at'
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function processed_by() {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id');
    }

    public function form2() {
        return $this->hasOne('App\CaseModel\Form2', 'form3_id', 'form3_id');
    }

    protected $appends = ['state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStateIdAttribute() {

        if($this->form2)
            if($this->form2->form1)
                return $this->form2->form1->case->state_id;

        return false;
    }
}
