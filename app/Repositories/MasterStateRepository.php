<?php

namespace App\Repositories;

use App\MasterModel\MasterState;
use Illuminate\Support\Facades\Cache;

class MasterStateRepository
{
    public static function getAll()
    {
        return Cache::remember('master_state:all', 3600, function () {
            return MasterState::all();
        });
    }

    public static function getAllByBranch()
    {
        return Cache::remember('master_state_by_branch:all', 3600, function () {
            return MasterState::with('branches')->get();
        });
    }
}
