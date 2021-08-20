<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\MasterModel\MasterDirectoryHQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;

class DirectoryHQController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    protected function rules_insert()
    {

        $rules = [
            'directory_hq_division' => 'required',
            'directory_hq_name' => 'required|string',
            'directory_hq_designation' => 'required',
            'directory_hq_ext' => 'required|integer',
            'directory_hq_email' => 'required|string',
            'directory_hq_sort' => 'required|integer'
        ];
        return $rules;
    }

    protected function rules_update()
    {

        $rules = [
            'directory_hq_division' => 'required',
            'directory_hq_name' => 'required|string',
            'directory_hq_designation' => 'required',
            'directory_hq_ext' => 'required|integer',
            'directory_hq_email' => 'required|string',
            'directory_hq_sort' => 'required|integer'
        ];
        return $rules;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $directoryHQ = MasterDirectoryHQ::orderBy('created_at', 'desc')->get();

            $datatables = Datatables::of($directoryHQ);

            return $datatables
                ->editColumn('directory_hq_id', function ($directoryHQ) {
                    return $directoryHQ->directory_hq_id;
                })->editColumn('directory_hq_name', function ($directoryHQ) {
                    return $directoryHQ->directory_hq_name;
                })->editColumn('directory_hq_designation', function ($directoryHQ) {
                    return $directoryHQ->directory_hq_designation;
                })->editColumn('directory_hq_ext', function ($directoryHQ) {
                    return $directoryHQ->directory_hq_ext;
                })->editColumn('directory_hq_email', function ($directoryHQ) {
                    return $directoryHQ->directory_hq_email;
                })->editColumn('action', function ($directoryHQ) {
                    $button = "";

                    if ($directoryHQ->is_active == 1) {
                        $button .= '<a value="' . route('master.directory.hq.view', $directoryHQ->directory_hq_id) . '" rel="tooltip" data-original-title="' . __('button.view') . '" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                        $button .= actionButton('green-meadow', __('button.edit'), route('master.directory.hq.edit', ['id' => $directoryHQ->directory_hq_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="' . __('button.deactivate') . '" onclick="deleteDirectoryHQ(' . $directoryHQ->directory_hq_id . ')"><i class="fa fa-times"></i></a>';
                    } else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="' . __('button.activate') . '" onclick="activateDirectoryHQ(' . $directoryHQ->directory_hq_id . ')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "DirectoryHQController", null, null, "Datatables load master directory hq");

        return view("admin.master.directory.hq.list", compact('directoryHQ'));
    }

    public function create()
    {

        $directoryHQ = new MasterDirectoryHQ;
        $directoryHqDivision = MasterDirectoryHQ::select('directory_hq_division')->get();

        return view("admin.master.directory.hq.create", compact('directoryHQ', 'directoryHqDivision'));
    }

    public function edit($id)
    {
        if ($id) {

            $directoryHQ = MasterDirectoryHQ::find($id);
            return view("admin.master.directory.hq.create", compact('directoryHQ'));
        }
    }

    public function view(Request $request, $id)
    {
        if ($id) {
            $directoryHQ = MasterDirectoryHQ::find($id);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 3, "DirectoryHQController", null, null, "View master directory hq " . $id);
            return view('admin.master.directory.hq.viewModal', compact('directoryHQ'), ['id' => $id])->render();
        }
    }

    public function delete(Request $request, $id)
    {
        if ($id) {
            $directoryHQ = MasterDirectoryHQ::find($id);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 6, "DirectoryHQController", null, null, "Delete master directory hq " . $id);
            $directoryHQ->is_active = 0;
            $directoryHQ->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id)
    {
        if ($id) {

            $directoryHQ = MasterDirectoryHQ::find($id);
            $directoryHQ->is_active = 1;

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "DirectoryHQController", null, null, "Edit master directory hq " . $id);
            $directoryHQ->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_insert());

        if ($request->directory_hq_id == NULL) {

            if ($validator->passes()) {

                $directoryHQ_data = $request->only(
                    'directory_hq_division',
                    'directory_hq_name',
                    'directory_hq_designation',
                    'directory_hq_ext',
                    'directory_hq_email',
                    'directory_hq_sort'
                );

                $directoryHQ = MasterDirectoryHQ::create($directoryHQ_data);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 4, "DirectoryHQController", json_encode($request->input()), null, "Master Directory HQ " . $directoryHQ->directory_hq_id . " - Create directory hq");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_update());

        if ($request->directory_hq_id != NULL) {

            if ($validator->passes()) {

                $directoryHQ = MasterDirectoryHQ::find($request->directory_hq_id)->update([
                    'directory_hq_division' => $request->directory_hq_division,
                    'directory_hq_name' => $request->directory_hq_name,
                    'directory_hq_designation' => $request->directory_hq_designation,
                    'directory_hq_ext' => $request->directory_hq_ext,
                    'directory_hq_email' => $request->directory_hq_email,
                    'directory_hq_sort' => $request->directory_hq_sort
                ]);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 5, "DirectoryHQController", null, null, "Edit master directory hq " . $request->directory_hq_id);
                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }
}
