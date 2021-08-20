<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterOrganization;
use App\MasterModel\MasterState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

//DB
    protected function rules_insert()
    {

        $rules = [
            'organization' => 'required',
            'org_address' => 'required',
            'org_postcode' => 'required|min:5|max:5',
            'org_state_id' => 'required',
            'org_district_id' => 'required',
            'org_office_phone' => 'required|string|regex:/^.{9,15}$/'
        ];

        return $rules;
    }

    protected function rules_update()
    {

        $rules = [
            'organization' => 'required',
            'org_address' => 'required',
            'org_postcode' => 'required|min:5|max:5',
            'org_district_id' => 'required',
            'org_state_id' => 'required',
            'org_office_phone' => 'required|string|regex:/^.{9,15}$/'
        ];

        return $rules;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $organizations = MasterOrganization::orderBy('is_active', 'desc')->get();

            $datatables = Datatables::of($organizations);

            return $datatables
                ->editColumn('organization', function ($organization) {
                    return $organization->organization;
                })->editColumn('org_description', function ($organization) {
                    return $organization->org_description;
                })->editColumn('address', function ($organization) {
                    return $organization->org_address . "<br>" .
                        $organization->org_address2 . "<br>" .
                        $organization->org_address3 . "<br>" .
                        $organization->org_postcode . " " .
                        $organization->district->district;
                })->editColumn('org_office_phone', function ($organization) {
                    return $organization->org_office_phone;
                })->editColumn('created_at', function ($model) {
                    return date('d/m/Y', strtotime($model->created_at));
                })->editColumn('org_email', function ($organization) {
                    return $organization->org_email;
                })->editColumn('action', function ($organization) {
                    $button = "";

                    if ($organization->is_active) {
                        $button .= '<a value="' . route('master.organization.view', $organization->jurisdiction_organization_id) . '" rel="tooltip" data-original-title="' . __('button.view') . '" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.organization.edit', ['id' => $organization->jurisdiction_organization_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="' . __('button.deactivate') . '"  onclick="deleteOrganization(' . $organization->jurisdiction_organization_id . ')"><i class="fa fa-times"></i></a>';
                    } else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="' . __('button.activate') . '" onclick="activateOrganization(' . $organization->jurisdiction_organization_id . ')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "OrganizationController", null, null, "Datatables load master organization");
        return view("admin.master.organization.list", compact('organizations'));
    }

    public function create()
    {
        $organization = new MasterOrganization;
        $districts = MasterDistrict::all();
        $states = MasterState::all();

        return view("admin.master.organization.create", compact('organization', 'districts', 'states'));
    }

    public function edit($id)
    {
        if ($id) {
            $organization = MasterOrganization::find($id);
            $districts = MasterDistrict::all();
            $states = MasterState::all();

            return view("admin.master.organization.create", compact('organization', 'districts', 'states'));
        }
    }

    public function view(Request $request, $id)
    {
        if ($id) {
            $organization = MasterOrganization::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 3, "OrganizationController", null, null, "View master organization " . $id);
            return view('admin.master.organization.viewModal', compact('organization'), ['id' => $id])->render();
        }
    }

    public function delete(Request $request, $id)
    {
        if ($id) {
            $organization = MasterOrganization::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 6, "OrganizationController", null, null, "Inactive master organization " . $id);
            $organization->is_active = 0;
            $organization->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id)
    {
        if ($id) {
            $organization = MasterOrganization::find($id);
            $organization->is_active = 1;
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "OrganizationController", null, null, "Edit master organization " . $id);
            $organization->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_insert());

        if ($request->jurisdiction_organization_id == NULL) {

            if ($validator->passes()) {

                $organization = MasterOrganization::create($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 4, "OrganizationController", json_encode($request->input()), null, "Master Organization " . $organization->organization_id . " - Create organization");
                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_update());

        if ($request->jurisdiction_organization_id != NULL) {

            if ($validator->passes()) {

                $organization = MasterOrganization::find($request->jurisdiction_organization_id)->update($request->all());
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 5, "OrganizationController", null, null, "Edit master organization " . $request->jurisdiction_organization_id);
                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }
}
