<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class ClaimSubmission extends Model
{
    //
    protected $table = 'claim_submission';
    protected $primaryKey = 'claim_submission_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id',
        'claim_case_id',
        'is_claimant_submit',
        'is_representative_letter',
        'submission_category_id',
        'pos_reference_no',
        'submission_type_id',
        'submission_date',
        'created_by_user_id'

    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function category() {
        return $this->belongsTo('App\MasterModel\MasterSubmissionCategory', 'submission_category_id');
    }

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterSubmissionType', 'submission_type_id');
    }

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id');
    }

    public function case() {
        return $this->belongsTo('App\CaseModel\ClaimCase', 'claim_case_id');
    }

}
