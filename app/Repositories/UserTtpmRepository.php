<?php

namespace App\Repositories;

use App\UserTTPM;
use Cache;
use DB;

class UserTtpmRepository
{
    public static function getCounter()
    {
        return Cache::remember('user_ttpm:counter', 3600, function () {
            return UserTTPM::select(DB::raw('count(1) total'))->first()->total;
        });
    }
}
