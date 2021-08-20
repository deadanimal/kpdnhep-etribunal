<?php

namespace App\Http\Controllers\Integration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Carbon\Carbon;

use App\IntegrationModel\ECBIS\CompanyROBModel;
use App\IntegrationModel\ECBIS\CompanyROCModel;
use App\IntegrationModel\ECBIS\OwnerROBModel;
use App\IntegrationModel\ECBIS\OwnerROCModel;

class ECBISController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkCompanyNo($company_no) {

        if($company = CompanyROCModel::where('id_syarikat', $company_no)->first()) {

            $owner = OwnerROCModel::where('noid_syarikat', $company->noid_syarikat)->get();

            $res = array(
                    'company' => $company,
                    'owner' => $owner
                );

            return response()->json($res)->header('Content-Type', "application/json");
        }
        else {
            if($company = CompanyROBModel::where('id_syarikat', $company_no)->first()) {

                $owner = OwnerROBModel::where('noid_syarikat', $company->noid_syarikat)->get();

                $res = array(
                    'company' => $company,
                    'owner' => $owner
                );

                return response()->json($res);
            }
            else {
                return response()->json(array("status" => "Not found!"));
            }
        }

    }
}
