<?php

namespace App\Http\Controllers;

use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterHearingRoom;
use App\MasterModel\MasterHearingVenue;
use App\MasterModel\MasterState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Response;

class AjaxController extends Controller
{
    
    public function ajaxState(Request $request){
    	if($request->ajax()){
            $state = Input::get('state_id');
            $district = MasterDistrict::where('state_id', '=', $state)->get();
            return Response::json($district);
        }
    }

    public function ajaxHearingRoom(Request $request){
        $this->middleware('auth');
    	if($request->ajax()){
            $state = Input::get('state_id');
            $branch = MasterState::join('master_branch','master_state.state_id','=','master_branch.branch_state_id')->where('master_state.state_id', '=', $state)->pluck('master_branch.branch_id')->first();
            $venue = MasterHearingVenue::where('branch_id', '=', $branch)->pluck('hearing_venue_id')->toArray();
            $hearingroom = MasterHearingRoom::wherein('hearing_venue_id', $venue)->get();
            return Response::json($hearingroom);
        }
    }
}
