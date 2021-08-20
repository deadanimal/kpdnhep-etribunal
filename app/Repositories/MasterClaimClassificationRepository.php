<?php

namespace App\Repositories;

use App\MasterModel\MasterClaimClassification;
use Illuminate\Support\Facades\Cache;

class MasterClaimClassificationRepository
{
    public static function getAll()
    {
        return Cache::remember('master_claim_classification:all', 3600, function () {
            return MasterClaimClassification::all();
        });
    }
}
