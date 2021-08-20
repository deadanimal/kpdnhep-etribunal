<?php

namespace App\Repositories;

use App\MasterModel\MasterBranchAddress;
use Cache;

class MasterBranchAddressRepository
{
    public static function getAll()
    {
        return Cache::remember('master_branch_address:all', 3600, function () {
            return MasterBranchAddress::with('state')->get();
        });
    }

    public static function getListByStateId($state_id = null)
    {

        if ($state_id != null) {
            $branches = Cache::remember('master_branch_address:' . $state_id, 3600, function () use ($state_id) {
                return MasterBranchAddress::where('state_id', $state_id)
                    ->get();
            });
        } else {
            $branches = self::getAll();
        }

        return $branches->pluck('branch_name', 'id');
    }
}
