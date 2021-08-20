<?php

namespace App\Http\Controllers\ClaimCase;

use App\CaseModel\ClaimCaseOpponent;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\GeneralController;
use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\User;
use App\RoleUser;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterStopType;
use App\MasterModel\MasterStopMethod;
use App\MasterModel\MasterStopReason;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterBranch;
use App\CaseModel\ClaimCase;
use App\SupportModel\Address;
use App\SupportModel\Attachment;
use App\CaseModel\StopNotice;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use PDF;
use App;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class StopNoticeController extends Controller
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
     * Create a new controller instance.
     *
     * @return void
     */

    protected function rules_insert()
    {

        $rules = [
            'claim_case_id' => 'required|integer',
            'stop_notice_method_id' => 'required|integer',
            'stop_notice_reason_id' => 'required|integer',
            'stop_notice_reason_desc' => 'required'
        ];

        return $rules;
    }

    protected function rules_update()
    {

        $rules = [
            'claim_case_id' => 'required|integer',
            'stop_notice_method_id' => 'required|integer',
            'stop_notice_reason_id' => 'required|integer',
            'stop_notice_reason_desc' => 'required'
        ];

        return $rules;
    }

    protected function rules_finalize()
    {

        $rules = [
            'processed_at' => 'required',
            'form_status_id' => 'required|integer'
        ];

        return $rules;
    }

    public function list(Request $request)
    {
        $status = MasterFormStatus::where('form_status_id', 26)->orWhere('form_status_id', 27)->orWhere('form_status_id', 57)->get();
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.stop_notice', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {
            $userid = Auth::id();
            $user = User::find($userid);

            if (Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin')) {
                $stop_notice = StopNotice::with(['case.form1', 'status', 'method'])
                    ->orderBy('stop_notice.created_at', 'desc');
            } else if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) {
                $stop_notice = StopNotice::with(['case.form1', 'status', 'method'])
                    ->orderBy('stop_notice.created_at', 'desc')
                    ->whereHas('case', function ($case) use ($request, $user) {
                        return $case->where('branch_id', $user->ttpm_data->branch_id);
                    });
            } else {
                $stop_notice = StopNotice::with(['case.form1', 'status', 'method'])
                    ->orderBy('created_at', 'desc')
                    ->whereHas('case', function ($case) use ($userid) {
                        return $case->where('claimant_user_id', $userid);
                    });
            }

            //Check for filteration
            if ($request->has('status') || $request->has('branch') || $request->has('year') || $request->has('month')) {

                if ($request->has('status') && !empty($request->status)) {
                    $stop_notice->where('form_status_id', $request->status);
                }

                if ($request->has('branch') && !empty($request->branch)) {
                    $stop_notice->whereHas('case', function ($case) use ($request) {
                        return $case->where('branch_id', $request->branch);
                    });
                }

                if ($request->has('year') && !empty($request->year)) {
                    $stop_notice->whereYear('stop_notice_date', $request->year);
                }

                if ($request->has('month') && !empty($request->month)) {
                    $stop_notice->whereMonth('stop_notice_date', $request->month);
                }
            }

            $datatables = Datatables::of($stop_notice);

            return $datatables
                ->addIndexColumn()
                ->editColumn('case_no', function ($stop_notice) {
                    //return $stop_notice->case->case_no;
                    return "<a class='' href='" . route('claimcase-view', [$stop_notice->case->claim_case_id]) . "'> " . $stop_notice->case->case_no . "</a>";
                })
                ->editColumn('filing_date', function ($stop_notice) {
                    return date('d/m/Y', strtotime($stop_notice->stop_notice_date));
                })
                ->editColumn('processed_at', function ($stop_notice) {
                    if ($stop_notice->form_status_id == 27)
                        return date('d/m/Y', strtotime($stop_notice->processed_at));
                    else return "-";
                })
                ->editColumn('form_status_id', function ($stop_notice) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    return $stop_notice->status->$status_lang;
                })
                ->editColumn('stop_notice_method_id', function ($stop_notice) {
                    $locale = App::getLocale();
                    $method_lang = "stop_method_" . $locale;
                    return $stop_notice->method->$method_lang;
                })
                ->editColumn('action', function ($stop_notice) {
                    $userid = Auth::id();
                    $user = User::find($userid);

                    $button = "";

                    $button .= actionButton('blue', __('button.view'), route('stopnotice-view', ['stop_notice_id' => $stop_notice->stop_notice_id]), false, 'fa-search', false);

                    if ($stop_notice->form_status_id == 26)
                        $button .= actionButton('green-meadow', __('button.edit'), route('stopnotice-edit', ['stop_notice_id' => $stop_notice->stop_notice_id]), false, 'fa-edit', false);

                    if ($stop_notice->form_status_id == 26 && $user->user_type_id != 3)
                        $button .= '<a class="btn btn-xs purple" rel="tooltip" data-original-title="' . __('button.process') . '" onclick="processStopNotice(' . $stop_notice->stop_notice_id . ')"><i class="fa fa-spinner"></i></a>';

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "StopNoticeController", null, null, "Datatables load stop notice");

        return view("claimcase/stop_notice/list", compact('status', 'branches', 'years', 'months'));
    }


    public function view(Request $request, $id)
    {
        if ($id) {
            $stop_notice = StopNotice::find($id);
            $attachments = Attachment::where('form_no', 10)->where('form_id', $id)->get();
            $audit = new AuditController;
            $audit->add($request, 3, "StopNoticeController", null, null, "View stop notice " . $stop_notice->case->case_no);
            return view('claimcase/stop_notice/view', compact('stop_notice', 'attachments'), ['id' => $id])->render();
        }
    }

    public function find(Request $request)
    {
        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);

            $case = ClaimCaseOpponent::select([
                'claim_case.claim_case_id',
                'claim_case_opponents.id',
                'claim_case_opponents.opponent_address_id',
                'claim_case.filing_date',
            ])
                ->join('claim_case', 'claim_case.claim_case_id', '=', 'claim_case_opponents.claim_case_id')
                ->join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case.claim_case_id')
                ->orderBy('case_year', 'desc')
                ->orderBy('case_sequence', 'desc')
                ->with([
                    'claimCase.form1',
                    'opponent_address'
                ])
                ->where('case_status_id', '>', 1)
                ->doesntHave('stopNotice')
                ->where(function ($case) {
                    return $case->whereDoesntHave('form4')
                        ->orWhereHas('form4Latest.form4', function ($form4_latest) {
                            return $form4_latest->where('hearing_status_id', '<>', 1)
                                ->orWhereNull('hearing_status_id');
                        });
                });

            if (Auth::user()->hasRole('user')) {
                $case->whereHas('claimCase', function ($q) use ($userid) {
                    $q->where('claimant_user_id', $userid);
                });
            } else {
                $case->whereHas('claimCase', function ($q) use ($userid) {
                    $q->where('branch_id', Auth::user()->ttpm_data->branch_id);
                });
            }

            $datatables = Datatables::of($case);

            return $datatables
                ->editColumn('case_no', function ($case) {
                    return $case->claimCase->case_no;
                })
                ->editColumn('filing_date', function ($case) {
                    if ($case->claimCase->form1->filing_date) {
                        return date('d/m/Y', strtotime($case->claimCase->form1->filing_date));
                    } else {
                        return "-";
                    }
                })
                ->editColumn('opponent_name', function ($case) {
                    return $case->opponent_address->name ?? '-';
                })
                ->editColumn('action', function ($case) {
                    $button = '';
                    $button .= actionButton('green-meadow', __('new.register_stop_notice'), route('stopnotice-create', ['claim_case_id' => $case->id]), false, 'fa-edit', false);

                    return $button;
                })
                ->make(true);
        }
        $audit = new AuditController;
        $audit->add($request, 12, "StopNoticeController", null, null, "Datatables load cases that can file stop notice");
        return view("claimcase/stop_notice/list2", compact('case'));
    }

    public function create(Request $request)
    {
        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id == 2 || $user->user_type_id == 1) {
            $is_staff = true;
        } else {
            $is_staff = false;
        }

        if ($is_staff) {
            $case = ClaimCaseOpponent::with('claimCase')->where('id', $request->claim_case_id)->first();
        } else {
            $userid = Auth::id();
            $case = ClaimCaseOpponent::with('claimCase')
                ->whereHas('claimCase', function ($q) use ($userid) {
                    $q->where('claimant_user_id', $userid);
                })
                ->where('id', $request->claim_case_id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        if (!$case) {
            return Redirect::route('stopnotice-find')->with("message", __('swal.claim_not_exist'));
        } else {
            $stop_notice = StopNotice::where('claim_case_opponent_id', $case->id)->first();

            if (!$stop_notice) {
                $stop_notice = new StopNotice;
                $stop_notice_date = date('d/m/Y');
                $stop_reasons = MasterStopReason::where('is_active', 1)->get();
                $stop_methods = MasterStopMethod::where('is_active', 1)->get();
                $attachments = null;

                $audit = new AuditController;
                $audit->add($request, 9, "StopNoticeController", null, null, "View stop notice form");

                return view("claimcase/stop_notice/create", compact('stop_notice', 'case', 'stop_reasons', 'stop_methods', 'attachments', 'is_staff', 'stop_notice_date'));
            } else {
                return Redirect::route('stopnotice-find')->with("message", __('swal.already_has_stopnotice'));
            }
        }

    }

    public function edit($id)
    {
        if ($id) {
            $userid = Auth::id();
            $user = User::find($userid);

            if ($user->user_type_id != 3) {
                $is_staff = true;
            } else {
                $is_staff = false;
            }


            $stop_notice = StopNotice::where('stop_notice_id', '=', $id)->first();
            $case = ClaimCaseOpponent::where('id', $stop_notice->claim_case_opponent_id)->first();

            $stop_notice_date = date('d/m/Y', strtotime($stop_notice->stop_notice_date));
            $stop_reasons = MasterStopReason::where('is_active', 1)->get();
            $stop_methods = MasterStopMethod::where('is_active', 1)->get();
            $attachments = Attachment::where('form_no', 10)->where('form_id', $id)->get();

            if (!is_null($stop_notice)) {
                return view("claimcase/stop_notice/create", compact('stop_notice', 'case', 'stop_reasons', 'stop_methods', 'attachments', 'is_staff', 'stop_notice_date'));
            }
        }

    }

    public function process($id)
    {
        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id != 3) {
            $is_staff = true;
        } else {
            $is_staff = false;
        }

        $stop_notice = StopNotice::find($id);

        return view('claimcase/stop_notice/modalProcess', compact('stop_notice', 'is_staff'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_insert());

        if ($request->stop_notice_id == NULL) {

            if ($validator->passes()) {
                $stop_notice_data = DB::table('stop_notice')
                    ->insertGetId([
                        'claim_case_id' => $request->claim_case_id,
                        'claim_case_opponent_id' => $request->claim_case_opponent_id,
                        'stop_notice_method_id' => $request->stop_notice_method_id,
                        'stop_notice_reason_id' => $request->stop_notice_reason_id,
                        'stop_notice_reason_desc' => $request->stop_notice_reason_desc,
                        'requested_by_user_id' => $request->requested_by_user_id,
                        'stop_notice_date' => $request->stop_notice_date
                            ? Carbon::createFromFormat('d/m/Y', $request->stop_notice_date)->toDateTimeString()
                            : NULL,
                        'created_by_user_id' => Auth::id()
                    ]);

                $form_no = 10;
                $userid = Auth::id();

                $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $request->stop_notice_id)->get();

                if ($request->stop_notice_id) {

                    if ($request->hasFile('attachment_1')) {
                        if ($request->file('attachment_1')->isValid()) {

                            if ($oldAttachments->get(0)) {
                                if ($request->file1_info == 2) {
                                    // Replace
                                    $oldAttachments->get(0)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_1);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file1_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_1);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new AuditController;
                            $audit->add($request, 4, "StopNoticeController", json_encode($request->input()), null, "Stop Notice " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
                        }
                    } else {
                        if ($oldAttachments->get(0)) {
                            if ($request->file1_info == 2) {
                                $oldAttachments->get(0)->delete();
                            }
                        }
                    }

                    if ($request->hasFile('attachment_2')) {
                        if ($request->file('attachment_2')->isValid()) {

                            if ($oldAttachments->get(1)) {
                                if ($request->file2_info == 2) {
                                    // Replace
                                    $oldAttachments->get(1)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_2);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file2_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_2);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new AuditController;
                            $audit->add($request, 4, "StopNoticeController", json_encode($request->input()), null, "Stop Notice " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");
                        }
                    } else {
                        if ($oldAttachments->get(1)) {
                            if ($request->file2_info == 2) {
                                $oldAttachments->get(1)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_3')) {
                        if ($request->file('attachment_3')->isValid()) {

                            if ($oldAttachments->get(2)) {
                                if ($request->file3_info == 2) {
                                    // Replace
                                    $oldAttachments->get(2)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_3);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file3_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_3);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new AuditController;
                            $audit->add($request, 4, "StopNoticeController", json_encode($request->input()), null, "Stop Notice " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");

                        }
                    } else {
                        if ($oldAttachments->get(2)) {
                            if ($request->file3_info == 2) {
                                $oldAttachments->get(2)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_4')) {
                        if ($request->file('attachment_4')->isValid()) {

                            if ($oldAttachments->get(3)) {
                                if ($request->file4_info == 2) {
                                    // Replace
                                    $oldAttachments->get(3)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file4_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }

                            $audit = new AuditController;
                            $audit->add($request, 4, "StopNoticeController", json_encode($request->input()), null, "Stop Notice " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");
                        }
                    } else {
                        if ($oldAttachments->get(3)) {
                            if ($request->file4_info == 2) {
                                $oldAttachments->get(3)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_5')) {
                        if ($request->file('attachment_5')->isValid()) {

                            if ($oldAttachments->get(4)) {
                                if ($request->file5_info == 2) {
                                    // Replace
                                    $oldAttachments->get(4)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file5_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }
                            $audit = new AuditController;
                            $audit->add($request, 4, "StopNoticeController", json_encode($request->input()), null, "Stop Notice " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");

                        }
                    } else {
                        if ($oldAttachments->get(4)) {
                            if ($request->file5_info == 2) {
                                $oldAttachments->get(4)->delete();
                            }
                        }
                    }
                }
                $audit = new AuditController;
                $audit->add($request, 4, "StopNoticeController", json_encode($request->input()), null, "Stop Notice " . $stop_notice_data . " - Create stop notice");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);

            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_update());

        if ($request->stop_notice_id != NULL) {

            if ($validator->passes()) {
                $stop_notice_data = StopNotice::find($request->stop_notice_id)->update([
                    'claim_case_id' => $request->claim_case_id,
                    'claim_case_opponent_id' => $request->claim_case_opponent_id,
                    'stop_notice_method_id' => $request->stop_notice_method_id,
                    'stop_notice_reason_id' => $request->stop_notice_reason_id,
                    'stop_notice_reason_desc' => $request->stop_notice_reason_desc,
                    'requested_by_user_id' => $request->requested_by_user_id,
                    'stop_notice_date' => $request->stop_notice_date ? Carbon::createFromFormat('d/m/Y', $request->stop_notice_date)->toDateTimeString() : NULL,
                    'created_by_user_id' => Auth::id()
                ]);

                ///////////////////////////// ATTACHMENT part //////////////////////////////
                $form_no = 10;
                $userid = Auth::id();

                //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

                $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $request->stop_notice_id)->get();

                if ($request->stop_notice_id) {

                    if ($request->hasFile('attachment_1')) {
                        if ($request->file('attachment_1')->isValid()) {

                            if ($oldAttachments->get(0)) {
                                if ($request->file1_info == 2) {
                                    // Replace
                                    $oldAttachments->get(0)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_1);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file1_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_1);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }


                        }
                    } else {
                        if ($oldAttachments->get(0)) {
                            if ($request->file1_info == 2) {
                                $oldAttachments->get(0)->delete();
                            }
                        }
                    }

                    if ($request->hasFile('attachment_2')) {
                        if ($request->file('attachment_2')->isValid()) {

                            if ($oldAttachments->get(1)) {
                                if ($request->file2_info == 2) {
                                    // Replace
                                    $oldAttachments->get(1)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_2);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file2_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_2);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }


                        }
                    } else {
                        if ($oldAttachments->get(1)) {
                            if ($request->file2_info == 2) {
                                $oldAttachments->get(1)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_3')) {
                        if ($request->file('attachment_3')->isValid()) {

                            if ($oldAttachments->get(2)) {
                                if ($request->file3_info == 2) {
                                    // Replace
                                    $oldAttachments->get(2)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_3);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file3_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_3);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }


                        }
                    } else {
                        if ($oldAttachments->get(2)) {
                            if ($request->file3_info == 2) {
                                $oldAttachments->get(2)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_4')) {
                        if ($request->file('attachment_4')->isValid()) {

                            if ($oldAttachments->get(3)) {
                                if ($request->file4_info == 2) {
                                    // Replace
                                    $oldAttachments->get(3)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file4_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_4);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }


                        }
                    } else {
                        if ($oldAttachments->get(3)) {
                            if ($request->file4_info == 2) {
                                $oldAttachments->get(3)->delete();
                            }
                        }
                    }


                    if ($request->hasFile('attachment_5')) {
                        if ($request->file('attachment_5')->isValid()) {

                            if ($oldAttachments->get(4)) {
                                if ($request->file5_info == 2) {
                                    // Replace
                                    $oldAttachments->get(4)->delete();

                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            } else {
                                if ($request->file5_info == 2) {
                                    // Add
                                    $attachment = new Attachment;
                                    $attachment->form_no = $form_no;
                                    $attachment->form_id = $request->stop_notice_id;
                                    $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                    $attachment->file_blob = file_get_contents($request->attachment_5);
                                    $attachment->created_by_user_id = $userid;
                                    $attachment->mime = mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                                    $attachment->created_at = Carbon::now();
                                    $attachment->updated_at = Carbon::now();
                                    $attachment->save();
                                }
                            }


                        }
                    } else {
                        if ($oldAttachments->get(4)) {
                            if ($request->file5_info == 2) {
                                $oldAttachments->get(4)->delete();
                            }
                        }
                    }
                }

                $audit = new AuditController;
                $audit->add($request, 5, "StopNoticeController", null, null, "Update stop notice " . $request->stop_notice_id);
                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function finalize(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_finalize());

        if ($request->stop_notice_id != NULL) {

            if ($validator->passes()) {

                $stop_notice = StopNotice::find($request->stop_notice_id)->update([
                    'processed_at' => $request->processed_at ? Carbon::createFromFormat('d/m/Y', $request->processed_at)->toDateTimeString() : NULL,
                    'processed_by_user_id' => $request->processed_by_user_id,
                    'form_status_id' => $request->form_status_id
                ]);
                $stop_notice = StopNotice::find($request->stop_notice_id);
                $replacing = ClaimCase::where('claim_case_id', '=', $stop_notice->claim_case_id)->first();
                $replacing->update([
                    "case_status_id" => 8,
                ]);

                return Response::json(['result' => 'Success', 'message' => __('new.create_success')]);

            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }

    }

    public function export(Request $request, $stop_notice_id, $type, $format)
    {
        $stop_notice = StopNotice::with('case', 'multiOpponents')
            ->find($stop_notice_id);

        if ($format == 'pdf') {
            if ($type == 'notice') {
                $this->data['stop_notice'] = $stop_notice;
                LogAuditRepository::store($request, 17, "StopNoticeController", $stop_notice->case->case_no, null, "Download Stop Notice (PDF)");

                $pdf = PDF::loadView('claimcase/stop_notice/printstopnotice' . App::getLocale(), $this->data);
                $pdf->setOption('enable-javascript', true);
                return $pdf->download('Notis Henti ' . $stop_notice->case->case_no . '.pdf');
            } else if ($type == 'letter') {

                $this->data['stop_notice'] = $stop_notice = StopNotice::find($stop_notice_id);

                $hearing_date = null;

                if ($stop_notice->case->form4_latest->form4) {
                    // if($stop_notice->case->form4_latest->form4->hearing_status_id) {
                    $hearing_date = $stop_notice->case->form4_latest->form4->hearing->hearing_date;
                    // }
                }

                $this->data['hearing_date'] = $hearing_date;

                $audit = new AuditController;
                $audit->add($request, 17, "StopNoticeController", $stop_notice->case->case_no, null, "Download Letter for Stop Notice (PDF)");

                $pdf = PDF::loadView('claimcase/stop_notice/surat_iringan_' . App::getLocale(), $this->data);
                $pdf->setOption('enable-javascript', true);
                return $pdf->download('Surat Iringan Notis Henti ' . $stop_notice->case->case_no . '.pdf');
            }

        } else if ($format == 'docx') {

            if ($type == 'notice') {

                $gen = new GeneralController;
                $file = $gen->integrateDocTemplate('stop_notice_' . App::getLocale(), [
                    "hearing_venue" => $stop_notice->case->branch->branch_name,
                    "state_name" => $stop_notice->case->branch->state->state,
                    "case_no" => $stop_notice->case->case_no,
                    "claimant_name" => htmlspecialchars($stop_notice->case->claimant_address->name),
                    "claimant_identification_type" => $stop_notice->case->claimant_address->nationality_country_id == 129 ? __('new.nric') : __('new.passport'),
                    "claimant_identification_no" => htmlspecialchars($stop_notice->case->claimant_address ? $stop_notice->case->claimant_address->identification_no : ''),
                    "opponent_name" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->name : ''),
                    "opponent_identification_type" => $stop_notice->multiOpponents->opponent_address->is_company == 0 ? ($stop_notice->multiOpponents->opponent_address->nationality_country_id == 129 ? __('new.nric') : __('new.passport')) : __('form1.company_no'),
                    "opponent_identification_no" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->identification_no : '-'),
                    "opponent_address1" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->street_1 ? htmlspecialchars($stop_notice->multiOpponents->opponent_address->street_1) : '') : '',
                    "opponent_address2" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->street_2 ? htmlspecialchars($stop_notice->multiOpponents->opponent_address->street_2) : '') : '',
                    "opponent_address3" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->street_3 ? htmlspecialchars($stop_notice->multiOpponents->opponent_address->street_3) : '') : '',
                    "opponent_postcode" => $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->postcode : '',
                    "opponent_district" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->distric ? $stop_notice->multiOpponents->opponent_address->district->district : '') : '',
                    "opponent_state" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->state ? $stop_notice->multiOpponents->opponent_address->state->state : '') : '',
                    "psu_name" => htmlspecialchars(strtoupper($stop_notice->processed_by ? $stop_notice->processed_by->name : 'SUPERADMIN')),
                    "psu_role_en" => $stop_notice->processed_by ? strtoupper($stop_notice->processed_by->roleuser->first()->role->display_name_en) : 'SUPERADMIN',
                    "psu_role_my" => $stop_notice->processed_by ? strtoupper($stop_notice->processed_by->roleuser->first()->role->display_name_my) : 'PENTADBIR',
                    "today_day" => localeDay(date('l')),
                    "today_month" => localeMonth(date('F')),
                    "today_year" => date('Y'),
                    "today_date" => date('d') . ' ' . localeMonth(date('F')) . ' ' . date('Y'),
                    "application_date" => date('j', strtotime($stop_notice->stop_notice_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($stop_notice->stop_notice_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($stop_notice->stop_notice_date . ' 00:00:00')),
                    "branch_myaddress" => $stop_notice->case->branch->branch_address ? $stop_notice->case->branch->branch_address : '',
                    "branch_address2" => $stop_notice->case->branch->branch_address2 ? $stop_notice->case->branch->branch_address2 : '',
                    "branch_address3" => $stop_notice->case->branch->branch_address3 ? $stop_notice->case->branch->branch_address3 : '',
                    "branch_enaddress" => $stop_notice->case->branch->branch_address_en ? $stop_notice->case->branch->branch_address_en : '',
                    "branch_en_address2" => $stop_notice->case->branch->branch_address2_en ? $stop_notice->case->branch->branch_address2_en : '',
                    "branch_en_address3" => $stop_notice->case->branch->branch_address3_en ? $stop_notice->case->branch->branch_address3_en : '',
                    "branch_postcode" => $stop_notice->case->branch->branch_postcode ? $stop_notice->case->branch->branch_postcode : '',
                    "branch_district" => $stop_notice->case->branch->district->district ? $stop_notice->case->branch->district->district : '',
                    "branch_state" => $stop_notice->case->branch->state->state ? $stop_notice->case->branch->state->state : '',
                    "extra_name" => $stop_notice->case->extra_claimant ? '/n /n' . $stop_notice->case->extra_claimant->name : '',
                    "extra_claimant_ic" => $stop_notice->case->extra_claimant ? ($stop_notice->case->extra_claimant->nationality_country_id == 129 ? __('new.nric') . ': ' : __('new.passport') . ': ') : '',
                ]);

                $audit = new AuditController;
                $audit->add($request, 17, "StopNoticeController", $stop_notice->case->case_no, null, "Download Letter for Stop Notice (DOCX)");

                return response()->download($file, 'Notis Henti ' . $stop_notice->case->case_no . '.docx')->deleteFileAfterSend(true);
            } elseif ($type == 'letter') {

                $hearing_date = null;
                $letter_name = 'surat_iringan_short_' . App::getLocale();

                if ($stop_notice->case->form4_latest->form4) {
                    // if($stop_notice->case->form4_latest->form4->hearing_status_id) {
                    $letter_name = 'surat_iringan_' . App::getLocale();
                    $hearing_date = $stop_notice->case->form4_latest->form4->hearing->hearing_date;
                    // }
                }

                $gen = new GeneralController;
                $file = $gen->integrateDocTemplate($letter_name, [
                    "case_no" => $stop_notice->case->case_no,
                    "claimant_name" => htmlspecialchars($stop_notice->case->claimant_address->name),
                    "claimant_identification_type" => $stop_notice->case->claimant_address->nationality_country_id == 129 ? __('new.nric') : __('new.passport'),
                    "claimant_identification_no" => htmlspecialchars($stop_notice->case->claimant_address ? $stop_notice->case->claimant_address->identification_no : ''),
                    "claimant_address1" => $stop_notice->case->claimant_address->street_1 ? htmlspecialchars($stop_notice->case->claimant_address->street_1) : '',
                    "claimant_address2" => $stop_notice->case->claimant_address->street_2 ? htmlspecialchars($stop_notice->case->claimant_address->street_2) : '',
                    "claimant_address3" => $stop_notice->case->claimant_address->street_3 ? htmlspecialchars($stop_notice->case->claimant_address->street_3) : '',
                    "claimant_postcode" => $stop_notice->case->claimant_address->postcode ? $stop_notice->case->claimant_address->postcode : '',
                    "claimant_district" => $stop_notice->case->claimant_address->district ? $stop_notice->case->claimant_address->district->district : '',
                    "claimant_state" => $stop_notice->case->claimant_address->state ? $stop_notice->case->claimant_address->state->state : '',
                    "opponent_name" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->name : ''),
                    "opponent_identification_type" => $stop_notice->multiOpponents->opponent_address->is_company == 0 ? ($stop_notice->multiOpponents->opponent_address->nationality_country_id == 129 ? __('new.nric') : __('new.passport')) : __('form1.company_no'),
                    "opponent_identification_no" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->identification_no : '-'),
                    "opponent_address1" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->street_1 ? $stop_notice->multiOpponents->opponent_address->street_1 : '') : ''),
                    "opponent_address2" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->street_2 ? $stop_notice->multiOpponents->opponent_address->street_2 : '') : ''),
                    "opponent_address3" => htmlspecialchars($stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->street_3 ? $stop_notice->multiOpponents->opponent_address->street_3 : '') : ''),
                    "opponent_postcode" => $stop_notice->multiOpponents->opponent_address ? $stop_notice->multiOpponents->opponent_address->postcode : '',
                    "opponent_district" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->distric ? $stop_notice->multiOpponents->opponent_address->district->district : '') : '',
                    "opponent_state" => $stop_notice->multiOpponents->opponent_address ? ($stop_notice->multiOpponents->opponent_address->state ? $stop_notice->multiOpponents->opponent_address->state->state : '') : '',
                    "psu_name" => htmlspecialchars(strtoupper($stop_notice->processed_by ? $stop_notice->processed_by->name : 'SUPERADMIN')),
                    "psu_role_en" => $stop_notice->processed_by ? strtoupper($stop_notice->processed_by->roleuser->first()->role->display_name_en) : 'SUPERADMIN',
                    "psu_role_my" => $stop_notice->processed_by ? strtoupper($stop_notice->processed_by->roleuser->first()->role->display_name_my) : 'PENTADBIR',
                    "today_day" => localeDay(date('l')),
                    "today_month" => localeMonth(date('F')),
                    "today_year" => date('Y'),
                    "today_date" => date('d') . ' ' . localeMonth(date('F')) . ' ' . date('Y'),
                    "application_date" => date('j', strtotime($stop_notice->stop_notice_date . ' 00:00:00')) . ' ' . localeMonth(date('F', strtotime($stop_notice->stop_notice_date . ' 00:00:00'))) . ' ' . date('Y', strtotime($stop_notice->stop_notice_date . ' 00:00:00')),
                    "hearing_date" => $hearing_date ? date('d', strtotime($hearing_date)) . ' ' . localeMonth(date('F', strtotime($hearing_date))) . ' ' . date('Y', strtotime($hearing_date)) : '-',
                    "hearing_day" => $hearing_date ? localeDay(date('l', strtotime($hearing_date))) : '-',
                ]);

                $audit = new AuditController;
                $audit->add($request, 17, "StopNoticeController", $stop_notice->case->case_no, null, "Download Letter for Stop Notice (DOCX)");

                return response()->download($file, 'Notis Henti ' . $stop_notice->case->case_no . '.docx')->deleteFileAfterSend(true);
            }

        }

    }


}
