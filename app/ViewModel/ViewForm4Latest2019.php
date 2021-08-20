<?php

namespace App\ViewModel;

use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form4;
use Illuminate\Database\Eloquent\Model;

class ViewForm4Latest2019 extends Model
{
    protected $table = 'view_form4_latest_2019';

    public function form4() {
        return $this->belongsTo(Form4::class, 'form4_id', 'form4_id');
    }

    public function claimCaseOpponent() {
        return $this->belongsTo(ClaimCaseOpponent::class, 'claim_case_opponent_id');
    }

    public function claimCase() {
        return $this->belongsTo(ClaimCase::class, 'claim_case_id', 'claim_case_id');
    }
}