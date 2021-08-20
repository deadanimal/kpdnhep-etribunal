<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterStopReason;

class StopReasonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'stop_reason_en' => 'required',
                    'stop_reason_my' => 'required'  
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'stop_reason_en' => 'required',
                    'stop_reason_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$stop_reasons = MasterStopReason::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($stop_reasons);

            return $datatables
                ->editColumn('stop_reason_id', function ($stop_reason) {
                    return $stop_reason->stop_reason_id;
                })->editColumn('stop_reason_en', function ($stop_reason) {
                    return $stop_reason->stop_reason_en;
                })->editColumn('stop_reason_my', function ($stop_reason) {
                    return $stop_reason->stop_reason_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($stop_reason) {
                    $button = "";

                    if($stop_reason->is_active) {
                        $button .= '<a value="' . route('master.stop_reason.view', $stop_reason->stop_reason_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.stop_reason.edit', ['id'=>$stop_reason->stop_reason_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'"  onclick="deleteStopReason('. $stop_reason->stop_reason_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateStopReason('. $stop_reason->stop_reason_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"StopReasonController",null,null,"Datatables load master stop reason");
    	return view("admin.master.stop_reason.list", compact('stop_reason'));
    }

    public function create(){
        $stop_reason = new MasterStopReason;
        
    	return view("admin.master.stop_reason.create", compact('stop_reason'));
    }

    public function edit($id){
    	if($id){
	    	$stop_reason = MasterStopReason::find($id);

	    	return view("admin.master.stop_reason.create", compact('stop_reason', 'feedback'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$stop_reason = MasterStopReason::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"StopReasonController",null,null,"View master stop reason ".$id);
    		return view('admin.master.stop_reason.viewModal',compact('stop_reason'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$stop_reason = MasterStopReason::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"StopReasonController",null,null,"Inactive master stop reason ".$id);
        	$stop_reason->is_active = 0;
        	$stop_reason->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $stop_reason = MasterStopReason::find($id);
            $stop_reason->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"StopReasonController",null,null,"Edit master stop reason ".$id);
            $stop_reason->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->stop_reason_id == NULL){

    		if($validator->passes()){

    			$stop_reason = MasterStopReason::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"StopReasonController",json_encode($request->input()),null,"Master Stop Reason ".$stop_reason->stop_reason_id." - Create stop reason");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->stop_reason_id != NULL){

    		if($validator->passes()){

    			$stop_reason = MasterStopReason::find($request->stop_reason_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"StopReasonController",null,null,"Edit master stop reason ".$request->stop_reason_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
