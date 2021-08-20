<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterDurationTerm;

class DurationTermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'term_en' => 'required',
                    'term_my' => 'required'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'term_en' => 'required',
                    'term_my' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$term = MasterDurationTerm::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($term);

            return $datatables
                ->editColumn('duration_term_id', function ($term) {
                    return $term->duration_term_id;
                })->editColumn('term_en', function ($term) {
                    return $term->term_en;
                })->editColumn('term_my', function ($term) {
                    return $term->term_my;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('action', function ($term) {
                    $button = "";

                    if($term->is_active) {
                        $button .= '<a value="' . route('master.term.view', $term->duration_term_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.term.edit', ['id'=>$term->duration_term_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteTerm('. $term->duration_term_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateTerm('. $term->duration_term_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"DurationTermController",null,null,"Datatables load master duration term");

    	return view("admin.master.term.list", compact('term'));
    }

    public function create(){
        $term = new MasterDurationTerm;
        
    	return view("admin.master.term.create", compact('term'));
    }

    public function edit($id){
    	if($id){
	    	$term = MasterDurationTerm::find($id);

	    	return view("admin.master.term.create", compact('term'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$term = MasterDurationTerm::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"DurationTermController",null,null,"View master duration term ".$id);
    		return view('admin.master.term.viewModal',compact('term'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$term = MasterDurationTerm::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"DurationTermController",null,null,"Delete master duration term ".$id);
        	$term->is_active = 0;
        	$term->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $term = MasterDurationTerm::find($id);
            $term->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"DurationTermController",null,null,"Edit master duration term ".$id);
            $term->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->duration_term_id == NULL){

    		if($validator->passes()){

    			$term = MasterDurationTerm::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"DurationTermController",json_encode($request->input()),null,"Master Duration Term ".$term->duration_term_id." - Create duration term");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->duration_term_id != NULL){

    		if($validator->passes()){

    			$term = MasterDurationTerm::find($request->duration_term_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"DurationTermController",null,null,"Edit master duration term ".$request->duration_term_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
