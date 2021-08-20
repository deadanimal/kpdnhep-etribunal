<?php

namespace App\Http\Controllers\ClaimCase;

use App\CaseModel\ClaimCaseOpponent;
use App\Repositories\LogAuditRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\RoleUser;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterDesignation;
use App\CaseModel\Inquiry;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\CaseModel\Form3;
use App\SupportModel\Address;
use App\SupportModel\Attachment;
use App\SupportModel\CounterClaim;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use PDF;
use App;

class Form3Controller extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function export(Request $request, $claim_case_id, $format)
    {
        $claim_case_opponent = ClaimCaseOpponent::find($claim_case_id);
        $claim = $claim_case_opponent->claimCase;

        if ($format == 'pdf') {
            $this->data['claim'] = $claim;
            $this->data['claim_case_opponent'] = $claim_case_opponent;
            $this->data['form3_filing_date'] = date('d M Y', strtotime($claim_case_opponent->form2->form3->filing_date));

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "Form3Controller", $claim->case_no, null, "Download form 3 (PDF)");

            if (App::getLocale() == 'en')
                $pdf = PDF::loadView('claimcase/form3/printform3en', $this->data);
            elseif (App::getLocale() == 'my')
                $pdf = PDF::loadView('claimcase/form3/printform3my', $this->data);

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Borang 3 ' . $claim->case_no . '.pdf');
        } else if ($format == 'docx') {
            $gen = new \App\Http\Controllers\GeneralController;
            $file = $gen->integrateDocTemplate('form3_' . App::getLocale(), [
                "hearing_venue_short" => $claim->venue ? $claim->venue->hearing_venue : '-',
                "state_name" => $claim->branch->state->state,
                "case_no" => $claim->case_no,
                "claimant_name" => htmlspecialchars($claim->claimant_address->name),
                "claimant_identification_type" => $claim->claimant_address->nationality_country_id == 129 ? __('form1.ic_no') : __('form1.passport_no'),
                "claimant_identification_no" => $claim->claimant_address->identification_no,
                "claimant_address" => htmlspecialchars($claim->claimant_address->street_1 . ($claim->claimant_address->street_2 ? ', ' . $claim->claimant_address->street_2 : '') . ($claim->claimant_address->street_3 ? ', ' . $claim->claimant_address->street_3 : '') . ', ' . $claim->claimant_address->postcode . ' ' . ($claim->claimant_address->district ? $claim->claimant_address->district->district : '') . ', ' . ($claim->claimant_address->state ? $claim->claimant_address->state->state : '')),
                "claimant_phone_home" => htmlspecialchars($claim->claimant_address->phone_home),
                "claimant_phone_mobile" => htmlspecialchars($claim->claimant_address->phone_mobile),
                "claimant_email" => htmlspecialchars($claim->claimant_address->email),
                "claimant_phone_fax" => htmlspecialchars($claim->claimant_address->phone_fax),
                "opponent_name" => htmlspecialchars($claim_case_opponent->opponent_address->name),
                "opponent_identification_type" => $claim_case_opponent->opponent_address->is_company == 0 ? ($claim_case_opponent->opponent_address->nationality_country_id == 129 ? __('form1.ic_no') : __('form1.passport_no')) : __('form1.company_no'),
                "opponent_identification_no" => $claim_case_opponent->opponent_address->identification_no,
                "opponent_address" => htmlspecialchars($claim_case_opponent->opponent_address->street_1 . ($claim_case_opponent->opponent_address->street_2 ? ', ' . $claim_case_opponent->opponent_address->street_2 : '') . ($claim_case_opponent->opponent_address->street_3 ? ', ' . $claim_case_opponent->opponent_address->street_3 : '') . ', ' . $claim_case_opponent->opponent_address->postcode . ' ' . ($claim_case_opponent->opponent_address->district ? $claim_case_opponent->opponent_address->district->district : '') . ', ' . ($claim_case_opponent->opponent_address->state ? $claim_case_opponent->opponent_address->state->state : '')),
                "opponent_phone_home" => htmlspecialchars($claim_case_opponent->opponent_address->phone_office),
                "opponent_phone_mobile" => htmlspecialchars($claim_case_opponent->opponent_address->phone_mobile),
                "opponent_email" => htmlspecialchars($claim_case_opponent->opponent_address->email),
                "opponent_phone_fax" => htmlspecialchars($claim_case_opponent->opponent_address->phone_fax),
                "defence_counterclaim_statement" => htmlspecialchars($claim_case_opponent->form2->form3->defence_counterclaim_statement),
                "filing_date" => date('d/m/Y', strtotime($claim->form1->filing_date)),
                "psu_name" => htmlspecialchars(strtoupper($claim->psu->name)),
                "psu_role_en" => strtoupper($claim->psu->roleuser->first()->role->display_name_en),
                "psu_role_my" => strtoupper($claim->psu->roleuser->first()->role->display_name_my)
            ]);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "Form3Controller", $claim->case_no, null, "Download form 3 (DOCX)");

            return response()->download($file, 'Borang 3 ' . $claim->case_no . '.docx')->deleteFileAfterSend(true);
        }

    }

    public function create($claim_case_id)
    {
        $case = ClaimCaseOpponent::find($claim_case_id);

        if (Auth::user()->user_type_id == 3) {
            if ($case->claimCase->claimant_user_id != Auth::id())
                abort(404);
        }

        if ($case->form2) {
            if ($case->form2->form_status_id < 22) {
                return;
            }
        } else {
            return;
        }

        // Check for user_id and get claimant information from database
        $userid = Auth::id();
        $user = User::find($userid);

        //dd($user->user_type_id);

        if ($user->user_type_id != 3) {
            $is_staff = true;
        } else {
            $is_staff = false;
        }

        if ($case->form2->form3) {
            $attachments = Attachment::where('form_no', 3)->where('form_id', $case->form2->form3_id)->get();
        } else {
            $attachments = null;
        }

        $f1_attachments = Attachment::where('form_no', 1)->where('form_id', $case->claimCase->form1_id)->get();
        $f2_attachments = Attachment::where('form_no', 2)->where('form_id', $case->form2->form2_id)->get();
        $psus = RoleUser::whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) use ($case) {
                return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) use ($case) {
                    return $user_ttpm->where('branch_id', $case->claimCase->branch_id);
                });
            })
            ->get();
        // $psus = RoleUser::where('role_id', 18)->orWhere('role_id', 17)->orWhere('role_id', 10)->get()->filter(function($query){
        //     return $query->user->user_status_id == 1;
        // });

        $claim_case_opponent = $case;
        $case = $case->claimCase;

        return view("claimcase/form3/viewForm3", compact('is_staff', 'case', 'attachments',
            'f1_attachments', 'f2_attachments', 'psus', 'claim_case_opponent'));
    }


    public function partialCreate2(Request $request)
    {

        // Get claim_case_id
        $claim_case_id = $request->claim_case_id;
        $case = ClaimCaseOpponent::find($claim_case_id);

        $rules['defence_counterclaim'] = 'required';

        $validator = Validator::make($request->all(), $rules);

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            $defence_counterclaim = $request->defence_counterclaim;

            if ($case->form2->form3) {
                // Update
                $form3 = $case->form2->form3;
                $form3->defence_counterclaim_statement = $defence_counterclaim;
                $form3->save();
            } else {
                // Add
                $form3_id = DB::table('form3')->insertGetId([
                    'defence_counterclaim_statement' => $defence_counterclaim,
                    'created_by_user_id' => Auth::id()
                ]);

                $form2 = $case->form2;
                $form2->form3_id = $form3_id;
                $form2->save();

                $case->claimCase->case_status_id = 5;
                $case->claimCase->save();
            }

            return response()->json(['result' => 'Success']);

        }
    }

    public function uploadAttachment(Request $request)
    {
        if ($request->ajax()) {
            $claim_case_id = $request->claim_case_id;
            $form_no = 3;
            $claim_case_opponent = ClaimCaseOpponent::find($claim_case_id);
            $form3_id = $claim_case_opponent->form2->form3_id;
            $created_by = Auth::id();

            $oldAttachments = Attachment::where('form_no', 3)
                ->where('form_id', $form3_id)
                ->get();

            if ($request->hasFile('attachment_1')) {
                if ($request->file('attachment_1')->isValid()) {
                    if ($oldAttachments->get(0)) {
                        if ($request->file1_info == 2) {
                            // Replace
                            $oldAttachments->get(0)->delete();

                            $attachment = new Attachment;
                            $attachment->form_no = $form_no;
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_1);
                            $attachment->created_by_user_id = $created_by;
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_1);
                            $attachment->created_by_user_id = $created_by;
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_1')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "Form3Controller", json_encode($request->input()), null, "Form 3 " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");

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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_2);
                            $attachment->created_by_user_id = $created_by;
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_2);
                            $attachment->created_by_user_id = $created_by;
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_2')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "Form3Controller", json_encode($request->input()), null, "Form 3 " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_3);
                            $attachment->created_by_user_id = $created_by;
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_3);
                            $attachment->created_by_user_id = $created_by;
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_3')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "Form3Controller", json_encode($request->input()), null, "Form 3 " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_4);
                            $attachment->created_by_user_id = $created_by;
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_4);
                            $attachment->created_by_user_id = $created_by;
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_4')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "Form3Controller", json_encode($request->input()), null, "Form 3 " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");

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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_5);
                            $attachment->created_by_user_id = $created_by;
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
                            $attachment->form_id = $form3_id;
                            $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                            $attachment->file_blob = file_get_contents($request->attachment_5);
                            $attachment->created_by_user_id = $created_by;
                            $attachment->mime = \GuzzleHttp\Psr7\mimetype_from_filename($request->file('attachment_5')->getClientOriginalName());
                            $attachment->created_at = Carbon::now();
                            $attachment->updated_at = Carbon::now();
                            $attachment->save();
                        }
                    }

                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 4, "Form3Controller", json_encode($request->input()), null, "Form 3 " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");
                }
            } else {
                if ($oldAttachments->get(4)) {
                    if ($request->file5_info == 2) {
                        $oldAttachments->get(4)->delete();
                    }
                }
            }

            return response()->json(['result' => 'Success']);
        }
    }

    public function list(Request $request)
    {
        $status = MasterFormStatus::where('form_status_id', 31)
            ->orWhere('form_status_id', 32)
            ->orWhere('form_status_id', 46)
            ->get();
        $branches = MasterBranch::where('is_active', 1)
            ->orderBy('branch_id', 'desc')
            ->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $input = $request->all();

        $input['year'] = (!isset($input['year']) || trim($input['year']) === '') ? date('Y') : $input['year'];

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.form3', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

        if ($request->ajax()) {
            $userid = Auth::id();
            $user = User::find($userid);

            $case = ClaimCaseOpponent::select([
                'claim_case_opponents.id',
                'claim_case.case_no',
                'claim_case.claimant_user_id',
                'claim_case.claimant_address_id',
                'claim_case_opponents.opponent_address_id',
                'claim_case_opponents.opponent_user_id',
                'claim_case_opponents.claim_case_id',
                'form3.filing_date',
                'form1.processed_at',
            ])
                ->with(['claimCase.form1', 'form2.form3.status', 'claimCase.claimant_address', 'opponent_address'])
                ->join('claim_case', 'claim_case.claim_case_id', '=', 'claim_case_opponents.claim_case_id')
                ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
                ->join('form2', 'form2.claim_case_opponent_id', '=', 'claim_case_opponents.id')
                ->join('form3', 'form2.form3_id', '=', 'form3.form3_id')
                ->whereNotNull('claim_case.form1_id')
                ->orderBy('form3.filing_date')
                ->orderBy('form1.filing_date');

            // public user can only see their data only.
            if (Auth::user()->hasRole('user')) {
                $case->where('claim_case.claimant_user_id', $userid);
            }

            // search by form 1 filing date

            if ($input['year'] > 0) {
                $case->whereYear('form1.filing_date', $input['year']);
            }
            if ($request->has('month') && !empty($request->month)) {
                $case->whereMonth('form1.filing_date', $request->month);
            }

            // only with form3 data
            $case->whereHas('form2', function ($f2) use ($request) {
                $f2->whereNotNull('form3_id')
                    ->whereHas('form3', function ($f3) use ($request) {
                        if ($request->has('status') && !empty($request->status) && $request->status > 0) {
                            $f3->where('form_status_id', $request->status);
                        } else {
                            $f3->where(function ($q) {
                                $q->whereIn('form_status_id', [31, 46])
                                    ->orWhere(function ($q2) {
                                        $q2->whereIn('form_status_id', [32])
                                            ->whereHas('created_by', function ($u) {
                                                $u->where('user_type_id', Auth::user()->user_type_id == 1 ? 2 : Auth::user()->user_type_id);
                                            });
                                    });
                            });
                        }
                    });
            });

            $case->whereHas('claimCase', function ($cc) use ($request) {
                if ($request->has('branch') && !empty($request->branch) && $request->branch > 0) {
                    $cc->where('branch_id', $request->branch);
                }
            });

            return Datatables::of($case)
                ->addIndexColumn()
                ->editColumn('processed_at_form1', function ($case) {
                    return date('d/m/Y', strtotime($case->claimCase->form1->filing_date));
                })
                ->editColumn('filing_date_form3', function ($case) {
                    if ($case->form2->form3->filing_date) {
                        return date('d/m/Y', strtotime($case->form2->form3->filing_date));
                    }

                    return '-';
                })
                ->editColumn('case_no', function ($case) {
                    return "<a class='' href='" . route('claimcase-view', [$case->claim_case_id]) . "'> " . $case->case_no . "</a>";
                    //return $case->case_no;
                })
                ->editColumn('claimant_name', function ($case) {
                    return $case->claimCase->claimant_address->name;
                })
                ->editColumn('opponent_name', function ($case) {
                    if ($case->opponent_user_id) {
                        return $case->opponent_address->name;
                    } else {
                        return "";
                    }
                })
                ->editColumn('status', function ($case) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    return $case->form2->form3->status->$status_lang;
                })
                ->editColumn('action', function ($case) {

                    $userid = Auth::id();
                    $user = User::find($userid);

                    $button = "";

                    $button .= actionButton('blue', __('button.view'), route('form3-view', ['id' => $case->id]), false, 'fa-search', false);

                    $allow = false;

                    if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks'))
                        if (Auth::user()->ttpm_data->branch_id == $case->branch_id)
                            $allow = true;
                        else $allow = false;
                    else $allow = true;

                    if ($allow) {

                        if ($case->form2->form3->form_status_id == 31 || ($user->user_type_id != 3
                                //&& $case->form1->form2->form3->form_status_id == 32
                            ))
                            $button .= actionButton('green-meadow', __('button.edit'), route('form3-edit', ['id' => $case->id]), false, 'fa-edit', false);

                        if (($case->form2->form3->form_status_id == 31 || $case->form2->form3->form_status_id == 32) && $user->user_type_id != 3)
                            $button .= '<a class="btn btn-xs purple" rel="tooltip" data-original-title="' . __('button.process') . '" onclick="processForm3(' . $case->id . ')"><i class="fa fa-spinner"></i></a>';

                    }

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form3Controller", null, null, "Datatables load form 3");

        return view("claimcase/form3/list", compact('status', 'branches', 'years', 'months', 'input'));
    }

    public function process(Request $request)
    {

        $claim_case_id = $request->claim_case_id;

        $cco = ClaimCaseOpponent::find($claim_case_id);
	    $case = $cco->claimCase;

        // $psus = RoleUser::where('role_id', 18)->orWhere('role_id', 17)->orWhere('role_id', 10)->get()->filter(function($query){
        //     return $query->user->user_status_id == 1;
        // });

        $psus = RoleUser::whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) use ($cco) {
                return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) use ($cco) {
                    return $user_ttpm->where('branch_id', $cco->claimCase->branch_id);
                });
            })
            ->get();


        return view('claimcase.form3.modalProcess', compact('case', 'psus', 'cco'));

    }

    public function view($claim_case_id)
    {
        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id != 3) {
            $is_staff = true;
        } else {
            $is_staff = false;
        }

        $claim_case = ClaimCaseOpponent::with('claimCase', 'form2')
            ->find($claim_case_id);

        if (Auth::user()->user_type_id == 3) {
            if ($claim_case->claimCase->claimant_user_id != Auth::id() && $claim_case->opponent_user_id != Auth::id()) {
                abort(404);
            }
        }

        $case_no = $claim_case->case_no;

        if ($claim_case->form2->form3_id) {
            $attachments = Attachment::where('form_no', 3)
                ->where('form_id', $claim_case->form2->form3_id)
                ->get();
        } else {
            $attachments = NULL;
        }

        $date = [];

        if ($claim_case->form2->form3_id && $claim_case->form2->form3->filing_date) {
            $date['form3_filing_date'] = date('d/m/Y', strtotime($claim_case->form2->form3->filing_date));
        }

        $claim_case_opponent = $claim_case;
        $claim_case = $claim_case->claimCase;

        $locale = App::getLocale();
        $status_lang = "hearing_status_" . $locale;

        return view("claimcase/form3/infoForm3", compact('case_no', 'claim_case', 'is_staff', 'userid',
            'attachments', 'date', 'claim_case_opponent', 'user', 'status_lang'));
    }

    public function insertCase(Request $request)
    {
        $rules['psu'] = 'required|numeric';
        $validator = Validator::make($request->all(), $rules);

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

//            $claim_case_id = $request->claim_case_id;
            $claim_case_opponent_id = $request->claim_case_id;
            $claim_case_opponent = ClaimCaseOpponent::find($claim_case_opponent_id);
            $case = $claim_case_opponent->claimCase;

            $filing_date = $request->filing_date ? Carbon::createFromFormat('d/m/Y', $request->filing_date)->toDateTimeString() : NULL;
            $psu = $request->psu;

            $form3 = $claim_case_opponent->form2->form3;
            $form3->filing_date = $filing_date;
            $form3->form_status_id = 46;
            $form3->processed_by_user_id = Auth::id();
            $form3->processed_at = Carbon::now();
            $form3->updated_at = Carbon::now();
            $form3->save();

            $case->psu_user_id = $psu;
            $case->case_status_id = $case->case_status_id > 6 ? $case->case_status_id : 6;
            $case->save();

            return response()->json(['result' => 'Success']);
        }
    }
}
