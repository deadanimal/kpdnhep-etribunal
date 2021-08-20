<?php

namespace App\Repositories;

use App\MasterModel\MasterInquiryMethod;
use Illuminate\Support\Facades\Cache;

class MasterInquiryMethodRepository
{
    public static function getAll()
    {
        return Cache::remember('master_inquiry_methods:all', 3600, function () {
            return MasterInquiryMethod::all();
        });
    }
}
