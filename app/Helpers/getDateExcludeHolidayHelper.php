<?php

namespace App\Helpers;

use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHoliday;
use Carbon\Carbon;

class getDateExcludeHolidayHelper
{
    public static function byBranch($start_date, $days, $branch_id)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date = (clone $start_date)->addDays($days)->toDateString();
        $current_date = (clone $start_date)->subDay();

        $state = MasterBranch::find($branch_id)->state;

        if ($state->is_friday_weekend == 1)
            $holidays = MasterHoliday::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('state_id', $state->state_id)->whereIn('day_in_week', [0, 1, 2, 3, 4])->get();
        else
            $holidays = MasterHoliday::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('state_id', $state->state_id)->whereIn('day_in_week', [1, 2, 3, 4, 5])->get();

        $i = 0;
        while ($i <= $holidays->count() + $days) {
            $current_date->addDay();

            if ($state->is_friday_weekend == 1) {
                if ($current_date->dayOfWeek == 5 || $current_date->dayOfWeek == 6)
                    continue;
            } else {
                if ($current_date->dayOfWeek == 6 || $current_date->dayOfWeek == 0)
                    continue;
            }

            $i++;

        }

        return $current_date->toDateString();

        //return response()->json(['date' => $current_date->toDateString(), 'day' => localeDay(date('l', strtotime($current_date->toDateTimeString())))]);
    }
}
