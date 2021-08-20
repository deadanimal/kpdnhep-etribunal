<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterSubdistrict extends Model
{
    public function state()
    {
        return $this->belongsTo(MasterDistrict::class, 'state_id');
    }
}
