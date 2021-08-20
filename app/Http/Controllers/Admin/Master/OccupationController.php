<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterOccupation;

class OccupationController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//
	protected function rules_insert(){

		$rules = [ 
//'code' => 'required|unique:master_inquiry_method|string|min:1|max:1',
			'occupation_en'=>'required',
			'occupation_my'=>'required'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
//'code' => 'required|string|min:1|max:1',
			'occupation_id'=>'required',
			'occupation_en'=>'required',
			'occupation_my'=>'required'
		];

		return $rules;
	}

	public function index(Request $request){

		if ($request->ajax()) {

			$occupations = MasterOccupation::orderBy('is_active', 'desc')->get();

			$datatables = Datatables::of($occupations);

			return $datatables
			->editColumn('occupation_en', function ($occupation) {
				return $occupation->occupation_en;
			})->editColumn('occupation_my', function ($occupation) {
				return $occupation->occupation_my;
			})->editColumn('created_at', function ($model) {
				return date('d/m/Y', strtotime($model->created_at));
			})->editColumn('action', function ($occupation) {
				$button = "";

				if($occupation->is_active) {
					$button .= '<a value="' . route('master.occupation.view', $occupation->occupation_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

					$button .= actionButton('green-meadow', __('button.edit'), route('master.occupation.edit', ['id'=>$occupation->occupation_id]), false, 'fa-edit', false);

					$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteOccupation('. $occupation->occupation_id .')"><i class="fa fa-times"></i></a>';
				}
				else {
					$button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateOccupation('. $occupation->occupation_id .')"><i class="fa fa-check"></i></a>';
				}


				return $button;
			})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"OccupationController",null,null,"Datatables load master occupation");

		return view("admin.master.occupation.list", compact('occupation', 'occupation'));
	}

	public function create(){
		$occupation = new MasterOccupation;

		return view("admin.master.occupation.create", compact('occupation'));
	}

	public function edit($id){
		if($id){
			$occupation = MasterOccupation::find($id);

			return view("admin.master.occupation.create", compact('occupation', 'occupation'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$occupation = MasterOccupation::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"OccupationController",null,null,"View master occupation ".$id);
			return view('admin.master.occupation.viewModal',compact('occupation'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$occupation = MasterOccupation::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"OccupationController",null,null,"Inactive master occupation ".$id);
			$occupation->is_active = 0;
			$occupation->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request, $id){
		if($id){
			$occupation = MasterOccupation::find($id);
			$occupation->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"OccupationController",null,null,"Edit master occupation ".$id);
			$occupation->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->occupation_id == NULL){

			if($validator->passes()){

				$occupation = MasterOccupation::create($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"OccupationController",json_encode($request->input()),null,"Master Occupation ".$occupation->occupation_id." - Create occupation");

				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->occupation_id != NULL){

			if($validator->passes()){

				$occupation = MasterOccupation::find($request->occupation_id)->update($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
            	$audit->add($request,5,"OccupationController",null,null,"Edit master occupation ".$request->occupation_id);
				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
