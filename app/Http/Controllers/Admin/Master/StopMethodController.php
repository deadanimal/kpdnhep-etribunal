<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterStopMethod;

class StopMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'stop_method_en' => 'required',
                    'stop_method_my' => 'required'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'stop_method_en' => 'required',
                    'stop_method_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$stop_method = MasterStopMethod::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($stop_method);

            return $datatables
                ->editColumn('stop_method_id', function ($stop_method) {
                    return $stop_method->stop_method_id;
                })->editColumn('stop_method_en', function ($stop_method) {
                    return $stop_method->stop_method_en;
                })->editColumn('stop_method_my', function ($stop_method) {
                    return $stop_method->stop_method_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($stop_method) {
                    $button = "";

                    if($stop_method->is_active) {
                        $button .= '<a value="' . route('master.stop_method.view', $stop_method->stop_method_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.stop_method.edit', ['id'=>$stop_method->stop_method_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'"  onclick="deleteStopMethod('. $stop_method->stop_method_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateStopMethod('. $stop_method->stop_method_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"StopMethodController",null,null,"Datatables load master stop method");
    	return view("admin.master.stop_method.list", compact('stop_method'));
    }

    public function create(){
        $stop_method = new MasterStopMethod;
        
    	return view("admin.master.stop_method.create", compact('stop_method'));
    }

    public function edit($id){
    	if($id){
	    	$stop_method = MasterStopMethod::find($id);

	    	return view("admin.master.stop_method.create", compact('stop_method'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$stop_method = MasterStopMethod::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"StopMethodController",null,null,"View master stop method ".$id);
    		return view('admin.master.stop_method.viewModal',compact('stop_method'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$stop_method = MasterStopMethod::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"StopMethodController",null,null,"Inactive master stop method ".$id);
        	$stop_method->is_active = 0;
        	$stop_method->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $stop_method = MasterStopMethod::find($id);
            $stop_method->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"StopMethodController",null,null,"Edit master stop method ".$id);
            $stop_method->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->stop_method_id == NULL){

    		if($validator->passes()){

    			$stop_method = MasterStopMethod::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"StopMethodController",json_encode($request->input()),null,"Master Stop Method ".$stop_method->stop_method_id." - Create stop method");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->stop_method_id != NULL){

    		if($validator->passes()){

    			$stop_method = MasterStopMethod::find($request->stop_method_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"StopMethodController",null,null,"Edit master stop method ".$request->stop_method_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
