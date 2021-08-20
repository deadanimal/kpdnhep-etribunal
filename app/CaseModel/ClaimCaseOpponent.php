<?php

namespace App\CaseModel;

use App\MasterModel\MasterOppoStatus;
use App\SupportModel\UserClaimCase;
use App\User;
use App\ViewModel\ViewForm4Latest2019;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaimCaseOpponent extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'claim_case_id',
        'opponent_user_id',
        'opponent_address_id',
        'branch_id',
        'transfer_branch_id',
        'status_id',
    ];

    protected $dates = ['deleted_at'];

    // relationship

    public function opponent()
    {
        return $this->belongsTo(User::class, 'opponent_user_id', 'user_id');
    }

    /**
     * Follow old string conversion to minimize job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opponent_address()
    {
        return $this->belongsTo(UserClaimCase::class, 'opponent_address_id', 'user_claimcase_id');
    }

    public function claimCase()
    {
        return $this->belongsTo(ClaimCase::class, 'claim_case_id', 'claim_case_id');
    }

    public function status()
    {
        return $this->belongsTo(MasterOppoStatus::class, 'status_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'branch_id', 'branch_id');
    }

    public function transferBranch()
    {
        return $this->belongsTo('App\MasterModel\MasterBranch', 'transfer_branch_id', 'branch_id');
    }

    public function form2()
    {
        return $this->hasOne(Form2::class, 'claim_case_opponent_id');
    }

    public function form4()
    {
        return $this->hasMany(Form4::class, 'claim_case_opponent_id');
    }

    public function form4Latest()
    {
        return $this->hasOne(ViewForm4Latest2019::class, 'claim_case_opponent_id');
    }

    public function stopNotice()
    {
        return $this->hasMany(StopNotice::class, 'claim_case_opponent_id');
    }

    public function getLastForm4Attribute()
    {
        return Form4::where('claim_case_opponent_id', $this->id)
            ->orderBy('form4_id', 'desc')
            ->first();
    }
}
