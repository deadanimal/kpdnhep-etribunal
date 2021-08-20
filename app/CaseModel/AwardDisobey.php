<?php

namespace App\CaseModel;

use Illuminate\Database\Eloquent\Model;

class AwardDisobey extends Model
{
    //
    protected $table = 'award_disobey';
    protected $primaryKey = 'award_disobey_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id',
        'applied_by',
        'applied_representative',
        'applied_against',
        'application_method_id',
        'complaints',
        'complaint_at',
        'psu_notes',
        'form_status_id',
        'created_by_user_id',
        'endorsement_date',
    ];

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }

    public function method() {
        return $this->belongsTo('App\MasterModel\MasterApplicationMethod', 'application_method_id', 'application_method_id');
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id', 'form_status_id');
    }

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    protected $appends = ['award_type', 'president_user_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getAwardTypeAttribute() {

        return $this->form4->award->award_type;
    }

    public function getPresidentUserIdAttribute() {

        if( $this->form4->president_user_id )
            return $this->form4->president_user_id;
        else return $this->form4->hearing->president_user_id;
    }

   
}
