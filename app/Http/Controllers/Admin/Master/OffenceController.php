<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterOffenceType;

class OffenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //DB
    protected function rules_insert(){

        $rules = [  
                    'offence_code' => 'required|min:3|max:5',                    
                    'offence_description_en' => 'required',
                    'offence_description_my' => 'required'
                     ];

        return $rules;
    }

     protected function rules_update(){
        $rules = [ 
                    'offence_code' => 'required|min:3|max:5',                    
                    'offence_description_en' => 'required',
                    'offence_description_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$offences = MasterOffenceType::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($offences);

            return $datatables
                ->editColumn('offence_type_id', function ($offence) {
                    return $offence->offence_type_id;
                })->editColumn('offence_code', function ($offence) {
                    return $offence->offence_code;    
                })->editColumn('offence_description_en', function ($offence) {
                    return $offence->offence_description_en;
                })->editColumn('offence_description_my', function ($offence) {
                    return $offence->offence_description_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($offence) {
                    $button = "";

                    if($offence->is_active) {
                        $button .= '<a value="' . route('master.offence_type.view', $offence->offence_type_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.offence_type.edit', ['id'=>$offence->offence_type_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteOffence('. $offence->offence_type_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateOffence('. $offence->offence_type_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"OffenceController",null,null,"Datatables load master offence");
    	return view("admin.master.offence_type.list", compact('offences'));
    }

    public function create(){
        $offence = new MasterOffenceType;
        // $categories = MasterOffenceType::all();

    	return view("admin.master.offence_type.create", compact('offence'));
    }

    public function edit($id){
    	if($id){
	    	$offence = MasterOffenceType::find($id);
	    	// $categories = MasterOffenceType::all();

	    	return view("admin.master.offence_type.create", compact('offence'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$offence = MasterOffenceType::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"OffenceController",null,null,"View master occupation ".$id);
    		return view('admin.master.offence_type.viewModal',compact('offence'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$offence = MasterOffenceType::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"OffenceController",null,null,"Inactive master offence ".$id);
        	$offence->is_active = 0;
        	$offence->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $offence = MasterOffenceType::find($id);
            $offence->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"OffenceController",null,null,"Edit master occupation ".$id);
            $offence->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->offence_type_id == NULL){

    		if($validator->passes()){

    			$offence = MasterOffenceType::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"OffenceController",json_encode($request->input()),null,"Master Offence ".$offence->offence_type_id." - Create offence type");
    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);               
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->offence_type_id != NULL){

    		if($validator->passes()){

    			$offence = MasterOffenceType::find($request->offence_type_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"OffenceController",null,null,"View master offence ".$request->offence_type_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
