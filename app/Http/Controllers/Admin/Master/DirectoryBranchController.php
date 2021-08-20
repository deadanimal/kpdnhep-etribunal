<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterDirectoryBranch;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterState;

class DirectoryBranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
            'directory_branch_head' => 'required|string',
            'directory_branch_email' => 'required|string',
            'address_1' => 'required|string',
            'postcode' => 'required|string',
            'district_id' => 'required|string',
            'state_id' => 'required|integer',
            'directory_branch_tel' => 'required|string',
            'directory_branch_faks' => 'required|string'
        ]; 
        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
            'directory_branch_head' => 'required|string',
            'directory_branch_email' => 'required|string',
            'address_1' => 'required|string',
            'postcode' => 'required|string',
            'district_id' => 'required|string',
            'state_id' => 'required|integer',
            'directory_branch_tel' => 'required|string',
            'directory_branch_faks' => 'required|string'
        ];
        return $rules;
    }

    public function index(Request $request){

        if ($request->ajax()) {

            $directoryBranch = MasterDirectoryBranch::orderBy('created_at', 'desc')->get();

            $datatables = Datatables::of($directoryBranch);

            return $datatables
            ->editColumn('directory_branch_id', function ($directoryBranch) {
                return $directoryBranch->directory_branch_id;
            })->editColumn('state_id', function ($directoryBranch) {
                return $directoryBranch->state->state;
            })->editColumn('address', function ($directoryBranch) {
                return "TRIBUNAL TUNTUTAN PENGGUNA MALAYSIA <br>".
                $directoryBranch->address_1."<br>".
                $directoryBranch->address_2."<br>".
                $directoryBranch->address_3."<br>".
                $directoryBranch->postcode." ".
                $directoryBranch->district->district."<br>".
                $directoryBranch->state->state.". <br>".
                trans('new.tel').": ". $directoryBranch->directory_branch_tel."<br>".
                trans('new.fax').": ". $directoryBranch->directory_branch_faks."<br>";
            })->editColumn('ks', function ($directoryBranch) {
                return  trans('new.name').": ".$directoryBranch->directory_branch_head."<br>".
                trans('new.email').": ".$directoryBranch->directory_branch_email."<br>";
            })->editColumn('action', function ($directoryBranch) {
                $button = "";

                if($directoryBranch->is_active == 1) {
                    $button .= '<a value="' . route('master.directory.branch.view', $directoryBranch->directory_branch_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    $button .= actionButton('green-meadow', __('button.edit'), route('master.directory.branch.edit', ['id'=>$directoryBranch->directory_branch_id]), false, 'fa-edit', false);

                    $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteDirectoryBranch('. $directoryBranch->directory_branch_id .')"><i class="fa fa-times"></i></a>';
                }
                else {
                 $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateDirectoryBranch('. $directoryBranch->directory_branch_id .')"><i class="fa fa-check"></i></a>';
             }

             return $button;
         })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"DirectoryBranchController",null,null,"Datatables load master directory branch");

        return view("admin.master.directory.branch.list", compact('directoryBranch'));
    }

    public function create(){

        $directoryBranch = new MasterDirectoryBranch;
        $states = MasterState::all();

        return view("admin.master.directory.branch.create", compact('directoryBranch','states'));
    }

    public function edit($id){
        if($id){

            $directoryBranch = MasterDirectoryBranch::find($id);
            $states = MasterState::all();
            return view("admin.master.directory.branch.create", compact('directoryBranch','states'));
        }
    }

    public function view(Request $request, $id){
        if($id){
            $directoryBranch = MasterDirectoryBranch::find($id);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"DirectoryBranchController",null,null,"View master directory branch ".$id);
            return view('admin.master.directory.branch.viewModal',compact('directoryBranch'), ['id' => $id])->render();
        }  
    }

    public function delete(Request $request, $id){
        if($id){
            $directoryBranch = MasterDirectoryBranch::find($id);
            
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"DirectoryBranchController",null,null,"Delete master directory branch ".$id);
            $directoryBranch->is_active = 0;
            $directoryBranch->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id){
        if($id){

            $directoryBranch = MasterDirectoryBranch::find($id);
            $directoryBranch->is_active =  1; 

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"DirectoryBranchController",null,null,"Edit master directory branch ".$id);
            $directoryBranch->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), $this->rules_insert());

        if($request->directory_branch_id == NULL){

            if($validator->passes()){

                $directoryBranch_data = $request->only(
                    'directory_branch_head',
                    'directory_branch_email',
                    'address_1',
                    'address_2',
                    'address_3',
                    'postcode',
                    'district_id',
                    'state_id',
                    'directory_branch_tel',
                    'directory_branch_faks'
                );

                $directoryBranch = MasterDirectoryBranch::create($directoryBranch_data);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"DirectoryBranchController",json_encode($request->input()),null,"Master Directory Branch ".$directoryBranch->directory_branch_id." - Create directory branch");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), $this->rules_update());

        if($request->directory_branch_id != NULL){

            if($validator->passes()){

                $directoryBranch = MasterDirectoryBranch::find($request->directory_branch_id)->update([

                   'directory_branch_head' => $request->directory_branch_head,
                   'directory_branch_email' => $request->directory_branch_email,
                   'address_1' => $request->address_1,
                   'address_2' => $request->address_2,
                   'address_3' => $request->address_3,
                   'postcode' => $request->postcode,
                   'district_id' => $request->district_id,
                   'state_id' => $request->state_id,
                   'directory_branch_tel' => $request->directory_branch_tel,
                   'directory_branch_faks' => $request->directory_branch_faks
               ]);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"DirectoryBranchController",null,null,"Edit master directory branch ".$request->directory_branch_id);
                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            }else{
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }
}
