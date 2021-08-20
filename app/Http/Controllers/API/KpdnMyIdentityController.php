<?php

namespace App\Http\Controllers\API;

use App\Repositories\KpdnMyIdentityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;

class KpdnMyIdentityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return bool|string
     */
    public function fetchMyIdentity(Request $request)
    {
        $token = KpdnMyIdentityRepository::generateToken();

        $data = KpdnMyIdentityRepository::getMyIdentity($request->get('nric'), $token);

        return response()->json($data);
    }
}