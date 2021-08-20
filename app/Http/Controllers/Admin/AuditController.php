<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\LogModel\LogAudit;
use App\MasterModel\MasterAuditType;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request, $type, $model, $data_old, $data_new, $description)
    {
        $audit = new LogAudit;
        $audit->audit_type_id = $type;
        $audit->created_by_user_id = Auth::id();
        $audit->ip_address = $request->ip();
        $audit->description = $description;
        $audit->model = $model;
        $audit->data_old = $data_old;
        $audit->data_new = $data_new;
        $audit->url = $request->fullUrl();
        $audit->save();
    }

    /*
    use App\Http\Controllers\Admin\AuditController;

    $audit = new AuditController;
    $audit->add($request,1,"LoginController",null,null,'User logged in');
    */

    public function index(Request $request)
    {

        $types = MasterAuditType::all();

        if ($request->ajax()) {

            $audit_trail = LogAudit::with('createdBy')
                ->orderBy('created_at', 'desc');

            if ($request->has('date') || $request->has('type')) {
                if ($request->has('date') && !empty($request->date)) {
                    $audit_trail->whereDate('created_at', Carbon::createFromFormat('d/m/Y', $request->date)->toDateString());
                }

                if ($request->has('type') && !empty($request->type)) {
                    $audit_trail->where('audit_type_id', $request->type);
                }
            }

            $datatables = Datatables::of($audit_trail);

            return $datatables
                ->editColumn('created_by', function ($audit_trail) {
                    return '<a value="' . route('audit-trail-view', $audit_trail->log_audit_id) . '" data-toggle="modal" class="btn blue btnModalPeranan btn-sm" ><i class="fa fa-search"></i> ' . ($audit_trail->createdBy ? $audit_trail->createdBy->name : '') . ' </a>';
                })
                ->editColumn('created_at', function ($audit_trail) {
                    return date('d/m/Y', strtotime($audit_trail->created_at));
                })
                ->editColumn('model', function ($audit_trail) {
                    if ($audit_trail->model) {
                        return $audit_trail->model;
                    } else {
                        "-";
                    }
                })
                ->editColumn('url', function ($audit_trail) {
                    if ($audit_trail->url) {
                        return $audit_trail->url;
                    } else {
                        "-";
                    }
                })
                ->editColumn('ip_address', function ($audit_trail) {
                    return $audit_trail->ip_address;
                })
                ->editColumn('audit_type_id', function ($audit_trail) {
                    $locale = App::getLocale();
                    $type_lang = 'type_' . $locale;
                    return $audit_trail->type->$type_lang;
                })
                ->make(true);
        }
        return view("admin.audit_trail.list", compact('audit_trail', 'types'));
    }

    public function view($id)
    {
        if ($id) {
            $audit_trail = LogAudit::find($id);

            return view('admin.audit_trail.viewModal', compact('audit_trail'));
        }
    }
}
