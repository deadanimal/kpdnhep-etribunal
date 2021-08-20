<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterVisitorReason;

class VisitorReasonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'reason_en' => 'required',
                    'reason_my' => 'required'
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'reason_en' => 'required',
                    'reason_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$reason = MasterVisitorReason::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($reason);

            return $datatables
                ->editColumn('visitor_reason_id', function ($reason) {
                    return $reason->visitor_reason_id;
                })->editColumn('reason_en', function ($reason) {
                    return $reason->reason_en;
                })->editColumn('reason_my', function ($reason) {
                    return $reason->reason_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($reason) {
                    $button = "";

                    if($reason->is_active) {
                        $button .= '<a value="' . route('master.reason.view', $reason->visitor_reason_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.reason.edit', ['id'=>$reason->visitor_reason_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'"  onclick="deleteReason('. $reason->visitor_reason_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateReason('. $reason->visitor_reason_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"VisitorReasonController",null,null,"Datatables load master visitor reason");
    	return view("admin.master.reason.list", compact('reason'));
    }

    public function create(){
        $reason = new MasterVisitorReason;
        
    	return view("admin.master.reason.create", compact('reason'));
    }

    public function edit($id){
    	if($id){
	    	$reason = MasterVisitorReason::find($id);

	    	return view("admin.master.reason.create", compact('reason'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$reason = MasterVisitorReason::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"VisitorReasonController",null,null,"View master visitor reason ".$id);
    		return view('admin.master.reason.viewModal',compact('reason'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$reason = MasterVisitorReason::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"VisitorReasonController",null,null,"Inactive master visitor reason ".$id);
        	$reason->is_active = 0;
        	$reason->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $reason = MasterVisitorReason::find($id);
            $reason->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"VisitorReasonController",null,null,"Edit master visitor reason ".$id);
            $reason->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->visitor_reason_id == NULL){

    		if($validator->passes()){

    			$reason = MasterVisitorReason::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"VisitorReasonController",json_encode($request->input()),null,"Master Visitor Reason ".$reason->visitor_reason_id." - Create visitor reason");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->visitor_reason_id != NULL){

    		if($validator->passes()){

    			$reason = MasterVisitorReason::find($request->visitor_reason_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"VisitorReasonController",null,null,"Edit master visitor reason ".$request->visitor_reason_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
