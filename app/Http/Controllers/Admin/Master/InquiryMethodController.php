<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterInquiryMethod;
use App\MasterModel\MasterClaimCategory;

class InquiryMethodController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//
	protected function rules_insert(){

		$rules = [ 
			'method_en' => 'required',
			'method_my' => 'required',
			'code' => 'required|unique:master_inquiry_method|string|min:1|max:1'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
			'method_en' => 'required',
			'method_my' => 'required',
			'code' => 'required|string|min:1|max:1'
		];

		return $rules;
	}

	public function index(Request $request){

		if ($request->ajax()) {

			$inquiry_methods = MasterInquiryMethod::orderBy('is_active', 'desc')->get();

			$datatables = Datatables::of($inquiry_methods);

			return $datatables
			->editColumn('inquiry_method_id', function ($inquiry_method) {
				return $inquiry_method->inquiry_method_id;
			})->editColumn('method_en', function ($inquiry_method) {
				return $inquiry_method->method_en;
			})->editColumn('method_my', function ($inquiry_method) {
				return $inquiry_method->method_my;
			})->editColumn('code', function ($inquiry_method) {
				return $inquiry_method->code;
			})->editColumn('created_at', function ($model) {
				return date('d/m/Y', strtotime($model->created_at));
			})->editColumn('action', function ($inquiry_method) {
				$button = "";

				if($inquiry_method->is_active) {
					$button .= '<a value="' . route('master.inquiry_method.view', $inquiry_method->inquiry_method_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

					$button .= actionButton('green-meadow', __('button.edit'), route('master.inquiry_method.edit', ['id'=>$inquiry_method->inquiry_method_id]), false, 'fa-edit', false);

					$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteInquiryMethod('. $inquiry_method->inquiry_method_id .')"><i class="fa fa-times"></i></a>';
				}
				else {
					$button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateInquiryMethod('. $inquiry_method->inquiry_method_id .')"><i class="fa fa-check"></i></a>';
				}

				return $button;
			})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"InquiryMethodController",null,null,"Datatables load master inquiry method");

		return view("admin.master.inquiry_method.list", compact('inquiry_method'));
	}

	public function create(){
		$inquiry_method = new MasterInquiryMethod;

		return view("admin.master.inquiry_method.create", compact('inquiry_method'));
	}

	public function edit($id){
		if($id){
			$inquiry_method = MasterInquiryMethod::find($id);

			return view("admin.master.inquiry_method.create", compact('inquiry_method'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$inquiry_method = MasterInquiryMethod::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"InquiryMethodController",null,null,"View master inquiry method ".$id);
			return view('admin.master.inquiry_method.viewModal',compact('inquiry_method'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$inquiry_method = MasterInquiryMethod::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"InquiryMethodController",null,null,"Inactive master inquiry method ".$id);
			$inquiry_method->is_active = 0;
			$inquiry_method->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request, $id){
		if($id){
			$inquiry_method = MasterInquiryMethod::find($id);
			$inquiry_method->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"InquiryMethodController",null,null,"Edit master inquiry method ".$id);
			$inquiry_method->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->inquiry_method_id == NULL){

			if($validator->passes()){

				$inquiry_method = MasterInquiryMethod::create($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"InquiryMethodController",json_encode($request->input()),null,"Master Inquiry Method ".$inquiry_method->inquiry_method_id." - Create inquiry method");

				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->inquiry_method_id != NULL){

			if($validator->passes()){

				$inquiry_method = MasterInquiryMethod::find($request->inquiry_method_id)->update($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
            	$audit->add($request,5,"InquiryMethodController",null,null,"Edit master inquiry method ".$request->inquiry_method_id);
				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
