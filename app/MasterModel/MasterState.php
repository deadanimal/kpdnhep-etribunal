<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterState extends Model
{
    protected $table = 'master_state';
    protected $primaryKey = 'state_id';
    public $timestamps = false;

    protected $fillable = [
        'is_friday_weekend',
        'next_claim_no',
        'next_b1_no',
    ];

    public function districts() {
        return $this->hasMany('App\MasterModel\MasterDistrict', 'state_id');
    }

    public function branches() {
        return $this->hasMany('App\MasterModel\MasterBranch', 'branch_state_id', 'state_id');
    }
}
