<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterRegion extends Model
{
    protected $table = 'master_region';
    protected $primaryKey = 'region_id';

    protected $fillable = [
        'region_name',
    ];
}
