<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingVenue;
use App\MasterModel\MasterHearingRoom;
use App\RoleUser;
use App\ViewModel\ViewReport1Cases;
use App\ViewModel\ViewReport1Postponed;
use App\ViewModel\ViewReport1Waived;
use Auth;
use DB;
use App;
use PDF;

class Report1Controller extends Controller
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

    public function view(Request $request)
    {
        $venues = MasterHearingRoom::where('is_active', 1)->orderBy('hearing_room_id', 'asc')->get();
        $rooms = MasterHearingVenue::where('is_active', 1)->orderBy('hearing_venue_id', 'asc')->get();
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'asc')->get();
        $presidents = RoleUser::where('role_id', 4)->get()->filter(function ($query) {
            return $query->user->user_status_id == 1;
        });
        $hearing_date = $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d');

        $cases = ViewReport1Cases::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'view_report1_cases.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->where('hearing_date', $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d'))
            ->where('president_user_id', 'LIKE', $request->president_user_id);

        $waived = ViewReport1Waived::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'view_report1_waived.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->where('hearing_date', $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d'))
            ->where('president_user_id', 'LIKE', $request->president_user_id);

        $postponed = ViewReport1Postponed::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'view_report1_postponed.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->where('hearing_date', $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d'))
            ->where('president_user_id', 'LIKE', $request->president_user_id);

        if ($request->branch_id) {
            $cases = $cases->where('branch_id', 'LIKE', $request->branch_id);
            $waived = $waived->where('branch_id', 'LIKE', $request->branch_id);
            $postponed = $postponed->where('branch_id', 'LIKE', $request->branch_id);
        }

        if ($request->hearing_venue_id) {
            $cases = $cases->where('hearing_venue_id', 'LIKE', $request->hearing_venue_id);
            $waived = $waived->where('hearing_venue_id', 'LIKE', $request->hearing_venue_id);
            $postponed = $postponed->where('hearing_venue_id', 'LIKE', $request->hearing_venue_id);
        }

        if ($request->hearing_room_id) {
            $cases = $cases->where('hearing_room_id', 'LIKE', $request->hearing_room_id);
            $waived = $waived->where('hearing_room_id', 'LIKE', $request->hearing_room_id);
            $postponed = $postponed->where('hearing_room_id', 'LIKE', $request->hearing_room_id);
        }

        if ($request->has('start_date') && !empty($request->start_date) && $request->has('end_date') && !empty($request->end_date)) {
            $cases = $cases->where('start_time', Carbon::createFromFormat('g:i:s A', $request->start_time)->toTimeString())
                ->where('end_time', Carbon::createFromFormat('g:i:s A', $request->end_time)->toTimeString());

            $waived = $waived->where('start_time', Carbon::createFromFormat('g:i:s A', $request->start_time)->toTimeString())
                ->where('end_time', Carbon::createFromFormat('g:i:s A', $request->end_time)->toTimeString());

            $postponed = $postponed->where('start_time', Carbon::createFromFormat('g:i:s A', $request->start_time)->toTimeString())
                ->where('end_time', Carbon::createFromFormat('g:i:s A', $request->end_time)->toTimeString());
        }

        $cases = $cases->get();
        $waived = $waived->get();
        $postponed = $postponed->get();

        return view('report/report1/view', compact('rooms', 'venues', 'presidents', 'branches', 'cases', 'waived', 'postponed', 'president'));
    }

    public function export(Request $request)
    {
        $cases = ViewReport1Cases::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'view_report1_cases.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->where('hearing_date', $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d'))
            ->where('branch_id', 'LIKE', $request->branch_id)
            ->where('hearing_venue_id', 'LIKE', $request->hearing_venue_id)
            ->where('hearing_room_id', 'LIKE', $request->hearing_room_id)
            ->where('president_user_id', 'LIKE', $request->president_user_id);

        $waived = ViewReport1Waived::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'view_report1_waived.claim_case_id')->orderBy('case_year', 'desc')->orderBy('case_sequence', 'desc')->where('hearing_date', $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d'))
            ->where('branch_id', 'LIKE', $request->branch_id)
            ->where('hearing_venue_id', 'LIKE', $request->hearing_venue_id)
            ->where('hearing_room_id', 'LIKE', $request->hearing_room_id)
            ->where('president_user_id', 'LIKE', $request->president_user_id);

        $postponed = ViewReport1Postponed::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'view_report1_postponed.claim_case_id')->orderBy('case_year', 'desc')->orderBy('case_sequence', 'desc')->where('hearing_date', $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateString() : date('Y-m-d'))
            ->where('branch_id', 'LIKE', $request->branch_id)
            ->where('hearing_venue_id', 'LIKE', $request->hearing_venue_id)
            ->where('hearing_room_id', 'LIKE', $request->hearing_room_id)
            ->where('president_user_id', 'LIKE', $request->president_user_id);


        if ($request->has('start_date') && !empty($request->start_date) && $request->has('end_date') && !empty($request->end_date)) {
            $cases = $cases->where('start_time', Carbon::createFromFormat('g:i:s A', $request->start_time)->toTimeString())
                ->where('end_time', Carbon::createFromFormat('g:i:s A', $request->end_time)->toTimeString());

            $waived = $waived->where('start_time', Carbon::createFromFormat('g:i:s A', $request->start_time)->toTimeString())
                ->where('end_time', Carbon::createFromFormat('g:i:s A', $request->end_time)->toTimeString());

            $postponed = $postponed->where('start_time', Carbon::createFromFormat('g:i:s A', $request->start_time)->toTimeString())
                ->where('end_time', Carbon::createFromFormat('g:i:s A', $request->end_time)->toTimeString());
        }

        if ($request->format == 'pdf') {
            $this->data['cases'] = $cases->get();
            $this->data['waived'] = $waived->get();
            $this->data['postponed'] = $postponed->get();
            $this->data['request'] = $request;
            $this->data['hearing_date'] = $request->hearing_date;

            //dd($this->data['request']);
            $pdf = PDF::loadView('report/report1/printreport1', $this->data);

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan1.pdf');
        }

    }


}
