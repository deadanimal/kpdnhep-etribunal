<?php

namespace App\MasterModel;

use App\CaseModel\ClaimCaseOpponent;
use Illuminate\Database\Eloquent\Model;

class MasterOppoStatus extends Model
{
    protected $table = 'master_oppo_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function claimCaseOpponents() {
        return $this->hasMany(ClaimCaseOpponent::class, 'status_id');
    }
}
