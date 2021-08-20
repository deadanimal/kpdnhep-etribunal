<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterClaimClassification;
use App\MasterModel\MasterClaimCategory;
use App;

class ClassificationController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//
	protected function rules_insert(){

		$rules = [ 
			'classification_en' => 'required',
			'classification_my' => 'required',
			'category_id' => 'required|integer',
			'rcy_id' => 'required|string|max:3|min:3|unique:master_claim_classification'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
			'classification_en' => 'required',
			'classification_my' => 'required',
			'category_id' => 'required|integer',
			'rcy_id' => 'required|string|max:3|min:3'
		];

		return $rules;
	}

	public function index(Request $request){

		$categories = MasterClaimCategory::orderBy('is_active', 'desc')->get();

		if ($request->ajax()) {

			$classifications = MasterClaimClassification::with(['category'])->where('is_active', 1);

			if($request->has('category') && !empty($request->category))
				$classifications->where('category_id', $request->category);

			$classifications->get();

			$datatables = Datatables::of($classifications);

			return $datatables
			->editColumn('claim_classification_id', function ($classification) {
				return $classification->claim_classification_id;
			})->editColumn('classification_en', function ($classification) {
				return $classification->classification_en;
			})->editColumn('classification_my', function ($classification) {
				return $classification->classification_my;
			})->editColumn('rcy_id', function ($classification) {
				return $classification->rcy_id;
			})->editColumn('category', function ($classification) {
				$category_lang = "category_".App::getLocale();
				return $classification->category->$category_lang;
			})->editColumn('created_at', function ($model) {
				return date('d/m/Y', strtotime($model->created_at));
			})->editColumn('action', function ($classification) {
				$button = "";

				if($classification->is_active) {
					$button .= '<a value="' . route('master.classification.view', $classification->claim_classification_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

					$button .= actionButton('green-meadow', __('button.edit'), route('master.classification.edit', ['id'=>$classification->claim_classification_id]), false, 'fa-edit', false);

					$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteClassification('. $classification->claim_classification_id .')"><i class="fa fa-times"></i></a>';
				}
                else {
                    $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateClassification('. $classification->claim_classification_id .')"><i class="fa fa-check"></i></a>';
                }

				return $button;
			})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"ClassificationController",null,null,"Datatables load master classification");

		return view("admin.master.classification.list", compact('classifications','categories'));
	}

	public function create(){
		$classification = new MasterClaimClassification;
		$categories = MasterClaimCategory::where('is_active', 1)->get();

		return view("admin.master.classification.create", compact('classification','categories'));
	}

	public function edit($id){
		if($id){
			$classification = MasterClaimClassification::find($id);
			$categories = MasterClaimCategory::where('is_active', 1)->get();

			return view("admin.master.classification.create", compact('classification','categories'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$classification = MasterClaimClassification::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"ClassificationController",null,null,"View master classification ".$id);
			return view('admin.master.classification.viewModal',compact('classification'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$classification = MasterClaimClassification::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"ClassificationController",null,null,"Delete master classification ".$id);
			$classification->is_active = 0;
			$classification->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request, $id){
		if($id){
			$classification = MasterClaimClassification::find($id);
			$classification->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"ClassificationController",null,null,"Edit master classification ".$id);
			$classification->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->claim_classification_id == NULL){

			if($validator->passes()){

				$classification = MasterClaimClassification::create($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"ClassificationController",json_encode($request->input()),null,"Master Classification ".$classification->claim_classification_id." - Create claim classification");

				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->claim_classification_id != NULL){

			if($validator->passes()){

				$classification = MasterClaimClassification::find($request->claim_classification_id)->update($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
            	$audit->add($request,5,"ClassificationController",null,null,"Edit master classification ".$request->claim_classification_id);

				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
