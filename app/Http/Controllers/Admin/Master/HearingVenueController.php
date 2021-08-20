<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterHearingVenue;
use App\MasterModel\MasterBranch;

class HearingVenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'hearing_venue' => 'required',
                    'branch_id' => 'required|integer'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'hearing_venue' => 'required',
                    'branch_id' => 'required|integer'
                ];

        return $rules;
    }

    public function index(Request $request){

        $branches = MasterBranch::orderBy('is_active', 'desc')->orderBy('branch_id','asc')->get(); //GET VALUE FROM DB

    	if ($request->ajax()) {

    		$hearing_venues = MasterHearingVenue::where('is_active', 1);

            if($request->has('branch') && !empty($request->branch))
                $hearing_venues->where('branch_id', $request->branch);

            $hearing_venues->get();

            $datatables = Datatables::of($hearing_venues);

            return $datatables
                ->editColumn('hearing_venue_id', function ($hearing_venue) {
                    return $hearing_venue->hearing_venue_id;
                })->editColumn('hearing_venue', function ($hearing_venue) {
                    return $hearing_venue->hearing_venue;
                })->editColumn('branch_id', function ($hearing_venue) {
                    return $hearing_venue->branch->branch_name;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($hearing_venue) {
                    $button = "";

                    if($hearing_venue->is_active) {
                        $button .= '<a value="' . route('master.hearing_venue.view', $hearing_venue->hearing_venue_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.hearing_venue.edit', ['id'=>$hearing_venue->hearing_venue_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteHearingVenue('. $hearing_venue->hearing_venue_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateHearingVenue('. $hearing_venue->hearing_venue_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"HearingVenueController",null,null,"Datatables load master hearing venue");

    	return view("admin.master.hearing_venue.list", compact('hearing_venues','branches'));
    }

    public function create(){
        $hearing_venue = new MasterHearingVenue;
        $branches = MasterBranch::where('is_active', 1)->get();

    	return view("admin.master.hearing_venue.create", compact('hearing_venue','branches'));
    }

    public function edit($id){
    	if($id){
	    	$hearing_venue = MasterHearingVenue::find($id);
            $branches = MasterBranch::where('is_active', 1)->get();

	    	return view("admin.master.hearing_venue.create", compact('hearing_venue','branches'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$hearing_venue = MasterHearingVenue::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"HearingVenueController",null,null,"View master hearing venue ".$id);
    		return view('admin.master.hearing_venue.viewModal',compact('hearing_venue'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$hearing_venue = MasterHearingVenue::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"HearingVenueController",null,null,"Delete master hearing venue ".$id);
        	$hearing_venue->is_active = 0;
        	$hearing_venue->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $hearing_venue = MasterHearingVenue::find($id);
            $hearing_venue->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"HearingVenueController",null,null,"Edit master hearing venue ".$id);
            $hearing_venue->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->hearing_venue_id == NULL){

    		if($validator->passes()){

    			$hearing_venue = MasterHearingVenue::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"HearingVenueController",json_encode($request->input()),null,"Master Hearing Venue ".$hearing_venue->hearing_venue_id." - Create hearing venue");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->hearing_venue_id != NULL){

    		if($validator->passes()){

    			$hearing_venue = MasterHearingVenue::find($request->hearing_venue_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"HearingVenueController",null,null,"Edit master hearing venue ".$request->hearing_venue_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
