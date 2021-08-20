<?php

namespace App\Repositories;

use App\UserPublicCompany;
use Cache;
use DB;

class UserPublicCompanyRepository
{
    public static function getCounter()
    {
        return Cache::remember('user_public_company:counter', 3600, function () {
            return UserPublicCompany::select(DB::raw('count(1) total'))->first()->total;
        });
    }
}
