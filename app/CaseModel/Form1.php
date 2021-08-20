<?php

namespace App\CaseModel;

use App\MasterModel\MasterOffenceType;
use Illuminate\Database\Eloquent\Model;

class Form1 extends Model
{
    //
    protected $table = 'form1';
    protected $primaryKey = 'form1_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_online_purchased',
        'purchased_date',
        'purchased_item_name',
        'purchased_item_brand',
        'purchased_amount',
        'claim_details',
        'claim_amount',
        'court_case_id',
        'payment_id',
        'filing_date',
        'matured_date',
        'claim_classification_id',
        'offence_type_id',
        'form_status_id',
        'form2_id',
        'is_printed',
        'is_online_filing',
        'created_by_user_id',
        'processed_by_user_id',
        'processed_at',
        'case_year',
        'case_sequence',
    ];


    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function processed_by() {
        return $this->belongsTo('App\User', 'processed_by_user_id', 'user_id');
    }

    public function court_case() {
        return $this->hasOne('App\SupportModel\CourtCase', 'court_case_id', 'court_case_id');
    }

    public function payment() {
        return $this->belongsTo('App\PaymentModel\Payment', 'payment_id', 'payment_id');
    }

    public function classification() {
        return $this->belongsTo('App\MasterModel\MasterClaimClassification', 'claim_classification_id', 'claim_classification_id');
    }

    public function offence_type() {
        return $this->belongsTo('App\MasterModel\MasterOffenceType', 'offence_type_id', 'offence_type_id');
    }

    public function offenceType() {
        return $this->belongsTo(MasterOffenceType::class, 'offence_type_id', 'offence_type_id')
            ->withDefault([
                'offence_type_id' => '-',
                'offence_description_en' => '-',
                'offence_description_my' => '-',
            ]);
    }

    public function status() {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id', 'form_status_id');
    }

    public function form2() {
        return $this->hasOne('App\CaseModel\Form2', 'form2_id', 'form2_id');
    }

    public function form2Inv() {
        return $this->hasOne('App\CaseModel\Form2', 'form1_id', 'form1_id');
    }

    public function case() {
        return $this->hasOne('App\CaseModel\ClaimCase', 'form1_id', 'form1_id');
    }

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

        // if($this->case)
        //     return $this->case->state_id;

        $case = \App\CaseModel\ClaimCase::where('form1_id', $this->form1_id)->first();

        if($case)
            if($case->branch_id)
                return $case->branch->branch_state_id;

        return false;
    }



}
