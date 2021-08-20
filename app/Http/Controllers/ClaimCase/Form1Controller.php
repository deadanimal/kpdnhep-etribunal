<?php

namespace App\Http\Controllers\ClaimCase;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form1;
use App\CaseModel\Form4;
use App\CaseModel\Inquiry;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Mail\ChangeBranchAlertMail;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterClaimClassification;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterOffenceType;
use App\MasterModel\MasterRelationship;
use App\MasterModel\MasterState;
use App\MasterModel\MasterSubdistrict;
use App\PaymentModel\Payment;
use App\PaymentModel\PaymentPostalOrder;
use App\Repositories\LogAuditRepository;
use App\Repositories\MasterCountryRepository;
use App\Repositories\MasterDistrictRepository;
use App\Repositories\MasterStateRepository;
use App\Repositories\RunnerRepository;
use App\RoleUser;
use App\SupportModel\Attachment;
use App\SupportModel\CourtCase;
use App\SupportModel\UserClaimCase;
use App\SupportModel\UserExtra;
use App\User;
use App\UserPublic;
use App\UserPublicCompany;
use App\UserPublicIndividual;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Mail;
use PDF;
use Redirect;
use Yajra\Datatables\Datatables;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class Form1Controller extends Controller
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
     * Retrive claim case of that id and link it back to user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieve(Request $request)
    {
        $input = $request->all();

        // get claim case data
        $case = ClaimCase::where('case_no', $input['ttpm_no'])
            ->where('case_status_id', '>', 1)
            ->whereHas('form1.payment', function ($q) use ($input) {
                $q->where('receipt_no', $input['receipt_no']);
            })
            ->first();

        if ($case) {
            // link with claim case opponents
            $opponent = $case->multiOpponents->where('id', $input['claim_case_opponent_id'])
                ->first();

            $opponent->opponent_user_id = Auth::id();
            $opponent->save();

            // link with user claim case
            $user_claimcase = UserClaimCase::find($opponent->opponent_address_id);
            $user_claimcase->user_id = Auth::id();
            $user_claimcase->save();

            return response()->json(['status' => 'ok']);
        } else
            return response()->json(['status' => 'notfound']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $case = ClaimCase::with('form1.payment')
            ->where('case_no', $request->ttpm_no)
            ->get()
            ->where('form1.payment.receipt_no', $request->receipt_no);

        if ($case->count() == 1) {
            $case = $case->first();

            if ($case->claimant_user_id == Auth::id())
                return response()->json(['status' => 'same']);

            return response()->json([
                'status' => 'found',
                'claimant_name' => $case->claimant_address->name,
                'claimant_type' => $case->claimant_address->is_company == 1 ? 3 : ($case->claimant_address->nationality_country_id == 129 ? 1 : 2),
                'claimant_identification_no' => $case->claimant_address->identification_no,
                'opponents' => $case->multiOpponents,
//                'opponent_name' => $case->opponent_address->name,
//                'opponent_type' => $case->opponent_address->is_company == 1 ? 3 : $case->opponent_address->nationality_country_id == 129 ? 1 : 2,
//                'opponent_identification_no' => $case->opponent_address->name,
            ]);
        } else
            return response()->json(['status' => 'notfound']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     */
    public function instant(Request $request)
    {
        if ($request->isMethod('get')) {
            $categories = MasterClaimCategory::where('is_active', 1)->get();

            if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin'))
                $branches = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();
            else
                $branches = MasterBranch::where('branch_id', Auth::user()->ttpm_data->branch_id)->get();

            return view('claimcase.form1.modalInstant', compact('categories', 'branches'));
        } else if ($request->ajax()) {
            // Handle submitted form

            $rules = [
                'claimant_identification_no' => 'required',
                'claimant_name' => 'required|string|max:255',
                'filing_date' => 'required',
                'claim_category' => 'required|numeric',
                'branch_id' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            $claimant_identification_no = $request->claimant_identification_no;
            $claimant_name = $request->claimant_name;

            // Check for existing user
            $user = User::where('username', $claimant_identification_no);

            if ($user->get()->count() > 0) { // Existed
                $claimant_id = $user->first()->user_id;
            } else { // New Sent Form

                // Partial register user and return user_id

                // Create partial user and return id
                $claimant_id = DB::table('users')->insertGetId([
                    'name' => $claimant_name,
                    'username' => $claimant_identification_no,
                    'user_type_id' => 3, // Public users
                    'language_id' => 1, // English
                    'user_status_id' => 6, // Partial
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // Company or Individual
                $claimant_public = DB::table('user_public')->insertGetId([
                    'user_id' => $claimant_id,
                    'user_public_type_id' => 1 // Individual
                ]);

                $claimant_public_individual = DB::table('user_public_individual')->insertGetId([
                    'user_id' => $claimant_id,
                    'nationality_country_id' => 129,
                    'identification_no' => $claimant_identification_no
                ]);

            }

            $claimant = User::where('username', $claimant_identification_no)->first();

            $claimant_address_id = DB::table('user_claimcase')->insertGetId([
                'user_id' => $claimant_id,

                'is_company' => 0,
                'name' => $claimant_name,
                'identification_no' => $claimant_identification_no,
                'nationality_country_id' => $claimant->public_data->user_public_type_id == 2 ? 129 : $claimant->public_data->individual->nationality_country_id,

                'street_1' => $claimant->public_data->address_mailing_street_1,
                'street_2' => $claimant->public_data->address_mailing_street_2,
                'street_3' => $claimant->public_data->address_mailing_street_3,
                'postcode' => $claimant->public_data->address_mailing_postcode,
                'district_id' => $claimant->public_data->address_mailing_district_id,
                'state_id' => $claimant->public_data->address_mailing_state_id,

                'phone_home' => $claimant->public_data->individual->phone_home,
                'phone_mobile' => $claimant->public_data->individual->phone_mobile,
                'phone_office' => $claimant->phone_office,
                'phone_fax' => $claimant->phone_fax,
                'email' => $claimant->email,
                'created_by_user_id' => Auth::id(),

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $filing_date = $request->filing_date ? Carbon::createFromFormat('d/m/Y', $request->filing_date)->toDateString() : Carbon::now()->toDateString();

            $general = new GeneralController;
            $matured_date = $general->getDateExcludeHolidaysByBranch($filing_date, env("CONF_F1_MATURED_DURATION", 14), $request->branch_id);

            if ($request->claim_category == 1) {
                $category = 55;
                $category_code = 'B';
            } else {
                $category = 56;
                $category_code = 'P';
            }

            // Get current user_id
            $staff_id = Auth::id();

            $branch_id = $request->branch_id;
            $branch = MasterBranch::find($branch_id);

            $form1_id = DB::table('form1')->insertGetId([
                'filing_date' => $filing_date,
                'matured_date' => $matured_date,               // Change this later
                'form_status_id' => 16,
                'claim_classification_id' => $category,
                'created_by_user_id' => $staff_id,
                'processed_by_user_id' => $staff_id,
                'processed_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $state = MasterState::find($branch->branch_state_id);

            $filing_year = date('Y', strtotime($filing_date));
            $case_no = RunnerRepository::generateAppNumber('TTPM', $branch->branch_code, $filing_year, null, null, $category_code);

            ClaimCase::create([
                'form1_id' => $form1_id,
                'case_no' => $case_no['number'],
                'filing_date' => $filing_date,
                'claimant_user_id' => $claimant_id,
                'claimant_address_id' => $claimant_address_id,
                'case_status_id' => 2, //Draft status
                'branch_id' => $request->branch_id,
                'created_by_user_id' => Auth::id(),
            ]);

            Form1::find($form1_id)
                ->update([
                    'case_year' => $filing_year,
                    'case_sequence' => $case_no['runner'],
                ]);

            $state->next_claim_no = $state->next_claim_no + 1;
            $state->save();

//            LogAuditRepository::store($request, 10, "Form1Controller", null, null, "Create instant form 1 : claim case " . $case_no);

            return response()->json(['result' => 'Success', 'case_no' => $case_no]);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function process(Request $request)
    {
        $claim_case_id = $request->claim_case_id;
        $case = ClaimCase::find($claim_case_id);
        $offences = MasterOffenceType::where('is_active', 1)
            ->get();
        $offences_p = MasterOffenceType::where('is_active', 1)
            ->where('offence_code', 'LIKE', '%P%')
            ->get();
        $offences_b = MasterOffenceType::where('is_active', 1)
            ->where('offence_code', 'LIKE', '%B%')
            ->get();
        $categories = MasterClaimCategory::where('is_active', 1)
            ->get();
        $classifications = MasterClaimClassification::where('is_active', 1)
            ->get();

        if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin')) {
            $branches = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();
            $hearing_venues = MasterBranch::with('venues.rooms')->where('branch_id', $case->branch_id)->first()->venues;
        } else {
            $branches = MasterBranch::where('branch_id', Auth::user()->ttpm_data->branch_id)->get();
            $hearing_venues = MasterBranch::with('venues.rooms')->where('branch_id', Auth::user()->ttpm_data->branch_id)->first()->venues;
        }

        $psus = RoleUser::whereIn('role_id', [18, 17, 10])
            ->whereHas('user', function ($user) use ($case) {
                return $user->where('user_status_id', 1)
                    ->whereHas('ttpm_data', function ($user_ttpm) use ($case) {
                        return $user_ttpm->where('branch_id', $case->branch_id);
                    });
            })
            ->get();

        // Get claim_case where claimant_id same as user_id
        $claim = ClaimCase::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->where('claimant_user_id', $case->claimant_user_id)
            ->where('case_status_id', '>', 1)
            ->where('claim_case_id', '!=', $claim_case_id)
            ->get();

        // Get claim_case where opponent_id same as user_id
        $opposed = ClaimCase::join('view_case_sequence', 'view_case_sequence.case_id', '=', 'claim_case.claim_case_id')
            ->orderBy('case_year', 'desc')
            ->orderBy('case_sequence', 'desc')
            ->where('opponent_user_id', $case->claimant_user_id)
            ->where('case_status_id', '>', 1)
            ->where('claim_case_id', '!=', $claim_case_id)
            ->get();

        return view('claimcase.form1.modalProcess', compact('case', 'psus', 'offences', 'offences_p',
            'offences_b', 'categories', 'classifications', 'branches', 'claim', 'opposed', 'hearing_venues'));
    }

    /**
     * @param $claim_case_id
     * @return mixed
     */
    public function payFPX($claim_case_id)
    {
        $case = ClaimCase::find($claim_case_id);

        if ($case) {
            $payment_id = $case->form1->payment_id;

            //if(!$case->form1->payment_id) {
            $form1_id = $case->form1_id;

            $payment_id = DB::table('payment')->insertGetId([
                'is_payment_counter' => 0,
                'payment_status_id' => 1,
                'claim_case_id' => $claim_case_id,
                'form_no' => 1,
                'form_id' => $form1_id,
                'description' => "Pemfailan Borang 1 / Form 1 Filing ",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $form1 = Form1::find($form1_id);
            $form1->form_status_id = 15;
            $form1->payment_id = $payment_id;
            $form1->updated_at = Carbon::now();
            $form1->save();
            //}

            return Response::json(['result' => 'ok', 'payment_id' => $payment_id]);
        } else
            return Response::json(['result' => 'ko']);
    }

    /**
     * @param $claim_case_id
     * @return mixed
     */
    public function payCounter($claim_case_id)
    {
        $case = ClaimCase::find($claim_case_id);

        if ($case) {
            $payment_id = $case->form1->payment_id;
            $form1_id = $case->form1_id;

            if (!$case->form1->payment_id) {

                $payment_id = DB::table('payment')->insertGetId([
                    'is_payment_counter' => 1,
                    'payment_status_id' => 3,
                    'claim_case_id' => $claim_case_id,
                    'form_no' => 1,
                    'form_id' => $form1_id,
                    'description' => "Pemfailan Borang 1 / Form 1 Filing",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $form1 = Form1::find($form1_id);
                $form1->form_status_id = 15;
                $form1->payment_id = $payment_id;
                $form1->updated_at = Carbon::now();
                $form1->save();
            } else {
                $payment = Payment::find($payment_id);
                $payment->is_payment_counter = 1;
                $payment->payment_fpx_id = NULL;
                $payment->payment_postalorder_id = NULL;
                $payment->claim_case_id = $claim_case_id;
                $payment->form_no = 1;
                $payment->form_id = $form1_id;
                $payment->description = "Pemfailan Borang 1 / Form 1 Filing";
                $payment->updated_at = Carbon::now();
                $payment->payment_status_id = 3;
                $payment->save();

                $form1 = Form1::find($form1_id);
                $form1->form_status_id = 15;
                $form1->updated_at = Carbon::now();
                $form1->save();
            }

            return Response::json(['result' => 'ok', 'payment_id' => $payment_id]);
        } else
            return Response::json(['result' => 'ko']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function payPostalOrder(Request $request)
    {
        $claim_case_id = $request->claim_case_id;
        $case = ClaimCase::find($claim_case_id);

        if ($case) {
            $payment_id = $case->form1->payment_id;
            $form1_id = $case->form1_id;

            if (!$case->form1->payment_id) {

                $payment_postalorder_id = DB::table('payment_postalorder')->insertGetId([
                    'postalorder_no' => $request->postalorder_no,
                    'paid_at' => Carbon::createFromFormat('d/m/Y', $request->postalorder_date)->toDateTimeString(),
                    'created_by_user_id' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $payment_id = DB::table('payment')->insertGetId([
                    'is_payment_counter' => 0,
                    'payment_status_id' => 3,
                    'payment_postalorder_id' => $payment_postalorder_id,
                    'claim_case_id' => $claim_case_id,
                    'form_no' => 1,
                    'form_id' => $form1_id,
                    'description' => "Pemfailan Borang 1 / Form 1 Filing",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $form1 = Form1::find($form1_id);
                $form1->form_status_id = 15;
                $form1->payment_id = $payment_id;
                $form1->updated_at = Carbon::now();
                $form1->save();
            } else {
                $payment = Payment::find($payment_id);

                $payment_postalorder_id = DB::table('payment_postalorder')->insertGetId([
                    'postalorder_no' => $request->postalorder_no,
                    'paid_at' => Carbon::createFromFormat('d/m/Y', $request->postalorder_date)->toDateTimeString(),
                    'created_by_user_id' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $payment = Payment::find($payment_id);
                $payment->is_payment_counter = 0;
                $payment->payment_fpx_id = NULL;
                $payment->payment_postalorder_id = $payment_postalorder_id;
                $payment->claim_case_id = $claim_case_id;
                $payment->form_no = 1;
                $payment->form_id = $form1_id;
                $payment->description = "Pemfailan Borang 1 / Form 1 Filing";
                $payment->updated_at = Carbon::now();
                $payment->payment_status_id = 3;
                $payment->save();

                $form1 = Form1::find($form1_id);
                $form1->form_status_id = 15;
                $form1->updated_at = Carbon::now();
                $form1->save();
            }

            return Response::json(['result' => 'ok', 'payment_id' => $payment_id]);
        } else
            return Response::json(['result' => 'ko']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $claim_case_id
     * @param $format
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, $claim_case_id, $format)
    {
        $claim = ClaimCase::find($claim_case_id);

        $extraOpponent = $claim->extra_claimant_id != null;

        if ($format == 'pdf') {
            $this->data['claim'] = $claim;
            $this->data['extraOpponent'] = $extraOpponent;
            $audit = new AuditController;
            $audit->add($request, 17, "Form1Controller", $claim->case_no, null, "Download form 1 (PDF)");

            $pdf = PDF::loadView('claimcase/form1/printform1' . App::getLocale(), $this->data);

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Borang 1 ' . $claim->case_no . '.pdf');
        } else if ($format == 'docx') {
            $gen = new GeneralController;
            $file = $gen->integrateDocTemplate('form1_' . ($extraOpponent ? '2_' : '') . App::getLocale(), [
                "hearing_venue_short" => $claim->venue ? $claim->venue->hearing_venue : '-',
                "state_name" => $claim->branch->state->state,
                "case_no" => $claim->case_no,
                "claimant_name" => htmlspecialchars($claim->claimant_address->name),
                "claimant_identification_type" => $claim->claimant_address->nationality_country_id == 129 ? __('form1.ic_no') : __('form1.passport_no'),
                "claimant_identification_no" => $claim->claimant_address->identification_no,
                "claimant_2_name" => $extraOpponent ? htmlspecialchars($claim->extraClaimant->name) : '',
                "claimant_2_identification_type" => __('form1.ic_no'),
                "claimant_2_identification_no" => $extraOpponent ? htmlspecialchars($claim->extraClaimant->identification_no) : '',
                "claimant_address" => $claim->claimant_address->street_1 ? $claim->claimant_address->street_1 . ($claim->claimant_address->street_2 ? ', ' . $claim->claimant_address->street_2 : '') . ($claim->claimant_address->street_3 ? ', ' . $claim->claimant_address->street_3 : '') . ', ' . $claim->claimant_address->postcode . ' ' . ($claim->claimant_address->district ? $claim->claimant_address->district->district : '') . ', ' . ($claim->claimant_address->state ? $claim->claimant_address->state->state : '') : '-',
                "claimant_phone_home" => $claim->claimant_address->phone_home,
                "claimant_phone_mobile" => $claim->claimant_address->phone_mobile,
                "claimant_email" => $claim->claimant_address->email,
                "claimant_phone_fax" => $claim->claimant_address->phone_fax,
                "opponent_name" => htmlspecialchars($claim->multiOpponents[0]->opponent_address->name),
                "opponent_identification_type" => $claim->multiOpponents[0]->opponent_address->is_company == 0 ? ($claim->multiOpponents[0]->opponent_address->nationality_country_id == 129 ? __('form1.ic_no') : __('form1.passport_no')) : __('form1.company_no'),
                "opponent_identification_no" => $claim->multiOpponents ? $claim->multiOpponents[0]->opponent_address->identification_no : '-',
                "opponent_address" => $claim->multiOpponents ? $claim->multiOpponents[0]->opponent_address->street_1 . ($claim->multiOpponents[0]->opponent_address->street_2 ? ', ' . $claim->multiOpponents[0]->opponent_address->street_2 : '') . ($claim->multiOpponents[0]->opponent_address->street_3 ? ', ' . $claim->multiOpponents[0]->opponent_address->street_3 : '') . ', ' . $claim->multiOpponents[0]->opponent_address->postcode . ' ' . ($claim->multiOpponents[0]->opponent_address->district ? $claim->multiOpponents[0]->opponent_address->district->district : '-') . ', ' . ($claim->multiOpponents[0]->opponent_address->state ? $claim->multiOpponents[0]->opponent_address->state->state : '') : '-',
                "opponent_phone_home" => $claim->multiOpponents ? $claim->multiOpponents[0]->opponent_address->phone_office : '-',
                "opponent_phone_mobile" => $claim->multiOpponents ? $claim->multiOpponents[0]->opponent_address->phone_mobile : '-',
                "opponent_email" => $claim->multiOpponents ? $claim->multiOpponents[0]->opponent_address->email : '-',
                "opponent_phone_fax" => $claim->multiOpponents ? $claim->multiOpponents[0]->opponent_address->phone_fax : '-',
                "claim_amount" => number_format($claim->form1->claim_amount, 2, '.', ','),
                "claim_details" => $claim->form1->claim_details,
                "filing_date" => date('d/m/Y', strtotime($claim->form1->processed_at)),
                "matured_date" => date('d/m/Y', strtotime($claim->form1->matured_date)),
                "psu_name" => strtoupper($claim->psu->name),
                "psu_role_en" => strtoupper($claim->psu->roleuser->first()->role->display_name_en),
                "psu_role_my" => strtoupper($claim->psu->roleuser->first()->role->display_name_my),
                "branch_address" => $claim->branch->branch_name,
                "branch_phone_office" => $claim->branch->branch_office_phone,
                "branch_phone_fax" => $claim->branch->branch_office_fax,
                "branch_email" => $claim->branch->branch_emel,
                "hearing_date" => $claim->last_form4 ? date('d/m/Y', strtotime($claim->last_form4->hearing->hearing_date)) : '-',
                "hearing_time" => $claim->last_form4 ? date('d/m/Y', strtotime($claim->last_form4->hearing->hearing_date . " " . $claim->last_form4->hearing->hearing_time)) : '-',
                "receipt_no" => $claim->form1->payment ? $claim->form1->payment->receipt_no : '-',
                "transaction_date" => $claim->form1->purchased_date ? date('d/m/Y', strtotime($claim->form1->purchased_date)) : '-',
                "purchased_item" => htmlspecialchars($claim->form1->purchased_item_name),
                "brand" => htmlspecialchars($claim->form1->purchased_item_brand),
                "amount_paid" => number_format($claim->form1->purchased_amount, 2, '.', ','),
            ]);

            $audit = new AuditController;
            $audit->add($request, 17, "Form1Controller", $claim->case_no, null, "Download form 1 (DOCX)");

            return response()
                ->download($file, 'Borang 1 ' . $claim->case_no . '.docx')
                ->deleteFileAfterSend(true);
        }

    }

    /**
     * @param $claim_case_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function rawhtml($claim_case_id)
    {

        $case = ClaimCase::where('claim_case_id', $claim_case_id);

        if ($case->get()->count() > 0) {
            $case = $case->first();
            return view("claimcase/rawhtml/" . App::getLocale() . "/form1", compact('case'));
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function list(Request $request)
    {
        $status = MasterFormStatus::where('form_status_id', '>=', 13)->where('form_status_id', '<=', 17)->get();
        $branches = MasterBranch::where('is_active', 1)->orderBy('branch_id', 'desc')->get();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $input = $request->all();

        $input['year'] = (!isset($input['year']) || trim($input['year']) === '') ? date('Y') : $input['year'];

        if (Auth::user()->user_type_id != 3 && !$request->has('branch')) {

            if (!$request->has('status')) {
                return redirect()->route('onlineprocess.form1', ['branch' => Auth::user()->ttpm_data->branch_id, 'status' => "14"]);
            } else {
                return redirect()->route('onlineprocess.form1', ['branch' => Auth::user()->ttpm_data->branch_id]);
            }

        } else if (!$request->has('status')) {
            return redirect()->route('onlineprocess.form1', ['status' => "14", 'branch' => $request->branch ? $request->branch : 0]);
        }

        if ($request->ajax()) {

            $userid = Auth::id();
            $user = User::find($userid);

            $case = ClaimCase::select([
                'claim_case.claim_case_id',
                'claim_case.form1_id',
                'claim_case.case_no',
                'claim_case.claimant_user_id',
'claim_case.extra_claimant_id',                
'claim_case.claimant_address_id',
                'form1.processed_at',
                'form1.filing_date',
                'form1.case_year',
                'form1.case_sequence',
                'claim_case.created_at',
            ])
                ->leftJoin('form1', 'form1.form1_id', '=', 'claim_case.form1_id')
                ->leftJoin('master_claim_classification', 'master_claim_classification.claim_classification_id', '=', 'form1.claim_classification_id')
                ->orderBy('case_year', 'desc')
                ->orderBy('case_sequence', 'desc')
                ->with(['form1.status', 'claimant_address', 'multiOpponents'])
                ->whereNotNull('claim_case.form1_id');

            if (Auth::user()->hasRole('user')) {
                $case->where('claim_case.claimant_user_id', $userid);
            }

            if ($request->has('status') && !empty($request->status) && $request->status > 0) {

                if ($request->status == 13) {
                    $case->where('case_no', 'DRAFT')
                        ->whereHas('created_by', function ($created_by) {
                            if (Auth::user()->user_type_id == 3) {
                                return $created_by->where('user_type_id', 3);
                            } else {
                                return $created_by->whereIn('user_type_id', [1, 2]);
                            }
                        });
                } else {
                    $case->where('form1.form_status_id', $request->status);
                }
            }


            if ($request->has('branch') && !empty($request->branch) && $request->branch > 0) {
                $case->where('branch_id', $request->branch);
            }

            if ($input['year'] > 0) {
                $case->whereYear('form1.filing_date', $input['year']);
            }

            if ($request->has('month') && !empty($request->month)) {
                $case->whereMonth('form1.filing_date', $request->month);
            }

            if ($request->has('date_start') && $request->has('date_end')) {
                $case->whereBetween('form1.filing_date', [$request->date_start, $request->date_end]);
            }

            if ($request->has('class_cat')) {
                $case->where('master_claim_classification.category_id', $request->class_cat);
            }

            if ($request->has('form2')) {
                $case->whereNull('form1.form2_id')
                    ->where('form_status_id', 17);
            }

            return Datatables::of($case)
                ->addIndexColumn()
                ->editColumn('processed_at', function ($case) {
                    if ($case->form1)
                        return $case->form1->processed_at ? date('d/m/Y', strtotime($case->form1->processed_at)) : "-";
                    else return "-";
                })
                ->editColumn('filing_date', function ($case) {
                    if ($case->form1)
                        return $case->form1->filing_date ? date('d/m/Y', strtotime($case->form1->filing_date)) : "-";
                    else return "-";
                })
                ->editColumn('matured_date', function ($case) {
                    if ($case->form1)
                        return $case->form1->matured_date ? date('d/m/Y', strtotime($case->form1->matured_date)) : "-";
                    else return "-";
                })
                ->editColumn('case_no', function ($case) {
                    return "<a class='' href='" . route('claimcase-view', [$case->claim_case_id]) . "'> " . $case->case_no . "</a>";
                    //return $case->case_no;
                })
                ->editColumn('claimant_name', function ($case) {
                    if ($case->claimant_address) {
return $case->claimant_address->name . ($case->extra_claimant_id != null ? ' & ' . $case->extraClaimant->name : '');                    
    return $case->claimant_address->name;
                    } else {
                        "-";
                    }
                })
                ->editColumn('opponent_address.name', function ($case) {
                    if ($case->multiOpponents) {
                        $oppos = $case->multiOpponents;
                        $oppo_data = '<ol>';
                        foreach ($oppos as $i => $oppo) {
                            $oppo_data .= '<li>' . $oppo->opponent_address->name . '</li>';
                        }

                        $oppo_data .= '</ol>';
                        return $oppo_data;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('status', function ($case) {
                    if ($case->form1) {
                        $locale = App::getLocale();
                        $status_lang = "form_status_desc_" . $locale;
                        return $case->form1->status->$status_lang;
                    } else {
                        return "-";
                    }
                })
                ->editColumn('action', function ($case) {

                    if (!$case->form1) {
                        return actionButton('green-meadow', __('button.edit'), route('form1-edit', ['id' => $case->claim_case_id]), false, 'fa-edit', false);
                    }

                    $userid = Auth::id();
                    $user = User::find($userid);

                    $button = "";

                    if ($case->form1->form_status_id > 13 && $case->multiOpponents()->count() > 0) {
                        $button .= actionButton('blue', __('button.view'), route('form1-view', ['id' => $case->claim_case_id]), false, 'fa-search', false);
                    }

                    /**
                     * if user is psu or ks
                     * and user branch_id eq case branch_id
                     * then allow eq true
                     *
                     * if other role
                     * then allow eq true
                     */
                    if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) {
                        if (Auth::user()->ttpm_data->branch_id == $case->branch_id) {
                            $allow = true;
                        } else {
                            $allow = false;
                        }
                    } else {
                        $allow = true;
                    }

                    if ($allow) {

                        /**
                         * Edit button
                         * if form_1 is draft
                         *      or (user is internal and form_1 is incomplete)
                         *      or (user is internal)
                         * then true
                         */
                        if ($case->form1->form_status_id == 13 || ($user->user_type_id != 3 && $case->form1->form_status_id == 16) || ($user->user_type_id != 3)) {
                            $button .= actionButton('green-meadow', __('button.edit'), route('form1-edit', ['id' => $case->claim_case_id]), false, 'fa-edit', false);
                        }

                        /**
                         * Payment button
                         * if form_1 is draft or awaiting_payment
                         *      and user is public
                         * then true
                         */
                        if (($case->form1->form_status_id == 13 || $case->form1->form_status_id == 15) && $user->user_type_id == 3) {
                            $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="' . __('button.make_payment') . '" onclick="choosePaymentMethod(' . $case->claim_case_id . ')"><i class="fa fa-dollar"></i></a>';
                        }

                        /**
                         * process button
                         * if form_1 is new or awating_payment or incomplete
                         *      and user is internal
                         * then true
                         */
                        if (($case->form1->form_status_id == 14 || $case->form1->form_status_id == 15 || $case->form1->form_status_id == 16) && $user->user_type_id != 3) {
                            /**
                             * case.multiopponent is not null
                             */
                            if (count($case->multiOpponents) > 0) {
                                $button .= '<a class="btn purple" rel="tooltip" data-original-title="' . __('button.process') . '" onclick="processForm1(' . $case->claim_case_id . ')"><i class="fa fa-spinner"></i></a>';
                            } else {
                                $button .= '<button type="button" class="btn red" rel="tooltip" data-original-title="' . __('form2.no-opponent') . '"><i class="fa fa-times"></i> ' . __('form2.no-opponent') . '</a>';
                            }
                        }

                        /**
                         * if user is internal
                         *      and form_1 status is already_filed
                         *      and allow eq true
                         *      and is_form2_lock eq false
                         *      and form2_id is null
                         * then true
                         */
                        if ($user->user_type_id != 3 && $case->form1->form_status_id == 17 && $allow && !$case->is_form2_lock && !$case->form1->form2_id && count($case->multiOpponents) > 0) {
                            $opponent_button = '';

                            foreach ($case->multiOpponents as $opponent) {
                                $opponent_button .= actionButton('blue btn-outline', $opponent->opponent_address->name,
                                    route('form2-create', ['claim_case_id' => $opponent->id]),
                                    false, 'fa-plus', false,
                                    $opponent->opponent_address->name);
                            }

                            $button .= '<button type="button" class="btn blue btn-outline" data-toggle="modal" data-target="#form2_create_modal_' . $case->claim_case_id . '"><i class="fa fa-plus"></i> ' . __('form2.form2') . '</button>';
                            $button .= modal('form2_create_modal_' . $case->claim_case_id, 'form2_create_body' . $case->claim_case_id, __('form2.file_form2'), $opponent_button);
                        }
                    }

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "Form1Controller", null, null, "Datatables load form 1");

        return view("claimcase/form1/list", compact('status', 'branches', 'years', 'months', 'input'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $claim_case_id
     * @return mixed
     * @throws \Exception
     */
    public function delete(Request $request, $claim_case_id)
    {
        if ($claim_case_id) {
            $case = ClaimCase::find($claim_case_id);
            $opponent = ClaimCaseOpponent::where('claim_case_id', $claim_case_id)->get();

            $audit = new AuditController;
            $audit->add($request, 6, "Form1Controller", null, null, "Delete claim case " . $case->case_no);

            $attachment = Attachment::where('form_no', 1)->where('form_id', $case->form1_id);
            if (!empty($attachment)) {
                $attachment->delete();
            }

            if (!empty($opponent)) {
                foreach ($opponent as $oppo) {
                    $oppo->delete();
                }
            }

            $case->delete();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    /**
     * @param null $inquiry_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function create($inquiry_id = null)
    {
        // Check for user_id and get claimant information from database
        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id != 3) {
            $is_staff = true;
            $user = new User;
            $state_districts = null;
            $state_mailing_districts = null;
        } else {
            $is_staff = false;
            if ($user->public_data->address_mailing_state_id) {
                $state_districts = MasterState::find($user->public_data->address_mailing_state_id)->districts;
            } else {
                $state_districts = null;
            }

            $state_mailing_districts = $user->public_data->address_mailing_state_id ? MasterState::find($user->public_data->address_mailing_state_id)->districts : null;
        }


        if ($inquiry_id) {
            $inquiry = Inquiry::find($inquiry_id);

            if ($inquiry->form1_id) {
                $attachments = Attachment::where('form_no', 0)
                    ->where('form_id', $inquiry_id)
                    ->get();

                if ($is_staff) {
                    $user = User::find($inquiry->inquired_by_user_id);

                    if ($inquiry->inquired_by->public_data->address_mailing_state_id) {
                        $state_districts = MasterState::find($inquiry->inquired_by->public_data->address_mailing_state_id)->districts;
                    } else {
                        $state_districts = null;
                    }
                }
            } else {
                $inquiry = null;
                $attachments = null;
            }

        } else {
            $inquiry = null;
            $attachments = null;
        }

        $state_subdistricts = ($user->public_data && $user->public_data->address_mailing_district_id)
            ? MasterSubdistrict::where('district_id', $user->public_data->address_mailing_district_id)->get()
            : null;;

        $subdistricts = ($user->public_data && $user->public_data->address_district_id)
            ? MasterSubdistrict::where('district_id', $user->public_data->address_district_id)->get()
            : null;

        $states = MasterStateRepository::getAll();
        $districts = MasterDistrictRepository::getAll();
        $countries = MasterCountryRepository::getAll();
        $categories = App\Repositories\MasterClaimCategoryRepository::getAll();
        $classifications = App\Repositories\MasterClaimClassificationRepository::getAll();
        $relationships = MasterRelationship::whereIn('relationship_id', [1, 2])->get();

        if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin')) {
            $branches = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();
            $hearing_venues = MasterBranch::with('venues.rooms')->where('branch_id', Auth::user()->ttpm_data->branch_id)->first()->venues;
        } else if (Auth::user()->hasRole('user')) {
            $branches = MasterBranch::where('is_active', 1)->get();
            $hearing_venues = null;
        } else {
            $branches = MasterBranch::where('branch_id', Auth::user()->ttpm_data->branch_id)->get();
            $hearing_venues = MasterBranch::with('venues.rooms')->where('branch_id', Auth::user()->ttpm_data->branch_id)->first()->venues;
        }

        if (Auth::user()->user_type_id != 3) {
            $psus = RoleUser::with('user')
                ->whereIn('role_id', [18, 17, 10])
                ->whereHas('user', function ($user) {
                    return $user->where('user_status_id', 1)->whereHas('ttpm_data', function ($user_ttpm) {
                        return $user_ttpm->where('branch_id', Auth::user()->ttpm_data->branch_id);
                    });
                })
                ->get();
        } else {
            $psus = null;
        }


        // $psus = RoleUser::where('role_id', 18)->orWhere('role_id', 17)->orWhere('role_id', 10)->get()->filter(function($query) {
        //     if(Auth::user()->user_type_id != 3)
        //         return ($query->user->user_status_id == 1) && ($query->user->ttpm_data->branch_id == Auth::user()->ttpm_data->branch_id);
        //     else
        //         return false;
        // });

        $offences = MasterOffenceType::where('is_active', 1)->get();
        $offences_p = MasterOffenceType::where('is_active', 1)->where('offence_code', 'LIKE', '%P%')->get();
        $offences_b = MasterOffenceType::where('is_active', 1)->where('offence_code', 'LIKE', '%B%')->get();

        $case = null;
        $opponent_counter = 0;

        return view("claimcase/form1/viewForm1", compact('user', 'states', 'state_districts', 'state_subdistricts',
            'districts', 'countries', 'categories', 'classifications', 'is_staff', 'case', 'attachments',
            'inquiry', 'branches', 'psus', 'offences', 'offences_p', 'offences_b', 'hearing_venues',
            'relationships', 'state_mailing_districts', 'subdistricts', 'opponent_counter'));
    }

    /**
     * @param $claim_case_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function edit($claim_case_id)
    {
        if ($claim_case_id) {
            // Check for user_id and get claimant information from database
            $userid = Auth::id();
            $user = Auth::user();

            if ($user->user_type_id != 3) {
                $is_staff = true;
            } else {
                $is_staff = false;
            }

            $case = ClaimCase::with('multiOpponents')
                ->find($claim_case_id);

            if (Auth::user()->user_type_id == 3) {
                $case->where('claimant_user_id', Auth::id());
            }

            if ($case) {
                $user = User::find($case->claimant_user_id);

                if ($case->claimant_address->state_id) {
                    $state_districts = MasterState::find($case->claimant_address->state_id)->districts;
                } else {
                    $state_districts = null;
                }

                $state_subdistricts = $case->claimant_address->subdistrict_id
                    ? MasterSubdistrict::where('district_id', $case->claimant_address->district_id)->get()
                    : null;

                $subdistricts = ($user->public_data && $user->public_data->address_mailing_district_id)
                    ? MasterSubdistrict::where('district_id', $user->public_data->address_mailing_district_id)->get()
                    : null;

                $states = MasterStateRepository::getAll();
                $districts = MasterDistrictRepository::getAll();
//                $claimant_subdistricts = MasterSubdistrict::where('district_id', $case->claimant_address->subdistrict_id)->get();
                $countries = MasterCountryRepository::getAll();
                $categories = App\Repositories\MasterClaimCategoryRepository::getAll();
                $classifications = App\Repositories\MasterClaimClassificationRepository::getAll();
                $relationships = MasterRelationship::whereIn('relationship_id', [1, 2])->get();

                if (Auth::user()->hasRole('ks') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin')) {
                    $branches = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();
                    $hearing_venues = MasterBranch::with('venues.rooms')->where('branch_id', $case->branch_id)->first()->venues;
                } else if (Auth::user()->hasRole('user')) {
                    $branches = MasterBranch::where('is_active', 1)->get();
                    $hearing_venues = null;
                } else {
                    $branches = MasterBranch::where('branch_id', Auth::user()->ttpm_data->branch_id)->get();
                    $hearing_venues = MasterBranch::with('venues.rooms')->where('branch_id', Auth::user()->ttpm_data->branch_id)->first()->venues;
                }

                if ($case->form1_id) {
                    $attachments = Attachment::where('form_no', 1)->where('form_id', $case->form1_id)->get();
                } else {
                    $attachments = null;
                }

                $inquiry = null;

                $psus = RoleUser::with('user')
                    ->whereIn('role_id', [18, 17, 10])
                    ->whereHas('user', function ($user) use ($case) {
                        return $user->where('user_status_id', 1)
                            ->whereHas('ttpm_data', function ($user_ttpm) use ($case) {
                                return $user_ttpm->where('branch_id', $case->branch_id);
                            });
                    })
                    ->get();

                $offences = MasterOffenceType::where('is_active', 1)->get();
                $offences_p = MasterOffenceType::where('offence_code', 'like', 'P%')->get();
                $offences_b = MasterOffenceType::where('offence_code', 'like', 'B%')->get();

                $is_edit = true;

                $opponent_counter = $case->multiOpponents->count() ?? 0;

                return view("claimcase.form1.viewForm1", compact('is_edit', 'user', 'states',
                    'state_districts', 'districts', 'countries', 'categories', 'classifications', 'is_staff',
                    'case', 'attachments', 'inquiry', 'branches', 'psus', 'offences', 'offences_p', 'offences_b',
                    'hearing_venues', 'relationships', 'state_subdistricts', 'subdistricts', 'opponent_counter'));
            } else
                abort(404);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAttachment(Request $request)
    {
        if ($request->claim_case_id != null) {
            if ($request->ajax()) {

                $claim_case_id = $request->claim_case_id;
                $form_no = 1;
                $case = ClaimCase::find($claim_case_id);
                $form1_id = $case->form1_id;
                $created_by = Auth::id();

                //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

                $oldAttachments = Attachment::where('form_no', 1)
                    ->where('form_id', $form1_id)
                    ->get();

                if ($request->hasFile('attachment_1')) {
                    if ($request->file('attachment_1')->isValid()) {
                        if ($oldAttachments->get(0)) {
                            if ($request->file1_info == 2) {
                                // Replace
                                $oldAttachments->get(0)->delete();

                                $attachment = new Attachment;
                                $attachment->form_no = $form_no;
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_1);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_1')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_1);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_2);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_2')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_2);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_3);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_3')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_3);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_4);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_4')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_4);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_5);
                                $attachment->created_by_user_id = $created_by;
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
                                $attachment->form_id = $form1_id;
                                $attachment->attachment_name = $request->file('attachment_5')->getClientOriginalName();
                                $attachment->file_blob = file_get_contents($request->attachment_5);
                                $attachment->created_by_user_id = $created_by;
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

                if ($case->form1->payment_id) {
                    if ($case->form1->payment->payment_status_id == 3 || $case->form1->payment->payment_status_id == 4)
                        $paid = true;
                    else
                        $paid = false;
                } else {
                    $paid = false;
                }

                /////////////////////////////////////////////// Check previous attachment existed

                // Check if inquiry_id existed
                if ($case->inquiry_id) {
                    // Check if inquiry has attachment
                    $migrate_attachment = Attachment::where('form_no', 0)
                        ->where('form_id', $case->inquiry_id)
                        ->update([
                            'form_no' => 1,
                            'form_id' => $case->form1_id
                        ]);
                }

                ////////////////////////////////////////////////////////////////////////////////

                $state = MasterState::find($case->branch->branch_state_id);

                /*
                 * if case number is null and user is a public
                 *      then create b1 number
                 */
                if ($case->case_no == 'DRAFT' && Auth::user()->user_type_id == 3) {
                    $case->form1_no = $case->case_no = RunnerRepository::generateAppNumber('B1', $case->branch->branch_code, date('Y'));
                    $state->next_b1_no = $state->next_b1_no + 1;
                    $state->save();
                }

                $case->save();

                LogAuditRepository::store($request, 4, "Form1Controller", json_encode($request->input()), null, "Creating claim case " . $case->case_no . " (STEP 4) - Upload attachments");

                return response()->json(['result' => 'Success', 'claim_case_id' => $claim_case_id, 'paid' => $paid]);
            }

            return response()->json(['result' => 'Fail', 'claim_case_id' => null, 'paid' => false]);
        }
    }

    /**
     * @param $request
     * @param null $type
     * @return array
     */
    protected function rules_partial1($request, $type = null)
    {
        $userid = Auth::id();
        $user = User::find($userid);

        $rules = [
            'claimant_identification_no' => 'required',
            'claimant_name' => 'required',
            'claimant_street1' => 'required',
            'claimant_postcode' => 'required|string|min:5|max:5',
            'claimant_district' => 'required|integer',
            'claimant_state' => 'required|integer'
        ];


        if ($user->user_type_id != 3) {
            $rules['claimant_identity_type'] = 'required';
        } else {
            $rules['claimant_email'] = 'required|email';
        }

        if ($request->has('has_extra_claimant')) {
            $rules['extra_claimant_identification_no'] = 'required';
            $rules['extra_claimant_name'] = 'required';
            $rules['extra_claimant_nationality'] = 'required_if:extra_claimant_identity_type,2|integer';
            $rules['extra_claimant_relationship'] = 'required|integer';
        }

        if ($request->claimant_identity_type == 3) {
            //$rules['claimant_phone_office'] = 'required|string|regex:/^.{9,15}$/';
        } else if ($request->claimant_identity_type == 2) {
            $rules['claimant_nationality'] = 'required|integer';

            // if(!$request->claimant_phone_mobile && !$request->claimant_phone_home) {
            //     $rules['claimant_phone_mobile'] = 'required_without_all:claimant_phone_home';
            //     $rules['claimant_phone_home'] = 'required_without_all:claimant_phone_mobile';
            // }
            // else {
            //     $rules['claimant_phone_mobile'] = 'regex:/^.{9,15}$/';
            //     $rules['claimant_phone_home'] = 'regex:/^.{9,15}$/';
            // }

        } else {
            $rules['claimant_identification_no'] = 'required|string|min:12|max:12';
            // if(!$request->claimant_phone_mobile && !$request->claimant_phone_home) {
            //     $rules['claimant_phone_mobile'] = 'required_without_all:claimant_phone_home';
            //     $rules['claimant_phone_home'] = 'required_without_all:claimant_phone_mobile';
            // }
            // else {
            //     $rules['claimant_phone_mobile'] = 'regex:/^.{9,15}$/';
            //     $rules['claimant_phone_home'] = 'regex:/^.{9,15}$/';
            // }
        }

        return $rules;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function partialCreate1(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_partial1($request));

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            // Get claim_case_id
            $claim_case_id = $request->claim_case_id;

            // Get current user_id
            $userid = Auth::id();
            $user = User::find($userid);

            // Update claimant mailing info
            $claimant_identity_type = $request->claimant_identity_type;
            $claimant_identification_no = $request->claimant_identification_no;

            // Check for nationality
            if ($claimant_identity_type == 2) {
                $claimant_nationality = $request->claimant_nationality;
            } else {
                $claimant_nationality = 129;
            }

            $claimant_name = $request->claimant_name;

            $claimant_street1 = $request->claimant_street1;
            $claimant_street2 = $request->claimant_street2;
            $claimant_street3 = $request->claimant_street3;
            $claimant_postcode = $request->claimant_postcode;
            $claimant_subdistrict = $request->claimant_subdistrict ?? null;
            $claimant_district = $request->claimant_district;
            $claimant_state = $request->claimant_state;
            $claimant_phone_home = $request->claimant_phone_home;
            $claimant_phone_mobile = $request->claimant_phone_mobile;
            $claimant_phone_office = $request->claimant_phone_office;
            $claimant_phone_fax = $request->claimant_phone_fax;
            $claimant_email = $request->claimant_email;

            $claimant_mailing_street1 = $request->claimant_mailing_street1;
            $claimant_mailing_street2 = $request->claimant_mailing_street2;
            $claimant_mailing_street3 = $request->claimant_mailing_street3;
            $claimant_mailing_postcode = $request->claimant_mailing_postcode;
            $claimant_mailing_subdistrict = $request->claimant_mailing_subdistrict ?? null;
            $claimant_mailing_district = $request->claimant_mailing_district;
            $claimant_mailing_state = $request->claimant_mailing_state;

            if ($user->user_type_id != 3) { // Staff

                // Check for existing user
                $user = User::where('username', $claimant_identification_no);

                if ($user->get()->count() > 0) { // Existed

                    // Update details
                    $userid = $user->first()->user_id;
                    $user = User::where('username', $claimant_identification_no)->first();

                    if ($user->public_data->user_public_type_id == 2) {
                        $update_userPublicCompany = UserPublicCompany::where('user_id', $userid)->update([
                            'company_no' => $claimant_identification_no,
                            'phone_home' => $claimant_phone_home,
                            'phone_mobile' => $claimant_phone_mobile
                        ]);
                    }
                } else { // New Sent Form
                    // Partial register user and return user_id

                    // Create partial user and return id
                    $userid = DB::table('users')->insertGetId([
                        'name' => $claimant_name,
                        'username' => $claimant_identification_no,
                        'user_type_id' => 3, // Public users
                        'language_id' => 1, // English
                        'phone_office' => $claimant_phone_office,
                        'phone_fax' => $claimant_phone_fax,
                        'email' => $claimant_email,
                        'user_status_id' => 6, // Partial
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Company or Individual
                    if ($claimant_identity_type > 2) { // Company
                        $claimant_public = DB::table('user_public')->insertGetId([
                            'user_id' => $userid,
                            'user_public_type_id' => 2, // Company
                            'address_mailing_street_1' => $claimant_mailing_street1,
                            'address_mailing_street_2' => $claimant_mailing_street2,
                            'address_mailing_street_3' => $claimant_mailing_street3,
                            'address_mailing_postcode' => $claimant_mailing_postcode,
                            'address_mailing_subdistrict_id' => $claimant_mailing_subdistrict,
                            'address_mailing_district_id' => $claimant_mailing_district,
                            'address_mailing_state_id' => $claimant_mailing_state
                        ]);

                        $claimant_public_company = DB::table('user_public_company')->insertGetId([
                            'user_id' => $userid,
                            'company_no' => $claimant_identification_no
                        ]);
                    } else { // Individual
                        $claimant_public = DB::table('user_public')->insertGetId([
                            'user_id' => $userid,
                            'user_public_type_id' => 1, // Individual
                            'address_mailing_street_1' => $claimant_mailing_street1,
                            'address_mailing_street_2' => $claimant_mailing_street2,
                            'address_mailing_street_3' => $claimant_mailing_street3,
                            'address_mailing_postcode' => $claimant_mailing_postcode,
                            'address_mailing_subdistrict_id' => $claimant_mailing_subdistrict,
                            'address_mailing_district_id' => $claimant_mailing_district,
                            'address_mailing_state_id' => $claimant_mailing_state
                        ]);

                        $claimant_public_individual = DB::table('user_public_individual')->insertGetId([
                            'user_id' => $userid,
                            'nationality_country_id' => $claimant_nationality,
                            'identification_no' => $claimant_identification_no,
                            'phone_home' => $claimant_phone_home,
                            'phone_mobile' => $claimant_phone_mobile
                        ]);
                    }
                }
            } else { // User Sent Form

                // Update details
                if ($user->public_data->user_public_type_id == 1) {
                    $update_userPublicIndividual = UserPublicIndividual::where('user_id', $userid)->update([
                        'phone_home' => $claimant_phone_home,
                        'phone_mobile' => $claimant_phone_mobile
                    ]);
                } // End If

                UserPublic::where('user_id', $userid)
                    ->update([
                        'address_mailing_street_1' => $claimant_mailing_street1,
                        'address_mailing_street_2' => $claimant_mailing_street2,
                        'address_mailing_street_3' => $claimant_mailing_street3,
                        'address_mailing_postcode' => $claimant_mailing_postcode,
                        'address_mailing_subdistrict_id' => $claimant_mailing_subdistrict,
                        'address_mailing_district_id' => $claimant_mailing_district,
                        'address_mailing_state_id' => $claimant_mailing_state
                    ]);

                $update_user = User::find($userid)->update([
                    'phone_office' => $claimant_phone_office,
                    'phone_fax' => $claimant_phone_fax,
                    'email' => $claimant_email
                ]);
            }

            /*
             *  Check if claim-case is existed
             */
            if ($claim_case_id == "") {
                $claimant_address_id = DB::table('user_claimcase')->insertGetId([
                    'user_id' => $userid,

                    'is_company' => 0,
                    'name' => $claimant_name,
                    'identification_no' => $claimant_identification_no,
                    'nationality_country_id' => $claimant_nationality,

                    'street_1' => $claimant_street1,
                    'street_2' => $claimant_street2,
                    'street_3' => $claimant_street3,
                    'postcode' => $claimant_postcode,
                    'subdistrict_id' => $claimant_subdistrict,
                    'district_id' => $claimant_district,
                    'state_id' => $claimant_state,

                    'phone_home' => $claimant_phone_home,
                    'phone_mobile' => $claimant_phone_mobile,
                    // 'phone_office' => $claimant->phone_office,
                    // 'phone_fax' => $claimant->phone_fax,
                    'email' => $claimant_email,
                    'created_by_user_id' => Auth::id(),

                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // Create partial claim and return id
                $inquiry_no = $request->inquiry_no;

                if (!$inquiry_no) {
                    $inquiry_id = NULL;
                } else {
                    $inquiry = Inquiry::where('inquiry_no', $inquiry_no)->get();

                    if ($inquiry->count() > 0) {
                        $inquiry_id = $inquiry->first()->inquiry_id;
                    } else {
                        $inquiry_id = NULL;
                    }
                }

                if ($request->has('has_extra_claimant')) {
                    $extra_claimant_id = DB::table('user_extra')->insertGetId([
                        'name' => $request->extra_claimant_name,
                        'identification_no' => $request->extra_claimant_identification_no,
                        'nationality_country_id' => $request->extra_claimant_nationality,
                        'relationship_id' => $request->extra_claimant_relationship
                    ]);
                } else {
                    $extra_claimant_id = null;
                }

                $claim_case_id = DB::table('claim_case')->insertGetId([
                    'inquiry_id' => $inquiry_id,
                    'case_no' => 'DRAFT',
                    'claimant_user_id' => $userid,
                    'claimant_address_id' => $claimant_address_id,
                    'extra_claimant_id' => $extra_claimant_id,
                    'case_status_id' => 1, //Draft status
                    'created_by_user_id' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            } else {
                // Update claimant address
                $claim = ClaimCase::find($claim_case_id);

                $inquiry_no = $request->inquiry_no;

                if (!$inquiry_no) {
                    $inquiry_id = NULL;
                } else {
                    $inquiry = Inquiry::where('inquiry_no', $inquiry_no)->get();

                    if ($inquiry->count() > 0) {
                        $inquiry_id = $inquiry->first()->inquiry_id;
                    } else {
                        $inquiry_id = NULL;
                    }
                }

                // $update_claimant_address = Address::find($claim->claimant_address_id)->update([
                //                 'street_1' => $claimant_street1,
                //                 'street_2' => $claimant_street2,
                //                 'street_3' => $claimant_street3,
                //                 'postcode' => $claimant_postcode,
                //                 'district_id' => $claimant_district,
                //                 'state_id' => $claimant_state,
                //                 'updated_at' => Carbon::now()
                //                 ]);

                $claimant_address = UserClaimCase::find($claim->claimant_address_id)->update([

                    'is_company' => 0,
                    'name' => $claimant_name,
                    'identification_no' => $claimant_identification_no,
                    'nationality_country_id' => $claimant_nationality,

                    'street_1' => $claimant_street1,
                    'street_2' => $claimant_street2,
                    'street_3' => $claimant_street3,
                    'postcode' => $claimant_postcode,
                    'subdistrict_id' => $claimant_subdistrict,
                    'district_id' => $claimant_district,
                    'state_id' => $claimant_state,

                    'phone_home' => $claimant_phone_home,
                    'phone_mobile' => $claimant_phone_mobile,
                    // 'phone_office' => $claimant->phone_office,
                    // 'phone_fax' => $claimant->phone_fax,
                    'email' => $claimant_email,
                    'updated_at' => Carbon::now()
                ]);

                if ($request->has('has_extra_claimant') && !$claim->extra_claimant_id) {
                    $extra_claimant_id = DB::table('user_extra')->insertGetId([
                        'name' => $request->extra_claimant_name,
                        'identification_no' => $request->extra_claimant_identification_no,
                        'nationality_country_id' => $request->extra_claimant_nationality,
                        'relationship_id' => $request->extra_claimant_relationship
                    ]);
                    $claim->extra_claimant_id = $extra_claimant_id;
                    $claim->save();
                } else if ($claim->extra_claimant_id && !$request->has('has_extra_claimant')) {
                    $extra_claimant_id = $claim->extra_claimant_id;
                    $claim->extra_claimant_id = null;
                    $claim->save();
                    UserExtra::find($extra_claimant_id)->delete();
                } else {
                    $user_extra = UserExtra::find($claim->extra_claimant_id);

                    if ($user_extra) {
                        $user_extra->update([
                            'name' => $request->extra_claimant_name,
                            'identification_no' => $request->extra_claimant_identification_no,
                            'nationality_country_id' => $request->extra_claimant_nationality,
                            'relationship_id' => $request->extra_claimant_relationship
                        ]);
                    }
                }

                // Update claim-case
                $update_claim_case = $claim->update([
                    'inquiry_id' => $inquiry_id,
                    'updated_at' => Carbon::now()
                ]);
            }

            // Check for instant process
            $claim = ClaimCase::find($claim_case_id);
            if (!$claim->form1_id) {

                if ($request->inst_filing_date && $request->inst_claim_category) {


                    // Get current user_id
                    $staffid = Auth::id();
                    $staff = User::find($staffid);

                    $branch = $staff->ttpm_data->branch;

                    if ($request->inst_claim_category == 1) {
                        $cat = 55;
                        $cat_code = 'B';
                    } else {
                        $cat = 56;
                        $cat_code = 'P';
                    }

                    $inst_filing_date = $request->inst_filing_date ? Carbon::createFromFormat('d/m/Y', $request->inst_filing_date)->toDateString() : Carbon::now()->toDateString();

                    $general = new GeneralController;
                    $matured_date = $general->getDateExcludeHolidaysByBranch($inst_filing_date, env("CONF_F1_MATURED_DURATION", 14), $branch->branch_id);

                    $form1_id = DB::table('form1')->insertGetId([
                        'filing_date' => $inst_filing_date,
                        'matured_date' => $matured_date,               // Change this later
                        'form_status_id' => 16, // Draft
                        'claim_classification_id' => $cat,
                        'created_by_user_id' => Auth::id(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $claim->form1_id = $form1_id;
                    $claim->branch_id = $branch->branch_id;

                    $state = MasterState::find($branch->branch_state_id);

                    $claim->save();
                }
            }


            $audit = new AuditController;
            $audit->add($request, 4, "Form1Controller", json_encode($request->input()), null, "Creating claim case " . $claim->case_no . " (STEP 1)");

            return response()->json(['result' => 'Success', 'claim_case_id' => $claim_case_id]);

        }
    }

    /**
     * @param $request
     * @param null $type
     * @return array
     */
    protected function rules_partial2($request, $type = null)
    {

        $rules = [
            'opponent_identity_type' => 'required',
            'opponent_identification_no' => 'required',
            'opponent_name' => 'required',
            'opponent_street1' => 'required',
            'opponent_postcode' => 'required|string|min:5|max:5',
            'opponent_district' => 'required|integer',
            'opponent_state' => 'required|integer'
        ];

        if ($request->opponent_identity_type == 3) {
            //$rules['opponent_phone_office'] = 'required|string|regex:/^.{9,15}$/';
        } else if ($request->opponent_identity_type == 2) {
            $rules['opponent_nationality'] = 'required|integer';
            //$rules['opponent_phone_mobile'] = 'required|string|regex:/^.{9,15}$/';
        } else {
            //$rules['opponent_phone_mobile'] = 'required|string|regex:/^.{9,15}$/';
        }

        return $rules;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function partialCreate2(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_partial2($request));

        if ($request->ajax()) {

            if ($request->has('add')) {
                if (!$validator->passes()) {
                    return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
                }

                $claim_case = ClaimCase::find($request->claim_case_id);

                $opponent_identification_no = $request->opponent_identification_no;
                $opponent_identity_type = $request->opponent_identity_type == 3 ? 2 : 1; // 2 - syarikat , 1 - individu
                $opponent_nationality = $request->opponent_identity_type != 2 ? 129 : $request->opponent_nationality; // malaysian
                $opponent_name = $request->opponent_name;
                $opponent_street1 = $request->opponent_street1;
                $opponent_street2 = $request->opponent_street2;
                $opponent_street3 = $request->opponent_street3;
                $opponent_postcode = $request->opponent_postcode;
                $opponent_state = $request->opponent_state;
                $opponent_district = $request->opponent_district;
                $opponent_phone_home = $request->opponent_phone_home;
                $opponent_phone_mobile = $request->opponent_phone_mobile;
                $opponent_phone_office = $request->opponent_phone_office;
                $opponent_phone_fax = $request->opponent_phone_fax;
                $opponent_email = $request->opponent_email;

                // Check for existing user
                $opponent = User::where('username', $opponent_identification_no)->first();

                // if user is existed and user that keyin is a staff
                // then update user public company data
                if ($opponent != null) { // user is existed
                    if (auth()->user()->user_type_id != 3) { // staff
                        if ($opponent->public_data->user_public_type_id == 2) { // company
                            UserPublicCompany::where('user_id', $opponent->user_id)->update([
                                'company_no' => $opponent_identification_no,
                                'representative_phone_home' => $opponent_phone_home,
                                'representative_phone_mobile' => $opponent_phone_mobile
                            ]);
                        }
                        // @todo what happen if personal?
                    }
                } else {
                    // Create partial user
                    $opponent = User::create([
                        'name' => $opponent_name,
                        'username' => $opponent_identification_no,
                        'user_type_id' => 3, // Public users
                        'language_id' => 1, // English
                        'phone_office' => $opponent_phone_office,
                        'phone_fax' => $opponent_phone_fax,
                        'email' => $opponent_email,
                        'user_status_id' => 6, // Partial
                    ]);

                    // create user public data
                    UserPublic::create([
                        'user_id' => $opponent->user_id,
                        'user_public_type_id' => $opponent_identity_type,
                        'address_mailing_street_1' => $opponent_street1,
                        'address_mailing_street_2' => $opponent_street2,
                        'address_mailing_street_3' => $opponent_street3,
                        'address_mailing_postcode' => $opponent_postcode,
                        'address_mailing_district_id' => $opponent_district,
                        'address_mailing_state_id' => $opponent_state
                    ]);

                    // create user public extra data
                    switch ($opponent_identity_type) {
                        case 2: // company
                            UserPublicCompany::create([
                                'user_id' => $opponent->user_id,
                                'company_no' => $opponent_identification_no,
                                'representative_phone_home' => $opponent_phone_home,
                                'representative_phone_mobile' => $opponent_phone_mobile
                            ]);
                            break;
                        default: // individual
                            UserPublicIndividual::create([
                                'user_id' => $opponent->user_id,
                                'nationality_country_id' => $opponent_nationality,
                                'identification_no' => $opponent_identification_no,
                                'phone_home' => $opponent_phone_home,
                                'phone_mobile' => $opponent_phone_mobile
                            ]);
                            break;
                    }
                }

                $opponent_address = UserClaimCase::create([
                    'user_id' => $opponent->user_id,
                    'is_company' => $opponent_identity_type == 2 ? 1 : 0,
                    'name' => $opponent_name,
                    'identification_no' => $opponent_identification_no,
                    'nationality_country_id' => $opponent_nationality,

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

                    'created_by_user_id' => auth()->user()->user_id,
                ]);


                // Update claim info about opponent
                $cco = ClaimCaseOpponent::create([
                    'claim_case_id' => $claim_case->claim_case_id,
                    'opponent_user_id' => $opponent->user_id,
                    'opponent_address_id' => $opponent_address->user_claimcase_id,
                    'status_id' => 1, // unfinish
                ]);

                $audit = new AuditController;
                $audit->add($request, 4, "Form1Controller", json_encode($request->input()), null, "Creating claim case " . $claim_case->case_no . " (STEP 2)");

                return response()->json([
                    'result' => 'Success',
                    'claim_case_id' => $claim_case->claim_case_id,
                    'user' => [
						'cco' => $cco,
						'opponent_address' => $opponent_address,
						'address_combined' => ($opponent_address->street_1 == null ? '':$opponent_address->street_1)." ".($opponent_address->street_2 == null ? '':$opponent_address->street_2)." ".($opponent_address->street_3 == null ? '':$opponent_address->street_3),
                        'district_fixed' => $opponent_address->district2->district,
                        'state_fixed' => $opponent_address->state->state,
						'user_id' => $opponent->user_id,
                        'name' => $opponent_name,
                        'identity' => $opponent_identification_no,

                        'identification_no' => $opponent_identification_no,
                        'nationality_country_id' => $opponent_nationality,

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
                        'cco_id' => $cco->id,
                    ]
                ]);
            }

            return response()->json(['result' => 'Success', 'claim_case_id' => $request->claim_case_id]);
        }
    }

    public function partialCreate2Destroy(Request $request, $cco_id)
    {
        $cco = ClaimCaseOpponent::find($cco_id);
        $claim_case_id = $cco->claim_case_id;

        $cco->delete();

        $ccos = ClaimCaseOpponent::with('opponent')
            ->where('claim_case_id', $claim_case_id)->get();

        return response()->json([
            'result' => 'Success',
            'ccos' => $ccos->toArray(),
        ]);
    }

    /**
     * @param $request
     * @return array
     */
    protected function rules_partial3($request)
    {

        $rules = [
            'purchased_item' => 'required',
            'claim_details' => 'required',
            'claim_amount' => 'required|numeric',
            'purchased_amount' => 'nullable|numeric'
        ];

        $userid = Auth::id();
        $user = User::find($userid);

        if ($user->user_type_id == 3)
            $rules['preferred_ttpm_branch'] = 'required|integer';

        if ($request->is_filed_on_court == 1)
            $rules['case_name'] = 'required';

        return $rules;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function partialCreate3(Request $request)
    {

        $validator = Validator::make($request->all(), $this->rules_partial3($request));

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            // Get claim_case_id
            $claim_case_id = $request->claim_case_id;

            // Get current user_id
            $userid = Auth::id();
            $user = User::find($userid);


            //////////////////////////////////////////
            // Check if form1 existed, updateOrCreate

            $is_filed_on_court = $request->is_filed_on_court;
            $case_name = $request->case_name;
            $case_status = $request->case_status;
            $case_place = $request->case_place;
            $case_created_at = $request->case_created_at ? Carbon::createFromFormat('d/m/Y', $request->case_created_at)->toDateTimeString() : NULL;

            $is_online_transaction = $request->is_online_transaction;
            $purchased_date = $request->purchased_date ? Carbon::createFromFormat('d/m/Y', $request->purchased_date)->toDateTimeString() : NULL;
            $purchased_item = $request->purchased_item;
            $purchased_brand = $request->purchased_brand;
            $purchased_amount = $request->purchased_amount;
            $claim_details = $request->claim_details;
            $claim_amount = $request->claim_amount;

            if ($user->user_type_id != 3) {
                $preferred_ttpm_branch = $user->ttpm_data->branch_id;
            } else {
                $preferred_ttpm_branch = $request->preferred_ttpm_branch;
            }

            $case = ClaimCase::find($claim_case_id);
            $inquiry_no = $request->inquiry_no;

            if (!$case->form1_id && $inquiry_no) {

                $inquiry = Inquiry::where('inquiry_no', $inquiry_no);

                if ($inquiry->count() > 0) {
                    $inquiry = $inquiry->first();

                    if ($inquiry->form1_id) {
                        $case->form1_id = $inquiry->form1_id;
                        $case->save();
                    }
                }
            }

            if ($case->form1_id) {
                // Update

                $form1 = Form1::find($case->form1_id);

                if ($is_filed_on_court == 1) {

                    // Check if already existed or not, If exised, update.

                    if ($form1->court_case_id) {
                        // Update courtcase
                        $court_case = CourtCase::find($form1->court_case_id);

                        $court_case->court_case_name = $case_name;
                        $court_case->court_case_status = $case_status;
                        $court_case->court_case_location = $case_place;
                        $court_case->filing_date = $case_created_at;
                        $court_case->updated_at = Carbon::now();
                        $court_case->save();
                    } else {
                        // Create courtcase
                        $court_case_id = DB::table('court_case')->insertGetId([
                            'court_case_name' => $case_name,
                            'court_case_status' => $case_status,
                            'court_case_location' => $case_place,
                            'filing_date' => $case_created_at,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                        $form1->court_case_id = $court_case_id;

                    }

                } else {

                    // If existed, delete old one
                    if ($form1->court_case_id) {
                        $court_case = CourtCase::find($form1->court_case_id)->delete();
                    } else {
                        $form1->court_case_id = NULL;
                    }

                }

                $form1->is_online_purchased = $is_online_transaction;
                $form1->purchased_date = $purchased_date;
                $form1->purchased_item_name = $purchased_item;
                $form1->purchased_item_brand = $purchased_brand;
                $form1->purchased_amount = $purchased_amount;
                $form1->claim_details = $claim_details;
                $form1->claim_amount = $claim_amount;
                $form1->updated_at = Carbon::now();

                // 61 - inquiry
                if($form1->form_status_id == 61){
                    $form1->form_status_id = 13; // Draft
                }

                $form1->save();


            } else {
                // Insert

                // If user has filed claim on court, create court_case and return court_case_id
                if ($is_filed_on_court == 1) {
                    $court_case_id = DB::table('court_case')->insertGetId([
                        'court_case_name' => $case_name,
                        'court_case_status' => $case_status,
                        'court_case_location' => $case_place,
                        'filing_date' => $case_created_at,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    $court_case_id = NULL;
                }

                $filing_date = Carbon::now()->toDateString();

                $general = new GeneralController;
                $matured_date = $general->getDateExcludeHolidaysByBranch($filing_date, env("CONF_F1_MATURED_DURATION", 14), $case->branch_id);


                // Create form1 and return form1_id
                $form1_id = DB::table('form1')->insertGetId([
                    'is_online_purchased' => $is_online_transaction,
                    'purchased_date' => $purchased_date,
                    'purchased_item_name' => $purchased_item,
                    'purchased_item_brand' => $purchased_brand,
                    'purchased_amount' => $purchased_amount,
                    'claim_details' => $claim_details,
                    'claim_amount' => $claim_amount,
                    'court_case_id' => $court_case_id,
                    'filing_date' => Carbon::now(),
                    'matured_date' => $matured_date,               // Change this later
                    'form_status_id' => 13, // Draft
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // Update claim info about form1

                $case->form1_id = $form1_id;

            }

            if ($case->form1) {
                if (!$case->form1->processed_at) {
                    $case->branch_id = $preferred_ttpm_branch;
                }
            } else {
                $case->branch_id = $preferred_ttpm_branch;
            }


            $case->updated_at = Carbon::now();
            $case->save();

            $branch_data = MasterBranch::find($preferred_ttpm_branch);
            $branch = array();
            $branch['name'] = $branch_data->branch_name;
            $branch['address'] = $branch_data->branch_address;
            $branch['address2'] = $branch_data->branch_address2;
            $branch['address3'] = $branch_data->branch_address3;
            $branch['postcode'] = $branch_data->branch_postcode;
            $branch['district'] = $branch_data->district->district;
            $branch['state'] = $branch_data->state->state;


            $audit = new AuditController;
            $audit->add($request, 4, "Form1Controller", json_encode($request->input()), null, "Creating claim case " . $case->case_no . " (STEP 3)");

            return response()->json(['result' => 'Success', 'claim_case_id' => $claim_case_id, 'branch' => $branch]);
        }
    }

    /**
     * @param $request
     * @param null $type
     * @return array
     */
    protected function rules_partial5($request, $type = null)
    {

        $rules = [
            'payment_method' => 'required|numeric',
            'claim_category' => 'required|numeric',
            'claim_classification' => 'required|numeric',
            'claim_offence' => 'required|numeric',
            'psu' => 'required|numeric',
            'hearing_venue_id' => 'required|numeric'
        ];

        if ($request->payment_method != 1) {
            $rules['payment_date'] = 'required';
            // $rules['receipt_no'] = 'required|unique:payment';
            $rules['receipt_no'] = 'required';
        }

        if ($request->payment_method == 3) {
            $rules['postalorder_no'] = 'required';
        }

        return $rules;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertCase(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_partial5($request));

        if ($request->ajax()) {

            if (!$validator->passes()) {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }

            // Get claim_case_id
            $claim_case_id = $request->claim_case_id;
            $case = ClaimCase::find($claim_case_id);


            $general = new GeneralController;

            $filing_date = $request->filing_date ? Carbon::createFromFormat('d/m/Y', $request->filing_date)->toDateString() : Carbon::now()->toDateString();
            $matured_date = $request->matured_date ? Carbon::createFromFormat('d/m/Y', $request->matured_date)->toDateString() : $general->getDateExcludeHolidaysByBranch($filing_date, env("CONF_F1_MATURED_DURATION", 14), $case->branch_id);

            $payment_method = $request->payment_method;
            $postalorder_no = $request->postalorder_no;
            $receipt_no = $request->receipt_no;
            $payment_date = $request->payment_date ? Carbon::createFromFormat('d/m/Y', $request->payment_date)->toDateTimeString() : NULL;

            $claim_category = $request->claim_category;
            $claim_classification = $request->claim_classification;
            $claim_offence = $request->claim_offence;
            $hearing_venue_id = $request->hearing_venue_id;

            $psu = $request->psu;

            if (!(Auth::user()->hasRole('ks') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin'))) {
                $branch = Auth::user()->ttpm_data->branch_id;
            } else {
                $branch = $request->branch;
            }


            ////////////////////////////////////////////    Check Branch    ////////////////////////////////////////////////////

            if ($case->branch_id != $request->branch) {
                $branch_data = MasterBranch::find($branch);

                if ($branch_data) {
                    Mail::to($branch_data->branch_emel)->send(new ChangeBranchAlertMail($case, App::getLocale() == "en" ? 1 : 2));
                }
            }

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


            //$hearing_date = $request->hearing_date ? Carbon::createFromFormat('d/m/Y', $request->hearing_date)->toDateTimeString() : NULL;
            $form1_id = $case->form1_id;
            $form1 = Form1::find($case->form1_id);

            $form1->filing_date = $filing_date;
            $form1->matured_date = $matured_date;
            $form1->claim_classification_id = $claim_classification;
            $form1->offence_type_id = $claim_offence;

            if ($form1->payment_id) {
                if ($payment_method == 2) { // Pay at counter
                    $payment_id = Payment::find($form1->payment_id)->update([
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'updated_at' => Carbon::now()
                    ]);
                } else if ($payment_method == 3) { // Pay by Postal Order
                    $payment_postalorder_id = PaymentPostalOrder::find($form1->payment->payment_postalorder_id)->update([
                        'postalorder_no' => $postalorder_no,
                        'paid_at' => $payment_date,
                        'updated_at' => Carbon::now()
                    ]);

                    $payment_id = Payment::find($form1->payment_id)->update([
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'updated_at' => Carbon::now()
                    ]);
                }

                $form1->form_status_id = $form1->form_status_id > 17 ? $form1->form_status_id : 17;

            } else {
                // Not exist yet

                if ($payment_method == 2) { // Pay at counter
                    $payment_id = DB::table('payment')->insertGetId([
                        'is_payment_counter' => 1,
                        'payment_status_id' => 4, // Completed
                        'claim_case_id' => $claim_case_id,
                        'form_no' => 1,
                        'form_id' => $case->form1_id,
                        'description' => "Pemfailan Borang 1 / Form 1 Filing",
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
                        'claim_case_id' => $claim_case_id,
                        'form_no' => 1,
                        'form_id' => $form1_id,
                        'description' => "Pemfailan Borang 1 / Form 1 Filing",
                        'receipt_no' => $receipt_no,
                        'paid_at' => $payment_date,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }

                $form1->payment_id = $payment_id;
                $form1->form_status_id = 17;

            }

            $form1->processed_by_user_id = Auth::id();
            $form1->processed_at = $form1->processed_at ?: Carbon::now();
            $form1->updated_at = Carbon::now();
            $form1->save();


            $case->psu_user_id = $psu;
            $case->branch_id = $branch;
            $case->hearing_venue_id = $hearing_venue_id;

            $branch_code = $case->branch->branch_code;
            $category_code = MasterClaimCategory::find($claim_category)->category_code;


            if ($request->hearing_date && !empty($request->hearing_date)) {
                $case->case_status_id = $case->case_status_id > 7 ? $case->case_status_id : 7;

                foreach ($case->multiOpponents as $cco) {
                    Form4::updateOrCreate(
                        [
                            'claim_case_opponent_id' => $cco->id,
                            'hearing_id' => $request->hearing_date
                        ], [
                            'claim_case_id' => $cco->claim_case_id,
                            'claim_case_opponent_id' => $cco->id,
                            'opponent_user_id' => $cco->opponent_user_id,
                            'hearing_id' => $request->hearing_date,
                            'created_by_user_id' => Auth::id(),
                            'psu_user_id' => Auth::id(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                }
            } else {
                $case->case_status_id = $case->case_status_id > 2 ? $case->case_status_id : 2;
            }

            $state = MasterState::find($case->branch->branch_state_id);

            if (!(strpos($case->case_no, 'TTPM') !== false)) {
                $filing_year = date('Y', strtotime($filing_date));
                $case_no = RunnerRepository::generateAppNumber('TTPM', $branch_code, $filing_year, null, null, $category_code);
                $case->case_no = $case_no['number'];
                $case->filing_date = $filing_date;
                $state->next_claim_no = $state->next_claim_no + 1;
                $state->save();

                Form1::find($case->form1_id)
                    ->update([
                        'case_year' => $filing_year,
                        'case_sequence' => $case_no['runner'],
                    ]);
            }

            ////////////////// Check for any changes of category in case_no
            if (strpos($case->case_no, 'TTPM') !== false) {
                $pattern = '/(\S+\()(.+)(\)\S+)/i';
                $replacement = '$1' . $category_code . '$3';
                $case->case_no = preg_replace($pattern, $replacement, $case->case_no);
            }

            $case->save();

            $audit = new AuditController;
            $audit->add($request, 4, "Form1Controller", json_encode($request->input()), null, "Creating claim case " . $case->case_no . " (STEP 5)");

            return response()->json(['result' => 'Success', 'payment_id' => $form1->payment_id, 'case_no' => $case->case_no]);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOpponentDetails(Request $request)
    {

        if ($request->id_no != "") {

            $userid = Auth::id();

            $id_no = $request->id_no;

            $opponent = User::where('username', $id_no)->where('user_id', '!=', $userid);//->whereNotNull('password');

            // If user public company

            // If user public individual

            if ($opponent->get()->count() > 0) { // User exist!

                $user = $opponent->first();

                if ($user->public_data->user_public_type_id == 1) { // Individual
                    $user_data = $user;
                    $user->public_data;
                    $user->public_data->individual;
                } else {
                    $user_data = $user;
                    $user->public_data;
                    $user->public_data->company;
                }


                return response()->json(['result' => 'Exist', 'user_data' => $user_data]);
            } else {
                return response()->json(['result' => 'None']);
            }
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function view(Request $request)
    {
        $claim_case_id = $request->claim_case_id;
        $is_staff = false;
        $userid = Auth::id();
        $user = User::find($userid);
        $attachments = null;
        $payments = null;

        if ($user->user_type_id != 3) {
            $is_staff = true;
        }

        $claim_case = ClaimCase::where('claim_case_id', $claim_case_id)->first();

        if (Auth::user()->user_type_id == 3) {
            $oppo = ClaimCaseOpponent::where('claim_case_id', $claim_case_id)
//                ->where('opponent_user_id', Auth::id())
                ->first();
            if ($claim_case->claimant_user_id != Auth::id() && $oppo == null)
                abort(404);
        }

        $case_no = $claim_case->case_no;

        if ($claim_case->form1_id) {
            $attachments = Attachment::where('form_no', 1)
                ->where('form_id', $claim_case->form1_id)
                ->get();
            $payments = Payment::where('form_no', 1)
                ->where('claim_case_id', $claim_case_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $date = array();

        if ($claim_case->form1_id) {
            if ($claim_case->form1->court_case_id) {
                if ($claim_case->form1->court_case->filing_date) {
                    $date['court_case_filing_date'] = date('d/m/Y', strtotime($claim_case->form1->court_case->filing_date));
                }
            }

            if ($claim_case->form1->processed_at) {
                $date['form1_filing_date'] = date('d/m/Y', strtotime($claim_case->form1->processed_at));
            }

            if ($claim_case->form1->matured_date) {
                $date['form1_matured_date'] = date('d/m/Y', strtotime($claim_case->form1->matured_date));
            }

            if ($claim_case->form1->payment_id) {
                if ($claim_case->form1->payment->paid_at) {
                    $date['form1_paid_at'] = date('d/m/Y', strtotime($claim_case->form1->payment->paid_at));
                }
            }

            if ($claim_case->form1->purchased_date) {
                $date['form1_purchased_date'] = date('d/m/Y', strtotime($claim_case->form1->purchased_date));
            }
        }

        $audit = new AuditController;
        $audit->add($request, 3, "Form1Controller", null, null, "View claim case " . $claim_case->case_no);

        return view("claimcase.form1.infoForm1", compact('case_no', 'claim_case', 'is_staff', 'userid', 'attachments', 'date', 'payments', 'user'));
    }
}
