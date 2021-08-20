<?php

namespace App\Repositories;

use App\MasterModel\MasterDistrict;
use Illuminate\Support\Facades\Cache;

class MasterDistrictRepository
{
    public static function getAll()
    {
        return Cache::remember('master_district:all', 3600, function () {
            return MasterDistrict::all();
        });
    }
}
