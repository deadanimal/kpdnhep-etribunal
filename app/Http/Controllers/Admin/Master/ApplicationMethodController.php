<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterApplicationMethod;

class ApplicationMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'method_en' => 'required',
                    'method_my' => 'required'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'method_en' => 'required',
                    'method_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$application_method = MasterApplicationMethod::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($application_method);

            return $datatables
                ->editColumn('application_method_id', function ($application_method) {
                    return $application_method->application_method_id;
                })->editColumn('method_en', function ($application_method) {
                    return $application_method->method_en;
                })->editColumn('method_my', function ($application_method) {
                    return $application_method->method_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($application_method) {
                    $button = "";

                    if($application_method->is_active) {
                        $button .= '<a value="' . route('master.application_method.view', $application_method->application_method_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.application_method.edit', ['id'=>$application_method->application_method_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteApplicationMethod('. $application_method->application_method_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateApplicationMethod('. $application_method->application_method_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"ApplicationMethodController",null,null,"Datatables load master application method");

    	return view("admin.master.application_method.list", compact('application_method'));
    }

    public function create(){
        $application_method = new MasterApplicationMethod;
        
    	return view("admin.master.application_method.create", compact('application_method'));
    }

    public function edit($id){
    	if($id){
	    	$application_method = MasterApplicationMethod::find($id);

	    	return view("admin.master.application_method.create", compact('application_method'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$application_method = MasterApplicationMethod::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"ApplicationMethodController",null,null,"View master application method ".$id);
    		return view('admin.master.application_method.viewModal',compact('application_method'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$application_method = MasterApplicationMethod::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"ApplicationMethodController",null,null,"Delete master application method ".$id);
        	$application_method->is_active = 0;
        	$application_method->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $application_method = MasterApplicationMethod::find($id);
            $application_method->is_active = 1;
            $application_method->save();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"ApplicationMethodController",null,null,"Edit master application method ".$id);
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->application_method_id == NULL){

    		if($validator->passes()){

    			$application_method = MasterApplicationMethod::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"ApplicationMethodController",json_encode($request->input()),null,"Master Application Method ".$request->application_method_id." - Create application method");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->application_method_id != NULL){

    		if($validator->passes()){

    			$application_method = MasterApplicationMethod::find($request->application_method_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"ApplicationMethodController",null,null,"Edit master application method ".$request->application_method_id);

    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
