<?php

namespace App\Http\Controllers\ClaimCase;

use App;
use App\CaseModel\Form4;
use App\CaseModel\ClaimCase;
use App\CaseModel\JudicialReview;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterCourt;
use App\Repositories\LogAuditRepository;
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

class JudicialReviewController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function list(Request $request)
    {
        $status = MasterFormStatus::whereIn('form_status_id', [30, 53])->get();
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $categories = MasterClaimCategory::where('is_active', 1)->orderBy('claim_category_id', 'desc')->get();


        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.judicial_review', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {
            $user = User::find(Auth::id());

            return self::dt($request, $user);
        }

        LogAuditRepository::store($request, 12, "JudicialReviewController", null, null, "Datatables load judicial review");

        return view("claimcase/judicial_review/list", compact('status', 'branches', 'categories'));
    }

    /**
     * Render datatable
     * @param $request
     * @param $user
     * @return mixed
     * @throws \Exception
     */
    public function dt($request, $user)
    {
        $judicial_review = self::dtQuery($request, $user);

        $datatables = Datatables::of($judicial_review);

        return $datatables
            ->editColumn('case_no', function ($judicial_review) {
                return "<a class='' href='" . route('claimcase-view', [$judicial_review->form4->case->claim_case_id]) . "'> "
                    . $judicial_review->form4->case->case_no . "</a>";
            })
            ->editColumn('created_at', function ($judicial_review) {
                return date('d/m/Y', strtotime($judicial_review->created_at));
            })
            ->editColumn('category', function ($judicial_review) {
                if ($judicial_review->form4->case->form1->classification) {
                    $locale = App::getLocale();
                    $category_lang = "category_" . $locale;
                    return $judicial_review->form4->case->form1->classification->category->$category_lang;
                } else return "-";
            })
            ->editColumn('form_status_id', function ($judicial_review) {
                $locale = App::getLocale();
                $status_lang = "form_status_desc_" . $locale;
                return $judicial_review->status->$status_lang;
            })
            ->editColumn('action', function ($judicial_review) {
                $button = "";

                $button .= actionButton('blue', __('button.view'),
                    route('judicialreview.view', ['judicial_review_id' => $judicial_review->judicial_review_id]),
                    false, 'fa-search', false);

                if ($judicial_review->form_status_id == 30) {
                    $button .= actionButton('green-meadow', __('button.edit'),
                        route('judicialreview.edit', ['judicial_review_id' => $judicial_review->judicial_review_id]),
                        false, 'fa-edit', false);
                }

                return $button;
            })
            ->make(true);
    }

    /**
     * Datatable query
     * @param $request
     * @param $user
     * @return \App\CaseModel\JudicialReview|\Illuminate\Database\Eloquent\Builder
     */
    public function dtQuery($request, $user)
    {
        $judicial_review = JudicialReview::with(['form4.case.form1.classification.category', 'status'])
            ->orderBy('judicial_review.created_at', 'desc');

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) {
            $judicial_review->whereHas('form4', function ($form4) use ($request, $user) {
                return $form4->whereHas('case', function ($case) use ($request, $user) {
                    return $case->where('branch_id', $user->ttpm_data->branch_id);
                });
            });
        } else if (Auth::user()->hasRole('user') || Auth::user()->hasRole('presiden') || Auth::user()->hasRole('pengerusi')
            || Auth::user()->hasRole('setiausaha') || Auth::user()->hasRole('financial-officer')
            || Auth::user()->hasRole('enforcer-officer')) {
            $judicial_review->whereHas('form4', function ($form4) use ($user) {
                return $form4->whereHas('case', function ($case) use ($user) {
                    return $case->where('claimant_user_id', $user->id);
                });
            });
        }

        //Check for filteration
        if ($request->has('status') || $request->has('branch') || $request->has('category') || $request->has('created_at')) {
            if ($request->has('status') && !empty($request->status)) {
                $judicial_review->where('form_status_id', $request->status);
            }

            if ($request->has('branch') && !empty($request->branch)) {
                $judicial_review->whereHas('form4', function ($form4) use ($request) {
                    return $form4->whereHas('case', function ($case) use ($request) {
                        return $case->where('branch_id', $request->branch);
                    });
                });
            }

            if ($request->has('category') && !empty($request->category)) {
                $judicial_review->whereHas('form4', function ($form4) use ($request) {
                    return $form4->whereHas('case', function ($case) use ($request) {
                        return $case->whereHas('form1', function ($form1) use ($request) {
                            return $form1->whereHas('classification', function ($classification) use ($request) {
                                return $classification->where('category_id', $request->category);
                            });
                        });
                    });
                });
            }

            if ($request->has('created_at') && !empty($request->created_at)) {
                $judicial_review->whereDate('created_at', Carbon::createFromFormat('d/m/Y', $request->created_at)->toDateString());
            }
        }

        return $judicial_review;
    }

    /**
     * View judicial review data
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function view(Request $request, $id)
    {
        if ($id) {
            $judicial_review = JudicialReview::find($id);
            $claim_case = $judicial_review->form4->case;
            $attachments = Attachment::where('form_no', 17)->where('form_id', $id)->get();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 3, "JudicialReviewController", null, null, "View judicial review " . $claim_case->case_no);

            return view('claimcase/judicial_review/view', compact('judicial_review', 'attachments', 'claim_case'), ['id' => $id])->render();
        }
    }

    /**
     * Render judicial review create form
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {

        $form4 = Form4::find($request->form4_id);
        $courts = MasterCourt::where('is_active', 1)->get();
        $judicial_review = null;
        $attachments = null;

        $old_review = JudicialReview::where('form4_id', $request->form4_id);
        if ($old_review->get()->count() > 0)
            $old_review = $old_review->first();
        else
            $old_review = null;
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 9, "JudicialReviewController", null, null, "View judicial review form");
        return view("claimcase/judicial_review/create", compact('form4', 'courts', 'attachments', 'judicial_review', 'old_review'));
    }

    /**
     * Render judicial review edit form
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $judicial_review = JudicialReview::find($request->judicial_review_id);

        $form4 = Form4::find($judicial_review->form4_id);
        $courts = MasterCourt::where('is_active', 1)->get();
        $attachments = Attachment::where('form_no', 17)->where('form_id', $request->judicial_review_id)->get();
        $old_review = null;

        return view("claimcase/judicial_review/create", compact('form4', 'courts', 'attachments', 'judicial_review', 'old_review'));
    }

    public function store(Request $request)
    {
        $rules = [
            'applied_by' => 'required|integer',
            'court_details' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        if (!$request->judicial_review_id) {

            $judicial_review_id = DB::table('judicial_review')->insertGetId([
                'form4_id' => $request->form4_id,
                'applied_by' => $request->applied_by,
                'application_no' => $request->application_no,
                'court_id' => $request->court_id,
                'court_details' => $request->court_details,
                'court_applied_at' => $request->applied_at ? Carbon::createFromFormat('d/m/Y', $request->applied_at)->toDateTimeString() : null,
                'is_doc_proceedingnotes' => $request->is_doc_proceedingnotes ? $request->is_doc_proceedingnotes : 0,
                'is_doc_decisionreason' => $request->is_doc_decisionreason ? $request->is_doc_decisionreason : 0,
                'psu_notes' => $request->psu_notes,
                'form_status_id' => $request->is_draft == 'true' ? 30 : 53,
                'created_by_user_id' => Auth::id()
            ]);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 4, "JudicialReviewController", json_encode($request->input()), null, "Judicial Review " . $judicial_review_id . " - Create judicial review");

        } else {

            $judicial_review_id = JudicialReview::find($request->judicial_review_id)->update([
                'applied_by' => $request->applied_by,
                'application_no' => $request->application_no,
                'court_id' => $request->court_id,
                'court_details' => $request->court_details,
                'court_applied_at' => $request->applied_at ? Carbon::createFromFormat('d/m/Y', $request->applied_at)->toDateTimeString() : null,
                'is_doc_proceedingnotes' => $request->is_doc_proceedingnotes ? $request->is_doc_proceedingnotes : 0,
                'is_doc_decisionreason' => $request->is_doc_decisionreason ? $request->is_doc_decisionreason : 0,
                'psu_notes' => $request->psu_notes,
                'form_status_id' => $request->is_draft == 'true' ? 30 : 53,
                'created_by_user_id' => Auth::id()
            ]);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "JudicialReviewController", null, null, "Update judicial review " . $request->judicial_review_id);
        }

        $form_no = 17;
        $userid = Auth::id();
        $form_id = $judicial_review_id;

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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "JudicialReviewController", json_encode($request->input()), null, "Judicial Review " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "JudicialReviewController", json_encode($request->input()), null, "Judicial Review " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "JudicialReviewController", json_encode($request->input()), null, "Judicial Review " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "JudicialReviewController", json_encode($request->input()), null, "Judicial Review " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");

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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
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
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "JudicialReviewController", json_encode($request->input()), null, "Judicial Review " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");
                }
            } else {
                if ($oldAttachments->get(4)) {
                    if ($request->file5_info == 2) {
                        $oldAttachments->get(4)->delete();
                    }
                }
            }
        }


        return response()->json(['result' => 'ok']);
    }

    public function find(Request $request)
    {
        $branches = MasterBranch::where('is_active', 1)
            ->orderBy('branch_id', 'desc')
            ->get();

        if ($request->ajax()) {
            return self::dtFind($request);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "JudicialReviewController", null, null, "Datatables load cases that can file judicial review");
        return view("claimcase/judicial_review/list2", compact('case', 'branches'));
    }

    public function dtFind($request)
    {
        $case = self::dtFindQuery($request);

        $datatables = Datatables::of($case);

        return $datatables
            ->editColumn('case_no', function ($case) {
                return $case->case_no;
            })
            ->editColumn('branch', function ($case) {
                return $case->form4->last()->hearing->branch->branch_name;
            })
            ->editColumn('filing_date', function ($case) {
                return $case->form1->filing_date ? date('d/m/Y', strtotime($case->form1->filing_date)) : '-';
            })
            ->editColumn('action', function ($case) {
                $button = "";
                $button .= actionButton('green-meadow', __('new.reg_review'),
                    route('judicialreview.create', ['form4_id' => $case->form4->last()->form4_id]),
                    false, 'fa-edit', false);

                return $button;
            })
            ->make(true);
    }

    public function dtFindQuery($request)
    {
        $case = ClaimCase::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->with(['form1', 'form4.hearing.branch'])
            ->has('form4')
            ->whereHas('form4_latest.form4.award');

        if (Auth::user()->ttpm_data) {
            $case->where('branch_id', Auth::user()->ttpm_data->branch_id);
        }

        $case = $case->get();

        $case = $case->filter(function ($value) {
            return count($value->judicial_review) < 2;
        });

        if ($request->has('branch')) {
            if ($request->has('branch') && !empty($request->branch)) {
                $case = $case->filter(function ($value) use ($request) {
                    return $value->form4->last()->hearing->branch_id == $request->branch;
                });
            }
        }

        return $case;
    }
}
