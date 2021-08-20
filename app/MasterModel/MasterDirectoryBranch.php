<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterDirectoryBranch extends Model
{
    protected $table = 'master_directory_branch';
    protected $primaryKey = 'directory_branch_id';

    protected $fillable = [
        'directory_branch_id',
        'directory_branch_head',
        'directory_branch_email',
        'address_1',
        'address_2',
        'address_3',
        'postcode',
        'district_id',
        'state_id',
        'directory_branch_tel',
        'directory_branch_faks',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

    public function district() {
        return $this->belongsTo('App\MasterModel\MasterDistrict', 'district_id');
    }

    public function state() {
        return $this->belongsTo('App\MasterModel\MasterState', 'state_id');
    }
}
