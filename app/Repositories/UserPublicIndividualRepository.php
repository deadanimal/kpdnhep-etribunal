<?php

namespace App\Repositories;

use App\UserPublicIndividual;
use Cache;
use DB;

class UserPublicIndividualRepository
{
    public static function getCounter()
    {
        return Cache::remember('user_public_individual:counter', 3600, function () {
            return UserPublicIndividual::select([
                DB::raw('count((case when (nationality_country_id = 129) then user_public_individual_id else NULL end)) citizen'),
                DB::raw('count((case when (nationality_country_id != 129) then user_public_individual_id else NULL end)) non_citizen'),
            ])->first();
        });
    }
}
