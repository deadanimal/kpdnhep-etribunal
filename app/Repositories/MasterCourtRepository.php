<?php

namespace App\Repositories;

use App;
use App\MasterModel\MasterCourt;
use Cache;

class MasterCourtRepository
{
    public static function getAll()
    {
        return Cache::remember('master_court:all', 3600, function () {
            return MasterCourt::with('state')->get();
        });
    }

    public static function getListByStateId($state_id = null, $is_hearing_result = null, $is_active = true)
    {
        if ($state_id != null) {
            $branches = Cache::remember('master_court:' . $state_id, 3600, function () use ($state_id) {
                return MasterCourt::where('state_id', $state_id)
                    ->where('is_magistrate', 1)
                    ->get();
            });
        } else {
            $branches = self::getAll();
        }

        if ($is_hearing_result != null) {
            $branches->where('is_hearing_result', 1);
        }

        $branches->where('is_active', 1);

        $court_name = 'court_name' . (App::getLocale() == 'en' ? '_en' : '');

        return $branches->pluck($court_name, 'court_id');
    }
}
