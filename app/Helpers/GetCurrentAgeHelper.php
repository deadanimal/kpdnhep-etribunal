<?php

namespace App\Helpers;

use Carbon\Carbon;

class GetCurrentAgeHelper
{
    /**
     * @param $birthDate
     * @param null $currentDate
     * @return string
     */
    public static function calc($birthDate, $currentDate = null)
    {
        $currentDate = Carbon::createFromFormat('Y-m-d', $currentDate ?: date('Y-m-d'));
        $birthDate = Carbon::createFromFormat('ymd', $birthDate);

        return $currentDate->diffInYears($birthDate);
    }
}
