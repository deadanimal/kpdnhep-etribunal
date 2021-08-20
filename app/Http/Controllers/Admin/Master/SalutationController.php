<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterSalutation;

class SalutationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'salutation_en' => 'required',
                    'salutation_my' => 'required'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'salutation_en' => 'required',
                    'salutation_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$salutation = MasterSalutation::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($salutation);

            return $datatables
                ->editColumn('salutation_id', function ($salutation) {
                    return $salutation->salutation_id;
                })->editColumn('salutation_en', function ($salutation) {
                    return $salutation->salutation_en;
                })->editColumn('salutation_my', function ($salutation) {
                    return $salutation->salutation_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($salutation) {
                    $button = "";

                    if($salutation->is_active) {
                        $button .= '<a value="' . route('master.salutation.view', $salutation->salutation_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.salutation.edit', ['id'=>$salutation->salutation_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'"  onclick="deleteSalutation('. $salutation->salutation_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateSalutation('. $salutation->salutation_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"SalutationController",null,null,"Datatables load master salutation");
    	return view("admin.master.salutation.list", compact('salutation'));
    }

    public function create(){
        $salutation = new MasterSalutation;
        
    	return view("admin.master.salutation.create", compact('salutation'));
    }

    public function edit($id){
    	if($id){
	    	$salutation = MasterSalutation::find($id);

	    	return view("admin.master.salutation.create", compact('salutation'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$salutation = MasterSalutation::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"SalutationController",null,null,"View master salutation ".$id);
    		return view('admin.master.salutation.viewModal',compact('salutation'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$salutation = MasterSalutation::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"SalutationController",null,null,"Inactive master salutation ".$id);
        	$salutation->is_active = 0;
        	$salutation->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $salutation = MasterSalutation::find($id);
            $salutation->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"SalutationController",null,null,"Edit master salutation ".$id);
            $salutation->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->salutation_id == NULL){

    		if($validator->passes()){

    			$salutation = MasterSalutation::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"SalutationController",json_encode($request->input()),null,"Master Salutation ".$salutation->salutation_id." - Create salutation");
    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->salutation_id != NULL){

    		if($validator->passes()){

    			$salutation = MasterSalutation::find($request->salutation_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"SalutationController",null,null,"Edit master salutation ".$request->salutation_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
