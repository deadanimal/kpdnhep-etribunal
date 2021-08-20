<?php

namespace App\Http\Controllers\ClaimCase;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form2;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterDesignation;
use App\Repositories\LogAuditRepository;
use App\RoleUser;
use App\PaymentModel\Payment;
use App\PaymentModel\PaymentPostalOrder;
use App\SupportModel\Attachment;
use App\SupportModel\CounterClaim;
use App\SupportModel\UserClaimCase;
use App\User;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Redirect;
use PDF;
use Yajra\Datatables\Datatables;

class Form2Controller extends Controller
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
            $this->data['form2_filing_date'] = date('d M Y', strtotime($claim_case_opponent->form2->filing_date));

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "Form2Controller", $claim->case_no, null, "Download form 2 (PDF)");

            if (App::getLocale() == 'en') {
                $pdf = PDF::loadView('claimcase/form2/printform2en', $this->data);
            } elseif (App::getLocale() == 'my') {
                $pdf = PDF::loadView('claimcase/form2/printform2my', $this->data);
            }

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Borang 2 ' . $claim->case_no . '.pdf');
        } else if ($format == 'docx') {
            $gen = new \App\Http\Controllers\GeneralController;

            $file = $gen->integrateDocTemplate('form2_' . App::getLocale(), [
                "hearing_venue_short" => $claim->venue ? $claim->venue->hearing_venue : '-',
                "state_name" => $claim->branch->state->state,
                "case_no" => $claim->case_no,
                "claimant_name" => htmlspecialchars($claim->claimant_address->name),
                "claimant_identification_type" => $claim->claimant_address->nationality_country_id == 129 ? __('form1.ic_no') : __('form1.passport_no'),
                "claimant_identification_no" => htmlspecialchars($claim->claimant_address->identification_no),
                "claimant_address" => htmlspecialchars($claim->claimant_address->street_1 . ($claim->claimant_address->street_2 ? ', ' . $claim->claimant_address->street_2 : '')
                    . ($claim->claimant_address->street_3 ? ', ' . $claim->claimant_address->street_3 : '') . ', '
                    . $claim->claimant_address->postcode . ' ' . ($claim->claimant_address->district ? $claim->claimant_address->district->district : '') . ', '
                    . ($claim->claimant_address->state ? $claim->claimant_address->state->state : '')),
                "claimant_phone_home" => htmlspecialchars($claim->claimant_address->phone_home),
                "claimant_phone_mobile" => htmlspecialchars($claim->claimant_address->phone_mobile),
                "claimant_email" => htmlspecialchars($claim->claimant_address->email),
                "claimant_phone_fax" => htmlspecialchars($claim->claimant_address->phone_fax),

                "opponent_name" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->name : '-'),
                "opponent_identification_type" => $claim_case_opponent->opponent_address ?
                    $claim_case_opponent->opponent_address->is_company == 0 ?
                        ($claim_case_opponent->opponent_address->nationality_country_id == 129 ?
                            __('form1.ic_no') :
                            __('form1.passport_no')) :
                        __('form1.company_no') :
                    '-',
                "opponent_identification_no" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->identification_no : '-'),
                "opponent_address" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->street_1
                    . ($claim_case_opponent->opponent_address->street_2 ? ', ' . $claim_case_opponent->opponent_address->street_2 : '')
                    . ($claim_case_opponent->opponent_address->street_3 ? ', ' . $claim_case_opponent->opponent_address->street_3 : '') . ', '
                    . $claim_case_opponent->opponent_address->postcode . ' ' . ($claim_case_opponent->opponent_address->district ? $claim_case_opponent->opponent_address->district->district : '') . ', '
                    . ($claim_case_opponent->opponent_address->state ? $claim_case_opponent->opponent_address->state->state : '') : '-'),
                "opponent_phone_home" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_office : '-'),
                "opponent_phone_mobile" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_mobile : '-'),
                "opponent_email" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->email : '-'),
                "opponent_phone_fax" => htmlspecialchars($claim_case_opponent->opponent_address ? $claim_case_opponent->opponent_address->phone_fax : '-'),

                "defence_statement" => htmlspecialchars($claim_case_opponent->form2->defence_statement),
                "counterclaim_statement" => htmlspecialchars($claim_case_opponent->form2->counterclaim ? $claim_case_opponent->form2->counterclaim->counterclaim_statement : ''),
                "filing_date" => date('d/m/Y', strtotime($claim->form1->filing_date)),
                "psu_name" => htmlspecialchars(strtoupper($claim->psu->name)),
                "psu_role_en" => strtoupper($claim->psu->roleuser->first()->role->display_name_en),
                "psu_role_my" => strtoupper($claim->psu->roleuser->first()->role->display_name_my),
                "branch_address" => htmlspecialchars($claim->branch->branch_name),
                "branch_phone_office" => htmlspecialchars($claim->branch->branch_office_phone),
                "branch_phone_fax" => htmlspecialchars($claim->branch->branch_office_fax),
                "branch_email" => htmlspecialchars($claim->branch->branch_emel),
                "hearing_date" => $claim_case_opponent->lastForm4 ? date('d/m/Y', strtotime($claim_case_opponent->lastForm4->hearing->hearing_date)) : '-',
                "hearing_time" => $claim_case_opponent->lastForm4 ? date('d/m/Y', strtotime($claim_case_opponent->lastForm4->hearing->hearing_date . " " . $claim_case_opponent->lastForm4->hearing->hearing_time)) : '-',
                "receipt_no" => htmlspecialchars($claim_case_opponent->form2->payment ? $claim_case_opponent->form2->payment->receipt_no : '-')
            ]);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "Form2Controller", $claim->case_no, null, "Download form 2 (DOCX)");

            return response()->download($file, 'Borang 2 ' . $claim->case_no . '.docx')->deleteFileAfterSend(true);
        }

    }

    public function create(Request $request, $claim_case_id)
    {
        $claim_case_opponent_id = $claim_case_id;
        $user_id = auth()->user()->user_id;
        $case = ClaimCaseOpponent::with('claimCase')->find($claim_case_opponent_id);
        $segment = $request->segment(3);

        if ($case == null && auth()->user()->user_type_id == 3) {
            abort(404);
        }

        if ($case->claimCase->form1_id) {
            if ($case->claimCase->form1->form_status_id < 17) {
                return;
            }
        } else {
            return;
        }

        // Check for user_id and get claimant information from database
        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id != 3) {
            $is_staff = true;
            $user = new User;
        } else {
            $is_staff = false;
        }

        $state_districts = MasterState::find($case->opponent_address->state_id)->districts;

        if ($case->form2 && $case->form2->form2_id) {
            $attachments = Attachment::where('form_no', 2)->where('form_id', $case->form2->form2_id)->get();
        } else {
            $attachments = null;
        }

        $f1_attachments = Attachment::where('form_no', 1)->where('form_id', $case->claimCase->form1_id)->get();

        $states = MasterState::all();
        $districts = MasterDistrict::all();
        $countries = MasterCountry::all();

        $designations = MasterDesignation::all();
        // $psus = RoleUser::where('role_id', 18)->orWhere('role_id', 17)->orWhere('role_id', 10)->get()->filter(function($query) use ($case){
        //     return ($query->user->user_status_id == 1) && ($query->user->ttpm_data->branch_id == $case->branch_id);
        // });
        $psus = RoleUser::with('user')
            ->whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) use ($case) {
                return $user->where('user_status_id', 1)
                    ->whereHas('ttpm_data', function ($user_ttpm) use ($case) {
                        return $user_ttpm->where('branch_id', $case->claimCase->branch_id);
                    });
            })
            ->get();

        $caseOppo = $case;
        $case = $case->claimCase;

        return view("claimcase/form2/viewForm2", compact('user', 'states', 'state_districts',
            'districts', 'countries', 'is_staff', 'case', 'attachments', 'f1_attachments',
            'designations', 'psus', 'opponent', 'segment', 'caseOppo'));
    }

    public function partialCreate1(Request $request)
    {
        $segment = $request->segment(3);

        $user_id = auth()->user()->user_id;
        $claim_case_id = $request->claim_case_id;
        $case = ClaimCaseOpponent::with('claimCase')
            ->where('id', $claim_case_id)
            ->first();

        if (!$case->form2) {
            // create partially form2
            $form2 = Form2::create([
                'form1_id' => $case->claimCase->form1_id,
                'opponent_user_id' => $user_id,
                'claim_case_opponent_id' => $case->id,
            ]);

            if ($case->claimCase->case_status_id < 4) {
                $case->claimCase->case_status_id = 3;
                $case->save();
            } // unprocess form2.
        } else {
            $form2 = $case->form2;
        }

        return response()->json(['result' => 'Success', 'form2_id' => $form2->form2_id]);
    }

    protected function rules_partial2($case)
    {
        $rules = [
            'opponent_street1' => 'required',
            'opponent_postcode' => 'required|string|min:5|max:5',
            'opponent_district' => 'required|integer',
            'opponent_state' => 'required|integer'
        ];

        return $rules;
    }

    public function partialCreate2(Request $request)
    {
        $segment = $request->segment(3);
        $user_id = auth()->user()->user_id;
        $claim_case_id = $request->claim_case_id;
        $case = ClaimCaseOpponent::with('claimCase')
            ->where('id', $claim_case_id)
            ->first();

        $opponent = $case;

        $validator = Validator::make($request->all(), $this->rules_partial2($case));
        
        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            $opponent_street1 = $request->opponent_street1 ?? null;
            $opponent_street2 = $request->opponent_street2 ?? null;
            $opponent_street3 = $request->opponent_street3 ?? null;
            $opponent_postcode = $request->opponent_postcode ?? null;
            $opponent_state = $request->opponent_state ?? null;
            $opponent_district = $request->opponent_district ?? null;
            $opponent_phone_home = $request->opponent_phone_home ?? null;
            $opponent_phone_mobile = $request->opponent_phone_mobile ?? null;
            $opponent_phone_office = $request->opponent_phone_office ?? null;
            $opponent_phone_fax = $request->opponent_phone_fax ?? null;
            $opponent_email = $request->opponent_email ?? null;

            if ($opponent->opponent->public_data && $opponent->opponent->public_data->user_public_type_id == 2) {
                // Update representative data
                $representative_identification_no = $request->representative_identification_no;
                $representative_nationality = $request->representative_nationality ?? null;
                $representative_name = $request->representative_name ?? null;
                $representative_designation = $request->representative_designation ?? null;

                $user_public_company = UserPublicCompany::where('user_id', $opponent->opponent_user_id)->first();
                $user_public_company->representative_name = $representative_name;
                $user_public_company->representative_nationality_country_id = $representative_nationality;
                $user_public_company->representative_identification_no = $representative_identification_no;
                $user_public_company->representative_designation_id = $representative_designation;
                $user_public_company->representative_phone_home = $opponent_phone_home;
                $user_public_company->representative_phone_mobile = $opponent_phone_office;
                $user_public_company->save();

            } else {
                $user_public_individual = UserPublicIndividual::where('user_id', $opponent->opponent_user_id)->first();
                $user_public_individual->phone_home = $opponent_phone_home;
                $user_public_individual->phone_mobile = $opponent_phone_office;
                $user_public_individual->save();
            }

            $opponent_address = UserClaimCase::find($opponent->opponent_address_id)->update([
                'street_1' => $opponent_street1,
                'street_2' => $opponent_street2,
                'street_3' => $opponent_street3,
                'postcode' => $opponent_postcode,
                'district_id' => $opponent_district,
                'state_id' => $opponent_state,

                'phone_home' => isset($opponent_phone_home) ? $opponent_phone_home : null,
                'phone_mobile' => isset($opponent_phone_mobile) ? $opponent_phone_mobile : null,
                'phone_office' => isset($opponent_phone_office) ? $opponent_phone_office : null,
                'phone_fax' => $opponent_phone_fax,
                'email' => $opponent_email,

                'updated_at' => Carbon::now()
            ]);

            $opponent = User::find($opponent->opponent_user_id);
            $opponent->phone_office = $opponent_phone_office;
            $opponent->phone_fax = $opponent_phone_fax;
            $opponent->email = $opponent_email;
            $opponent->save();

            return response()->json(['result' => 'Success']);
        }
    }


    public function partialCreate3(Request $request)
    {
        // Get claim_case_id
        $claim_case_opponent_id = $claim_case_id = $request->claim_case_id;
        $user_id = auth()->user()->user_id;
        $case = ClaimCaseOpponent::with('claimCase')
            ->where('id', $claim_case_id)
            ->first();

        $rules = [
            'defence_statement' => 'required'
        ];

        if ($request->is_counterclaim == 1) {
            $rules['total_counterclaim'] = 'required';
            $rules['counterclaim_desc'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            $defence_statement = $request->defence_statement;
            $is_counterclaim = $request->is_counterclaim;
            $total_counterclaim = $request->total_counterclaim;
            $counterclaim_desc = $request->counterclaim_desc;

            $form2 = Form2::where('claim_case_opponent_id', $claim_case_opponent_id);

//            if (Auth::user()->hasRole('user')) {
//                $form2->where('opponent_user_id', auth()->user()->user_id); // opponent = orang yang claim b1 kepada b2.
//            }

            $form2 = $form2->first();

            if ($form2 && $form2->counterclaim_id != null) {
                if ($is_counterclaim == 1) {
                    // Update
                    $counterclaim = CounterClaim::find($form2->counterclaim_id)->update([
                        'counterclaim_amount' => $total_counterclaim,
                        'counterclaim_statement' => $counterclaim_desc,
                        'updated_at' => Carbon::now()
                    ]);

                    $counterclaim_id = $form2->counterclaim_id;
                } else {
                    // Delete
                    $counterclaim_id = null;

                    $counterclaim = CounterClaim::find($form2->counterclaim_id);
                    $form2->counterclaim_id = null;
                    $form2->save();
                    $counterclaim->delete();

                }
            } else {
                if ($is_counterclaim == 1) {
                    // Add
                    $counterclaim_id = DB::table('counterclaim')->insertGetId([
                        'counterclaim_amount' => $total_counterclaim,
                        'counterclaim_statement' => $counterclaim_desc,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $counterclaim_id = null;
                }
            }

            $form2->defence_statement = $defence_statement;
            $form2->counterclaim_id = $counterclaim_id;
            $form2->save();

            return response()->json(['result' => 'Success']);

        }
    }

    public function uploadAttachment(Request $request)
    {
        if ($request->ajax()) {
            $claim_case_id = $request->claim_case_id;
            $form_no = 2;
            $case = ClaimCaseOpponent::with('claimCase')
                ->where('id', $claim_case_id)
                ->first();
            $form2_id = $case->form2->form2_id;
            $created_by = Auth::id();

            //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

            $oldAttachments = Attachment::where('form_no', 2)
                ->where('form_id', $form2_id)
                ->get();

            if ($request->hasFile('attachment_1')) {
                if ($request->file('attachment_1')->isValid()) {
                    if ($oldAttachments->get(0)) {
                        if ($request->file1_info == 2) {
                            // Replace
                            $oldAttachments->get(0)->delete();

                            $attachment = new Attachment;
                            $attachment->form_no = $form_no;
                            $attachment->form_id = $form2_id;
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
                            $attachment->form_id = $form2_id;
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
                    $audit->add($request, 4, "Form2Controller", json_encode($request->input()), null, "Form 2 " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form2_id;
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
                            $attachment->form_id = $form2_id;
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
                    $audit->add($request, 4, "Form2Controller", json_encode($request->input()), null, "Form 2 " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");

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
                            $attachment->form_id = $form2_id;
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
                            $attachment->form_id = $form2_id;
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
                    $audit->add($request, 4, "Form2Controller", json_encode($request->input()), null, "Form 2 " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");

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
                            $attachment->form_id = $form2_id;
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
                            $attachment->form_id = $form2_id;
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
                    $audit->add($request, 4, "Form2Controller", json_encode($request->input()), null, "Form 2 " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $form2_id;
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
                            $attachment->form_id = $form2_id;
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
                    $audit->add($request, 4, "Form2Controller", json_encode($request->input()), null, "Form 2 " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");
                }
            } else {
                if ($oldAttachments->get(4)) {
                    if ($request->file5_info == 2) {
                        $oldAttachments->get(4)->delete();
                    }
                }
            }

            if ($case->form2->payment_id != null) {
                if ($case->form2->payment->payment_status_id == 3 || $case->form2->payment->payment_status_id == 4)
                    $paid = true;
                else
                    $paid = false;
            } else {
                $paid = false;
            }

            return response()->json(['result' => 'Success', 'paid' => $paid]);
        }
    }

    /**
     * @param $claim_case_opponent_id
     * @return mixed
     */
    public function payFPX($claim_case_opponent_id)
    {
        $case = ClaimCaseOpponent::find($claim_case_opponent_id);

        if ($case) {
            $form2_id = $case->form2->form2_id;

            $payment = Payment::create([
                'is_payment_counter' => 0,
                'payment_status_id' => 1,
                'claim_case_id' => $case->claim_case_id,
                'claim_case_opponent_id' => $claim_case_opponent_id,
                'form_no' => 2,
                'form_id' => $form2_id,
                'description' => "Pemfailan Borang 2 / Form 2 Filing",
            ]);

            $form2 = Form2::where('form2_id', $form2_id)
                ->update([
                    'form_status_id' => 20,
                    'payment_id' => $payment->payment_id,
                ]);

            return Response::json(['result' => 'ok', 'payment_id' => $payment->payment_id]);
        } else {
            return Response::json(['result' => 'ko']);
        }
    }

    public function payCounter($claim_case_opponent_id)
    {
        $case = ClaimCaseOpponent::with('claimCase')
            ->where('id', $claim_case_opponent_id)
            ->first();

        if ($case) {
            $payment_id = $case->form2->payment_id;
            $form2_id = $case->form2->form2_id;

            if ($payment_id == null) {
                $payment = Payment::create([
                    'is_payment_counter' => 1,
                    'payment_status_id' => 3,
                    'claim_case_id' => $case->claimCase->claim_case_id,
                    'claim_case_opponent_id' => $claim_case_opponent_id,
                    'form_no' => 2,
                    'form_id' => $form2_id,
                    'description' => "Pemfailan Borang 2 / Form 2 Filing",
                ]);

                $form2 = $case->form2;
                $form2->form_status_id = 20;
                $form2->payment_id = $payment->payment_id;
                $form2->updated_at = Carbon::now();
                $form2->save();
            } else {
                $payment = Payment::find($payment_id);
                $payment->is_payment_counter = 1;
                $payment->payment_fpx_id = NULL;
                $payment->payment_postalorder_id = NULL;
                $payment->claim_case_id = $case->claimCase->claim_case_id;
                $payment->claim_case_opponent_id = $claim_case_opponent_id;
                $payment->form_no = 2;
                $payment->form_id = $form2_id;
                $payment->description = "Pemfailan Borang 2 / Form 2 Filing";
                $payment->updated_at = Carbon::now();
                $payment->payment_status_id = 3;
                $payment->save();

                $form2 = Form2::find($form2_id);
                $form2->form_status_id = 20;
                $form2->updated_at = Carbon::now();
                $form2->save();
            }

            return Response::json(['result' => 'ok', 'payment_id' => $payment_id]);
        } else
            return Response::json(['result' => 'ko']);
    }

    public function payPostalOrder(Request $request)
    {
        $claim_case_opponent_id = $request->claim_case_id;
        $case = ClaimCaseOpponent::with('claimCase')
            ->where('id', $claim_case_opponent_id)
            ->first();

        if ($case) {
            $payment_id = $case->form2->payment_id;
            $form2_id = $case->form2->form2_id;

            if ($payment_id == null) {
                $payment_postalorder = PaymentPostalOrder::create([
                    'postalorder_no' => $request->postalorder_no,
                    'paid_at' => Carbon::createFromFormat('d/m/Y', $request->postalorder_date)->toDateTimeString(),
                    'created_by_user_id' => Auth::id(),
                ]);

                $payment = Payment::create([
                    'is_payment_counter' => 0,
                    'payment_status_id' => 3,
                    'payment_postalorder_id' => $payment_postalorder->payment_postalorder_id,
                    'claim_case_id' => $case->claimCase->claim_case_id,
                    'claim_case_opponent_id' => $claim_case_opponent_id,
                    'form_no' => 2,
                    'form_id' => $form2_id,
                    'description' => "Pemfailan Borang 2 / Form 2 Filing",
                ]);

                $form2 = Form2::find($form2_id);
                $form2->form_status_id = 20;
                $form2->payment_id = $payment->payment_id;
                $form2->updated_at = Carbon::now();
                $form2->save();
            } else {
                $payment = Payment::find($payment_id);

                $payment_postalorder = PaymentPostalOrder::create([
                    'postalorder_no' => $request->postalorder_no,
                    'paid_at' => Carbon::createFromFormat('d/m/Y', $request->postalorder_date)->toDateTimeString(),
                    'created_by_user_id' => Auth::id(),
                ]);

                $payment = Payment::find($payment_id);
                $payment->is_payment_counter = 0;
                $payment->payment_fpx_id = NULL;
                $payment->payment_postalorder_id = $payment_postalorder->payment_postalorder_id;
                $payment->claim_case_id = $case->claimCase->claim_case_id;
                $payment->claim_case_opponent_id = $claim_case_opponent_id;
                $payment->form_no = 2;
                $payment->form_id = $form2_id;
                $payment->description = "Pemfailan Borang 2 / Form 2 Filing";
                $payment->updated_at = Carbon::now();
                $payment->payment_status_id = 3;
                $payment->save();

                $form2 = Form2::find($form2_id);
                $form2->form_status_id = 20;
                $form2->updated_at = Carbon::now();
                $form2->save();
            }

            return Response::json(['result' => 'ok', 'payment_id' => $payment_id]);
        } else
            return Response::json(['result' => 'ko']);
    }

    public function list(Request $request)
    {
        $status = MasterFormStatus::where('form_status_id', '>=', 18)
            ->where('form_status_id', '<=', 22)
            ->get();
        $branches = MasterBranch::where('is_active', 1)
            ->orderBy('branch_id', 'desc')
            ->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $input = $request->all();

        $input['year'] = (!isset($input['year']) || trim($input['year']) === '') ? date('Y') : $input['year'];

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('onlineprocess.form2', ['branch' => Auth::user()->ttpm_data->branch_id ?? '']);
        }

        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);

            $case = ClaimCaseOpponent::select([
                'claim_case.claim_case_id',
                'form1.form1_id',
                'form2.form2_id',
                'form2.filing_date',
                'claim_case_opponents.id',
                'claim_case_opponents.opponent_user_id',
                'claim_case_opponents.opponent_address_id',
            ])
                ->with([
                    'claimCase.form1.form2Inv', 'claimCase.claimant_address',
                    'claimCase', 'opponent_address', 'form2.status'
                ])
                ->join('claim_case', 'claim_case_opponents.claim_case_id', '=', 'claim_case.claim_case_id')
                ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
                ->join('form2', 'form2.claim_case_opponent_id', '=', 'claim_case_opponents.id')
                ->orderBy('form2.filing_date', 'desc')
                ->orderBy('form1.filing_date', 'desc') // contigencies: if choose non-filed form2
                ->whereNotNull('claim_case.form1_id')
                ->whereHas('form2', function ($form2) use ($request) {
                    if ($request->has('status') && !empty($request->status)) {
                        $form2->where('form_status_id', $request->status);
                    }
                });

            if ($input['year'] > 0) {
                $case->whereYear('form1.filing_date', $input['year']);
            }

            if ($request->has('month') && !empty($request->month)) {
                $case->whereMonth('form2.filing_date', $request->month);
            }

            if (Auth::user()->hasRole('user')) {
                $case->where('claim_case_opponents.opponent_user_id', $userid);
            }

            if ($request->has('branch') && !empty($request->branch) && $request->branch > 0) {
                $case->whereHas('claimCase', function ($q) use ($request) {
                    return $q->where('branch_id', $request->branch);
                });
            }

            return Datatables::of($case)
                ->addIndexColumn()
                ->editColumn('filing_date_form1', function ($case) {
                    return date('d/m/Y', strtotime($case->claimCase->form1->processed_at));
                })
                ->editColumn('filing_date_form2', function ($case) {
                    if ($case->form2 && $case->form2->filing_date) {
                        return date('d/m/Y', strtotime($case->form2->filing_date));
                    }
                    return "-";
                })
                ->editColumn('matured_date', function ($case) {
                    if ($case->form2 && $case->form2->matured_date) {
                        return date('d/m/Y', strtotime($case->form2->matured_date));
                    }

                    return "-";
                })
                ->editColumn('case_no', function ($case) {
                    return "<a class='' href='" . route('claimcase-view-cc', [$case->id, 'cc']) . "'> " . $case->claimCase->case_no . "</a>";
                })
                ->editColumn('claimant_name', function ($case) {
                    return $case->claimCase->claimant_address->name;
                })
                ->editColumn('opponent_name', function ($case) {
                    if ($case->opponent_address) {
                        return $case->opponent_address->name;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('status', function ($case) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    return $case->form2->status->$status_lang;
                })
                ->editColumn('action', function ($case) {

                    $userid = Auth::id();
                    $user = User::find($userid);

                    $button = "";

                    if ($case->form2->form_status_id > 18) {
                        $button .= actionButton('blue', __('button.view'), route('form2-view', ['id' => $case->id]), false, 'fa-search', false);
                    }

                    $allow = false;

                    if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('psu')) {
                        if (Auth::user()->ttpm_data->branch_id == $case->claimCase->branch_id) {
                            $allow = true;
                        } else {
                            $allow = false;
                        }
                    } else {
                        $allow = true;
                    }

                    if ($allow) {

                        /**
                         * Edit
                         */
                        if ($case->form2->form_status_id == 18 || ($user->user_type_id != 3 && $case->form2->form_status_id == 21) || ($user->user_type_id != 3)) {
                            $button .= actionButton('green-meadow', __('button.edit'), route('form2-edit', ['id' => $case->id]), false, 'fa-edit', false);
                        }

                        /**
                         * Payment
                         */
                        if (($case->form2->form_status_id == 18 || $case->form2->form_status_id == 20) && $user->user_type_id == 3) {
                            $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="' . __('button.make_payment') . '" onclick="choosePaymentMethod(' . $case->id . ')"><i class="fa fa-dollar"></i></a>';
                        }

                        /**
                         * Process
                         */
                        if (($case->form2->form_status_id == 19 || $case->form2->form_status_id == 20 || $case->form2->form_status_id == 21) && $user->user_type_id != 3) {
                            $button .= '<a class="btn btn-xs purple" rel="tooltip" data-original-title="' . __('button.process') . '" onclick="processForm2(' . $case->id . ')"><i class="fa fa-spinner"></i></a>';
                        }

                        /**
                         * user is not public
                         * and (submit form 2 or hearing)
                         * and allow
                         * and not have form3
                         * and form2 have counter claim id
                         * Form3 Create
                         */
                        if ($user->user_type_id != 3 && ($case->claimCase->case_status_id == 4 || $case->claimCase->case_status_id == 7) && $allow && !$case->form2->form3 && $case->form2->counterclaim_id) {
                            $button .= actionButton('blue btn-outline', __('form3.file_form3'), route('form3-create', ['claim_case_id' => $case->id]), false, 'fa-plus', false, __('form3.form3'));
                        }
                    }

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form2Controller", null, null, "Datatables load form 2");

        return view("claimcase/form2/list", compact('status', 'branches', 'years', 'months', 'input'));
    }

    public function process(Request $request)
    {
        $claim_case_id = $request->claim_case_id;

        $case = ClaimCaseOpponent::find($claim_case_id);

        $psus = RoleUser::whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) use ($case) {
                return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) use ($case) {
                    return $user_ttpm->where('branch_id', $case->claimCase->branch_id);
                });
            })
            ->get();;

        return view('claimcase.form2.modalProcess', compact('case', 'psus'));
    }

    public function view($claim_case_id)
    {
        $userid = Auth::id();
        $user = Auth::user();
        $is_staff = ($user->user_type_id != 3) ? true : false;

        $claim_case_opponent = ClaimCaseOpponent::find($claim_case_id);

        if ($user->user_type_id == 3) {
            if ($claim_case_opponent->claimCase->claimant_user_id != $userid && $claim_case_opponent->opponent_user_id != $userid) {
                abort(404);
            }
        }

        $case_no = $claim_case_opponent->claimCase->case_no;

        if ($claim_case_opponent->form2->form2_id) {
            $attachments = Attachment::where('form_no', 2)
                ->where('form_id', $claim_case_opponent->form2->form2_id)
                ->get();
            $payments = Payment::where('form_no', 2)
                ->where('claim_case_id', $claim_case_opponent->claim_case_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $attachments = NULL;
            $payments = null;
        }

        $date = array();

        if ($claim_case_opponent->form2) {
            if ($claim_case_opponent->form2->filing_date) {
                $date['form2_filing_date'] = date('d/m/Y', strtotime($claim_case_opponent->form2->filing_date));
            }

            if ($claim_case_opponent->form2->matured_date) {
                $date['form2_matured_date'] = date('d/m/Y', strtotime($claim_case_opponent->form2->matured_date));
            }

            if ($claim_case_opponent->form2->payment_id) {
                if ($claim_case_opponent->form2->payment->paid_at) {
                    $date['form2_paid_at'] = date('d/m/Y', strtotime($claim_case_opponent->form2->payment->paid_at));
                }
            }
        }

        $claim_case_oppo = $claim_case_opponent;
        $claim_case = $claim_case_opponent->claimCase;

        return view("claimcase/form2/infoForm2", compact('case_no', 'claim_case', 'claim_case_oppo',
            'is_staff', 'userid', 'attachments', 'date', 'payments', 'user'));
    }

    protected function rules_partial5($request, $type = null)
    {

        $rules = [
            'payment_method' => 'required|numeric',
            'psu' => 'required|numeric'
        ];

        if ($request->payment_method != 1) {
            $rules['payment_date'] = 'required';
            $rules['receipt_no'] = 'required';
        }

        if ($request->payment_method == 3) {
            $rules['postalorder_no'] = 'required';
        }

        return $rules;
    }

    public function insertCase(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_partial5($request));

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            // Get claim_case_id
            $claim_case_id = $request->claim_case_id;
            $case = ClaimCaseOpponent::find($claim_case_id);
            $claim_case_opponent = $case;
            $case = $claim_case_opponent->claimCase;

            ////////////////////////////////////////////////////////////////////////////////////////////////

            $filing_date = $request->filing_date ? Carbon::createFromFormat('d/m/Y', $request->filing_date)->toDateString() : Carbon::now()->toDateString();
            $matured_date = $request->matured_date ? Carbon::createFromFormat('d/m/Y', $request->matured_date)->toDateString() : $general->getDateExcludeHolidaysByBranch($filing_date, env("CONF_F2_MATURED_DURATION", 14), $case->branch_id);

            $payment_method = $request->payment_method;
            $postalorder_no = $request->postalorder_no;
            $receipt_no = $request->receipt_no;
            $payment_date = $request->payment_date ? Carbon::createFromFormat('d/m/Y', $request->payment_date)->toDateTimeString() : NULL;

            $psu = $request->psu;
            //$hearing_date = $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateTimeString() : NULL;
            $form2_id = $claim_case_opponent->form2->form2_id;
            $form2 = Form2::find($form2_id);

            $form2->filing_date = $filing_date;
            $form2->matured_date = $matured_date;
            $form2->processed_by_user_id = Auth::id();
            $form2->processed_at = Carbon::now();
            //$form1->hearing_date = $hearing_date;


            if ($form2->payment_id) {

                if ($payment_method == 2) { // Pay at counter
                    $payment_id = Payment::find($form2->payment_id)->update([
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'updated_at' => Carbon::now()
                    ]);
                } else if ($payment_method == 3) { // Pay by Postal Order

                    $payment_postalorder_id = PaymentPostalOrder::find($form2->payment->payment_postalorder_id)->update([
                        'postalorder_no' => $postalorder_no,
                        'paid_at' => $payment_date,
                        'updated_at' => Carbon::now()
                    ]);

                    $payment_id = Payment::find($form2->payment_id)->update([
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'updated_at' => Carbon::now()
                    ]);
                }

                $form2->form_status_id = $form2->form_status_id > 22 ? $form2->form_status_id : 22;

            } else {
                // Not exist yet

                if ($payment_method == 2) { // Pay at counter
                    $payment_id = DB::table('payment')->insertGetId([
                        'is_payment_counter' => 1,
                        'payment_status_id' => 4, // Completed
                        'claim_case_id' => $case->claim_case_id,
                        'form_no' => 2,
                        'form_id' => $form2_id,
                        'description' => "Pemfailan Borang 2 / Form 2 Filing",
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else if ($payment_method == 3) { // Pay by Postal Order
                    // Should be postalorder first

                    $payment_postalorder_id = DB::table('payment_postalorder')->insertGetId([
                        'postalorder_no' => $postalorder_no,
                        'paid_at' => $payment_date,
                        'created_by_user_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $payment_id = DB::table('payment')->insertGetId([
                        'is_payment_counter' => 0,
                        'payment_postalorder_id' => $payment_postalorder_id,
                        'payment_status_id' => 4, // Completed Unverified
                        'claim_case_id' => $case->claim_case_id,
                        'form_no' => 2,
                        'form_id' => $form2_id,
                        'description' => "Pemfailan Borang 2 / Form 2 Filing",
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

                $form2->payment_id = $payment_id;
                $form2->form_status_id = 22;

            }


            $form2->updated_at = Carbon::now();
            $form2->save();

            $case->case_status_id = $case->case_status_id > 4 ? $case->case_status_id : 4;
            $case->psu_user_id = $psu;
            $case->save();

            return response()->json(['result' => 'Success', 'payment_id' => $form2->payment_id]);
        }
    }
}
