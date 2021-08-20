<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterCourt;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterBranch;

class CourtController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//DB
	protected function rules_insert(){

		$rules = [ 
			'court_name' => 'required',
			'address1' => 'required',
			'state_id'=>'required|integer',
			'district_id' => 'required|integer',
			'branch_id' => 'required|integer',
			'postcode' => 'required|string|min:5|max:5'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
			'court_name' => 'required',
			'address1' => 'required',
			'state_id'=>'required|integer',
			'district_id' => 'required|integer',
			'branch_id' => 'required|integer',
			'postcode' => 'required|string|min:5|max:5'
		];

		return $rules;
	}

	public function index(Request $request) {

		$branches = MasterBranch::orderBy('is_active', 'desc')->orderBy('branch_id','asc')->get();

		if ($request->ajax()) {

			$courts = MasterCourt::with(['branch'])->where('is_active', 1);

			if($request->has('branch') && !empty($request->branch))
				$courts->where('branch_id', $request->branch);

			$courts->get();

			$datatables = Datatables::of($courts);

			return $datatables
			->editColumn('court_name', function ($court) {
				return $court->court_name;
			})->editColumn('branch_name', function ($court) {
				return $court->branch->branch_name;  
			})->editColumn('address', function ($court) {
				return $court->address1."<br>".
				$court->address2."<br>".$court->postcode." ".
				$court->district->district.", ".$court->state->state;   
			})->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at)); 
			})->editColumn('action', function ($court) {
				$button = "";

				if($court->is_active) {
					$button .= '<a value="' . route('master.court.view', $court->court_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

					$button .= actionButton('green-meadow', __('button.edit'), route('master.court.edit', ['id'=>$court->court_id]), false, 'fa-edit', false);

					$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteCourt('. $court->court_id .')"><i class="fa fa-times"></i></a>';
				}
                else {
                    $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateCourt('. $court->court_id .')"><i class="fa fa-check"></i></a>';
                }

				return $button;
			})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"CourtController",null,null,"Datatables load master court");

		return view("admin.master.court.list", compact('courts','branches'));
	}

	public function create(){
		$court = new MasterCourt;
		$districts = MasterDistrict::all();
		$states = MasterState::all();
		$branches = MasterBranch::where('is_active', 1)->get();

		return view("admin.master.court.create", compact('court','districts','states', 'branches'));
	}

	public function edit($id){
		if($id){
			$court = MasterCourt::find($id);
			$districts = MasterDistrict::all();
			$states = MasterState::all();
			$branches = MasterBranch::where('is_active', 1)->get();

			return view("admin.master.court.create", compact('court','districts','states', 'branches'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$court = MasterCourt::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"CourtController",null,null,"View master court ".$id);
			return view('admin.master.court.viewModal',compact('court'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$court = MasterCourt::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"CourtController",null,null,"Delete master court ".$id);
			$court->is_active = 0;
			$court->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request,$id){
		if($id){
			$court = MasterCourt::find($id);
			$court->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"CourtController",null,null,"Edit master court ".$id);
			$court->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->court_id == NULL){

			if($validator->passes()){

				$court = MasterCourt::create($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"CourtController",json_encode($request->input()),null,"Master Court ".$court->court_id." - Create master court");

				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);               
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->court_id != NULL){

			if($validator->passes()){

				$court = MasterCourt::find($request->court_id)->update($request->all());
				$audit = new \App\Http\Controllers\Admin\AuditController;
            	$audit->add($request,5,"CourtController",null,null,"Edit master court ".$request->court_id);
				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
