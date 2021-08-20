<?php

namespace App\MasterModel;

use App\CaseModel\Form4;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBranchAddress extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'state_id',
        'branch_name',
        'address_my',
        'address_en',
    ];

    public function branch()
    {
        return $this->belongsTo(MasterBranch::class, 'branch_id', 'branch_id');
    }

    public function form4()
    {
        return $this->hasMany(Form4::class, 'letter_branch_address_id');
    }
}
