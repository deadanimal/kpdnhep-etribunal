<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterSubmissionType;

class SubmissionTypeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//DB
	protected function rules_insert(){

		$rules = [ 
			'type_en' => 'required',
			'type_my' => 'required'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
			'type_en' => 'required',
			'type_my' => 'required'
		];

		return $rules;
	}

	public function index(Request $request){
		
		if ($request->ajax()) {

			$submission_types = MasterSubmissionType::orderBy('is_active', 'desc')->get();

			$datatables = Datatables::of($submission_types);

			return $datatables
				->editColumn('submission_type_en', function ($submission_type) {
					return $submission_type->submission_type_en;
				})->editColumn('submission_type_my', function ($submission_type) {
					return $submission_type->submission_type_my;
				})->editColumn('created_at', function ($model) {
					return date('d/m/Y', strtotime($model->created_at));
				})->editColumn('action', function ($submission_type) {
					$button = "";

					if($submission_type->is_active) {
						$button .= '<a value="' . route('master.submission_type.view', $submission_type->submission_type_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

						$button .= actionButton('green-meadow', __('button.edit'), route('master.submission_type.edit', ['id'=>$submission_type->submission_type_id]), false, 'fa-edit', false);

						$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'"  onclick="deleteType('. $submission_type->submission_type_id .')"><i class="fa fa-times"></i></a>';
					}
					else {
						$button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateType('. $submission_type->submission_type_id .')"><i class="fa fa-check"></i></a>';
					}

					return $button;

				})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"SubmissionTypeController",null,null,"Datatables load master submission type");
		return view("admin.master.submission_type.list", compact('submission_types'));
	}

	public function create(){
		$submission_type = new MasterSubmissionType;
// $categories = MasterClaimsubmission_type::all();

		return view("admin.master.submission_type.create", compact('submission_type'));
	}

	public function edit($id){
		if($id){
			$submission_type = MasterSubmissionType::find($id);
// $categories = MasterClaimsubmission_type::all();

			return view("admin.master.submission_type.create", compact('submission_type'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$submission_type = MasterSubmissionType::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"SubmissionTypeController",null,null,"View master submission type ".$id);
			return view('admin.master.submission_type.viewModal',compact('submission_type'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$submission_type = MasterSubmissionType::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"SubmissionTypeController",null,null,"Inactive master submission type ".$id);
			$submission_type->is_active = 0;
			$submission_type->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request, $id){
		if($id){
			$submission_type = MasterSubmissionType::find($id);
			$submission_type->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"SubmissionTypeController",null,null,"Edit master submission type ".$id);
			$submission_type->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->submission_type_id == NULL){

			if($validator->passes()){

				$submission_type = MasterSubmissionType::create($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"SubmissionTypeController",json_encode($request->input()),null,"Master Submission Type ".$submission_type->submission_type_id." - Create submission type");
				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);               
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->submission_type_id != NULL){

			if($validator->passes()){

				$submission_type = MasterSubmissionType::find($request->submission_type_id)->update($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"SubmissionTypeController",null,null,"Edit master submission type ".$request->submission_type_id);
				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
