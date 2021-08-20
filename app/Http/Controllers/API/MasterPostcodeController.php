<?php

namespace App\Http\Controllers\API;

use App\MasterModel\MasterPostcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;

class MasterPostcodeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return bool|string
     */
    public function __invoke(Request $request)
    {
        $postcodes = MasterPostcode::where('name', ($request->has('p') ? $request->p : null))
            ->first();

        $data['postcode'] = !empty($postcodes) ? $postcodes->toArray() : [];

        return response()->json($data);
    }
}