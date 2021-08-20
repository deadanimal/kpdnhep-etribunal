<?php

namespace App\Http\Controllers\ClaimCase;

use App;
use App\CaseModel\AwardDisobey;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form4;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterApplicationMethod;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterFormStatus;
use App\SupportModel\Attachment;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PDF;
use Yajra\Datatables\Datatables;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class AwardDisobeyController extends Controller
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


    public function list(Request $request)
    {

        $status = MasterFormStatus::whereIn('form_status_id', [28, 29])->get();
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc');

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.award_disobey', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('psu')) {
            $branches->where('branch_id', Auth::user()->ttpm_data->branch_id);
        }

        $branches = $branches->get();

        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);

            if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('psu')) {
                $award_disobey = AwardDisobey::with(['form4.case', 'status', 'method'])->orderBy('award_disobey.created_at', 'desc');
                // $award_disobey = $award_disobey->filter(function ($value) use ($user) {
                //     return $value->form4->case->branch_id == $user->ttpm_data->branch_id;
                // });
                $award_disobey->whereHas('form4', function ($form4) use ($user) {
                    return $form4->whereHas('case', function ($case) use ($user) {
                        return $case->where('branch_id', $user->ttpm_data->branch_id);
                    });
                });
            } else if (Auth::user()->hasRole('user')) {
                $award_disobey = AwardDisobey::with(['form4.case', 'status', 'method'])->orderBy('created_at', 'desc');
                // $award_disobey = $award_disobey->filter(function ($value) use ($userid) {
                //     return $value->form4->case->claimant_user_id == $userid;
                // });
                $award_disobey->whereHas('form4', function ($form4) use ($userid) {
                    return $form4->whereHas('case', function ($case) use ($userid) {
                        return $case->where('claimant_user_id', $userid);
                    });
                });
            } else
                $award_disobey = AwardDisobey::with(['form4.case', 'status', 'method'])->orderBy('award_disobey.created_at', 'desc');
            //$stop_notice = StopNotice::whereNotNull('claim_case_id')->get();

            //Check for filteration
            if ($request->has('status') || $request->has('branch')) {

                if ($request->has('status') && !empty($request->status))
                    $award_disobey->where('form_status_id', $request->status);
                // = $award_disobey->filter(function ($value) use ($request) {
                //     return $value->form_status_id == $request->status;
                // });

                if ($request->has('branch') && !empty($request->branch))
                    $award_disobey->whereHas('form4', function ($form4) use ($request) {
                        return $form4->whereHas('case', function ($case) use ($request) {
                            return $case->where('branch_id', $request->branch);
                        });
                    });
                // $award_disobey = $award_disobey->filter(function ($value) use ($request) {
                //     return $value->form4->case->branch_id == $request->branch;
                // });
            }

            $datatables = Datatables::of($award_disobey);

            return $datatables
                ->editColumn('case_no', function ($award_disobey) {
                    //return $award_disobey->form4->case->case_no;
                    return "<a class='' href='" . route('claimcase-view', [$award_disobey->form4->case->claim_case_id]) . "'> " . $award_disobey->form4->case->case_no . "</a>";
                })->editColumn('created_at', function ($award_disobey) {
                    return date('d/m/Y', strtotime($award_disobey->created_at));
                })->editColumn('form_status_id', function ($award_disobey) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    return $award_disobey->status->$status_lang;
                })->editColumn('method_id', function ($award_disobey) {
                    $locale = App::getLocale();
                    $method_lang = "method_" . $locale;
                    return $award_disobey->method->$method_lang;
                })->editColumn('action', function ($award_disobey) {
                    $button = "";

                    $button .= actionButton('blue', __('button.view'), route('awarddisobey.view', ['award_disobey_id' => $award_disobey->award_disobey_id]), false, 'fa-search', false);

                    return $button;
                })->make(true);
        }
        $audit = new AuditController;
        $audit->add($request, 12, "AwardDisobeyController", null, null, "Datatables load award disobey");
        return view("claimcase/award_disobey/list", compact('status', 'branches'));
    }

    public function view(Request $request, $id)
    {

        if ($id) {
            $award_disobey = AwardDisobey::find($id);
            $claim_case = $award_disobey->form4->case;
            $attachments = Attachment::where('form_no', 16)->where('form_id', $id)->get();
            $audit = new AuditController;
            $audit->add($request, 3, "AwardDisobeyController", null, null, "View award disobey " . $award_disobey->form4->case->case_no);

            return view('claimcase/award_disobey/view', compact('award_disobey', 'attachments', 'claim_case'), ['id' => $id])->render();
        }
    }

    public function create(Request $request)
    {
        $form4 = Form4::find($request->form4_id);
        $application_methods = MasterApplicationMethod::where('is_active', 1)->get();
        $attachments = null;
        $audit = new AuditController;
        $audit->add($request, 9, "AwardDisobeyController", null, null, "View award disobey form");
        return view("claimcase/award_disobey/create", compact('form4', 'application_methods', 'attachments'));
    }

    public function store(Request $request)
    {
        $rules = [
            'applied_by' => 'required|integer',
            'applied_against' => 'required|integer',
            'application_method_id' => 'required|integer',
            'complaints' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        $award_disobey_id = DB::table('award_disobey')->insertGetId([
            'form4_id' => $request->form4_id,
            'applied_by' => $request->applied_by,
            'applied_representative' => $request->applied_representative ?? null,
            'applied_against' => $request->applied_against,
            'application_method_id' => $request->application_method_id,
            'complaints' => $request->complaints,
            'complaint_at' => $request->complaint_at ? Carbon::createFromFormat('d/m/Y', $request->complaint_at)->toDateTimeString() : Carbon::now(),
            'endorsement_date' => $request->endorsement_date ? Carbon::createFromFormat('d/m/Y', $request->endorsement_date)->toDateTimeString() : Carbon::now(),
            'psu_notes' => $request->psu_notes,
            'form_status_id' => 28,
            'created_by_user_id' => Auth::id()
        ]);

        // $award_disobey = new AwardDisobey;
        // $award_disobey->form4_id = $request->form4_id;
        // $award_disobey->applied_by = $request->applied_by;
        // $award_disobey->applied_against = $request->applied_against;
        // $award_disobey->application_method_id = $request->application_method_id;
        // $award_disobey->complaints = $request->complaints;
        // $award_disobey->complaint_at = $request->complaint_at ? Carbon::createFromFormat('d/m/Y', $request->complaint_at)->toDateTimeString() : Carbon::now();
        // $award_disobey->psu_notes = $request->psu_notes;
        // $award_disobey->form_status_id = 1;
        // $award_disobey->save();


        $form_no = 16;
        $userid = Auth::id();
        $form_id = $award_disobey_id;

        //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

        $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $form_id)->get();

        if ($form_id) {

            if ($request->hasFile('attachment_1')) {
                if ($request->file('attachment_1')->isValid()) {

                    if ($oldAttachments->get(0)) {
                        if ($request->file1_info == 2) {
                            // Replace
                            $oldAttachments->get(0)->delete();

                            $attachment = new Attachment;
                            $attachment->form_no = $form_no;
                            $attachment->form_id = $form_id;
                            $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_1);
                            $attachment->created_by_user_id = $userid;
                            $attachment->mime = mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                            $audit = new AuditController;
                            $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
                        }
                    } else {
                        if ($request->file1_info == 2) {
                            // Add
                            $attachment = new Attachment;
                            $attachment->form_no = $form_no;
                            $attachment->form_id = $form_id;
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
                    $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form_id;
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
                            $attachment->form_id = $form_id;
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
                    $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form_id;
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
                            $attachment->form_id = $form_id;
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
                    $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");


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
                            $attachment->form_id = $form_id;
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
                            $attachment->form_id = $form_id;
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
                    $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form_id;
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
                            $attachment->form_id = $form_id;
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
                    $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");


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
        $audit->add($request, 4, "AwardDisobeyController", json_encode($request->input()), null, "Award Disobey " . $award_disobey_id . " - Create award disobey");
        return response()->json(['result' => 'ok']);
    }

    public function find(Request $request)
    {

        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();

        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);
			
            $case = ClaimCase::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case.claim_case_id')->orderBy('case_year', 'desc')->orderBy('case_sequence', 'desc')->with(['form1', 'form4.hearing.branch'])->whereHas('form4_latest.form4.award');
				
            if ($request->has('branch') && !empty($request->branch))
                $case = $case->where('branch_id', $request->branch);
			
            $datatables = Datatables::of($case);

            return $datatables
                ->editColumn('case_no', function ($case) {
                    return $case->case_no;
                })->editColumn('branch', function ($case) {
                    return $case->form4->last()->hearing->branch->branch_name;
                })->editColumn('filing_date', function ($case) {
                    if ($case->form1->filing_date)
                        return date('d/m/Y', strtotime($case->form1->filing_date));
                    else return "-";
                })->editColumn('action', function ($case) {

                    $button = "";

                    $button .= actionButton('green-meadow', __('new.register_kpa'), route('awarddisobey.create', ['form4_id' => $case->form4->last()->form4_id]), false, 'fa-edit', false);

                    return $button;
                })->make(true);
        }
        $audit = new AuditController;
        $audit->add($request, 12, "AwardDisobeyController", null, null, "Datatables load cases that can file award disobey");
        return view("claimcase/award_disobey/list2", compact('case', 'branches'));

    }

}
