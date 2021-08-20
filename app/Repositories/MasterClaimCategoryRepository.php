<?php

namespace App\Repositories;

use App\MasterModel\MasterClaimCategory;
use Illuminate\Support\Facades\Cache;

class MasterClaimCategoryRepository
{
    public static function getAll()
    {
        return Cache::remember('master_claim_category:all', 3600, function () {
            return MasterClaimCategory::where('is_active', 1)
                ->get();
        });
    }
}
