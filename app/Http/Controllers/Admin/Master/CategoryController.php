<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterClaimCategory;

class CategoryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//DB
	protected function rules_insert(){

		$rules = [ 
			'category_en' => 'required',
			'category_my' => 'required',
			'category_code' => 'required|string|max:1|min:1|unique:master_claim_category'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
			'category_en' => 'required',
			'category_my' => 'required',
			'category_code' => 'required|string|max:1|min:1'
		];

		return $rules;
	}

	public function index(Request $request){

		if ($request->ajax()) {

			$categories = MasterClaimCategory::orderBy('is_active', 'desc')->get();

			$datatables = Datatables::of($categories);

			return $datatables
			->editColumn('claim_category_id', function ($category) {
				return $category->claim_category_id;
			})->editColumn('category_en', function ($category) {
				return $category->category_en;
			})->editColumn('category_my', function ($category) {
				return $category->category_my;
			})->editColumn('category_code', function ($category) {
				return $category->category_code;
			})->editColumn('created_at', function ($model) {
				return date('d/m/Y', strtotime($model->created_at));
			})->editColumn('action', function ($category) {
				$button = "";

				if($category->is_active) {
					$button .= '<a value="' . route('master.category.view', $category->claim_category_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

					$button .= actionButton('green-meadow', __('button.edit'), route('master.category.edit', ['id'=>$category->claim_category_id]), false, 'fa-edit', false);

					$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteCategory('. $category->claim_category_id .')"><i class="fa fa-times"></i></a>';
				}
				else {
					$button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateCategory('. $category->claim_category_id .')"><i class="fa fa-check"></i></a>';
				}

				return $button;
			})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"CategoryController",null,null,"Datatables load master category");

		return view("admin.master.category.list", compact('categories'));
	}

	public function create(){
		$category = new MasterClaimCategory;
// $categories = MasterClaimCategory::all();

		return view("admin.master.category.create", compact('category'));
	}

	public function edit($id){
		if($id){
			$category = MasterClaimCategory::find($id);
// $categories = MasterClaimCategory::all();

			return view("admin.master.category.create", compact('category'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$category = MasterClaimCategory::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"CategoryController",null,null,"View master claim category ".$id);
			return view('admin.master.category.viewModal',compact('category'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$category = MasterClaimCategory::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"CategoryController",null,null,"Delete master category ".$id);
			$category->is_active = 0;
			$category->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request, $id){
		if($id){
			$category = MasterClaimCategory::find($id);
			$category->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"CategoryController",null,null,"Edit master category ".$id);
			$category->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->claim_category_id == NULL){

			if($validator->passes()){

				$category = MasterClaimCategory::create($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"CategoryController",json_encode($request->input()),null,"Master Category ".$category->claim_category_id." - Create claim category");

				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);               
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->claim_category_id != NULL){

			if($validator->passes()){

				$category = MasterClaimCategory::find($request->claim_category_id)->update($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
            	$audit->add($request,5,"CategoryController",null,null,"Edit master category ".$request->claim_category_id);
				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
