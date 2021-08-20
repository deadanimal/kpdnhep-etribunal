<?php

namespace App\Repositories;

use App\MasterModel\MasterBranch;
use App\MasterModel\MasterState;

class MasterBranchRepository
{
    public static function getAll()
    {
//        return Cache::remember('master_branch:all', 3600, function () {
            return MasterBranch::with('state')->get();
//        });
    }

    public static function getListByStateName()
    {
        $branches = [];
        $branches_raw = MasterStateRepository::getAll();
        $branches_raw->load('branches');

        foreach($branches_raw as $hs) {
            $branches[$hs->branches[0]->branch_id] = $hs->state_name;
        }

        return $branches;
    }
}
