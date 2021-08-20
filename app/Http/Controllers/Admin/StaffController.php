<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\LogAuditRepository;
use App\Repositories\MasterBranchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserTTPM;
use App\UserTTPMPresident;
use App\Permission;
use App\Role;
use App\RoleUser;
use App\UserPublicIndividual;
use App\PermissionUser;
use App\MasterModel\MasterUserType;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterLanguage;
use App\MasterModel\MasterUserStatus;
use App\MasterModel\MasterSalutation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App;
use Auth;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $status = MasterUserStatus::where('user_status_id', '!=', 6)->get();
        $branches = MasterBranchRepository::getListByStateName();

        $designations = Role::where('type', 2)->get();

        if ($request->ajax()) {

            $ttpmuser = User::with(['ttpm_data.branch', 'roleuser.role', 'user_status'])
                ->where('user_type_id', 2)
                ->orderBy('user_status_id', 'asc');

            if (Auth::user()->hasRole('ks')) {
                $ttpmuser->whereHas('ttpm_data', function ($ttpm_data) {
                    return $ttpm_data->where('user_status_id', Auth::user()->ttpm_data->branch_id);
                });
            }

            // Check for filteration
            if ($request->has('status') && !empty($request->status)) {
                $ttpmuser->where('user_status_id', $request->status);
            }

            if ($request->has('branch') && !empty($request->branch)) {
                $ttpmuser->whereHas('ttpm_data', function ($ttpm_data) use ($request) {
                    return $ttpm_data->where('branch_id', $request->branch);
                });
            }

            if ($request->has('designation') && !empty($request->designation)) {
                $ttpmuser->whereHas('roleuser', function ($roleuser) use ($request) {
                    return $roleuser->where('role_id', $request->designation);
                });
            }

            $datatables = Datatables::of($ttpmuser);

            return $datatables
                ->addIndexColumn()
                ->editColumn('name', function ($ttpmuser) {
                    return $ttpmuser->name;
                })
                ->editColumn('email', function ($ttpmuser) {
                    return $ttpmuser->email;
                })
                ->editColumn('username', function ($ttpmuser) {
                    return $ttpmuser->username;
                })
                ->editColumn('created_at', function ($ttpmuser) {
                    return Carbon::parse($ttpmuser->created_at)->format('d/m/Y');
                })
                ->editColumn('branch', function ($ttpmuser) {
                    return $ttpmuser->ttpm_data->branch->branch_name;
                })
                ->editColumn('user_status', function ($ttpmuser) {
                    $locale = App::getLocale();
                    $status_lang = "status_" . $locale;
                    return $ttpmuser->user_status->$status_lang;
                })
                ->editColumn('designation', function ($ttpmuser) {
                    $display_name = "display_name_" . App::getLocale();
                    return $ttpmuser->roleuser->count() > 0 ? $ttpmuser->roleuser->first()->role->$display_name : '';
                })
                ->editColumn('action', function ($ttpmuser) {
                    $button = '';

                    if ($ttpmuser->user_status_id != 2) {
                        if (Auth::user()->hasRole('admin')) {
                            $button .= '<a class="btn btn-xs red" rel="tooltip" 
                            data-original-title="' . __('button.impersonate') . '" 
                            href="' . route('admin.users.impersonate', $ttpmuser->user_id) . '">
                            <i class="fa fa-play"></i>
                            </a>';
                        }

                        $button .= '<a value="' . route('ttpm.view', $ttpmuser->user_id) . '" rel="tooltip" data-original-title="' . __('button.view') . '" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';
                        $button .= actionButton('green-meadow', __('button.edit'), route('ttpm.edit', ['id' => $ttpmuser->user_id]), false, 'fa-edit', false);
                        $button .= '<a class="btn btn-xs purple" rel="tooltip" data-original-title="' . __('button.change_pass') . '" onclick="changePasswordUser(' . $ttpmuser->user_id . ')"><i class="fa fa-key"></i></a>';
                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="' . __('button.deactivate') . '" onclick="deleteUser(' . $ttpmuser->user_id . ')"><i class="fa fa-times"></i></a>';
                    } else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="' . __('button.activate') . '" onclick="activateUser(' . $ttpmuser->user_id . ')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "StaffController", null, null, "Datatables load TTPM users");

        return view("admin.user.ttpm.list", compact('ttpmuser', 'status', 'branches', 'designations'));
    }

    public function create()
    {
        $master_user_type = MasterUserType::all();
        $master_user_status = MasterUserStatus::where('user_status_id', '!=', 6)->get();
        //$master_branch = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();
        if (Auth::user()->hasRole('ks'))
            $master_branch = MasterBranch::where('branch_id', Auth::user()->ttpm_data->branch_id)->get();
        else
            $master_branch = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();

        $master_salutation = MasterSalutation::where('is_active', 1)->get();
        // $master_designation = MasterDesignation::all();
        $master_language = MasterLanguage::all();
        $permission = Permission::orderby('name')->get();

        if (Auth::user()->hasRole('admin'))
            $roles = Role::where('type', '=', 2)->get();
        else
            $roles = Role::where('id', '=', 18)->get();

        $role_user = 0;

        $findUser = new User;
        $findTTPMUser = new UserTTPM;
        $findPresidentUser = new UserTTPMPresident;
        return view("admin.user.ttpm.create", compact('findUser', 'findTTPMUser', 'master_user_type', 'master_branch', 'master_language', 'permission', 'roles', 'role_user', 'findPresidentUser', 'master_salutation', 'master_user_status'));
    }

    protected function rules_insert($request)
    {

        $rules = [
            'name' => 'required',
            'username' => 'required | unique:users',
            'password' => 'required',
            'repeat_password' => 'required|same:password',
            'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            'phone_office' => 'required|string|regex:/^.{9,15}$/',
            'identification_no' => 'required', 'min:12', 'max:12', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/',
            'branch_id' => 'required',
            // 'designation_type_id' => 'required',
            'designation_id' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'signature' => 'mimes:jpeg,jpg,png,JPG,JPEG, | max:2000',
            'user_status_id' => 'required|integer'
        ];

        if ($request->designation_id == 4) {
            $rules['president_code'] = 'required';
            $rules['salutation_id'] = 'required|integer';
            $rules['is_appointed'] = 'required|integer';

            if ($request->is_appointed == 1) {
                $rules['year_start'] = 'required|numeric';
                $rules['year_end'] = 'required|numeric';
            }
        }

        return $rules;
    }


    public function insert(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_insert($request));

        if ($request->user_id == NULL) {

            if ($validator->passes()) {

                $user_input = $request->only(
                    'name',
                    'username',
                    'password',
                    'language_id',
                    'phone_office',
                    'phone_fax',
                    'email',
                    'user_status_id'
                );

                $user_input['username'] = $user_input['username'];
                $user_input['password'] = bcrypt(md5($user_input['password']));
                $user_input['user_type_id'] = 2;
                $user_input['user_status_id'] = 1;

                $user = User::create($user_input);

                if ($user) {
                    $user_ttpm_input = $request->only(
                        'phone_mobile',
                        'identification_no',
                        'branch_id',
                        //'designation_id',
                        'phone_office',
                        'phone_fax',
                        'email'
                    );

                    if ($request->hasFile('signature_blob')) {
                        if ($request->file('signature_blob')->isValid()) {
                            $user_ttpm_input['signature_blob'] = file_get_contents($request->signature_blob);
                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request, 4, "StaffController", json_encode($request->input()), null, "TTPM Staff " . $request->username . " - Upload signature");
                        }
                    }

                    $getUser_id = User::where('username', '=', $user_input['username'])->first();

                    $getUser_id->attachRole($request->designation_id);

                    $user_ttpm_input['user_id'] = $getUser_id->user_id;
                    $userTPPM = UserTTPM::create($user_ttpm_input);


                    ///////////////////////////////////////
                    // if($request->designation_id == 8)
                    //     $newrole = $request->branch_id + 9;
                    // else 
                    //     $newrole = $request->designation_id;

                    // $role_user = RoleUser::insert([
                    //     'user_id' => $getUser_id->user_id,
                    //     'role_id' => $newrole
                    // ]);

                    if ($request->designation_id == 4) {
                        $user_ttpm_prez_input = $request->only(
                            'president_code',
                            'is_appointed',
                            'year_start',
                            'year_end',
                            'salutation_id'
                        );
                        $user_ttpm_prez_input['user_id'] = $getUser_id->user_id;
                        $userTPPMPrez = UserTTPMPresident::create($user_ttpm_prez_input);
                    }
                }
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 4, "StaffController", json_encode($request->input()), null, "TTPM Staff " . $request->username . " - Create staff account");
                return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function edit($id)
    {

        $master_user_type = MasterUserType::all();
        $master_user_status = MasterUserStatus::where('user_status_id', '!=', 6)->get();
        //$master_branch = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();
        if (Auth::user()->hasRole('ks'))
            $master_branch = MasterBranch::where('branch_id', Auth::user()->ttpm_data->branch_id)->get();
        else
            $master_branch = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();

        $master_salutation = MasterSalutation::where('is_active', 1)->get();
        // $master_designation = MasterDesignation::all();
        $master_language = MasterLanguage::all();
        $permission = Permission::all();

        if (Auth::user()->hasRole('admin'))
            $roles = Role::where('type', '=', 2)->get();
        else
            $roles = Role::where('id', '=', 18)->get();

        $findUser = User::where('user_id', '=', $id)->first();
        $findTTPMUser = UserTTPM::where('user_id', '=', $id)->first();
        $role_user = RoleUser::where('user_id', $id)->first()->role_id;

        //dd($findUser->roleuser);

        $findPresidentUser = UserTTPMPresident::where('user_id', '=', $id)->first();

        return view("admin.user.ttpm.create", compact('findUser', 'findTTPMUser', 'master_user_type', 'master_branch', 'master_language', 'permission', 'roles', 'role_user', 'findPresidentUser', 'master_salutation', 'master_user_status'));
    }

    protected function rules_update($request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required',
            'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            'identification_no' => 'required', 'min:12', 'max:12', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/',
            'branch_id' => 'required',
            // 'designation_type_id' => 'required',
            'designation_id' => 'required',
            'phone_office' => 'required|string|regex:/^.{9,15}$/',
            'email' => 'required|string|email|max:255',
            'signature' => 'mimes:jpeg,jpg,png,JPG,JPEG, | max:2000',
            'user_status_id' => 'required|integer'
        ];

        if ($request->designation_id == 4) {
            $rules['president_code'] = 'required';
            $rules['salutation_id'] = 'required|integer';
            $rules['is_appointed'] = 'required|integer';

            if ($request->is_appointed == 1) {
                $rules['year_start'] = 'required|numeric';
                $rules['year_end'] = 'required|numeric';
            }
        }

        return $rules;
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_update($request));

        if ($request->user_id != NULL) {

            if ($validator->passes()) {

                ////////////////////////////////////
                $user = User::find($request->user_id)->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'language_id' => $request->language_id,
                    'phone_office' => $request->phone_office,
                    'phone_fax' => $request->phone_fax,
                    'email' => $request->email,
                    'user_status_id' => $request->user_status_id
                ]);

                $o = RoleUser::where('user_id', '=', $request->user_id)->delete();
                $sel_user = User::findOrFail($request->user_id);

                $sel_user->attachRole($request->designation_id);

                $ttpm = UserTTPM::where('user_id', $request->user_id)->update([
                    'phone_mobile' => $request->phone_mobile,
                    'identification_no' => $request->identification_no,
                    //'designation_id' => $request->designation_id,
                    'branch_id' => $request->branch_id,
                ]);

                if ($request->hasFile('signature_blob')) {
                    if ($request->file('signature_blob')->isValid()) {
                        //die(base64_encode($request->signature_blob));

                        $ttpm = UserTTPM::where('user_id', $request->user_id)->update([
                            'signature_blob' => file_get_contents($request->signature_blob),
                        ]);
                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request, 4, "StaffController", json_encode($request->input()), null, "TTPM Staff " . $request->username . " - Upload signature");
                    }
                }

                ///////////////////////////////////////
                // if($request->designation_id == 8)
                //     $newrole = $request->branch_id + 9;
                // else 
                //     $newrole = $request->designation_id;

                // $role_user = RoleUser::where('user_id',$request->user_id)->update(
                //     ['role_id' => $newrole]
                // );

                $userTPPMPrez = UserTTPMPresident::find($request->user_id);

                if ($userTPPMPrez) {
                    if ($request->designation_id == 4) {
                        $userTPPMPrez->update([
                            'president_code' => $request->president_code,
                            'is_appointed' => $request->is_appointed,
                            'year_start' => $request->year_start,
                            'year_end' => $request->year_end,
                            'salutation_id' => $request->salutation_id
                        ]);
                    } else {
                        $userTPPMPrez->delete();
                    }
                } else {
                    if ($request->designation_id == 4) {
                        $user_ttpm_prez_input = $request->only(
                            'president_code',
                            'is_appointed',
                            'year_start',
                            'year_end',
                            'salutation_id'
                        );
                        $user_ttpm_prez_input['user_id'] = $request->user_id;
                        $userTPPMPrez = UserTTPMPresident::create($user_ttpm_prez_input);
                    }
                }

                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 5, "StaffController", null, null, "Update TTPM Staff " . $request->username);
                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);

            } else {

                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

        }

    }

    public function view(Request $request, $id)
    {
        if ($id) {
            $ttpmuser = User::where('user_id', '=', $id)->first();
            $role_user = RoleUser::where('user_id', $ttpmuser->user_id)->first()->role_id;
            $display_name = "display_name_" . App::getLocale();
            $designation = Role::find($role_user)->$display_name;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 3, "StaffController", null, null, "View TTPM Staff " . $request->username);
            return view('admin.user.ttpm.view_modal', compact('ttpmuser', 'designation'), ['id' => $id])->render();
        }
    }

    public function delete(Request $request, $id)
    {
        if ($id) {
            User::find($id)->update(['user_status_id' => 2]);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 6, "StaffController", null, null, "Status TTPM user to inactive " . $id);
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id)
    {
        if ($id) {
            User::find($id)->update(['user_status_id' => 1]);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "StaffController", null, null, "Status TTPM user to active " . $id);
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }
}