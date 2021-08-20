<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterPostcode extends Model
{
    protected $fillable = [
        'state_id',
        'district_id',
        'subdistrict_id',
    ];

    public function state()
    {
        return $this->belongsTo(MasterState::class, 'state_id', 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(MasterDistrict::class, 'district_id', 'district_id');
    }

    public function subdistrict()
    {
        return $this->belongsTo(MasterSubdistrict::class, 'subdistrict_id');
    }
}
