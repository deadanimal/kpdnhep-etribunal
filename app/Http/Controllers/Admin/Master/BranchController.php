<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterBranch;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterState;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'branch_name' => 'required',
                    'branch_code' => 'required||string|max:5|unique:master_branch',
                    'branch_address' => 'required',
                    'branch_address_en' => 'required',
                    'branch_postcode' => 'required|digits:5',
                    'branch_state_id' => 'required|integer',
                    'branch_district_id' => 'required|integer',
                    'branch_office_phone' => 'required|string|regex:/^.{9,15}$/',
                    'branch_emel' => 'required|email|string',
                    'is_hq' => 'required|integer'
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'branch_name' => 'required',
                    'branch_code' => 'required|string|max:5',
                    'branch_address' => 'required',
                    'branch_address_en' => 'required',
                    'branch_postcode' => 'required|digits:5',
                    'branch_state_id' => 'required|integer',
                    'branch_district_id' => 'required|integer',
                    'branch_office_phone' => 'required|string|regex:/^.{9,15}$/',
                    'branch_emel' => 'required|email|string',
                    'is_hq' => 'required|integer'
                ];

        return $rules;
    }

    public function index(Request $request){

    	if ($request->ajax()) {

    		$branches = MasterBranch::orderBy('is_active', 'desc')->orderBy('is_hq', 'desc')->get();

            $datatables = Datatables::of($branches);

            return $datatables
                ->editColumn('branch_id', function ($branch) {
                    return $branch->branch_id;
                })->editColumn('branch_name', function ($branch) {
                	if($branch->is_hq == 1)
                    	return $branch->branch_name." (HQ)";
                    else
                    	return $branch->branch_name;
                })->editColumn('branch_code', function ($branch) {
                    return $branch->branch_code;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('address', function ($branch) {
                    return $branch->branch_address."<br>".
			                    $branch->branch_address2."<br>".
			                    $branch->branch_address3."<br>".
			                    $branch->branch_postcode." ".
			                    $branch->district->district.", ".
			                    $branch->state->state;
                })->editColumn('contact', function ($branch) {
                    return  trans('new.phone_office')." : ".$branch->branch_office_phone."<br>".
                    		trans('new.phone_fax')." : ".$branch->branch_office_fax."<br>".
                    		trans('new.email')." : ".$branch->branch_emel;
                })->editColumn('action', function ($branch) {
                    $button = "";

                    if($branch->is_active) {
                        $button .= '<a value="' . route('master.branch.view', $branch->branch_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.branch.edit', ['id'=>$branch->branch_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteBranch('. $branch->branch_id .')"><i class="fa fa-times"></i></a>';
                    }
                    else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateBranch('. $branch->branch_id .')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"BranchController",null,null,"Datatables load master branch");

    	return view("admin.master.branch.list", compact('branches'));
    }

    public function create(){
    	$branch = new MasterBranch;
    	$states = MasterState::all();

    	return view("admin.master.branch.create", compact('branch','states'));
    }

    public function edit($id){
    	if($id){
	    	$branch = MasterBranch::find($id);
	    	$states = MasterState::all();

	    	return view("admin.master.branch.create", compact('branch','states'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$branch = MasterBranch::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"BranchController",null,null,"View master branch ".$id);
    		return view('admin.master.branch.viewModal',compact('branch'), ['id' => $id])->render();
        }
    	
    }

    public function delete(Request $request, $id){
        if($id){
        	$branch = MasterBranch::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"BranchController",null,null,"Delete master branch ".$id);
        	$branch->is_active = 0;
        	$branch->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){
            $branch = MasterBranch::find($id);
            $branch->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"BranchController",null,null,"Edit master branch ".$id);
            $branch->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->branch_id == NULL){

    		if($validator->passes()){

    			$branch_data = $request->only(
    				'branch_name',
    				'branch_code',
    				'branch_address',
    				'branch_address2',
    				'branch_address3',
                    'branch_address_en',
                    'branch_address2_en',
                    'branch_address3_en',
    				'branch_postcode',
    				'branch_state_id',
    				'branch_district_id',
    				'branch_office_phone',
    				'branch_office_fax',
    				'branch_emel',
    				'is_hq'
    				);

    			$branch = MasterBranch::create($branch_data);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"BranchController",json_encode($request->input()),null,"Master Branch ".$branch->branch_id." - Create branch");

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->branch_id != NULL){

    		if($validator->passes()){

    			$branch = MasterBranch::find($request->branch_id)->update([
	            	'branch_name' => $request->branch_name,
	            	'branch_code' => $request->branch_code,
	            	'branch_address' => $request->branch_address,
	            	'branch_address2' => $request->branch_address2,
	            	'branch_address3' => $request->branch_address3,
                    'branch_address_en',
                    'branch_address2_en',
                    'branch_address3_en',
	            	'branch_postcode' => $request->branch_postcode,
	            	'branch_state_id' => $request->branch_state_id,
	            	'branch_district_id' => $request->branch_district_id,
	            	'branch_office_phone' => $request->branch_office_phone,
	            	'branch_office_fax' => $request->branch_office_fax,
	            	'branch_emel' => $request->branch_emel,
	            	'is_hq' => $request->is_hq
	            ]);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"BranchController",null,null,"Edit master branch ".$request->branch_id);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
