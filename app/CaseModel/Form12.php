<?php

namespace App\CaseModel;

use Illuminate\Database\Eloquent\Model;

class Form12 extends Model
{
    //
    protected $table = 'form12';
    protected $primaryKey = 'form12_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id',
        'absence_reason',
        'unfiled_reason',
        'form_status_id',
        'applied_by',
        'filing_date',
        'application_date',
        'psu_user_id',
        'processed_by_user_id',
        'created_at',
        'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */

    public function getStateIdAttribute() {

        $case = \App\CaseModel\ClaimCase::find($this->form4->claim_case_id);

        if($case)
            if($case->branch_id)
                return $case->branch->branch_state_id;

        return false;
    }

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }

    public function processed_by() {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id', 'form_status_id');
    }

    public function psu() {
        return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }

}
