<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterHearingRoom;
use App\MasterModel\MasterHearingVenue;

use App\MasterModel\MasterBranch;

class HearingRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'hearing_room' => 'required',
                    'hearing_venue_id' => 'required|integer',
                    'address' => 'required'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'hearing_room' => 'required',
                    'hearing_venue_id' => 'required|integer',
                    'address' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

        $branches = MasterBranch::orderBy('is_active', 'desc')->orderBy('branch_id','asc')->get(); //GET VALUE FROM DB

    	if ($request->ajax()) {

    		$hearing_rooms = MasterHearingRoom::with(['venue'])->where('is_active', 1)->get();

            if($request->has('branch') && !empty($request->branch))
                $hearing_rooms = $hearing_rooms->filter(function ($value) use ($request) {
                    if($value->venue)
                        return $value->venue->branch_id == $request->branch;
                    else return false;
                });

            $datatables = Datatables::of($hearing_rooms);

            return $datatables
                ->editColumn('hearing_room_id', function ($hearing_room) {
                    return $hearing_room->hearing_room_id;
                })->editColumn('hearing_room', function ($hearing_room) {
                    return $hearing_room->hearing_room;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('hearing_venue_id', function ($hearing_room) {
                    if($hearing_room->hearing_venue_id)
                        return $hearing_room->venue->hearing_venue;
                    else
                        return "";
                })->editColumn('action', function ($hearing_room) {
                    $button = "";

                    if($hearing_room->is_active) {
                        $button .= '<a value="' . route('master.hearing_room.view', $hearing_room->hearing_room_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.hearing_room.edit', ['id'=>$hearing_room->hearing_room_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteHearingRoom('. $hearing_room->hearing_room_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateHearingRoom('. $hearing_room->hearing_room_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"HearingRoomController",null,null,"Datatables load master hearing room");
    	return view("admin.master.hearing_room.list", compact('hearing_rooms','branches'));
    }

    public function create(){
        $hearing_room = new MasterHearingRoom;
        $venues = MasterHearingVenue::where('is_active', 1)->get();

    	return view("admin.master.hearing_room.create", compact('hearing_room','venues'));
    }

    public function edit($id){
    	if($id){
	    	$hearing_room = MasterHearingRoom::find($id);
            $venues = MasterHearingVenue::where('is_active', 1)->get();

	    	return view("admin.master.hearing_room.create", compact('hearing_room','venues'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$hearing_room = MasterHearingRoom::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"HearingRoomController",null,null,"View master hearing room ".$id);
    		return view('admin.master.hearing_room.viewModal',compact('hearing_room'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$hearing_room = MasterHearingRoom::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"HearingRoomController",null,null,"Delete master hearing room ".$id);
        	$hearing_room->is_active = 0;
        	$hearing_room->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $hearing_room = MasterHearingRoom::find($id);
            $hearing_room->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"HearingRoomController",null,null,"Edit master hearing room ".$id);
            $hearing_room->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->hearing_room_id == NULL){

    		if($validator->passes()){

    			$hearing_room = MasterHearingRoom::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"HearingRoomController",json_encode($request->input()),null,"Master Hearing Room ".$hearing_room->hearing_room_id." - Create hearing room");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->hearing_room_id != NULL){

    		if($validator->passes()){

    			$hearing_room = MasterHearingRoom::find($request->hearing_room_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"HearingRoomController",null,null,"Edit master hearing room ".$request->hearing_room_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
