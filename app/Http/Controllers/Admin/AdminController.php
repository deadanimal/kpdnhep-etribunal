<?php

namespace App\Http\Controllers\Admin;

use App;

use App\Http\Controllers\Controller;
use App\Permission;
use App\PermissionRole;
use App\Role;
use App\User;
use App\MasterModel\MasterUserType;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

 
class AdminController extends Controller {
	public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function listroles(Request $request) {
		if ($request->ajax()) {
			$roles = Role::all();

			$datatables = Datatables::of($roles);

			return $datatables
				->editColumn('id', function ($roles) {
					return $roles->id;
				})
				->editColumn('name', function ($roles) {
					$display_name = "display_name_".App::getLocale();
					return $roles->$display_name;
				})
				->addColumn('tindakan', function ($roles) {
					// $button = '<form method="post"><a class="btn btn-xs blue-hoki" href="' . route('admins.editroles', $roles->id) . '"><i class="fa fa-pencil margin-right-5"></i>' . trans('button.edit') . '</a><button class="btn btn-xs btn-danger ajaxDelete" href="' . route('admins.destroyroles', $roles->id) . '"><i class="fa fa-trash margin-right-5"></i>' . trans('button.delete') . '</button></form>';
					$button = actionButton('blue btnModalPeranan', trans('button.view'), route('admins.viewroles', ['id'=>$roles->id]), false, 'fa-search', false).
					actionButton('green-meadow', trans('button.edit'), route('admins.editroles', ['id'=>$roles->id]), false, 'fa-edit', false).
	                actionButton('btn-danger ajaxDelete', trans('button.delete'), route('admins.destroyroles', ['id'=>$roles->id]), false, 'fa-trash-o', false);
					return $button;
				})->rawColumns(['name','description', 'tindakan'])
				->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"AdminController",null,null,"Datatables load roles");

		return view('acl.roles.index');
	}

	public function viewroles(Request $request, $id) {
		$role = Role::findOrFail($id);
		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,3,"AdminController",null,null,"View roles ".$id);
		return view('acl.roles.view', compact('role'));
	}

	public function createroles(Request $request) {
		$userType = MasterUserType::all();
		$relations = Permission::orderby('name')->get()->pluck('name', 'id');
		return view('acl.roles.create',compact('relations','userType'));
	}

    public function storeroles(Request $request){

    	$rules = [ 
                    'name' => 'required',
		        	'display_name_en' => 'required',
		        	'display_name_my' => 'required',
                ];

        $validator = Validator::make($request->all(), $rules);

        if(!$validator->passes()){
            return back()->withErrors($validator->getMessageBag()->toArray())->withInput();
        }

        try {
			// $role_type=$request->role_type;
			// $ttpm_type=$request->ttpm_type;

        	$owner = new Role;
			$owner->name=$request->name;
			$owner->display_name_en=$request->display_name_en; // optional
			$owner->display_name_my=$request->display_name_my; // optional
			$owner->description =$request->description; // optional
			$owner->type=$request->role_type;
			/*if($role_type == 1)
				$owner->type =0;
			elseif($role_type == 2)
				$owner->type =2;
			else
				$owner->type =0;*/
			$owner->save();

			$permissions = $request->permissions;
			if(!empty($permissions)){
				foreach($permissions as $p){
					$ownerperm = new PermissionRole;
					$ownerperm->permission_id=$p;
					$ownerperm->role_id=$owner->id;
					$ownerperm->save();
				}
			}

			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,4,"AdminController",json_encode($request->input()),null,"Role ".$request->name." - Create role");

        } catch (ValidationException $e) {
            return back()->withErrors($e->getErrors())->withInput();
        }
        return redirect(route('admins.listroles'))->withSuccess(trans('admins.createroles'));
    }

    public function editroles($id){
    	$userType = MasterUserType::all();
		$model = Role::findOrFail($id);
		$relations = Permission::orderby('name')->get()->pluck('name', 'id');
        return view('acl.roles.edit', compact('model','relations','userType'));
    }

    public function updateroles(Request $request,$id){

    	$rules = [ 
                    'name' => 'required',
		        	'display_name_en' => 'required',
		        	'display_name_my' => 'required',
                ];

        $validator = Validator::make($request->all(), $rules);

        if(!$validator->passes()){
            return back()->withErrors($validator->getMessageBag()->toArray())->withInput();
        }

        try {

    		$o = PermissionRole::where('role_id','=',$id)->delete();
			/*$role_type=$request->role_type;
			$ttpm_type=$request->ttpm_type;*/

        	$owner = Role::findOrFail($id);
			$owner->name=$request->name;
			$owner->display_name_en=$request->display_name_en; // optional
			$owner->display_name_my=$request->display_name_my; // optional
			$owner->description =$request->description; // optional
			$owner->type=$request->role_type;
			/*if($role_type == 1 && $ttpm_type == 1)
				$owner->type =0;
			elseif($role_type == 2 && $ttpm_type == 1)
				$owner->type =1;
			elseif($role_type == 2 && $ttpm_type == 2)
				$owner->type =2;
			else
				$owner->type =0;*/

			$owner->save();
			// foreach($o as $o){
			// 	$o->delete();
			// }
			$permissions = $request->permissions;
			if(!empty($permissions)){
				foreach($permissions as $p){
					$ownerperm = new PermissionRole;
					$ownerperm->permission_id=$p;
					$ownerperm->role_id=$owner->id;
					$ownerperm->save();
				}
			}

			$audit = new \App\Http\Controllers\Admin\AuditController;
        	$audit->add($request,5,"AdminController",null,null,"Edit roles ".$id);

        } catch (ValidationException $e) {
            return back()->withErrors($e->getErrors())->withInput();
        }
        return redirect(route('admins.listroles'))->withSuccess(trans('admins.updateroles'));
    }

    public function destroyroles(Request $request,$id){
        $owner = Role::findOrFail($id);
        $owner->delete($id);
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,6,"AdminController",null,null,"Delete role ".$id);
        return Response::json(['status' => 'ok']);
        // return redirect(route('admins.listroles'))->withSuccess(trans('admins.updateroles'));
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function listpermissions(Request $request) {
		if ($request->ajax()) {
			$permissions = Permission::orderby('name')->get();

			$datatables = Datatables::of($permissions);

			return $datatables
				->editColumn('id', function ($permissions) {
					return $permissions->id;
				})
				->editColumn('name', function ($permissions) {
					return $permissions->display_name;
				})
				->editColumn('description', function ($permissions) {
					$permissions = $permissions->description;

					return $permissions;
				})
				->addColumn('tindakan', function ($permissions) {
					// $button = '<form action="'.route('acl.permissions.destroy', $permissions->id).'" method="post"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="'.csrf_token().'"><a class="btn btn-xs blue-hoki" href="'.route('acl.permissions.edit', $permissions->id).'"><i class="fa fa-pencil margin-right-5"></i>'.trans('acl.button.edit').'</a><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash margin-right-5"></i>'.trans('acl.button.delete').'</button></form>';
					//     return $button;
					// route('acl.permissions.destroy', $permissions->id)
					// $button = '<form method="post"><a class="btn btn-xs blue-hoki" href="' . route('admins.editpermissions', $permissions->id) . '"><i class="fa fa-pencil margin-right-5"></i>' . trans('button.edit') . '</a><button class="btn btn-xs btn-danger ajaxDelete" href="' . route('admins.destroypermissions', $permissions->id) . '"><i class="fa fa-trash margin-right-5"></i>' . trans('button.delete') . '</button></form>';

					$button = actionButton('blue btnModalKebenaran', trans('button.view'), route('admins.viewpermissions', ['id'=>$permissions->id]), false, 'fa-search', false).
					actionButton('green-meadow', trans('button.edit'), route('admins.editpermissions', ['id'=>$permissions->id]), false, 'fa-edit', false).
	                actionButton('btn-danger ajaxDelete', trans('button.delete'), route('admins.destroypermissions', ['id'=>$permissions->id]), false, 'fa-trash-o', false);
					return $button;
				})->rawColumns(['name','description', 'tindakan'])
				->make(true);
		}
		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"AdminController",null,null,"Datatables load permissions");
		return view('acl.permissions.index');
	}

	public function viewpermissions(Request $request, $id) {
		$permission = Permission::findOrFail($id);
		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,3,"AdminController",null,null,"View permission ".$id);
		return view('acl.permissions.view', compact('permission'));
	}

	public function createpermissions(Request $request) {
		$relations = Role::get()->pluck('name', 'id');
		return view('acl.permissions.create',compact('relations'));
	}

    public function storepermissions(Request $request){
    	
    	$rules = [ 
                    'name' => 'required',
		        	'display_name' => 'required',
                ];

        $validator = Validator::make($request->all(), $rules);

        if(!$validator->passes()){
            return back()->withErrors($validator->getMessageBag()->toArray())->withInput();
        }

        try {

        	$owner = new Permission;
			$owner->name=$request->name;
			$owner->display_name=$request->display_name; // optional
			$owner->description =$request->description; // optional
			$owner->save();
			$roles = $request->roles;
			if(!empty($roles)){
				foreach($roles as $p){
					$ownerperm = new PermissionRole;
					$ownerperm->role_id=$p;
					$ownerperm->permission_id=$owner->id;
					$ownerperm->save();
				}
			}

			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,4,"AdminController",json_encode($request->input()),null,"Permission ".$request->name." - Create permission");
        } catch (ValidationException $e) {
            return back()->withErrors($e->getErrors())->withInput();
        }
        return redirect(route('admins.listpermissions'))->withSuccess(trans('admins.createpermissions'));
    }

    public function editpermissions($id){
		$model = Permission::findOrFail($id);
		$relations = Role::get()->pluck('name', 'id');

        return view('acl.permissions.edit', compact('model','relations'));
    }

    public function updatepermissions(Request $request,$id){

    	$rules = [ 
                    'name' => 'required',
		        	'display_name' => 'required',
                ];

        $validator = Validator::make($request->all(), $rules);

        if(!$validator->passes()){
            return back()->withErrors($validator->getMessageBag()->toArray())->withInput();
        }
        
        try {

    		$o = PermissionRole::where('permission_id','=',$id)->delete();
        	$owner = Permission::findOrFail($id);
			$owner->name=$request->name;
			$owner->display_name=$request->display_name; // optional
			$owner->description =$request->description; // optional
			$owner->save();
			// foreach($o as $o){
			// 	$o->delete();
			// }
			$roles = $request->roles;
			if(!empty($roles)){
        		$o = PermissionRole::where('permission_id','=',$id)->get();
				foreach($o as $o){
					$o->delete();
				}
				foreach($roles as $p){
					$ownerperm = new PermissionRole;
					$ownerperm->role_id=$p;
					$ownerperm->permission_id=$owner->id;
					$ownerperm->save();
				}
			}

			$audit = new \App\Http\Controllers\Admin\AuditController;
        	$audit->add($request,5,"AdminController",null,null,"Edit permission ".$id);
        } catch (ValidationException $e) {
            return back()->withErrors($e->getErrors())->withInput();
        }
        return redirect(route('admins.listpermissions'))->withSuccess(trans('admins.updatepermissions'));
    }

    public function destroypermissions(Request $request, $id){
        $owner = Permission::findOrFail($id);
        $owner->delete($id);
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,6,"AdminController",null,null,"Delete permission ".$id);
        return Response::json(['status' => 'ok']);
        // return redirect(route('admins.listpermissions'))->withSuccess(trans('admins.updatepermissions'));
    }
}
