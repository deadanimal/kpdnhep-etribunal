<?php

namespace App\Http\Controllers\ClaimCase;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form4;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterMonth;
use App\Repositories\LogAuditRepository;
use App\SupportModel\Attachment;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use Yajra\Datatables\Datatables;

class ClaimCaseController extends Controller
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

    /**
     * List all claim case.
     * This DT are using custom column html.
     * See views claimcase.list_row.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        if (!(Auth::user()->hasRole('admin') || Auth::user()->hasRole('user')) && !$request->has('branch')) {
            return redirect()->route('claimcase-list', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {
            $start_date = $request->has('start_date') && !empty($request->start_date)
                ? Carbon::createFromFormat('d/m/Y', $request->start_date)
                    ->startOfDay()
                    ->toDateTimeString()
                : Carbon::parse()->startOfYear()->toDateTimeString();
            $end_date = $request->has('end_date') && !empty($request->end_date)
                ? Carbon::createFromFormat('d/m/Y', $request->end_date)
                    ->endOfDay()
                    ->toDateTimeString()
                : Carbon::parse()->endOfYear()->toDateTimeString();
            $hearing_position_reason_lang = "hearing_position_reason_" . App::getLocale();
            $hearing_position_lang = "hearing_position_" . App::getLocale();
            $reason_lang = "stop_reason_" . App::getLocale();

            $case = ClaimCase::select([
                'claim_case.*',
                DB::raw('form1.filing_date form1_filing_date'),
                'form1.case_year',
                'form1.case_sequence',
            ])
                ->with('multiOpponents')
                ->join('form1', 'form1.form1_id', '=', 'claim_case.form1_id')
//                ->join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case.claim_case_id')
                ->orderBy('case_sequence')
                ->where('case_no', 'NOT LIKE', '%--%')
                ->whereYear('form1.filing_date', '>', '2007');

            $case = $case->whereHas('form1', function ($form1) use ($request, $start_date, $end_date) {
                $form1->where('form_status_id', 17)
                    ->whereBetween('filing_date', [$start_date, $end_date]);
            });

            if ($request->has('branch') && !empty($request->branch)) {
                $case = $case->where(function ($q) use ($request) {
                    $q->where('branch_id', $request->branch)
                        ->orWhere('transfer_branch_id', $request->branch);
                });
            }

            $case = $case->orderBy('form1.filing_date', 'desc')->get();

            $index = array();

            foreach ($case as $c) {
                array_push($index, $c->claim_case_id);
            }

            $datatables = Datatables::of($case);

            return $datatables
                ->addIndexColumn()
                ->editColumn('case', function ($case) use (
                    $index, $hearing_position_lang, $hearing_position_reason_lang, $reason_lang
                ) {
                    $i = array_search($case->claim_case_id, $index, true);
                    return view("claimcase/list_row", compact('case', 'i', 'hearing_position_reason_lang',
                        'hearing_position_lang', 'reason_lang'));
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "ClaimCaseController", null, null, "Datatables load cases");

        return view("claimcase/list", compact('branches', 'years', 'months'));
    }

    public function view(Request $request, $claim_case_id, $cc = null)
    {
        if ($cc != null) {
            $claim_case_oppo = ClaimCaseOpponent::find($claim_case_id);
            $claim_case = $claim_case_oppo->claimCase;

            if (Auth::user()->user_type_id == 3) {
                if ($claim_case->claimant_user_id != Auth::id() && $claim_case_oppo->opponent_user_id != Auth::id())
                    abort(404);
            }
        } else {
            $claim_case = ClaimCase::find($claim_case_id);
            $claim_case_oppo = $claim_case->multiOpponents;
            $oppo = $claim_case->multiOpponents()->where('opponent_user_id', Auth::id())->first();

            if (Auth::user()->user_type_id == 3) {
                if ($claim_case->claimant_user_id != Auth::id() && $oppo == null)
                    abort(404);
            }
        }

        $attachments = Attachment::where('form_no', 1)
            ->where('form_id', $claim_case->form1_id)
            ->get();

        $userid = Auth::id();
        $user = User::find($userid);

        LogAuditRepository::store($request, 3, "ClaimCaseController", null, null, "View claim case " . $claim_case->case_no);

        return view("claimcase.view", compact('claim_case', 'user', 'claim_case_oppo', 'attachments'));
    }

    public function exportHearing(Request $request, $form4_id, $form_no, $format)
    {
        $form4 = Form4::find($form4_id);

        $form4_before = Form4::where('claim_case_opponent_id', $form4->claim_case_opponent_id)
            ->where('form4_id', '<', $form4->form4_id)
            ->get();

        $hq_address = MasterBranch::where('is_hq', 1)->first();

        if (count($form4_before) > 0) {
            $form4_before = $form4_before->last();
        } else {
            $form4_before = null;
        }

        if ($format == 'pdf') {
            $this->data['form4'] = $form4;
            $this->data['form4_before'] = $form4_before;
            $this->data['hq_address'] = $hq_address;

            $pdf = PDF::loadView('claimcase/print/' . App::getLocale() . '/form' . $form_no, $this->data);
            $pdf->setOption('enable-javascript', true);

            if ($form_no == 4) {
                $form4->form_status_id = 36;
                $form4->save();
            }

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "ClaimCaseController", $form4_id, null, "Download form " . $form_no . " (PDF)");

            return $pdf->download('Borang ' . $form_no . ' ' . $form4->case->case_no . '.pdf');
        } else if ($format == 'docx') {
            $gen = new GeneralController;
            $salutation_lang = "salutation_" . App::getLocale();

            $form_hearing_date = date('j', strtotime($form4->hearing->hearing_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($form4->hearing->hearing_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($form4->hearing->hearing_date . ' 00:00:00'));
            $form_hearing_time = date('g.i', strtotime($form4->hearing->hearing_date . ' ' . $form4->hearing->hearing_time)) . ' ' . localeDaylight(date('a', strtotime($form4->hearing->hearing_date . ' ' . $form4->hearing->hearing_time)));

            $file = $gen->integrateDocTemplate('form' . $form_no . '_' . App::getLocale(), [
                "en_hq_address" => $hq_address->branch_address_en . ', ' . $hq_address->branch_address2_en . ', ' . $hq_address->branch_address3_en . ', ' . $hq_address->branch_postcode . ', ' . $hq_address->district->district . ', ' . $hq_address->state->state_name,
                "hq_address" => $hq_address->branch_address . ', ' . $hq_address->branch_address2 . ', ' . $hq_address->branch_address3 . ', ' . $hq_address->branch_postcode . ', ' . $hq_address->district->district . ', ' . $hq_address->state->state_name,
                "hearing_venue_short" => $form4->case->venue ? strtoupper($form4->case->venue->hearing_venue) : '-',
                "state_name" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state,
                "case_no" => strtoupper($form4->case->case_no),
                "claimant_name" => htmlspecialchars(strtoupper($form4->case->claimant_address->name)),
                "claimant_identification_type" => strtoupper($form4->case->claimant_address->is_company == 0 ? ($form4->case->claimant_address->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : ''),
                "claimant_identification_no" => htmlspecialchars($form4->case->claimant_address->is_company == 0 ? $form4->case->claimant_address->identification_no : '(' . $form4->case->claimant_address->identification_no . ')'),
                "claimant_address" => $form4->case->claimant_address->street_1 . ($form4->case->claimant_address->street_2 ? ', ' . $form4->case->claimant_address->street_2 : '') . ($form4->case->claimant_address->street_3 ? ', ' . $form4->case->claimant_address->street_3 : '') . ', ' . $form4->case->claimant_address->postcode . ' ' . ($form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : '') . ', ' . ($form4->case->claimant_address->state ? $form4->case->claimant_address->state->state : ''),
                "address1_claimant" => strtoupper($form4->case->claimant_address->street_1),
                "address2_claimant" => $form4->case->claimant_address->street_2 ? strtoupper($form4->case->claimant_address->street_2) . ',' : '',
                "address3_claimant" => $form4->case->claimant_address->street_3 ? strtoupper($form4->case->claimant_address->street_3) . ',' : '',
                "postcode_claimant" => $form4->case->claimant_address->postcode,
                "district_claimant" => $form4->case->claimant_address->district ? strtoupper($form4->case->claimant_address->district->district) : '',
                "state_claimant" => $form4->case->claimant_address->state ? strtoupper($form4->case->claimant_address->state->state) : '',
                "claimant_phone_home" => $form4->case->claimant_address->phone_home,
                "claimant_phone_mobile" => $form4->case->claimant_address->phone_mobile,
                "claimant_email" => $form4->case->claimant_address->email,
                "claimant_phone_fax" => $form4->case->claimant_address->phone_fax,
                "opponent_name" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? strtoupper($form4->claimCaseOpponent->opponent_address->name) : ''),
                "opponent_identification_type" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? (strtoupper($form4->claimCaseOpponent->opponent_address->is_company == 0 ? ($form4->claimCaseOpponent->opponent_address->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : '')) : ''),
                "opponent_identification_no" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->is_company == 0 ? $form4->claimCaseOpponent->opponent_address->identification_no : '(' . $form4->claimCaseOpponent->opponent_address->identification_no . ')') : ''),
                "opponent_address" => $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->street_1 . ($form4->claimCaseOpponent->opponent_address->street_2 ? ', ' . $form4->claimCaseOpponent->opponent_address->street_2 : '') . ($form4->claimCaseOpponent->opponent_address->street_3 ? ', ' . $form4->claimCaseOpponent->opponent_address->street_3 : '') . ', ' . $form4->claimCaseOpponent->opponent_address->postcode . ' ' . ($form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : '') . ', ' . ($form4->claimCaseOpponent->opponent_address->state ? $form4->claimCaseOpponent->opponent_address->state->state : '')) : '',
                "address1_opponent" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? strtoupper($form4->claimCaseOpponent->opponent_address->street_1) : ''),
                "address2_opponent" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->street_2 ? strtoupper($form4->claimCaseOpponent->opponent_address->street_2) . ',' : '') : ''),
                "address3_opponent" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->street_3 ? strtoupper($form4->claimCaseOpponent->opponent_address->street_3) . ',' : '') : ''),
                "postcode_opponent" => $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->postcode : '',
                "district_opponent" => $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->district ? strtoupper($form4->claimCaseOpponent->opponent_address->district->district) : '') : '',
                "state_opponent" => $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->state ? strtoupper($form4->claimCaseOpponent->opponent_address->state->state) : '') : '',
                "opponent_phone_home" => $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->phone_office : '',
                "opponent_phone_mobile" => $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->phone_mobile : '',
                "opponent_email" => $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->email : '',
                "opponent_phone_fax" => $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->phone_fax : '',
                "hearing_date" => $form_hearing_date,
                "hearing_day" => localeDay(date('l', strtotime($form4->hearing->hearing_date . ' 00:00:00'))),
                "hearing_time" => $form_hearing_time,
                "hearing_venue" => $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '',
                "hearing_room" => $form4->hearing->hearing_room ? $form4->hearing->hearing_room->hearing_room : '',
                "hearing_address_venue" => $form4->hearing->hearing_room ? str_replace(', ,', ', ', str_replace('<br>', '<w:br/>', $form4->hearing->hearing_room->address)) : '-',
                "hearing_location" => $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '-',
                "today_date" => $form4->created_at->format('d').' '.localeMonth($form4->created_at->format('F')).' '.$form4->created_at->format('Y'),
                "psu_f4_name" => strtoupper($form4->psu->name),
                "psu_name" => strtoupper($form4->psus->count() > 0 ? $form4->psus->first()->name : ""),
                "psu_role_en" => ($form4->psu->roleuser->first()->role->name == "ks-hq" || $form4->psu->roleuser->first()->role->name == "ks") ? "ASSISTANT SECRETARY" : strtoupper($form4->psu->roleuser->first()->role->display_name_en),
                "psu_role_my" => ($form4->psu->roleuser->first()->role->name == "ks-hq" || $form4->psu->roleuser->first()->role->name == "ks") ? "PENOLONG SETIAUSAHA" : strtoupper($form4->psu->roleuser->first()->role->display_name_my),
                "award_description" => htmlspecialchars($form4->award
                    ? (App::getLocale() == 'en' && $form4->award->award_description_en != null
                        ? $form4->award->award_description_en
                        : $form4->award->award_description
                    )
                    : ''
                ),
                "president_salutation" => strtoupper($form4->president ? ($form4->president->ttpm_data->president->salutation ? $form4->president->ttpm_data->president->salutation->$salutation_lang : '') . ' ' . $form4->president->name : ""),
                "president_name" => htmlspecialchars(strtoupper($form4->president ? $form4->president->name : "")),
                "award_day" => $form4->award ? date('d', strtotime($form4->award->award_date . ' 00:00:00')) : '',
                "award_month" => $form4->award ? localeMonth(date('F', strtotime($form4->award->award_date . ' 00:00:00'))) : '',
                "award_year" => $form4->award ? date('Y', strtotime($form4->award->award_date . ' 00:00:00')) : '',
                "award_date" => $form4->award ? date('j', strtotime($form4->award->award_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($form4->award->award_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($form4->award->award_date . ' 00:00:00')) : '',
                "hearing_before_date" => $form4_before ? date('j', strtotime($form4_before->hearing->hearing_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($form4_before->hearing->hearing_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($form4_before->hearing->hearing_date . ' 00:00:00')) : '',
                "president_before_salutation" => $form4_before ? strtoupper($form4_before->president ? ($form4_before->president->ttpm_data->president->salutation ? $form4_before->president->ttpm_data->president->salutation->$salutation_lang : '') . ' ' . $form4_before->president->name : "") : '',
                "hearing_num_day" => date('d', strtotime($form4->hearing->hearing_date . ' 00:00:00')),
                "hearing_month" => localeMonth(date('F', strtotime($form4->hearing->hearing_date . ' 00:00:00'))),
                "hearing_year" => date('Y', strtotime($form4->hearing->hearing_date . ' 00:00:00')),
                "today_day" => date('d'),
                "today_month" => localeMonth(date('F')),
                "today_year" => date('Y'),
                "unfiled_defence_reason" => htmlspecialchars($form4->form12 ? $form4->form12->unfiled_reason : ''),
                "absent_reason" => htmlspecialchars($form4->form12 ? $form4->form12->absence_reason : ''),
                "filing_date" => $form4->form12 ? date('d/m/Y', strtotime($form4->form12->filing_date . ' 00:00:00')) : '',
                "extra_myclaimant" => $form4->case->extra_claimant ? ('/ /n' . $form4->case->extra_claimant->name . '/n No. KP: ' . $form4->case->extra_claimant->identification_no) : '',
                "extra_name" => $form4->case->extra_claimant ? '/n /n' . $form4->case->extra_claimant->name : '',
                "extra_claimant_ic" => $form4->case->extra_claimant ? ($form4->case->extra_claimant->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : '',
            ]);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "ClaimCaseController", $form4_id, null, "Download form " . $form_no . " (DOCX)");

            return response()->download($file, 'Borang ' . $form_no . ' ' . $form4->case->case_no . '.docx')->deleteFileAfterSend(true);
        }

    }

    public function exportLetter(Request $request, $form4_id, $letter, $format)
    {
        $form4 = Form4::find($form4_id);
        $hq_address = MasterBranch::where('is_hq', 1)->first();

        if ($format == 'pdf') {
            $this->data['form4'] = $form4;
            $this->data['hq_address'] = $hq_address;

            switch ($letter) {
                case 1:
                    $letter_name = "minit";
                    break;
                case 2:
                    $letter_name = "pertanyaan_tuntutan";
                    break;
                case 3:
                    $letter_name = "surat_award_ditolak";
                    break;
                case 4:
                    $letter_name = "surat_tangguh";
                    break;
                case 5:
                    $letter_name = "surat_bersama_award_penentang";
                    break;
                case 6:
                    $letter_name = "surat_bersama_award_penuntut";
                    break;
                case 7:
                    $letter_name = "surat_serahan_award";
                    break;
                case 8:
                    $letter_name = "surat_dibatalkan";
                    break;
                default:
                    $letter_name = "";
                    break;
            }

            LogAuditRepository::store($request, 17, "ClaimCaseController", $form4_id, null, "Download letter " . $letter_name . " (PDF)");

            $pdf = PDF::loadView('claimcase/print/' . App::getLocale() . '/' . $letter_name, $this->data);
            $pdf->setOption('enable-javascript', true);

            return $pdf->download(ucwords((str_replace('_', ' ', $letter_name))) . ' ' . $form4->case->case_no . '.pdf');
        } else if ($format == 'docx') {
            $locale = App::getLocale();
            $gen = new GeneralController;
            $salutation_lang = "salutation_" . $locale;
            $display_name = "display_name_" . $locale;
            $hearing_position_reason = "hearing_position_reason_" . $locale;
            $designation_lang = "designation_" . $locale;
            $term_lang = 'term_' . $locale;
            $address_lang = 'address_' . $locale;

            switch ($letter) {
                case 1:
                    $letter_name = "minit";
                    break;
                case 2:
                    $letter_name = "pertanyaan_tuntutan";
                    break;
                case 3:
                    $letter_name = "surat_award_ditolak";
                    break;
                case 4:
                    $letter_name = "surat_tangguh";
                    break;
                case 5:
                    $letter_name = "surat_bersama_award_penentang";
                    break;
                case 6:
                    $letter_name = "surat_bersama_award_penuntut";
                    break;
                case 7:
                    $letter_name = "surat_serahan_award";
                    break;
                case 8:
                    $letter_name = "surat_dibatalkan";
                    break;
                case 9:
                    $letter_name = "surat_bersama_award_penentang_9_10";
                    break;
                case 10:
                    $letter_name = "surat_bersama_award_penuntut_9_10";
                    break;
                default:
                    $letter_name = "";
                    break;
            }

            $params = [
                'duration_award' => $form4->award ? (($form4->award->award_obey_duration ? $form4->award->award_obey_duration : 14) . ' ' . ($form4->award->term ? $form4->award->term->$term_lang : strtolower(__('new.days')))) : '',
                "en_hq_address" => $hq_address->branch_address_en . ', ' . $hq_address->branch_address2_en . ', ' . $hq_address->branch_address3_en . ', ' . $hq_address->branch_postcode . ', ' . $hq_address->district->district . ', ' . $hq_address->state->state_name,
                "hq_address" => $hq_address->branch_address . ', ' . $hq_address->branch_address2 . ', ' . $hq_address->branch_address3 . ', ' . $hq_address->branch_postcode . ', ' . $hq_address->district->district . ', ' . $hq_address->state->state_name,
                "claimant_name" => htmlspecialchars(strtoupper($form4->case->claimant_address->name)),
                "claimant_identification_type" => $form4->case->claimant_address->nationality_country_id == 129 ? __('new.ic') : __('new.passport'),
                "claimant_identification_no" => $form4->case->claimant_address->identification_no,
                "claimant_address1" => htmlspecialchars(strtoupper($form4->case->claimant_address->street_1)),
                "claimant_address2" => htmlspecialchars(strtoupper($form4->case->claimant_address->street_2)),
                // "claimant_address3" => $claimant,
                "claimant_address3" => $form4->case->claimant_address->street_3 ? htmlspecialchars(strtoupper($form4->case->claimant_address->street_3)) . ',' : '',
                "claimant_postcode" => $form4->case->claimant_address->postcode,
                'claimant_district' => $form4->case->claimant_address->subdistrict ? $form4->case->claimant_address->subdistrict->name : ($form4->case->claimant_address->district ? $form4->case->claimant_address->district->district : ''),
                "claimant_state" => $form4->case->claimant_address->state ? $form4->case->claimant_address->state->state : '',

                "opponent_name" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? strtoupper($form4->claimCaseOpponent->opponent_address->name) : ''),
                "opponent_rep_name" => $form4->claimCaseOpponent->opponent_address // have oppo address
                    ? ($form4->claimCaseOpponent->opponent_address->is_company == 0 // and not company
                        ? $form4->claimCaseOpponent->opponent_address->name
                        : ($form4->claimCaseOpponent->opponent->public_data->company // have company data
                            ? $form4->claimCaseOpponent->opponent->public_data->company->representative_name
                            : $form4->claimCaseOpponent->opponent_address->name
                        )
                    )
                    : '',
                "opponent_identification_no" => $form4->claimCaseOpponent->opponent_address
                    ? ($form4->claimCaseOpponent->opponent_address->is_company == 0
                        ? $form4->claimCaseOpponent->opponent_address->identification_no
                        : '(' . $form4->claimCaseOpponent->opponent_address->identification_no . ')')
                    : '',
                "opponent_identification_type" => $form4->claimCaseOpponent->opponent_address
                    ? ($form4->claimCaseOpponent->opponent_address->is_company == 0
                        ? ($form4->claimCaseOpponent->opponent_address->nationality_country_id == 129
                            ? __('new.ic')
                            : __('new.passport')
                        )
                        : ($form4->claimCaseOpponent->opponent->public_data->company
                            ? __('new.ic')
                            : __('new.company_no')
                        )
                    ) : '',
                "company" => $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->is_company == 1 ? ($form4->claimCaseOpponent->opponent->public_data->company ? __('new.from_company') : '') : '') : '',
                "comp_name" => htmlspecialchars($form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->is_company == 1 ? ($form4->claimCaseOpponent->opponent->public_data->company ? $form4->claimCaseOpponent->opponent_address->name : '') : '') : ''),
                "designation" => $form4->claimCaseOpponent->opponent_address ? ($form4->claimCaseOpponent->opponent_address->is_company == 1 ? ($form4->claimCaseOpponent->opponent->public_data->company ? __('new.designation_option') : '') : '') : '',
                "desg_type" => ($form4->claimCaseOpponent->opponent_address && $form4->claimCaseOpponent->opponent_address->is_company == 1 && $form4->claimCaseOpponent->opponent->public_data->company && $form4->claimCaseOpponent->opponent->public_data->company->designation)
                    ? $form4->claimCaseOpponent->opponent->public_data->company->designation->$designation_lang
                    : '',
                "opponent_address1" => $form4->claimCaseOpponent->opponent_address ? htmlspecialchars(strtoupper($form4->claimCaseOpponent->opponent_address->street_1)) : '',
                "opponent_address2" => $form4->claimCaseOpponent->opponent_address ? htmlspecialchars(strtoupper($form4->claimCaseOpponent->opponent_address->street_2)) : '',
                // "opponent_address3" => $opponent,
                "opponent_address3" => $form4->claimCaseOpponent->opponent_address ? htmlspecialchars(strtoupper($form4->claimCaseOpponent->opponent_address->street_3)) . ',' : '',
                "opponent_postcode" => $form4->claimCaseOpponent->opponent_address ? $form4->claimCaseOpponent->opponent_address->postcode : '',
                'opponent_district' => $form4->claimCaseOpponent->opponent_address->subdistrict ? $form4->claimCaseOpponent->opponent_address->subdistrict->name : ($form4->claimCaseOpponent->opponent_address->district ? $form4->claimCaseOpponent->opponent_address->district->district : ''),
                "opponent_state" => $form4->claimCaseOpponent->opponent_address->state ? strtoupper($form4->claimCaseOpponent->opponent_address->state->state) : '',

                "case_no" => strtoupper($form4->case->case_no),
                "hearing_date" => date('j', strtotime($form4->hearing->hearing_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($form4->hearing->hearing_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($form4->hearing->hearing_date . ' 00:00:00')),
                "hearing_day" => localeDay(date('l', strtotime($form4->hearing->hearing_date . ' 00:00:00'))),
                "hearing_room" => $form4->hearing->hearing_room ? $form4->hearing->hearing_room->hearing_room : '-',
                "inline_hearing_address_venue" => $form4->hearing->hearing_room ? str_replace(', ,', ', ', str_replace('<br>', '', $form4->hearing->hearing_room->address)) : '-',
                "hearing_address_venue" => $form4->hearing->hearing_room ? str_replace(', ,', ', ', str_replace('<br>', '<w:br/>', $form4->hearing->hearing_room->address)) : '-',
                "hearing_venue" => $form4->hearing->hearing_room ? $form4->hearing->hearing_room->venue->hearing_venue : '-',
                "hearing_time" => date('g.i', strtotime($form4->hearing->hearing_date . ' ' . $form4->hearing->hearing_time)) . ' ' . localeDaylight(date('a', strtotime($form4->hearing->hearing_date . ' ' . $form4->hearing->hearing_time))),
                "psu_name" => $form4->psus ? strtoupper($form4->psus->first()->psu->name) : '',
                "psu_role" => $form4->psus ? ($form4->psus->first()->psu->roleuser->first()->role->name == "ks-hq" || $form4->psus->first()->psu->roleuser->first()->role->name == "ks" ? __('new.psu') : strtoupper($form4->psus->first()->psu->roleuser->first()->role->$display_name)) : '',
                "psu_identification_no" => htmlspecialchars($form4->psu->ttpm_data->identification_no),
                "award_date" => $form4->award ? date('j', strtotime($form4->award->award_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($form4->award->award_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($form4->award->award_date . ' 00:00:00')) : '',
                "hearing_end_time" => date('h:i A', strtotime($form4->hearing_end_time . ' 00:00:00')),
                "branch_name" => $form4->case->branch->branch_name,
                "branch_en_address" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address_en : $form4->case->transfer_branch->branch_address_en,
                "branch_2en_address" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address2_en : $form4->case->transfer_branch->branch_address2_en,
                "branch_3en_address" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address3_en : $form4->case->transfer_branch->branch_address3_en,
                "branch_address" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address : $form4->case->transfer_branch->branch_address,
                "branch_2address" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address2 : $form4->case->transfer_branch->branch_address2,
                "branch_3address" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_address3 : $form4->case->transfer_branch->branch_address3,
                "branch_postcode" => $form4->case->transfer_branch_id == NULL ? $form4->case->branch->branch_postcode : $form4->case->transfer_branch->branch_postcode,
                "branch_district" => ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->district->district : $form4->case->transfer_branch->district->district)),
                "branch_state" => ucfirst(strtolower($form4->case->transfer_branch_id == NULL ? $form4->case->branch->state->state : $form4->case->transfer_branch->state->state)),
                "cancelled_reason" => $form4->hearing_position_reason ? strtolower($form4->hearing_position_reason->$hearing_position_reason) : '',
                "extra_name" => $form4->case->extra_claimant ? '/n /n' . $form4->case->extra_claimant->name : '',
                "extra_claimant_ic" => $form4->case->extra_claimant ? ($form4->case->extra_claimant->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : '',
            ];

            $params = array_merge($params, [
                'letter_branch_2_address' => $form4->letter_branch_address_id != null
                    ? $form4->letterBranchAddress->$address_lang
                    : ($locale == 'en'
                        ? $params['branch_en_address'] . ', ' . $params['branch_2en_address'] . ', '
                        . $params['branch_3en_address'] . ', ' . $params['branch_postcode'] . ', '
                        . $params['branch_district'] . ', ' . $params['branch_state']
                        : $params['branch_address'] . ', ' . $params['branch_2address'] . ', '
                        . $params['branch_3address'] . ', ' . $params['branch_postcode'] . ', '
                        . ucfirst(strtolower($params['branch_district'])) . ', ' . ucfirst(strtolower($params['branch_state']))
                    ),
                'letter_magistrate_court_name' => $form4->letter_court_id != null
                    ? (
                    ($locale == 'en ' && $form4->letterCourt->court_name_en != null)
                        ? $form4->letterCourt->court_name_en
                        : $form4->letterCourt->court_name
                    )
                    : ($locale == 'en'
                        ? 'Magistrate Court '
                        : 'Mahkamah Majistret ')
                    . ucfirst(strtolower($params['branch_state'])),
            ]);

//            dd($params);

            if ($form4->form4_next) {
                $params = array_merge($params, [
                    "hearing_new_date" => $form4->form4_next ? date('j', strtotime($form4->form4_next->hearing->hearing_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($form4->form4_next->hearing->hearing_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($form4->form4_next->hearing->hearing_date . ' 00:00:00')) : '',
                    "hearing_new_day" => $form4->form4_next ? localeDay(date('l', strtotime($form4->form4_next->hearing->hearing_date . ' 00:00:00'))) : '',
                    "hearing_new_time" => $form4->form4_next ? date('g.i', strtotime($form4->form4_next->hearing->hearing_date . ' ' . $form4->form4_next->hearing->hearing_time)) . ' ' . localeDaylight(date('a', strtotime($form4->form4_next->hearing->hearing_date . ' ' . $form4->form4_next->hearing->hearing_time))) : '',
                    "hearing_new_venue" => $form4->form4_next ? ($form4->form4_next->hearing->hearing_room ? $form4->form4_next->hearing->hearing_room->venue->hearing_venue : '-') : '-',
                    "hearing_new_room" => $form4->form4_next ? ($form4->form4_next->hearing->hearing_room ? $form4->form4_next->hearing->hearing_room->hearing_room : '-') : '',
                    "hearing_new_address_venue" => $form4->form4_next->hearing->hearing_room ? str_replace(', ,', ', ', str_replace('<br>', '<w:br/>', $form4->form4_next->hearing->hearing_room->address)) : '-',
                    "inline_hearing_new_address_venue" => $form4->form4_next->hearing->hearing_room ? str_replace(', ,', ', ', str_replace('<br>', '', $form4->form4_next->hearing->hearing_room->address)) : '-',
                ]);
            }

            $file = $gen->integrateDocTemplate($letter_name . '_' . App::getLocale(), $params);

            LogAuditRepository::store($request, 17, "ClaimCaseController", $form4_id, null, "Download letter " . $letter_name . " (DOCX)");

            return response()->download($file, ucwords((str_replace('_', ' ', $letter_name))) . ' ' . $form4->case->case_no . '.docx')->deleteFileAfterSend(true);
        }
    }
}
