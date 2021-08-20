<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\LogModel\LogMyIdentity;
use Carbon\Carbon;
use Auth;
use App;
use Yajra\Datatables\Datatables;

class LogMyIdentityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $types = LogMyIdentity::all();

    	if ($request->ajax()) {

    		$myidentity_log = LogMyIdentity::orderBy('created_at', 'desc');

            if ( $request->has('username') || $request->has('transaction_code') || $request->has('requested_at') || $request->has('requested_ic') || $request->has('replied_at') || $request->has('reply_indicator') || $request->has('status') ) {

                if($request->has('username') && !empty($request->username)) 
                    $myidentity_log->where('username', $request->username);
                    // $myidentity_log = $myidentity_log->filter(function ($value) use ($request) {
                    //     return $value->username == $request->username;
                    // });

                if($request->has('transaction_code') && !empty($request->transaction_code)) 
                    $myidentity_log->where('transaction_code', $request->transaction_code);
                    // $myidentity_log = $myidentity_log->filter(function ($value) use ($request) {
                    //     return $value->transaction_code == $request->transaction_code;
                    // });

                if($request->has('requested_at') && !empty($request->transaction_code))
                    $myidentity_log->whereDate('requested_at', Carbon::createFromFormat('d/m/Y', $request->requested_at)->toDateString());
                    // $myidentity_log = $myidentity_log->filter(function ($value) use ($request) {
                    //     return date('d/m/Y h:i A', strtotime($value->requested_at)) == $request->requested_at;
                    // });

                if($request->has('requested_ic') && !empty($request->requested_ic)) 
                    $myidentity_log->where('requested_ic', $request->requested_ic);
                    // $myidentity_log = $myidentity_log->filter(function ($value) use ($request) {
                    //     return $value->requested_ic == $request->requested_ic;
                    // });

                if($request->has('replied_at') && !empty($request->transaction_code))
                    $myidentity_log->whereDate('replied_at', Carbon::createFromFormat('d/m/Y', $request->replied_at)->toDateString());
                    // $myidentity_log = $myidentity_log->filter(function ($value) use ($request) {
                    //    return date('d/m/Y h:i A', strtotime($value->replied_at)) == $request->replied_at;
                    // });

                if($request->has('reply_indicator') && !empty($request->reply_indicator)) 
                    $myidentity_log->where('reply_indicator', (int) $request->reply_indicator - 1);
                    // $myidentity_log = $myidentity_log->filter(function ($value) use ($request) {
                    //     return $value->reply_indicator == (int) $request->reply_indicator - 1;
                    // });
            }

            $datatables = Datatables::of($myidentity_log);

            return $datatables
            ->editColumn('ip_address', function ($myidentity_log) {
                return $myidentity_log->ip_address;
            })->editColumn('agency_code', function ($myidentity_log) {
                return $myidentity_log->agency_code;
            })->editColumn('branch_code', function ($myidentity_log) {
            	return $myidentity_log->branch_code;
            })->editColumn('username', function ($myidentity_log) {
            	return $myidentity_log->username;
            })->editColumn('transaction_code', function ($myidentity_log) {
                return "<span data-toggle='tooltip' title='".$myidentity_log->transaction_code_text."' class='label label-primary' style='cursor: pointer;'>".$myidentity_log->transaction_code."</span>";
            })->editColumn('requested_at', function ($myidentity_log) {
            	return date('d/m/Y h:i A', strtotime($myidentity_log->requested_at));
            })->editColumn('requested_ic', function ($myidentity_log) {
                return $myidentity_log->requested_ic;
            })->editColumn('request_indicator', function ($myidentity_log) {
                return "<span data-toggle='tooltip' title='".$myidentity_log->request_indicator_text."' class='label label-primary' style='cursor: pointer;'>".$myidentity_log->request_indicator."</span>";
            })->editColumn('replied_at', function ($myidentity_log) {
                return date('d/m/Y', strtotime($myidentity_log->replied_at));
            })->editColumn('reply_indicator', function ($myidentity_log) {
                return "<span data-toggle='tooltip' title='".$myidentity_log->reply_indicator_text."' class='label label-primary' style='cursor: pointer;'>".$myidentity_log->reply_indicator."</span>";
            })->make(true);
        }
        return view("admin.myidentity_log", compact('myidentity_log'));
    }

}
