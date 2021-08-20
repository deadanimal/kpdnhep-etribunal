<?php

namespace App\Repositories;

use App\MasterModel\MasterCountry;
use Illuminate\Support\Facades\Cache;

class MasterCountryRepository
{
    public static function getAll()
    {
        return Cache::remember('master_country:all', 3600, function () {
            return MasterCountry::all();
        });
    }
}
