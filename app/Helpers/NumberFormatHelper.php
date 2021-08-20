<?php

namespace App\Helpers;

class NumberFormatHelper
{
    public static function calculatePercentage($val, $total = 0, $decimal = 2, $postfix = '%')
    {
        if ($total == 0) {
            return "0.00%";
        }

        return number_format($val / $total * 100, $decimal, '.', '') . $postfix;
    }
}
