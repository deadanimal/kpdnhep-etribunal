<?php

namespace App\Http\Controllers\Listing;

use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\ViewModel\ViewListHearing;
use App;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingRoom;
use App\CaseModel\Form4;
use Carbon\Carbon;
use Auth;

class HearingListController extends Controller
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
            return redirect()->route('listing.hearing', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'asc')->get(); //GET VALUE FROM DB

        if ($request->ajax()) {

            $hearing = ViewListHearing::with(['f3_status', 'f2_status', 'president'])
                ->orderBy('filing_date', 'desc');

            if ($request->has('hearing_date') || $request->has('branch') || $request->has('hearing_place') || $request->has('hearing_room')) {

                if ($request->has('hearing_date') && !empty($request->hearing_date))
                    $hearing->whereDate('hearing_date', Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString());
                // $hearing = $hearing->filter(function ($value) use ($request) {
                // 	return $value->hearing_date == Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString();
                // }); //CARBON IS SPECIAL FOR DATE AND TIME

                if ($request->has('branch') && !empty($request->branch))
                    $hearing->where('branch_id', $request->branch);
                // $hearing = $hearing->filter(function ($value) use ($request) {
                // 	return $value->branch_id == $request->branch;
                // });

                if ($request->has('hearingplace') && !empty($request->hearingplace))
                    $hearing->where('hearing_venue_id', $request->hearingplace);
                // $hearing = $hearing->filter(function ($value) use ($request) {
                // 	return $value->hearing_venue_id == $request->hearing_place;
                // });

                if ($request->has('hearingRoom') && !empty($request->hearingRoom))
                    $hearing->where('hearing_room_id', $request->hearingRoom);
                // $hearing = $hearing->filter(function ($value) use ($request) {
                // 	return $value->hearing_room_id == $request->hearing_room;
                // });
            }

            $datatables = Datatables::of($hearing);
            return $datatables
                ->editColumn('case_no', function ($hearing) {
                    return $hearing->case_no;
                })
                ->editColumn('filing_date_form1_raw', function ($hearing) {
                    return $hearing->filing_date;
                })
                ->editColumn('filing_date', function ($hearing) {
                    return date('d/m/Y', strtotime($hearing->filing_date));
                })
                ->editColumn('hearing_date', function ($hearing) {
                    return date('d/m/Y', strtotime($hearing->hearing_date));
                })
                ->editColumn('matured_date', function ($hearing) {
                    return date('d/m/Y', strtotime($hearing->matured_date));
                })
                ->editColumn('form2_status', function ($hearing) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    if ($hearing->f2_status_id)
                        return $hearing->f2_status->$status_lang;
                    else
                        return __('new.not_filed');
                })
                ->editColumn('form3_status', function ($hearing) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;

                    if ($hearing->f3_status_id)
                        return $hearing->f3_status->$status_lang;
                    else
                        return __('new.not_filed');
                })
                ->editColumn('president_name', function ($hearing) {
                    return $hearing->president ? $hearing->president->name : '-';
                })
                ->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "HearingListController", null, null, "Datatables load hearing");
        return view("list.hearing.list", compact('hearing', 'hearing_date', 'branch', 'hearingplace', 'hearingRoom', 'branches', 'hearinges'));
    }

    public function listAttendance(Request $request)
    {

        return view("list.hearing.hearing_attendance");
    }


    public function list_hearing_date(Request $request)
    {
        if ($request->ajax()) {

            $form4 = Form4::select(['form4.form4_id', 'form4.hearing_id', 'form1.filing_date', 'claim_case.claim_case_id'])
                ->with('hearing')
                ->join('claim_case', 'claim_case.claim_case_id', '=', 'form4.claim_case_id')
                ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
                ->whereNull('hearing_status_id')
                ->whereHas('hearing', function ($q) use ($request) {
                    $q->where('hearing.hearing_date', $request->hearing_date)
                        ->where('hearing.hearing_time', $request->hearing_time);

                    if (!auth()->user()->hasRole('presiden')) {
                        $q->where('hearing.branch_id', Auth::user()->ttpm_data->branch_id);
                    }
                });

            $datatables = Datatables::of($form4);
            return $datatables
                ->addIndexColumn()
                ->editColumn('case_no', function ($form4) {
                    return "<a class='' href='" . route('claimcase-view', [$form4->case->claim_case_id]) . "'> " . $form4->case->case_no . "</a>";
                })
                ->editColumn('filing_date_form1_raw', function ($form4) {
                    return $form4->case->form1->filing_date;
                })
                ->editColumn('claimant_name', function ($form4) {
                    return $form4->case->claimant_address->name;
                })
                ->editColumn('filing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->case->form1->filing_date));
                })
                ->editColumn('president_name', function ($form4) {
                    if ($form4->hearing->president)
                        return $form4->hearing->president->name;
                    else return '-';
                })
                ->editColumn('classification', function ($form4) {
                    $locale = App::getLocale();
                    $classification_lang = "classification_" . $locale;
                    return $form4->case->form1->classification->$classification_lang;
                })
                ->editColumn('action', function ($form4) {
                    $button = '<div>';

                    $button .= '<div class="btn-group">
	                                <button class="btn btn-xs dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
	                                	<i class="fa fa-download"></i>
	                                	' . __('form1.download') . '
	                                </button>
	                                <ul class="dropdown-menu pull-left" role="menu" style="position: inherit;">
	                                    <li>
	                                        <a href="' . route('form1-export', ['claim_case_id' => $form4->claim_case_id, 'format' => 'pdf']) . '">
	                                            <i class="fa fa-file-pdf-o"></i> PDF
	                                        </a>
	                                    </li>
	                                    <li>
	                                        <a href="' . route('form1-export', ['claim_case_id' => $form4->claim_case_id, 'format' => 'docx']) . '">
	                                            <i class="fa fa-file-text-o"></i> DOCX
	                                        </a>
	                                    </li>
	                                </ul>
	                            </div>';

                    if ($form4->case->form1->form2_id) {
                        $button .= '<br><div class="btn-group">
		                                <button class="btn btn-xs grey-salsa dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
		                                	<i class="fa fa-download"></i>
		                                	' . __('form2.download') . ' (' . $form4->case->opponent_address->name . ')
		                                </button>
		                                <ul class="dropdown-menu pull-left" role="menu" style="position: inherit;">
		                                    <li>
		                                        <a href="' . route('form2-export', ['claim_case_id' => $form4->claim_case_opponent_id, 'format' => 'pdf']) . '">
		                                            <i class="fa fa-file-pdf-o"></i> PDF
		                                        </a>
		                                    </li>
		                                    <li>
		                                        <a href="' . route('form2-export', ['claim_case_id' => $form4->claim_case_opponent_id, 'format' => 'docx']) . '">
		                                            <i class="fa fa-file-text-o"></i> DOCX
		                                        </a>
		                                    </li>
		                                </ul>
		                            </div>';
                    }

                    return $button . '</div>';
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "HearingListController", null, null, "Datatables load today hearing schedule");

        return view("list.hearing.list_hearing_date");
    }

}