<?php

namespace App\Http\Controllers\ClaimCase;

use App\CaseModel\ClaimCaseOpponent;
use App\Repositories\ClaimCaseRepository;
use App\MasterModel\MasterBranchAddress;
use App\MasterModel\MasterCourt;
use App\Repositories\LogAuditRepository;
use App\Repositories\MasterBranchAddressRepository;
use App\Repositories\MasterCourtRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form4;
use App\CaseModel\StopNotice;
use Auth;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingStatus;
use App\MasterModel\MasterHearingPosition;
use App\MasterModel\MasterHearingPositionReason;
use App\MasterModel\MasterF10Type;
use App\MasterModel\MasterDurationTerm;
use App\HearingModel\Award;
use App\SupportModel\Form4PSU;
use App\SupportModel\Form4Update;
use App\RoleUser;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App;
use DB;
use Carbon\Carbon;


class Form4Controller extends Controller
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

    protected function rules_insert_status()
    {
        $rules = [
            'hearing_status_id' => 'required|integer',
            'hearing_position_id' => 'required|integer'
        ];

        return $rules;
    }

    public function list(Request $request)
    {
        $status = MasterFormStatus::where('status_code', 'LIKE', '%B4%')->get();
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $years = range(date('Y')+1, 2000);
        $months = MasterMonth::all();
        $input = $request->all();

        $input['year'] = (!isset($input['year']) || trim($input['year']) === '') ? date('Y') : $input['year'];

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.form4', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {

            $form4 = Form4::select([
                'form4.form4_id',
                'form4.claim_case_id',
                'form4.hearing_id',
                'form4.form_status_id',
                'form4.opponent_user_id',
                'form4.counter',
                'form1.processed_at',
            ])
                ->with(['status', 'hearing.hearing_room', 'case', 'opponent'])
                ->join('claim_case', 'claim_case.claim_case_id', '=', 'form4.claim_case_id')
                ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
                ->orderBy('case_year', 'asc')
                ->orderBy('case_sequence', 'asc');

            if (Auth::user()->hasRole('user')) {
                $form4->whereHas('case', function ($case) {
                    return $case->where('claimant_user_id', Auth::id())->orWhere('opponent_user_id', Auth::id());
                });
            }

            // Check for filteration
            if ($request->has('status') || $request->has('branch') || $request->has('month')) {

                if ($request->has('status') && !empty($request->status)) {
                    $form4->where('form4.form_status_id', $request->status);
                }

                if ($request->has('branch') && !empty($request->branch)) {
                    $form4->where('claim_case.branch_id', $request->branch);
                }

                if ($request->has('month') && !empty($request->month)) {
                    $form4->whereMonth('form1.filing_date', $request->month);
                }
            }

            if ($input['year'] > 0) {
                $form4->whereYear('form1.filing_date', $input['year']);
            }

            $datatables = Datatables::of($form4);

            return $datatables
                ->editColumn('case_no', function ($form4) {
                    return "<a class='' href='" . route('claimcase-view', [$form4->claim_case_id]) . "'>" . $form4->case->case_no . "</a>";
                })
                ->editColumn('opponent_name', function ($form4) {
                    if ($form4->claim_case_opponent_id) {
                        return $form4->claimCaseOpponent->opponent_address->user->name ?? '-';
                    } else {
                        return "-";
                    }
                })
                ->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y h:i A', strtotime($form4->hearing->hearing_date . " " . $form4->hearing->hearing_time));
                })
                ->editColumn('hearing_location', function ($form4) {
                    if ($form4->hearing->hearing_room)
                        return "<strong>" . $form4->hearing->hearing_room->hearing_room . "</strong><br>" . $form4->hearing->hearing_room->address;
                    else
                        return '-';
                })
                ->editColumn('status', function ($form4) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    return $form4->status->$status_lang;
                })
                ->editColumn('counter', function ($form4) {
                    return $form4->counter;
                })
                ->addColumn('action', function ($form4) {
                    return '<div class="btn-group" style="position: relative;">
                                            <button class="btn btn-xs btn-default m-b-5 dropdown-toggle"
                                                    type="button" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="fa fa-download"></i>'.  __('form4.form4') .'
                                            </button>
                                            <ul class="dropdown-menu pull-left" role="menu"
                                                style="position: inherit;">
                                                <li>
                                                    <a href="'.route('form4-export', ['form4_id'=>$form4->form4_id, 'form_no'=>4, 'format'=>'pdf']) .'">
                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="'. route('form4-export', ['form4_id'=>$form4->form4_id, 'form_no'=>4, 'format'=>'docx']) .'">
                                                        <i class="fa fa-file-text-o"></i> DOCX
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>';
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form4Controller", null, null, "Datatables load form 4");

        return view("claimcase.form4.list", compact('branches', 'status', 'months', 'years', 'input'));
    }

    /**
     * List of hearing status entry.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function listStatus(Request $request)
    {
        // RBAC
        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('form4-status-list', ['branch' => Auth::user()->ttpm_data->branch_id, 'year' => date('Y')]);
        } else if ((Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) && !$request->has('branch')) {
            return redirect()->route('form4-status-list', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        $branches = MasterBranch::where('is_active', 1)
            ->orderBy('branch_id', 'desc');

        /*
         * if psu & psu-hq
         *    then filter by their own branch_id only
         */
        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq')) {
            $branches->where('branch_id', Auth::user()->ttpm_data->branch_id);
        }

        $branches = $branches->get();

        if ($request->ajax()) {
            $locale = App::getLocale();

            $form4 = Form4::with([
                'claimCaseOpponent.opponent_address',
                'claimCaseOpponent.opponent',
                'case:claim_case_id,case_no,case_status_id,branch_id,form1_id,claimant_address_id',
                'case.claimant_address:user_claimcase_id,name',
                'case.form1:form1_id,filing_date,claim_classification_id',
                'case.form1.classification.category:claim_category_id,category_en,category_my',
                'hearing:hearing_id,hearing_date',
                'form4_before.form4:form4_id,hearing_status_id',
                'form4_before.form4.form12:form4_id'
            ])
                ->whereNull('award_id');
//                ->whereHas('claimCaseOpponent');

            if ($request->has('hearing_date') && !empty($request->hearing_date)) {
                $form4->whereNull('hearing_status_id')
                    ->orderBy('created_at', 'desc')
                    ->where('hearing_id', $request->hearing_date);
            }

            if ($request->has('branch') && !empty($request->branch)) {
                // check by branch_id or transfer_branch_id
                $form4->whereHas('case', function ($case) use ($request) {
                    return $case->where('branch_id', $request->branch)
                        ->orWhere('transfer_branch_id', $request->branch);
                });
            }

            if ($request->has('year') && !empty($request->year)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    $date = Carbon::createFromFormat('Y', $request->year);

                    return $hearing->whereBetween('hearing_date', [
                        $date->startOfYear()->toDateString(),
                        $date->endOfYear()->toDateString()
                    ]);
                });
            }

            if ($request->has('month') && !empty($request->month)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    $date = Carbon::createFromFormat('Y-m', (($request->has('year') && !empty($request->year))
                            ? $request->year
                            : date('Y')) . '-' . $request->month);

                    return $hearing->whereBetween('hearing_date', [
                        $date->startOfMonth()->toDateString(),
                        $date->endOfMonth()->toDateString()
                    ]);
                });
            }

            $datatables = Datatables::of($form4);

            return $datatables
                ->addIndexColumn()
                ->editColumn('case_no', function ($form4) {
                    return $form4->case->case_no;
                })
                ->editColumn('category', function ($form4) use ($locale) {
                    return $form4->case->form1->classification->category->{"category_" . $locale} ?? '-';
                })
                ->editColumn('classification', function ($form4) use ($locale) {
                    return $form4->case->form1->classification->{"classification_" . $locale} ?? '-';
                })
                ->editColumn('claimant_name', function ($form4) {
                    return $form4->case->claimant_address->name ?? '';
                })
                ->editColumn('opponent_name', function ($form4) {
                    return $form4->claimCaseOpponent->opponent_address->name ?? '-';
                })
                ->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->hearing->hearing_date));
                })
                ->editColumn('type', function ($form4) {
                    if ($form4->case->case_status_id <= 6) {
                        return __('new.new');
                    } else if (!$form4->form4_before) {
                        return __('new.new');
                    } else if ($form4->form4_before && $form4->form4_before->form4 && ($form4->form4_before->form4->hearing_status_id == 3 || $form4->form4_before->form4->hearing_status_id == 2)) {
                        return __('new.postponed');
                    } else if ($form4->form4_before && $form4->form4_before->form4 && ($form4->form4_before->form4->hearing_status_id == 1 && $form4->form4_before->form4->form12)) {
                        return __('new.form12');
                    }
                    return '';
                })
                ->editColumn('action', function ($form4) {
                    $button = "";
                    $button .= actionButton('green-meadow',
                        __('button.set_hearing_status'),
                        route('form4-status-set', ['form4_id' => $form4->form4_id]),
                        false,
                        'fa fa-edit',
                        false);
                    $button .= actionButton('green', __('button.attendance'), route('listing.attendance', [
                        'hearing_id' => $form4->hearing_id,
                        'claim_case_id' => $form4->claim_case_id,
                        'claim_case_opponent_id' => $form4->claim_case_opponent_id,
                        'branch' => $form4->case->branch_id,
                    ]), false, 'fa fa-list', false);
                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form4Controller", null, null, "Datatables load claim without hearing status");

        return view("hearing.status.list", compact('form4', 'branches', 'years', 'months'));
    }

    public function transferList(Request $request)
    {
        // RBAC
        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('form4-transfer-list', ['branch' => Auth::user()->ttpm_data->branch_id, 'year' => date('Y')]);
        } else if ((Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) && !$request->has('branch')) {
            return redirect()->route('form4-transfer-list', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq')) {
            $branches = MasterBranch::where('is_active', 1)->where('branch_id', Auth::user()->ttpm_data->branch_id)->orderBy('branch_id', 'desc')->get();
        } else {
            $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        }

        if ($request->ajax()) {
            $locale = App::getLocale();
            $form4 = Form4::with([
                'case:claim_case_id,case_no,case_status_id,transfer_branch_id,form1_id,claimant_address_id,opponent_address_id',
                'case.claimant_address:user_claimcase_id,name',
                'case.opponent_address:user_claimcase_id,name',
                'case.form1:form1_id,filing_date,claim_classification_id',
                'case.form1.classification.category:claim_category_id,category_en,category_my',
                'hearing:hearing_id,hearing_date',
                'form4_before.form4:form4_id,hearing_status_id',
                'form4_before.form4.form12:form4_id'
            ]);


            if ($request->has('branch') && !empty($request->branch)) {
                $form4->whereHas('case', function ($case) use ($request) {
                    return $case->where('transfer_branch_id', $request->branch);
                });
            }

            if ($request->has('year') && !empty($request->year)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    $date = Carbon::createFromFormat('Y', $request->year);
                    return $hearing->whereBetween('hearing_date', [
                        $date->startOfYear()->toDateString(),
                        $date->endOfYear()->toDateString()
                    ]);
                });
            }

            if ($request->has('month') && !empty($request->month)) {
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    $date = Carbon::createFromFormat('Y-m', (($request->has('year') && !empty($request->year)) ? $request->year : date('Y')) . '-' . $request->month);
                    return $hearing->whereBetween('hearing_date', [
                        $date->startOfMonth()->toDateString(),
                        $date->endOfMonth()->toDateString()
                    ]);
                });
            }

            $datatables = Datatables::of($form4);

            return $datatables
                ->editColumn('case_no', function ($form4) {
                    return "<a class='' href='" . route('claimcase-view', [$form4->claim_case_id]) . "'> " . $form4->case->case_no . "</a>";
                    // return $form4->case->case_no;
                })
                ->editColumn('category', function ($form4) use ($locale) {
                    return $form4->case->form1->classification->category->{"category_" . $locale} ?? '-';
                })
                ->editColumn('classification', function ($form4) use ($locale) {
                    return $form4->case->form1->classification->{"classification_" . $locale} ?? '-';
                })
                ->editColumn('claimant_name', function ($form4) {
                    return $form4->case->claimant_address->name ?? '';
                })
                ->editColumn('opponent_name', function ($form4) {
                    return $form4->case->opponent_address->name ?? '-';
                })
                ->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->hearing->hearing_date));
                })
                ->editColumn('position', function ($form4) {
                    // if ($form4->case->case_status_id <= 6) {
                    //     return __('new.new');
                    // } else if (!$form4->form4_before->form4) {
                    //     return __('new.new');
                    // } else if ($form4->form4_before->form4->hearing_status_id == 3 || $form4->form4_before->form4->hearing_status_id == 2) {
                    //     return __('new.postponed');
                    // } else if ($form4->form4_before->form4->hearing_status_id == 1 && $form4->form4_before->form4->form12) {
                    //     return __('new.form12');
                    // }
                    // return '';
                    $locale = App::getLocale();
                    $position_lang = "hearing_position_" . $locale;

                    if ($form4->hearing_position_id)
                        return $form4->hearing_position->$position_lang;
                    else
                        return "-";
                })
                ->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "Form4Controller", null, null, "Datatables load claim without hearing status");
        return view("hearing.status.transfer", compact('form4', 'branches', 'years', 'months'));
    }

    /**
     * Set status hearing
     * KEMASUKAN STATUS PENDENGARAN
     *
     * @param \Illuminate\Http\Request $request
     * @param $form4_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function setStatus(Request $request, $form4_id)
    {
        if ($form4_id) {
            $form4 = Form4::with('attendance')
                ->find($form4_id);

            $form4_next = Form4::where('form4_id', '>', $form4_id)
                ->where('claim_case_id', $form4->claim_case_id);

            if ($form4_next->get()->count() > 0) {
                $form4_next = $form4_next->first();
            } else {
                $form4_next = null;
            }

            $positions = MasterHearingPosition::all();
            $status = MasterHearingStatus::all();
            $reasons = MasterHearingPositionReason::all();
            $branches = MasterBranch::where('is_active', 1)->get();
            $f10_types = MasterF10Type::all();
            $terms = MasterDurationTerm::where('is_active', 1)->get();
            $form4_state_id = $form4->case->transfer_branch_id == NULL
                ? $form4->case->branch->state->state_id
                : $form4->case->transfer_branch->state->state_id;
            $letter_branch_addresses = MasterBranchAddressRepository::getListByStateId($form4_state_id);
            $letter_courts = MasterCourtRepository::getListByStateId($form4_state_id, 1, 1);

            $psus = RoleUser::whereIn('role_id', [18, 17, 10])
                ->whereHas('user', function ($user) {
                    return $user->where('user_status_id', 1);
                })
                ->get();

            $presidents = RoleUser::whereIn('role_id', [4])
                ->whereHas('user', function ($user) {
                    return $user->where('user_status_id', 1);
                })
                ->get();

            LogAuditRepository::store($request, 9, "Form4Controller", null, null, "View hearing status entry form ");

            return view("hearing.status.create", compact('form4', 'form4_next', 'positions', 'status',
                'reasons', 'branches', 'f10_types', 'psus', 'presidents', 'terms', 'letter_branch_addresses', 'letter_courts'));
        }
    }

    protected function rules_store($request)
    {

        $rules = [
            'president' => 'required|integer',
            'is_finish' => 'required|integer',
            'hearing_position_id' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required',
            'psus' => 'required'
        ];

        if ($request->is_finish == 1) {

            if ($request->hearing_position_id == 3 || $request->hearing_position_id == 5) {
                $rules['award_type'] = 'required|integer';
                $rules['award_desc'] = 'required|string';
                $rules['award_date'] = 'required|string';

                if ($request->award_type == 10) {
                    $rules['f10_type_id'] = 'required|integer';

                    if ($request->f10_type_id == 1) {
                        $rules['is_president'] = 'required|integer';
                        //$rules['new_hearing_date2'] = 'required|integer';

                        if ($request->is_president == 0)
                            $rules['earlier_president'] = 'required|integer';
                    }
                }


            } else if ($request->hearing_position_id == 4) {
                $rules['hearing_position_reason_id'] = 'required|integer';
            } else if ($request->hearing_position_id == 6) {
                $rules['stop_notice_date'] = 'required';
            }

        } else {
            $rules['hearing_position_reason_id'] = 'required|integer';
            // $rules['details'] = 'required|string';

            if ($request->hearing_position_reason_id == 9)
                $rules['branch_id'] = 'required|integer';
        }

        return $rules;
    }

    /**
     * Update hearing status
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @throws \Exception
     */
    public function storeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_store($request));

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        if ($request->form4_id != NULL) {
            $form4 = Form4::find($request->form4_id);
            $form4->president_user_id = $request->president;
            $form4->hearing_status_id = $request->is_finish;
            $form4->hearing_position_id = $request->hearing_position_id;
            $form4->letter_branch_address_id = $request->letter_branch_address_id;
            $form4->letter_court_id = $request->letter_court_id;
            $form4->hearing_start_time = date('h:i:s', strtotime($request->start_time));
            $form4->hearing_end_time = date('h:i:s', strtotime($request->end_time));
            $form4->processed_by_user_id = Auth::id();
            $form4->processed_at = Carbon::now();

            // If hearing position is tangguh
            // then get old form4 data to copy its form12_id.
            $form4_old = Form4::orderBy('form4_id', 'desc')
                ->where('claim_case_opponent_id', '!=', $form4->claim_case_opponent_id)
                ->offset(1)
                ->first();

            if ($form4_old != null) {
                $form4->form12_id = $form4_old->form12_id;
            }

            Form4PSU::where('form4_id', $request->form4_id)->delete();

            if ($request->has('psus')) {
                foreach ($request->psus as $psu_user_id) {
                    $form4_psu = new Form4PSU;
                    $form4_psu->form4_id = $request->form4_id;
                    $form4_psu->psu_user_id = $psu_user_id;
                    $form4_psu->save();
                }
            }

            if ($request->is_finish == 1) {
                // if this cco status_id still 1, then update to 2.
                $cco = $form4->claimCaseOpponent;

                if ($cco->status_id == 1) {
                    $cco->update(['status_id' => 2]); // finished
                }

                // if other cco in that cc is_finished eq 1 then update cc is_finished eq 1
                ClaimCaseRepository::updateFinishStatus($cco->claimCase);

                if ($request->hearing_position_id == 3 || $request->hearing_position_id == 5) {
                    // Create new award and get award_id
                    if ($form4->award_id != null) {
                        $award = Award::find($form4->award_id);
                        $award->delete();
                    }

                    $form4->award_id = null;
                    $form4->save();

                    $new_award = Award::create([
                        'award_type' => $request->award_type,
                        'is_display_representative' => $request->is_representative,
                        'award_value' => $request->award_value,
                        'award_cost_value' => $request->cost,
                        'award_obey_duration' => $request->num_period,
                        'award_term_id' => $request->period,
                        'award_description' => $request->award_desc,
                        'award_description_en' => $request->award_description_en,
                        'award_date' => $request->award_date ? Carbon::createFromFormat('d/m/Y', $request->award_date)->toDateTimeString() : Carbon::now(),
                        'award_matured_date' => $request->award_date ? Carbon::createFromFormat('d/m/Y', $request->award_date)->addDays(14)->toDateTimeString() : Carbon::now()->addDays(14)
                    ]);

                    if ($request->award_type == 10) {
                        $new_award->f10_type_id = $request->f10_type_id;
                        $new_award->save();
                    }

                    $form4->award_id = $new_award->award_id;

                } else if ($request->hearing_position_id == 4) {
                    $form4->hearing_position_reason_id = $request->hearing_position_reason_id;
                } else if ($request->hearing_position_id == 6) {
                    $stop_notice_id = DB::table('stop_notice')->insertGetId([
                        'claim_case_id' => $form4->claim_case_id,
                        'claim_case_opponent_id' => $form4->claim_case_opponent_id,
                        'created_by_user_id' => Auth::id(),
                        'form_status_id' => 57,
                        'stop_notice_date' => $request->stop_notice_date ? Carbon::createFromFormat('d/m/Y', $request->stop_notice_date)->toDateTimeString() : Carbon::now()
                    ]);

                    ClaimCase::find($form4->claim_case_id)->update(['case_status_id' => 8]);
                }

                $c_case = ClaimCase::find($form4->claim_case_id)
                    ->update(['case_status_id' => 8]);
            } else {
                // case is not finished
                $form4->hearing_position_reason_id = $request->hearing_position_reason_id;
                $form4->hearing_details = $request->details;

                $form4_counter = Form4::select(DB::raw('count(*) as total'))
                    ->first();

                if ($request->new_hearing_date) {
                    $new_form4 = new Form4;
                    $new_form4->counter = $form4_counter->total;
                    $new_form4->form12_id = $form4->form12_id;
                    $new_form4->claim_case_id = $form4->case->claim_case_id;
                    $new_form4->claim_case_opponent_id = $form4->claim_case_opponent_id;
                    $new_form4->opponent_user_id = $form4->opponent_user_id;
                    $new_form4->hearing_id = $request->new_hearing_date;
                    $new_form4->created_by_user_id = Auth::id();
                    $new_form4->psu_user_id = Auth::id();
                    $new_form4->save();

                    $form4->hearing_status_id = 2;
                } else {
                    $form4->hearing_status_id = 3;
                }

            }

            $case = ClaimCase::find($form4->claim_case_id);
            if ($request->hearing_position_id == 2) {
                if ($request->hearing_position_reason_id == 9) {
                    $case->update([
                        'transfer_branch_id' => $request->branch_id
                    ]);
                }
            }

            $form4->save();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 4, "Form4Controller", json_encode($request->input()), null, "Entry Hearing Status " . $form4->case->case_no);

            return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
        }
    }

    public function updateSubmitStatus(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_store($request));

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        //dd($request->input());

        if ($request->form4_id != NULL) {
            $form4_update = Form4Update::insertGetId([
                'form4_id' => $request->form4_id,
                'reason' => $request->reason,
                'updated_by_user_id' => Auth::id(),
                'updated_at' => Carbon::now()
            ]);

            $form4 = Form4::find($request->form4_id);
            $form4->president_user_id = $request->president;
            $form4->hearing_status_id = $request->is_finish;
            $form4->hearing_position_id = $request->hearing_position_id;
            $form4->letter_branch_address_id = $request->letter_branch_address_id;
            $form4->letter_court_id = $request->letter_court_id;

            Form4PSU::where('form4_id', $request->form4_id)->delete();

            if ($request->has('psus')) {
                foreach ($request->psus as $psu_user_id) {
                    $form4_psu = new Form4PSU;
                    $form4_psu->form4_id = $request->form4_id;
                    $form4_psu->psu_user_id = $psu_user_id;
                    $form4_psu->save();
                }
            }

            $form4_next = Form4::where('form4_id', '>', $request->form4_id)
                ->where('claim_case_opponent_id', $form4->claim_case_opponent_id)
                ->get();

            if ($form4_next->count() > 0) {
                $form4_next = $form4_next->first();
            } else {
                $form4_next = null;
            }

            if ($form4_next) {
                $award = Award::find($form4_next->award_id);
                $form4_next->award_id = null;
                $form4_next->save();

                if ($award) {
                    $award->delete();
                }
            }

            if ($request->is_finish == 1) {
                $c_case = ClaimCase::find($form4->claim_case_id)->update(['case_status_id' => 8]);

                if ($request->hearing_position_id == 3 || $request->hearing_position_id == 5) {

                    // Create new award and get award_id
                    $award = Award::find($form4->award_id);
                    $form4->award_id = null;
                    $form4->save();

                    if ($award) {
                        $award->delete();
                    }

                    $award_id = DB::table('award')->insertGetId([
                        'award_type' => $request->award_type,
                        'is_display_representative' => $request->is_representative,
                        'award_value' => $request->award_value,
                        'award_cost_value' => $request->cost,
                        'award_obey_duration' => $request->num_period,
                        'award_term_id' => $request->period,
                        'award_description' => $request->award_desc,
                        'award_date' => $request->award_date ? Carbon::createFromFormat('d/m/Y', $request->award_date)->toDateTimeString() : Carbon::now(),
                        'award_matured_date' => $request->award_date ? Carbon::createFromFormat('d/m/Y', $request->award_date)->addDays(14)->toDateTimeString() : Carbon::now()->addDays(14)
                    ]);

                    $new_award = Award::find($award_id);

                    if ($request->award_type == 10) {

                        $new_award->f10_type_id = $request->f10_type_id;
                        $new_award->save();

                        // if($request->f10_type_id == 1) {

                        //     if($form4_next) {
                        //         $new_form4 = $form4_next;
                        //     } else {
                        //         $new_form4 = new Form4;
                        //     }
                        //     $new_form4->claim_case_id = $form4->case->claim_case_id;
                        //     $new_form4->hearing_id = $request->new_hearing_date2;
                        //     $new_form4->created_by_user_id = Auth::id();
                        //     $new_form4->psu_user_id = Auth::id();

                        //     if($request->is_president == 0)
                        //         $new_form4->president_user_id = $request->earlier_president;

                        //     $new_form4->save();
                        // }
                    }

                    $form4->award_id = $award_id;

                } else if ($request->hearing_position_id == 4) {
                    $form4->hearing_position_reason_id = $request->hearing_position_reason_id;
                    $form4->award_id = null;

                } else if ($request->hearing_position_id == 6) {
                    $form4->award_id = null;

                    // Create new award and get award_id
                    $stop_notice = StopNotice::where('claim_case_id', $form4->claim_case_id)->delete();

                    // Create stop notice
                    $stop_notice_id = DB::table('stop_notice')->insertGetId([
                        'claim_case_id' => $form4->claim_case_id,
                        'claim_case_opponent_id' => $form4->claim_case_opponent_id,
                        'created_by_user_id' => Auth::id(),
                        'stop_notice_date' => $request->stop_notice_date ? Carbon::createFromFormat('d/m/Y', $request->stop_notice_date)->toDateTimeString() : Carbon::now()
                    ]);

                    //ClaimCase::find($form4->claim_case->id)->update(['case_status_id'=>8]);
                }
            } else {
                //case is not finished
                $form4->award_id = null;
                $form4->hearing_position_reason_id = $request->hearing_position_reason_id;
                $form4->hearing_details = $request->details;

                if ($form4_next) {
                    $new_form4 = $form4_next;

                    if (!$request->new_hearing_date) {
                        $form4_next->delete();
                        $new_form4 = false;
                    }
                } else {
                    if ($request->new_hearing_date) {
                        $new_form4 = new Form4;
                        $new_form4->created_by_user_id = Auth::id();
                    } else {
                        $new_form4 = false;
                    }
                }

                if ($new_form4) {
                    $new_form4->form12_id = $form4->form12_id;
                    $new_form4->claim_case_id = $form4->case->claim_case_id;
                    $new_form4->claim_case_opponent_id = $form4->claim_case_opponent_id;
                    $new_form4->opponent_user_id = $form4->opponent_user_id;
                    $new_form4->hearing_id = $request->new_hearing_date;
                    $new_form4->psu_user_id = Auth::id();
                    $new_form4->save();
                }
            }

            $form4->save();

            $case = ClaimCase::find($form4->claim_case_id);
            if ($request->hearing_position_id == 2) {
                if ($request->hearing_position_reason_id == 9) {
                    $case->update([
                        'transfer_branch_id' => $request->branch_id
                    ]);
                }
            }

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "Form4Controller", null, null, "Update Hearing Status " . $form4->case->case_no);

            return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
        }
    }

    /**
     * List of hearing status entry.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function updateListStatus(Request $request)
    {
        // RBAC
        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('form4-status-update-list', ['branch' => Auth::user()->ttpm_data->branch_id]);
        } else if ((Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) && !$request->has('branch')) {
            return redirect()->route('form4-status-update-list', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $locale = App::getLocale();

        if ($request->ajax()) {
            $form4 = Form4::with(['case.claimant_address', 'claimCaseOpponent.opponent_address', 'case.form1.classification.category', 'hearing_status', 'hearing'])
                ->whereNotNull('hearing_status_id')
                ->orderBy('created_at', 'desc');

            if ($request->has('hearing_date') && !empty($request->hearing_date))
                $form4->where('hearing_id', $request->hearing_date);

            if ($request->has('branch') && !empty($request->branch)) {
                $form4->whereHas('case', function ($case) use ($request) {
                    return $case->where('branch_id', $request->branch)
                        ->orWhere('transfer_branch_id', $request->branch);
                });
            }

            if ($request->has('year') && !empty($request->year))
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    $date = Carbon::createFromFormat('Y', $request->year);
                    return $hearing->whereBetween('hearing_date', [
                        $date->startOfYear()->toDateString(),
                        $date->endOfYear()->toDateString()
                    ]);
                });

            if ($request->has('month') && !empty($request->month))
                $form4->whereHas('hearing', function ($hearing) use ($request) {
                    $date = Carbon::createFromFormat('Y-m', (($request->has('year') && !empty($request->year)) ? $request->year : date('Y')) . '-' . $request->month);
                    return $hearing->whereBetween('hearing_date', [
                        $date->startOfMonth()->toDateString(),
                        $date->endOfMonth()->toDateString()
                    ]);
                });

            $datatables = Datatables::of($form4);

            return $datatables
                ->editColumn('case_no', function ($form4) {
                    return $form4->case->case_no;
                })
                ->editColumn('hearing_status', function ($form4) use ($locale) {
                    return $form4->hearing_status->{"hearing_status_" . $locale . ($form4->award ? ' (' . __('new.form') . ' ' . $form4->award->award_type . ')' : '')} ?? '-';
                })
                ->editColumn('classification', function ($form4) use ($locale) {
                    return $form4->case->form1->classification->{"classification_" . $locale};
                })
                ->editColumn('claimant_name', function ($form4) {
                    return $form4->case->claimant_address->name ?? '-';
                })
                ->editColumn('opponent_name', function ($form4) {
                    return $form4->claimCaseOpponent->opponent_address->name ?? '-';
                })
                ->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y', strtotime($form4->hearing->hearing_date));
                })
                ->editColumn('action', function ($form4) {
                    $button = "";
                    $button .= actionButton('blue', __('button.view_hearing'), route('form4-status-update-view', ['form4_id' => $form4->form4_id]), false, 'fa fa-search', false);
                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form4Controller", null, null,
            "Datatables load update hearing status list");

        return view("hearing.status.update.list", compact('form4', 'branches', 'years', 'months'));
    }

    public function updateModalStatus(Request $request)
    {
        $url = route('form4-status-update-edit', ['form4_id' => $request->form4_id]);

        return view("hearing.status.update.modal", compact('url'));
    }

    public function updateViewStatus(Request $request)
    {
        $form4 = Form4::find($request->form4_id);

        if ($request->ajax()) {

            $form4 = Form4::with(['hearing', 'hearing_status', 'hearing_position'])
                ->where('claim_case_opponent_id', $form4->claim_case_opponent_id);

            $datatables = Datatables::of($form4);

            return $datatables
                ->editColumn('status', function ($form4) {
                    $locale = App::getLocale();
                    $status_lang = "hearing_status_" . $locale;
                    if ($form4->hearing_status_id)
                        return $form4->hearing_status->$status_lang;
                    else
                        return __('hearing.unprocessed');
                })
                ->editColumn('position', function ($form4) {
                    $locale = App::getLocale();
                    $position_lang = "hearing_position_" . $locale;

                    if ($form4->hearing_position_id)
                        return $form4->hearing_position->$position_lang;
                    else
                        return "-";
                })
                ->editColumn('hearing_date', function ($form4) {
                    return date('d/m/Y h:i A', strtotime($form4->hearing->hearing_date . " " . $form4->hearing->hearing_time));
                })
                ->editColumn('action', function ($form4) {
                    $button = "";

                    if ($form4->hearing_status_id)
                        $button .= '<a class="btn btn-xs green-meadow" rel="tooltip" data-original-title="' . __('button.edit_hearing_status') . '" href="javascript:;" onclick="updateModal(' . $form4->form4_id . ')"><i class="fa fa fa-edit"></i>' . __('button.edit_hearing_status') . '</a>';

                    if ($form4->hearing_status_id == 1) {
                        //Surat Dibatalkan
                        if ($form4->hearing_position_id == 4) {
                            $button .= downloadButton(__('form4.canceled_letter'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 8, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 8, "format" => "docx"]), 'dark');
                            // $button .= actionButton('dark', __('button.download'), route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>8, "format"=>"pdf"]), false, 'fa fa-download', false, __('form4.canceled_letter'));
                        }

                        if ($form4->award_id) {
                            /**
                             * Surat Serahan Award
                             *
                             * Form4 have award_id
                             * and
                             *      user is claimant
                             *      or user is not public
                             */
                            $button .= downloadButton(__('form4.award_submission_letter'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 7, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 7, "format" => "docx"]), 'dark');

                            /**
                             * Surat Bersama Award P
                             *
                             * Form4 have award_id
                             * and
                             *      user is claimant
                             *      or user is not public
                             */
                            if ($form4->case->opponent_user_id == Auth::id() || Auth::user()->user_type_id != 3) {
                                if (in_array($form4->award->award_type, [9, 10])) {
                                    $button .= downloadButton(__('form4.letter_with_award_p'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 5, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 9, "format" => "docx"]), 'dark');
                                } else {
                                    $button .= downloadButton(__('form4.letter_with_award_p'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 5, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 5, "format" => "docx"]), 'dark');
                                }
                            }

                            /**
                             * Surat Bersama Award PYM
                             *
                             * Form4 have award_id
                             * and
                             *      user is claimant
                             *      or user is not public
                             */
                            if ($form4->case->claimant_user_id == Auth::id() || Auth::user()->user_type_id != 3) {
                                if (in_array($form4->award->award_type, [9, 10])) {
                                    $button .= downloadButton(__('form4.letter_with_award_pym'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 6, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 10, "format" => "docx"]), 'dark');
                                } else {
                                    $button .= downloadButton(__('form4.letter_with_award_pym'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 6, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 6, "format" => "docx"]), 'dark');
                                }
                            }


                            //Award
                            if ($form4->award->award_type != 10)
                                $button .= downloadButton(__('new.form') . ' ' . $form4->award->award_type, route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "pdf"]), route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "docx"]), 'dark');
                            // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>$form4->award->award_type, "format"=>"pdf"]), false, 'fa fa-download', false, __('new.form').' '.$form4->award->award_type);

                            //Award B10
                            if ($form4->award->f10_type_id == 2)
                                $button .= downloadButton(__('new.form') . ' ' . $form4->award->award_type, route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "pdf"]), route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "docx"]), 'dark');
                            // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>$form4->award->award_type, "format"=>"pdf"]), false, 'fa fa-download', false, __('new.form').' '.$form4->award->award_type);

                            elseif ($form4->award->f10_type_id == 1)
                                $button .= downloadButton(__('new.form') . ' ' . $form4->award->award_type . 'K', route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type . 'k', "format" => "pdf"]), route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type . 'k', "format" => "docx"]), 'dark');
                            // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>$form4->award->award_type.'k', "format"=>"pdf"]), false, 'fa fa-download', false, __('new.form').' '.$form4->award->award_type.'K');

                            elseif ($form4->award->f10_type_id == 4)
                                $button .= downloadButton(__('new.form') . ' ' . $form4->award->award_type . 'B', route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "pdf"]), route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "docx"]), 'dark');
                            // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>$form4->award->award_type.'k', "format"=>"pdf"]), false, 'fa fa-download', false, __('new.form').' '.$form4->award->award_type.'B');

                            //Surat Ditolak
                            elseif ($form4->award->f10_type_id == 3) {
                                $button .= downloadButton(__('new.form') . ' ' . $form4->award->award_type . 'T', route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "pdf"]), route("form4-export", ["form4_id" => $form4->form4_id, "form_no" => $form4->award->award_type, "format" => "docx"]), 'dark');
                                // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export", ["form4_id"=>$form4->form4_id, "form_no"=>$form4->award->award_type.'k', "format"=>"pdf"]), false, 'fa fa-download', false, __('new.form').' '.$form4->award->award_type.'T');

                                $button .= downloadButton(__('form4.form10_rejected'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 3, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 3, "format" => "docx"]), 'dark');
                                // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>3, "format"=>"pdf"]), false, 'fa fa-download', false, __('form4.form10_rejected'));
                            }


                        }
                    }

                    if ($form4->hearing_status_id == 2) {
                        //Surat Tangguh
                        $button .= downloadButton(__('form4.postponed'), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 4, "format" => "pdf"]), route("form4-export-letter", ["form4_id" => $form4->form4_id, "letter" => 4, "format" => "docx"]), 'dark');
                        // $button .= '<br>'.actionButton('dark', __('button.download'), route("form4-export-letter", ["form4_id"=>$form4->form4_id, "letter"=>4, "format"=>"pdf"]), false, 'fa fa-download', false, __('form4.postponed'));
                    }


                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "Form4Controller", null, null, "Datatables load hearing status " . $form4->case->case_no);

        return view("hearing.status.update.view", compact('form4'));
    }

}
