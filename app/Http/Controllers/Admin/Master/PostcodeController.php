<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterDesignation;

class PostcodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
    	if ($request->ajax()) {
    		$designation = MasterDesignation::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($designation);

            return $datatables
                ->editColumn('designation_id', function ($designation) {
                    return $designation->designation_id;
                })->editColumn('designation_en', function ($designation) {
                    return $designation->designation_en;
                })->editColumn('designation_my', function ($designation) {
                    return $designation->designation_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($designation) {
                    $button = "";

                    if($designation->is_active) {
                        $button .= '<a value="' . route('master.designation.view', $designation->designation_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.designation.edit', ['id'=>$designation->designation_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteDesignation('. $designation->designation_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateDesignation('. $designation->designation_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"DesignationController",null,null,"Datatables load master designation");

    	return view("admin.master.postcode.index", compact('designation'));
    }

    public function create(){
        $designation = new MasterDesignation;

    	return view("admin.master.designation.create", compact('designation'));
    }

    public function edit($id){
    	if($id){
	    	$designation = MasterDesignation::find($id);

	    	return view("admin.master.designation.create", compact('designation'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$designation = MasterDesignation::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"DesignationController",null,null,"View master designation ".$id);
    		return view('admin.master.designation.viewModal',compact('designation'), ['id' => $id])->render();
        }
    }

    public function delete(Request $request, $id){
        if($id){
        	$designation = MasterDesignation::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"DesignationController",null,null,"Delete master designation ".$id);
        	$designation->is_active = 0;
        	$designation->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $designation = MasterDesignation::find($id);
            $designation->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"DesignationController",null,null,"Edit master designation ".$id);
            $designation->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->designation_id == NULL){

    		if($validator->passes()){

    			$designation = MasterDesignation::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"DesignationController",json_encode($request->input()),null,"Master Designation ".$designation->designation_id." - Create designation");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->designation_id != NULL){

    		if($validator->passes()){

    			$designation = MasterDesignation::find($request->designation_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"DesignationController",null,null,"Edit master designation ".$request->designation_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
