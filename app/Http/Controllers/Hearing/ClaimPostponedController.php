<?php

namespace App\Http\Controllers\Hearing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\CaseModel\Form4;
use App;
use Auth;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingRoom;
use Carbon\Carbon;

class ClaimPostponedController extends Controller
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

    public function index(Request $request)
    {

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('hearing.claim_postponed', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq'))
            $branches = MasterBranch::where('is_active', 1)->where('branch_id', Auth::user()->ttpm_data->branch_id)->orderBy('branch_id', 'desc')->get();
        else
            $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();

        if ($request->ajax()) {

            $form4 = Form4::with(['case.form1', 'hearing_position_reason', 'hearing'])->where('hearing_status_id', 2)->orderBy('created_at', 'desc');

            if ($request->has('branch')) {

                if ($request->has('branch') && !empty($request->branch))
                    $form4->whereHas('case', function ($case) use ($request) {
                        return $case->where('branch_id', $request->branch);
                    });
                // $form4 = $form4->filter(function ($value) use ($request) {
                // 	return $value->case->branch_id == $request->branch;
                // });
            }

            $datatables = Datatables::of($form4);
            return $datatables
                ->editColumn('case_no', function ($form4) {
                    //Clickable Button with value
                    $button = '<a href="' . route('claimcase-view', $form4->case->claim_case_id) . '" class="" >' . $form4->case->case_no . '</a>';

                    return $button;
                    //Click With button value END
                })->editColumn('filing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->case->form1->filing_date));
                })->editColumn('hearing_position_reason', function ($form4) {
                    if (!$form4->hearing_position_reason)
                        return "-";

                    $locale = App::getLocale();
                    $hearing_position_reason_lang = "hearing_position_reason_" . $locale;
                    return $form4->hearing_position_reason->$hearing_position_reason_lang;

                })->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->hearing->hearing_date));
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "ClaimPostponedController", null, null, "Datatables load claim that has been adjourned");

        return view("hearing.claim_postponed.list", compact('form4', 'branches'));
    }

    public function view($form4_id)
    {

        if ($form4_id) {
            $form4 = Form4::find($form4_id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 3, "ClaimPostponedController", null, null, "View claimcase details " . $form4->case->case_no);

            return view("hearing.claim_postponed.view", compact('form4'));
        }
    }

}