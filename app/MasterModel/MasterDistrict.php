<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterDistrict extends Model
{
    protected $table = 'master_district';
    protected $primaryKey = 'district_id';

    public function state() {
        return $this->belongsTo(MasterState::class, 'state_id');
    }
}
