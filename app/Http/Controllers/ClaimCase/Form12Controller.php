<?php

namespace App\Http\Controllers\ClaimCase;

use App\CaseModel\ClaimCaseOpponent;
use App\Repositories\LogAuditRepository;
use App\Repositories\MasterBranchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form12;
use App\CaseModel\Form11;
use App\CaseModel\Form4;
use App\UserWitness;
use Auth;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingStatus;
use App\MasterModel\MasterHearingPosition;
use App\MasterModel\MasterHearingPositionReason;
use App\SupportModel\Attachment;
use App\MasterModel\MasterF10Type;
use App\HearingModel\Award;
use App\HearingModel\Hearing;
use App\User;
use App\RoleUser;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App;
use DB;
use Carbon\Carbon;

class Form12Controller extends Controller
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

    protected function rules_insert()
    {

        $rules = [
            'form4_id' => 'required|integer',
            'versus' => 'required|integer',
            'versus_against' => 'required|integer',
            'application_date' => 'required',
            'filing_date' => 'required',
            'absence_reason' => 'required'
        ];

        return $rules;
    }

    protected function rules_update()
    {

        $rules = [
            'form4_id' => 'required|integer',
            'versus' => 'required|integer',
            'versus_against' => 'required|integer',
            'absence_reason' => 'required'
        ];

        return $rules;
    }

    public function list(Request $request)
    {
        $years = range(date('Y'), 2000);
        $branches = MasterBranchRepository::getListByStateName();
//        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $status = MasterFormStatus::where('form_status_id', '>=', 24)->where('form_status_id', '<=', 25)->get();
        $input = $request->all();

        $input['year'] = (!isset($input['year']) || trim($input['year']) === '') ? date('Y') : $input['year'];

        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.form12', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {
            $form12 = Form12::select('form12.*')
                ->join('form4', 'form4.form4_id', '=', 'form12.form4_id')
                ->orderBy('form12.filing_date', 'desc')
                ->with(['form4.case', 'form4.hearing', 'form4.award']);

            if ($input['year'] > 0) {
                $year = Carbon::createFromFormat('Y', $input['year']);
                $form12 = $form12->whereBetween('form12.filing_date', [
                    $year->startOfYear()->toDateString(),
                    $year->endOfYear()->toDateString()
                ]);
            }

            $form12->whereHas('form4', function ($form4) use ($request) {
                return $form4->whereHas('case', function ($case) use ($request) {
                    if ($request->has('branch') && !empty($request->branch) && $request->branch > 0) {
                        return $case->where('branch_id', $request->branch);
                    } else if ($request->branch == 0) {
                        // something
                    } else {
                        return $case->where('branch_id', Auth::user()->ttpm_data->branch_id);
                    }
                });
            });

            if ($request->has('status') && !empty($request->status) && $request->status > 0) {
                $form12 = $form12->where('form12.form_status_id', $request->status);
            }

            // $form12 = $form12->get();

            if ($request->has('f2_status') && !empty($request->f2_status)) {
                if ($request->f2_status == 1) {
                    $form12->whereHas('form4', function ($form4) {
                        return $form4->whereHas('claimCaseOpponent', function ($case) {
                            return $case->whereHas('form2', function ($form2) {
                                return $form2->whereNotNull('form2_id');
                            });
                        });
                    });
                } else {
                    $form12->whereHas('form4', function ($form4) {
                        return $form4->whereHas('claimCaseOpponent', function ($case) {
                            return $case->whereHas('form2', function ($form2) {
                                return $form2->whereNotNull('form2_id');
                            });
                        });
                    });
                }
            }


            $datatables = Datatables::of($form12);

            return $datatables
                ->editColumn('case_no', function ($form12) {
                    //return $form12->form4->case->case_no;
                    return "<a class='' href='" . route('claimcase-view', [$form12->form4->case->claim_case_id]) . "'> " . $form12->form4->case->case_no . "</a>";
                })
                ->editColumn('hearing_date', function ($form12) {
                    if ($form12->form4->hearing) {
                        return date('d/m/Y', strtotime($form12->form4->hearing->hearing_date));
                    } else {
                        return "-";
                    }
                })
                ->editColumn('filing_date', function ($form12) {
                    return date('d/m/Y', strtotime($form12->filing_date));
                })
                ->editColumn('award_date', function ($form12) {
                    if ($form12->form4->award) {
                        return date('d/m/Y', strtotime($form12->form4->award->award_date));
                    } else {
                        return "-";
                    }
                })
                ->editColumn('form2_status', function ($form12) {
                    return !empty($form12->form4->claimCaseOpponent->form2) ? '<span class="label bg-green-jungle"><i class="fa fa-check"></i></span>' : '<span class="label bg-red-thunderbird"><i class="fa fa-times"></i></span>';
                })
                ->editColumn('new_hearing_date', function ($form12) {
                    if ($form12->form4->form4_next) {
                        if ($form12->form4->form4_next->hearing) {
                            return date('d/m/Y', strtotime($form12->form4->form4_next->hearing->hearing_date));
                        } else {
                            return "-";
                        }
                    } else {
                        return "-";
                    }
                })
                ->editColumn('action', function ($form12) {
                    $button = "";

                    $button .= '<a href="' . route('form12-view', $form12->form12_id) . '" rel="tooltip" data-original-title="' . __('button.view') . '" class="btn btn-xs blue" ><i class="fa fa-search"></i></a>';

                    if ($form12->form_status_id == 24) {
                        $button .= actionButton('green-meadow', __('button.edit'), route('form12-edit', ['id' => $form12->form12_id]), false, 'fa-edit', false);

                        $button .= '<a class="btn btn-xs purple" rel="tooltip" data-original-title="' . __('button.process') . '" onclick="processForm12(' . $form12->form12_id . ')"><i class="fa fa-spinner"></i></a>';
                    } else {

                        if (Auth::user()->user_type_id != 3)
                            $button .= actionButton('green-meadow', __('button.edit'), route('form12-edit', ['id' => $form12->form12_id]), false, 'fa-edit', false);

                        $button .= actionButton('dark btn-outline', 'PDF', route("form4-export", ["form4_id" => $form12->form4_id, "form_no" => 12, "format" => "pdf"]), false, 'fa-file-pdf-o', false);

                        $button .= actionButton('dark btn-outline', 'DOCX', route("form4-export", ["form4_id" => $form12->form4_id, "form_no" => 12, "format" => "docx"]), false, 'fa-file-o', false);
                    }

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form12Controller", null, null, "Datatables load form 12");

        return view("claimcase.form12.list", compact('branches', 'status', 'months', 'years', 'input'));
    }

    public function process(Request $request)
    {

        $form12_id = $request->form12_id;

        $form12 = Form12::find($form12_id);
        // $psus = RoleUser::where('role_id', 18)->orWhere('role_id', 17)->orWhere('role_id', 10)->get()->filter(function($query){
        //     return $query->user->user_status_id == 1;
        // });
        $psus = RoleUser::whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();

        if ($request->isMethod('post')) {

            $rules = [
                'filing_date' => 'required',
                'psu' => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            // submit
            $form12->form_status_id = 25;
            $form12->psu_user_id = $request->psu;
            $form12->processed_by_user_id = Auth::id();
            $form12->processed_at = Carbon::now();
            $form12->save();

            return Response::json(['status' => 'ok']);

        }

        return view('claimcase.form12.modalProcess', compact('form12', 'psus'));

    }

    /**
     * List of form4 that can create form12
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function find(Request $request)
    {
        if ($request->ajax()) {
            $cases = ClaimCaseOpponent::select([
                'claim_case_opponents.id',
                'claim_case_opponents.claim_case_id',
                'claim_case_opponents.opponent_address_id',
                'claim_case.case_no',
            ])
                ->with(['opponent_address', 'form4Latest.form4.hearing', 'form4Latest.form4.award'])
                ->join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case_opponents.claim_case_id')
                ->join('claim_case', 'claim_case.claim_case_id', '=', 'claim_case_opponents.claim_case_id')
                ->where('claim_case.branch_id', Auth::user()->ttpm_data->branch_id)
                ->whereHas('form4Latest.form4', function ($form4) {
                    $form4->whereHas('award', function ($award) {
                        return $award->whereNotIn('award_type', [9, 10]);
                    });
                })
                ->orderBy('case_year', 'desc')
                ->orderBy('case_sequence', 'desc');

            $datatables = Datatables::of($cases);

            return $datatables
                ->addIndexColumn()
                ->editColumn('case_no', function ($case) {
                    return $case->case_no;
                })
                ->editColumn('hearing_date', function ($case) {
                    return date('d/m/Y', strtotime($case->form4Latest->form4->hearing->hearing_date));
                })
                ->editColumn('opponent_name', function ($case) {
                    return $case->opponent_address ? $case->opponent_address->name : '-';
                })
                ->editColumn('award_date', function ($case) {
                    return date('d/m/Y', strtotime($case->form4Latest->form4->award->award_date));
                })
                ->editColumn('action', function ($case) {
                    $button = "";
                    $button .= actionButton('green-meadow', __('new.add_f12'), route('form12-create', ['form4_id' => $case->form4Latest->form4_id]), false, 'fa-edit', false);
                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form12Controller", null, null, "Datatables load cases that can file form 12");

        return view("claimcase.form12.find", compact('form4'));

    }

    /**
     * Open create form to create form12.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $form12 = new Form12;
        $form4 = Form4::find($request->form4_id);

        if (!$form4->claimCaseOpponent->form2 && !$request->has('forced')) {
            return redirect()->back()->with('form2_url', [route('form2-create', ['claim_case_id' => $form4->claim_case_opponent_id]), $request->form4_id]);
        }

        $hearings = Hearing::where('branch_id', $form4->hearing->branch_id)
            ->whereDate('hearing_date', '>', Carbon::createFromFormat('Y-m-d', $form4->hearing->hearing_date))
            ->get();

        $attachments = null;

        $form4_next = $form4->form4_next ?? null;

        LogAuditRepository::store($request, 9, "Form12Controller", null, null, "View set aside award form");

        return view("claimcase.form12.create", compact('form4', 'form12', 'attachments', 'hearings',
            'form4_next'));
    }

    public function store(Request $request)
    {
        if (!$request->form12_id) {
            $validator = Validator::make($request->all(), $this->rules_insert());
        } else {
            $validator = Validator::make($request->all(), $this->rules_update());
        }

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        if (!$request->form12_id) {
            // create new form 12
            $form12_id = DB::table('form12')
                ->insertGetId([
                    'form4_id' => $request->form4_id, // form4 yang asal. bukan yang latest.
                    'absence_reason' => $request->absence_reason,
                    'unfiled_reason' => $request->unfiled_reason,
                    'form_status_id' => 24,
                    'applied_by' => $request->versus,
                    'created_by_user_id' => Auth::id(),
                    'filing_date' => $request->filing_date ? Carbon::createFromFormat('d/m/Y', $request->filing_date)->toDateTimeString() : Carbon::now(),
                    'application_date' => $request->application_date ? Carbon::createFromFormat('d/m/Y', $request->application_date)->toDateTimeString() : Carbon::now()
                ]);

            $form4_old = Form4::find($request->form4_id);

            if ($request->new_hearing_date) {
                $form4_id = DB::table('form4')
                    ->insertGetId([
                        'form12_id' => $form12_id,
                        'claim_case_id' => $form4_old->claim_case_id,
                        'claim_case_opponent_id' => $form4_old->claim_case_opponent_id,
                        'opponent_user_id' => $form4_old->opponent_user_id,
                        'hearing_id' => $request->new_hearing_date,
                        'created_by_user_id' => Auth::id(),
                        'psu_user_id' => Auth::id()
                    ]);
            }

            LogAuditRepository::store($request, 4, "Form12Controller", json_encode($request->input()),
                null, "Form 12 " . $form4_old->case->case_no . " - Create form 12");

        } else {
            // Update
            $form12 = Form12::find($request->form12_id);

            $form12_id = $request->form12_id;

            $form12->update([
                'absence_reason' => $request->absence_reason,
                'unfiled_reason' => $request->unfiled_reason,
                // 'form_status_id' => 24,
                'applied_by' => $request->versus
            ]);

            $form4 = Form4::find($form12->form4_id);

            $form4_next = $form4->form4_next;

            if ($request->has('new_hearing_date')) {
                if ($form4_next) {
                    $form4_next->update([
                        'hearing_id' => $request->new_hearing_date
                    ]);
                } else {
                    $form4_id = DB::table('form4')
                        ->insertGetId([
                            'form12_id' => $form12_id,
                            'claim_case_id' => $form4->claim_case_id,
                            'claim_case_opponent_id' => $form4->claim_case_opponent_id,
                            'opponent_user_id' => $form4->opponent_user_id,
                            'hearing_id' => $request->new_hearing_date,
                            'created_by_user_id' => Auth::id(),
                            'psu_user_id' => Auth::id()
                        ]);
                }
            }

            LogAuditRepository::store($request, 5, "Form12Controller", null,
                null, "Update Form 12 " . $form4->case->case_no);
        }


        $form_no = 12;
        $userid = Auth::id();
        $form_id = $form12_id;

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
                    $audit->add($request, 4, "Form12Controller", json_encode($request->input()), null, "Form 12 " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
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
                    $audit->add($request, 4, "Form12Controller", json_encode($request->input()), null, "Form 12 " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");
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
                    $audit->add($request, 4, "Form12Controller", json_encode($request->input()), null, "Form 12 " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");
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
                    $audit->add($request, 4, "Form12Controller", json_encode($request->input()), null, "Form 12 " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");
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
                    $audit->add($request, 4, "Form12Controller", json_encode($request->input()), null, "Form 12 " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");
                }
            } else {
                if ($oldAttachments->get(4)) {
                    if ($request->file5_info == 2) {
                        $oldAttachments->get(4)->delete();
                    }
                }
            }
        }

        return Response::json(['status' => 'ok', 'message' => $request->form12_id ? __('new.create_success') : __('new.update_success')]);

    }

    public function edit($form12_id)
    {
        if ($form12_id) {
            $form12 = Form12::find($form12_id);
            $form4 = $form12->form4;

            $form4_next = Form4::find($form12->form4_id)->form4_next ?? null;

            $attachments = Attachment::where('form_no', 12)->where('form_id', $form12_id)->get();
            $hearings = Hearing::where('branch_id', $form4->hearing->branch_id)->whereDate('hearing_date', '>', Carbon::createFromFormat('Y-m-d', $form4->hearing->hearing_date))->get();

            return view("claimcase.form12.create", compact('form4', 'form12', 'attachments', 'hearings', 'form4_next'));
        }
    }

    /**
     * To view form 12 data
     * @param \Illuminate\Http\Request $request
     * @param $form12_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request, $form12_id)
    {
        if ($form12_id) {
            $form12 = Form12::find($form12_id);
            $attachments = Attachment::where('form_no', 12)->where('form_id', $form12_id)->get();
            $claim_case = $form12->form4->case;
            $claim_case_opponent = $form12->form4->claimCaseOpponent;

            LogAuditRepository::store($request, 3, "Form12Controller", null, null, "View form 12 for " . $claim_case->case_no);

            return view('claimcase.form12.view', compact('form12', 'attachments', 'claim_case', 'claim_case_opponent'));
        }
    }

    public function delete(Request $request, $id)
    {
        if ($id) {
            $form12 = Form12::find($id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 6, "Form12Controller", null, null, "Delete form 12 " . $form12->form4->case->case_no);
            $form12->is_active = 0;
            $form12->save();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }
}
    