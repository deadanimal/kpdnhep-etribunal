<?php

namespace App\Http\Controllers\Search;

use App;
use App\CaseModel\ClaimCase;
use App\Http\Controllers\Controller;
use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class Tab4Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        LogAuditRepository::store($request, 7, "SearchController", json_encode($request->input()), null, "Form 1 search");

        if ($request->ajax()) {
            if ($request->has('branch_code') && $request->has('case_no') && $request->has('case_no_2')) {
                $f1_no = "B1-" . $request->branch_code . "-" . $request->case_no . "-" . $request->case_no_2;
            } else {
                $f1_no = "";
            }

            $form1_check = ClaimCase::with(['branch'])
                ->where("form1_no", "LIKE", "%{$f1_no}%")
                ->whereHas('form1', function ($form1) {
                    return $form1->where('form_status_id', '>=', 13);
                });

            if ($request->branch_id != 0) {
                $form1_check->where("branch_id", "LIKE", $request->branch_id);
            }

            $datatables = Datatables::of($form1_check);

            return $datatables
                ->editColumn('form1_no', function ($form1_check) {
                    if ($form1_check->case) {
                        return "<a class='' href='" . route('form1-view', ['id' => $form1_check->case->claim_case_id]) . "'> " . $form1_check->form1_no . "</a>";
                    } else {
                        return $form1_check->form1_no;
                    }
                })
                ->editColumn('name', function ($form1_check) {
                    if ($form1_check->claimant) {
                        return $form1_check->claimant->name;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('username', function ($form1_check) {
                    if ($form1_check->claimant) {
                        $info = '<i class="fa fa-user"></i> ' . $form1_check->claimant->username ?: '-';
                        $info .= '<br><i class="fa fa-phone"></i> ' . ($form1_check->claimant->phone_office != '' ? $form1_check->claimant->phone_office : '-');
                        return $info .= '<br><i class="fa fa-envelope"></i> ' . $form1_check->claimant->email ?: '-';
                    } else {
                        return "-";
                    }
                })
                ->editColumn('status', function ($form1_check) {
                    $var = 'form_status_desc_'.App::getLocale();
                    return $form1_check->form1->status->$var;
                })
                ->rawColumns(['username'])
                ->make(true);

        }

        return view('search.tab4-result');
    }
}
