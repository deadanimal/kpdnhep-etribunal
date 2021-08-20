<?php

namespace App\Http\Controllers\Inquiry;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use App\CaseModel\Inquiry;
use App\Http\Controllers\Controller;
use App\Mail\InquirySecretaryAlertMail;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterClaimClassification;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterFormStatus;
use App\MasterModel\MasterInquiryFeedback;
use App\MasterModel\MasterInquiryMethod;
use App\MasterModel\MasterInquiryType;
use App\MasterModel\MasterOrganization;
use App\MasterModel\MasterState;
use App\Repositories\LogAuditRepository;
use App\Repositories\RunnerRepository;
use App\RoleUser;
use App\SupportModel\Attachment;
use App\SupportModel\CourtCase;
use App\User;
use App\UserExtra;
use App\UserPublic;
use App\UserPublicCompany;
use App\UserPublicIndividual;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PDF;
use Yajra\Datatables\Datatables;

class InquiryController extends Controller
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
     * View inquiry data
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function view(Request $request)
    {
        $inquiry_id = $request->inquiry_id;
        $is_process = $request->has('is_process') ? $request->is_process : 0;

        if ($inquiry_id) {
            $inquiry = Inquiry::find($inquiry_id);
            $updated_at = date('d/m/Y', strtotime($inquiry->created_at));
            $userid = Auth::id();
            $user = User::find($userid);
            $is_staff = $user->user_type_id != 3 ? 1 : 0;
            $case = ClaimCase::where('form1_id', $inquiry->form1_id)->first();
            $attachments = $inquiry->form1_id ? Attachment::select('attachment_name', 'attachment_id')
                ->where('form_no', ($case ? 1 : 0))
                ->where('form_id', ($case ? $case->form1_id : $inquiry_id))->get() : null;
            $claimed = $inquiry->form1_id ? ($case ? true : false) : false;

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 3, "InquiryController", null, null, "View Inquiry " . $inquiry->inquiry_no);
            return view("inquiry.viewModal", compact('inquiry', 'is_staff', 'is_process', 'attachments', 'claimed', 'updated_at'));
        }
    }

    /**
     * Print inquiry data
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function print(Request $request)
    {
        $inquiry_id = $request->inquiry_id;

        if ($inquiry_id) {

            $this->data['inquiry'] = $inquiry = Inquiry::find($inquiry_id);
            $this->data['updated_at'] = date('d/m/Y', strtotime($inquiry->created_at));

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 17, "InquiryController", $inquiry->inquiry_no, null, "Download inquiry");

            $pdf = PDF::loadView('inquiry/print', $this->data);

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Pertanyaan ' . $inquiry->inquiry_no . '.pdf');
        }
    }

    public function viewbranch()
    {
        $branches = MasterBranch::where('is_active', 1)->get();

        return view('inquiry/branchModal', compact('branches'));
    }


    /**
     * List of inquiry data
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $status = MasterFormStatus::where('form_status_id', '>=', 9)
            ->where('form_status_id', '<=', 12)
            ->get();
        $branches = MasterBranch::where('is_active', 1)
            ->orderBy('branch_id', 'desc')
            ->get();
        $types = MasterInquiryType::get();
        $methods = MasterInquiryMethod::where('is_active', 1)
            ->get();

        $internal = false;

        if (Auth::user()->user_type_id != 3)
            $internal = true;

        if (Auth::user()->user_type_id != 3 && !$request->has('branch')) {

            if (!Auth::user()->hasRole('setiausaha')) {
                if (!$request->has('status')) {
                    return redirect()->route('onlineprocess.inquiry', ['branch' => Auth::user()->ttpm_data->branch_id, 'status' => "9"]);
                } else {
                    return redirect()->route('onlineprocess.inquiry', ['branch' => Auth::user()->ttpm_data->branch_id]);
                }
            } else {
                if (!$request->has('status')) {
                    return redirect()->route('onlineprocess.inquiry', ['status' => "10"]);
                }
            }
        }

        if ($request->ajax()) {
            $userid = Auth::id();
            $user = User::find($userid);

            if ($user->user_type_id != 3) { // internal user
                $inquiry = Inquiry::select([
                    DB::raw('datediff(CURDATE(), processed_at) as date_elapsed'),
                    'inquiry.inquiry_id',
                    'inquiry.inquiry_type_id',
                    'inquiry.inquiry_form_status_id',
                    'inquiry.inquiry_method_id',
                    'inquiry.inquiry_no',
                    'inquiry.inquiry_msg',
                    'inquiry.branch_id',
                    'inquiry.created_at',
                    'inquiry.inquired_by_user_id',
                ])
                    ->with(['inquired_by', 'type', 'method', 'status', 'branch'])
                    ->orderBy('inquiry.created_at', 'desc');
            } else {  // public
                $inquiry = Inquiry::with(['inquired_by', 'type', 'method', 'status', 'branch'])
                    ->where('inquiry.inquired_by_user_id', $userid)
                    ->orderBy('inquiry.created_at', 'desc');
            }

            if ($request->has('branch') && !empty($request->branch) && $request->branch > 0) {
                $inquiry->where(function ($q) use ($request) {
                    $q->where('branch_id', $request->branch);
                });
            }

            // Check for filteration
            if ($request->has('status') && !empty($request->status) && $request->status > 0) {
                $inquiry->where('inquiry_form_status_id', $request->status);
            }

            if ($request->has('more_than') && !empty($request->more_than)) {
                $inquiry->raw('datediff(CURDATE(), processed_at) as date_elapsed >= ' .$request->more_than);
            }

            if ($request->has('type') && !empty($request->type)) {
                $inquiry->where('inquiry_type_id', $request->type);
            }

            if ($request->has('method') && !empty($request->method)) {
                $inquiry->where('inquiry_method_id', $request->method);
            }

            $datatables = Datatables::of($inquiry);

            return $datatables
                ->addIndexColumn()
                ->editColumn('inquiry_type', function ($inquiry) {
                    $locale = App::getLocale();
                    $type_lang = "type_" . $locale;
                    return $inquiry->type->$type_lang;
                })
                ->editColumn('inquiry_user', function ($inquiry) {
                    if ($inquiry->inquired_by_user_id)
                        return $inquiry->inquired_by->name;
                    else
                        return '';
                })
                ->editColumn('created_at', function ($inquiry) {
                    return Carbon::parse($inquiry->created_at)->format('d/m/Y');
                })
                ->editColumn('status', function ($inquiry) {
                    $locale = App::getLocale();
                    $status_lang = "form_status_desc_" . $locale;
                    return $inquiry->status->$status_lang;
                })
                ->editColumn('branch_name', function ($inquiry) {
                    if ($inquiry->branch)
                        return $inquiry->branch->branch_name;
                    else
                        return '';
                })
                ->editColumn('day_answered', function ($inquiry) {
                    if ($inquiry->form_status_id == 11 || $inquiry->form_status_id == 12) {
                        // Telah Dijawab & Telah Dijawab oleh SU
                        $to = Carbon::parse($inquiry->processed_at ? $inquiry->processed_at : $inquiry->updated_at);
                        $from = Carbon::parse($inquiry->created_at);
                        return $to->diffInDays($from);
                    } else {
                        return $inquiry->date_elapsed ?: 0;
//                        $to = Carbon::now();
//                        $from = Carbon::parse($inquiry->processed_at);
//                        return $to->diffInDays($from);
                    }
                })
                ->editColumn('inquiry_method', function ($inquiry) {
                    $locale = App::getLocale();
                    $method_lang = "method_" . $locale;
                    return $inquiry->method->$method_lang;
                })
                ->addColumn('action', function ($inquiry) {
                    $userid = Auth::id();
                    $user = User::find($userid);

                    $button = "";

                    if ($inquiry->inquired_by_user_id)
                        $button .= '<a value="' . route('inquiry.view', $inquiry->inquiry_id) . '" rel="tooltip" data-original-title="' . __('button.view') . '" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    if ($inquiry->inquiry_form_status_id == 9) { // Unanswered
                        if ($inquiry->inquired_by_user_id && $user->user_type_id != 3) {
                            //untuk staff
                            $button .= actionButton('green-meadow', __('button.edit'), route('inquiry.edit', ['id' => $inquiry->inquiry_id]), false, 'fa-edit', false);
                            $button .= actionButton('purple', __('button.process'), route('inquiry.process', ['id' => $inquiry->inquiry_id]), false, 'fa-spinner', false);
                        }
                    } else if ($inquiry->inquiry_form_status_id == 10 && Auth::user()->hasRole('setiausaha')) { // Unanswered
                        $button .= actionButton('purple', __('button.process'), route('inquiry.process', ['id' => $inquiry->inquiry_id]), false, 'fa-spinner', false);
                    }

                    return $button;
                })
                ->make(true);
        }

        LogAuditRepository::store($request, 12, "InquiryController", null, null, "Datatables load inquiry");

        return view("inquiry.list", compact('status', 'branches', 'types', 'methods', 'internal'));
    }

    public function delete(Request $request, $inquiry_id)
    {
        if ($inquiry_id) {
            $inquiry = Inquiry::find($inquiry_id);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 6, "InquiryController", null, null, "Delete inquiry " . $inquiry->inquiry_no);
            $attachment = Attachment::where('form_no', 0)->where('form_id', $inquiry->inquiry_id)->delete();
            $inquiry->delete();

            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    /**
     * Show inquiry create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $is_staff = $user->user_type_id != 3 ? true : false;
        $inquiry_methods = MasterInquiryMethod::where('is_active', 1)->get();
        $inquiry_types = MasterInquiryType::all();
        $countries = MasterCountry::all();
        $states = MasterState::all();
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();
        $inquiry_feedbacks = MasterInquiryFeedback::all();
        $organizations = MasterOrganization::where('is_active', 1)->get();
        $attachments = null;
        $inquiry = null;
        $branches = MasterBranch::where('is_active', 1)->get();
        $locale = App::getLocale();
        $method_lang = "method_" . $locale;
        $category_lang = "category_" . $locale;
        $classification_lang = "classification_" . $locale;
        $feedback_lang = "feedback_" . $locale;

        return view("inquiry.create", compact('is_staff', 'inquiry_methods', 'inquiry_types',
            'countries', 'states', 'categories', 'classifications', 'inquiry_feedbacks', 'organizations',
            'attachments', 'inquiry', 'branches', 'locale', 'method_lang', 'category_lang', 'classification_lang',
            'feedback_lang'));
    }

    /**
     * Show edit inquiry form
     * @param $inquiry_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function edit($inquiry_id)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $is_staff = $user->user_type_id != 3 ? true : false;
        $inquiry = Inquiry::find($inquiry_id);
        $inquiry_methods = MasterInquiryMethod::where('is_active', 1)->get();
        $inquiry_types = MasterInquiryType::all();
        $countries = MasterCountry::all();
        $states = MasterState::all();
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();
        $inquiry_feedbacks = MasterInquiryFeedback::all();
        $organizations = MasterOrganization::where('is_active', 1)->get();
        $branches = MasterBranch::where('is_active', 1)->get();
        $case = $inquiry->form1_id ? ClaimCase::where('form1_id', $inquiry->form1_id)->first() : null;
        $attachments = Attachment::select('attachment_name', 'attachment_id')
            ->where('form_no', ($case > 0 ? 1 : 0))
            ->where('form_id', ($case > 0 ? $case->form1_id : $inquiry_id))
            ->get();

        return view("inquiry.create", compact('is_staff', 'inquiry_methods', 'inquiry_types', 'countries',
            'states', 'categories', 'classifications', 'inquiry_feedbacks', 'organizations', 'attachments', 'inquiry',
            'branches'));
    }

    protected function rules_user($request)
    {

        if ($request->inquiry_type == 1) {
            $rules = ['inquiry_msg' => 'required|string|max:1000'];
        } else {
            $rules = [
                'purchased_item' => 'required',
                'reason' => 'required',
                'claim_amount' => 'required|numeric',
                'purchased_amount' => 'nullable|numeric'
            ];


            if ($request->is_filed_on_court == 1)
                $rules['case_name'] = 'required';

            if ($request->opponent_identity_type == 2)
                $rules['opponent_nationality'] = 'required|integer';
        }
        $rules['transaction_state'] = 'required';

        return $rules;
    }

    protected function rules_staff($request, $inquiry)
    {

        $ic_rules = ['required', 'min:12', 'max:12', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];

        if ($request->claimant_identity_type == 1)
            $rules['claimant_identification_no'] = $ic_rules;
        else
            $rules['claimant_identification_no'] = 'required';


        if ($inquiry && $inquiry->inquiry_no && $request->inquiry_method != 7 && $request->is_process == 1) {
            $rules['feedback_type'] = 'required';
            $rules['inquiry_feedback_msg'] = 'required';
        }

        if ($request->claimant_identity_type == 2)
            $rules['claimant_nationality'] = 'required|integer';


        if ($request->inquiry_type == 1) {
            $rules['inquiry_msg'] = 'required|string|max:1000';
        } else {

            $rules['purchased_item'] = 'required';
            $rules['reason'] = 'required';
            $rules['claim_amount'] = 'required|numeric';
            $rules['purchased_amount'] = 'nullable|numeric';

            if ($request->is_process == 1) {
                $rules['claim_category'] = 'required';
                $rules['claim_classification'] = 'required';
            }

            if ($request->is_filed_on_court == 1)
                $rules['case_name'] = 'required';

            if ($request->opponent_identity_type == 2)
                $rules['opponent_nationality'] = 'required|integer';
        }

        if ($request->feedback_type == 2 && $request->is_process == 1) {
            $rules['feedback_cannot_filed_reason'] = 'required|integer';

            if ($request->feedback_cannot_filed_reason == 1)
                $rules['feedback_cannot_filed_agencies'] = 'required|integer';
        }

        $rules['inquiry_method'] = 'required';
        $rules['claimant_identity_type'] = 'required';
        $rules['transaction_state'] = 'required';

        return $rules;
    }

    /**
     * Stored inqury | and update too. @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @todo change it to update. not store.
     */
    public function store(Request $request)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $inquiry_id = $request->inquiry_id ? $request->inquiry_id : null;
        $inquiry = $request->inquiry_id ? Inquiry::find($inquiry_id) : null;
        $log = [];

        if ($user->user_type_id != 3) {
            $validator = Validator::make($request->all(), $this->rules_staff($request, $inquiry));

            if ($request->ajax()) {

                if (!$validator->passes()) {
                    return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
                }

                $inquiry_method = $request->inquiry_method;
                $inquiry_date = $request->inquiry_date;
                $inquiry_type = $request->inquiry_type;
                $claimant_identity_type = $request->claimant_identity_type;
                $claimant_identification_no = $request->claimant_identification_no;
                $claimant_nationality = $claimant_identity_type == 2 ? $request->claimant_nationality : 129; // 129 - malaysia
                $name = $request->name;
                $street1 = $request->street1;
                $street2 = $request->street2;
                $street3 = $request->street3;
                $postcode = $request->postcode;
                $district = $request->district;
                $state = $request->state;
                $phone_home = $request->phone_home;
                $phone_mobile = $request->phone_mobile;
                $phone_office = $request->phone_office;
                $phone_fax = $request->phone_fax;
                $email = $request->email;
                $inquiry_msg = $request->inquiry_msg;
                $opponent_identity_type = $request->opponent_identity_type;
                $opponent_identification_no = $request->opponent_identification_no;
                $opponent_nationality = $opponent_identity_type == 2 ? $request->opponent_nationality : 129; // 129 - malaysia
                $relationship_id = $opponent_identity_type == 3 ? 3 : null;
                $opponent_name = $request->opponent_name;
                $transaction_date = $request->transaction_date;
                $purchased_item = $request->purchased_item;
                $purchased_brand = $request->purchased_brand;
                $paid_amount = $request->paid_amount;
                $reason = $request->reason;
                $claim_amount = $request->claim_amount;
                $is_filed_on_court = $request->is_filed_on_court;
                $case_name = $request->case_name;
                $case_status = $request->case_status;
                $case_place = $request->case_place;
                $case_created_at = $request->case_created_at;
                $claim_classification = $request->claim_classification;
                $feedback_type = $request->feedback_type;
                $feedback_cannot_filed_agencies = $request->feedback_cannot_filed_agencies;
                $inquiry_feedback_msg = $request->inquiry_feedback_msg;
                $transaction_address = $request->transaction_address;
                $transaction_postcode = $request->transaction_postcode;
                $transaction_state = $request->transaction_state;
                $transaction_district = $request->transaction_district;
                $phone_no = $request->phone_no;


                // Check for existing user
                $claimant = User::where('username', $claimant_identification_no);

                if ($claimant->get()->count() > 0) { // Existed
                    $claimant_id = $claimant->first()->user_id;
                    $claimant = User::where('username', $claimant_identification_no)->first();

                    if ($claimant->public_data->user_public_type_id == 1) {
                        UserPublicIndividual::where('user_id', $claimant_id)->update([
                            'identification_no' => $claimant_identification_no,
                            'nationality_country_id' => $claimant_nationality,
                            'phone_home' => $phone_home,
                            'phone_mobile' => $phone_mobile
                        ]);
                    } else if ($claimant->public_data->user_public_type_id == 2) {
                        UserPublicCompany::where('user_id', $claimant_id)->update([
                            'company_no' => $claimant_identification_no,
                            'representative_phone_home' => $phone_home,
                            'representative_phone_mobile' => $phone_mobile
                        ]);
                    }

                    UserPublic::where('user_id', $claimant_id)->update([
                        'address_mailing_street_1' => $street1,
                        'address_mailing_street_2' => $street2,
                        'address_mailing_street_3' => $street3,
                        'address_mailing_postcode' => $postcode,
                        'address_mailing_district_id' => $district,
                        'address_mailing_state_id' => $state
                    ]);

                    User::find($claimant_id)->update([
                        'name' => $name,
                        'username' => $claimant_identification_no,
                        'phone_office' => $phone_office,
                        'phone_fax' => $phone_fax,
                        'email' => $email
                    ]);
                } else { // New
                    // Create partial user and return id
                    $claimant_id = DB::table('users')->insertGetId([
                        'name' => $name,
                        'username' => $claimant_identification_no,
                        'user_type_id' => 3, // Public users
                        'language_id' => 1, // English
                        'phone_office' => $phone_office,
                        'phone_fax' => $phone_fax,
                        'email' => $email,
                        'user_status_id' => 6, // Partial
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    // Company or Individual
                    if ($claimant_identity_type > 2) { // Company
                        $opponent_public = DB::table('user_public')->insertGetId([
                            'user_id' => $claimant_id,
                            'user_public_type_id' => 2, // Company
                            'address_mailing_street_1' => $street1,
                            'address_mailing_street_2' => $street2,
                            'address_mailing_street_3' => $street3,
                            'address_mailing_postcode' => $postcode,
                            'address_mailing_district_id' => $district,
                            'address_mailing_state_id' => $state
                        ]);

                        $opponent_public_company = DB::table('user_public_company')->insertGetId([
                            'user_id' => $claimant_id,
                            'company_no' => $claimant_identification_no
                        ]);

                    } else { // Individual
                        $opponent_public = DB::table('user_public')->insertGetId([
                            'user_id' => $claimant_id,
                            'user_public_type_id' => 1, // Individual
                            'address_mailing_street_1' => $street1,
                            'address_mailing_street_2' => $street2,
                            'address_mailing_street_3' => $street3,
                            'address_mailing_postcode' => $postcode,
                            'address_mailing_district_id' => $district,
                            'address_mailing_state_id' => $state
                        ]);

                        $opponent_public_individual = DB::table('user_public_individual')->insertGetId([
                            'user_id' => $claimant_id,
                            'nationality_country_id' => $claimant_nationality,
                            'identification_no' => $claimant_identification_no,
                            'phone_home' => $phone_home,
                            'phone_mobile' => $phone_mobile
                        ]);
                    }
                }

                //$claimant_id


                if ($inquiry_type == 1) {

                    if ($feedback_type == 4)
                        $inquiry_form_status_id = 10;
                    else {
                        if (RoleUser::where('user_id', $userid)->where('role_id', 6)->get()->count() > 0)
                            $inquiry_form_status_id = 12;
                        else
                            $inquiry_form_status_id = 11;
                    }

                    if ($inquiry) {
                        // Update
                        $inquiry_update = $inquiry->update([
                            'inquiry_method_id' => $inquiry_method,
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquiry_msg' => $inquiry_msg,
                            'inquired_by_user_id' => $claimant_id,
                            'inquiry_feedback_id' => $feedback_type,
                            'inquiry_feedback_msg' => $inquiry_feedback_msg,
                            //'inquiry_form_status_id' => $inquiry_form_status_id,
                            'jurisdiction_organization_id' => $feedback_cannot_filed_agencies,
                            //'processed_by_user_id' => $userid,
                            'processed_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                    } else {

                        if (Auth::user()->user_type_id != 3) {
                            $branch = MasterBranch::find(Auth::user()->ttpm_data->branch_id);

                        } else {
                            $branch = MasterBranch::orderBy('inquiry_counter', 'asc')->first();
                        }
                        $branch_id = $branch->branch_id;
                        $branch->update(['inquiry_counter' => ($branch->inquiry_counter + 1)]);

                        // Add
                        $inquiry_id = DB::table('inquiry')->insertGetId([
                            'inquiry_no' => "INQUIRY",  /// Please change this later [method]-[branch]-[id]-[year]
                            'branch_id' => $branch_id,
                            'inquiry_method_id' => $inquiry_method,
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquiry_msg' => $inquiry_msg,
                            'inquired_by_user_id' => $claimant_id,
                            'inquiry_feedback_id' => $feedback_type,
                            'inquiry_feedback_msg' => $inquiry_feedback_msg,
                            'inquiry_form_status_id' => $inquiry_form_status_id,
                            'jurisdiction_organization_id' => $feedback_cannot_filed_agencies,
                            'processed_by_user_id' => $userid,
                            'processed_at' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                        $inquiry = Inquiry::find($inquiry_id);
                        $method_code = MasterInquiryMethod::find($inquiry_method)->code;

                        $state = MasterState::find($request->transaction_state);

                        $met_code = $method_code;
                        $state_code = $state->code;

                        $inquiry->inquiry_no = RunnerRepository::generateAppNumber('INQUIRY', $state_code, date('Y'), null, null, $met_code);
                        $inquiry->save();
                    }
                } else {
                    if ($inquiry && $inquiry->opponent_user_extra_id) {
                        if ($opponent_identification_no || $opponent_name) {
                            $user_extra_update = UserExtra::find($inquiry->opponent_user_extra_id)
                                ->update([
                                    'name' => $opponent_name,
                                    'identification_no' => $opponent_identification_no,
                                    'nationality_country_id' => $opponent_nationality,
                                    'relationship_id' => $relationship_id,
                                    'updated_at' => Carbon::now()
                                ]);
                            $user_extra_id = $inquiry->opponent_user_extra_id;
                        } else {
                            $user_extra_id = NULL;
                        }
                    } else {
                        if ($opponent_identification_no || $opponent_name) {
                            $user_extra_id = DB::table('user_extra')
                                ->insertGetId([
                                    'name' => $opponent_name,
                                    'identification_no' => $opponent_identification_no,
                                    'nationality_country_id' => $opponent_nationality,
                                    'relationship_id' => $relationship_id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                        } else {
                            $user_extra_id = NULL;
                        }
                    }

                    // if been filed before on court
                    if ($is_filed_on_court == 1) {
                        if ($inquiry && $inquiry->form1_id && $inquiry->form1->court_case_id) {
                            if ($case_name) {
                                CourtCase::find($inquiry->form1->court_case_id)
                                    ->update([
                                        'court_case_name' => $case_name,
                                        'court_case_status' => $case_status,
                                        'court_case_location' => $case_place,
                                        'filing_date' => $case_created_at ? Carbon::createFromFormat('d/m/Y', $case_created_at)->toDateTimeString() : NULL,
                                        'updated_at' => Carbon::now()
                                    ]);
                                $court_case_id = $inquiry->form1->court_case_id;
                            } else
                                $court_case_id = NULL;
                        } else {
                            if ($case_name) {
                                // Create courtcase
                                $court_case_id = DB::table('court_case')
                                    ->insertGetId([
                                        'court_case_name' => $case_name,
                                        'court_case_status' => $case_status,
                                        'court_case_location' => $case_place,
                                        'filing_date' => $case_created_at ? Carbon::createFromFormat('d/m/Y', $case_created_at)->toDateTimeString() : NULL,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);
                            } else {
                                $court_case_id = NULL;
                            }
                        }
                    } else {
                        $court_case_id = NULL;
                    }

                    if ($inquiry && $inquiry->form1_id) {
                        Form1::find($inquiry->form1_id)->update([
                            'is_online_purchased' => 0,
                            'purchased_date' => $transaction_date ? Carbon::createFromFormat('d/m/Y', $transaction_date)->toDateTimeString() : NULL,
                            'purchased_item_name' => $purchased_item,
                            'purchased_item_brand' => $purchased_brand,
                            'purchased_amount' => $paid_amount,
                            'claim_details' => $reason,
                            'claim_amount' => $claim_amount,
                            'court_case_id' => $court_case_id,
                            'filing_date' => Carbon::now(),
                            'matured_date' => Carbon::now()->addDays(config('tribunal.form1.maturity_period')),
                            'claim_classification_id' => $claim_classification,
                            'form_status_id' => 61, // New claim
                            'updated_at' => Carbon::now()
                        ]);
                        $form1_id = $inquiry->form1_id;
                    } else {
                        $form1_id = DB::table('form1')->insertGetId([
                            'is_online_purchased' => 0,
                            'purchased_date' => $transaction_date ? Carbon::createFromFormat('d/m/Y', $transaction_date)->toDateTimeString() : NULL,
                            'purchased_item_name' => $purchased_item,
                            'purchased_item_brand' => $purchased_brand,
                            'purchased_amount' => $paid_amount,
                            'claim_details' => $reason,
                            'claim_amount' => $claim_amount,
                            'court_case_id' => $court_case_id,
                            'filing_date' => Carbon::now(),
                            'matured_date' => Carbon::now()->addDays(config('tribunal.form1.maturity_period')),
                            'claim_classification_id' => $claim_classification,
                            'form_status_id' => 61, // New claim
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }


                    if ($inquiry) {
                        $inquiry_update = Inquiry::find($inquiry->inquiry_id)->update([
                            'inquiry_method_id' => $inquiry_method,
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquired_by_user_id' => $claimant_id,
                            'opponent_user_extra_id' => $user_extra_id,
                            'form1_id' => $form1_id,
                            'inquiry_feedback_id' => $feedback_type,
                            'inquiry_feedback_msg' => $inquiry_feedback_msg,
                            'jurisdiction_organization_id' => $feedback_cannot_filed_agencies,
                            'transaction_address' => $transaction_address,
                            'transaction_postcode' => $transaction_postcode,
                            'transaction_state' => $transaction_state,
                            'transaction_district' => $transaction_district,
                            'phone_no' => $phone_no,
                            //'processed_by_user_id' => $userid,
                            'processed_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {

                        if (Auth::user()->user_type_id != 3) {
                            $branch = MasterBranch::find(Auth::user()->ttpm_data->branch_id);

                        } else {
                            $branch = MasterBranch::orderBy('inquiry_counter', 'asc')->first();
                        }
                        $branch_id = $branch->branch_id;
                        $branch->update(['inquiry_counter' => ($branch->inquiry_counter + 1)]);

                        $inquiry_id = DB::table('inquiry')->insertGetId([
                            'inquiry_no' => "INQUIRY",  /// Please change this later [method]-[branch]-[id]-[year]
                            'branch_id' => $branch_id,
                            'inquiry_method_id' => $inquiry_method,
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquired_by_user_id' => $claimant_id,
                            'opponent_user_extra_id' => $user_extra_id,
                            'form1_id' => $form1_id,
                            'inquiry_feedback_id' => $feedback_type,
                            'inquiry_feedback_msg' => $inquiry_feedback_msg,
                            'jurisdiction_organization_id' => $feedback_cannot_filed_agencies,
                            'transaction_address' => $transaction_address,
                            'transaction_postcode' => $transaction_postcode,
                            'transaction_state' => $transaction_state,
                            'transaction_district' => $transaction_district,
                            'phone_no' => $phone_no,
                            'processed_by_user_id' => $userid,
                            'processed_at' => Carbon::now(),
                            'created_at' => $inquiry_date ? Carbon::createFromFormat('d/m/Y', $inquiry_date)->toDateTimeString() : Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                        $inquiry = Inquiry::find($inquiry_id);
                        $method_code = MasterInquiryMethod::find($inquiry_method)->code;

                        $state = MasterState::find($request->transaction_state);

                        $inquiry->inquiry_no = RunnerRepository::generateAppNumber('INQUIRY', $inquiry->state->code, date('Y'), null, null, $method_code);
                        $inquiry->save();
                    }

                }
            }
        } else {
            //$is_staff = false;

            $validator = Validator::make($request->all(), $this->rules_user($request));

            if ($request->ajax()) {
                if (!$validator->passes()) {
                    return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
                }

                $inquiry_type = $request->inquiry_type;

                $inquiry_msg = $request->inquiry_msg;

                $opponent_identity_type = $request->opponent_identity_type;
                $opponent_identification_no = $request->opponent_identification_no;
                if ($opponent_identity_type == 2)
                    $opponent_nationality = $request->opponent_nationality;
                else
                    $opponent_nationality = 129;

                if ($opponent_identity_type == 3)
                    $relationship_id = 3;
                else
                    $relationship_id = null;

                $opponent_name = $request->opponent_name;

                $transaction_date = $request->transaction_date;
                $purchased_item = $request->purchased_item;
                $purchased_brand = $request->purchased_brand;
                $paid_amount = $request->paid_amount;

                $reason = $request->reason;
                $claim_amount = $request->claim_amount;
                $is_filed_on_court = $request->is_filed_on_court;
                $case_name = $request->case_name;
                $case_status = $request->case_status;
                $case_place = $request->case_place;
                $case_created_at = $request->case_created_at;

                if ($inquiry_type == 1) {
                    if ($inquiry) {
                        $inquiry_update = Inquiry::find($inquiry->inquiry_id)->update([
                            'inquiry_type_id' => 1,
                            'created_by_user_id' => $userid,
                            'inquired_by_user_id' => $userid,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'inquiry_msg' => $inquiry_msg
                        ]);

                    } else {
                        if (Auth::user()->user_type_id != 3) {
                            $branch = MasterBranch::find(Auth::user()->ttpm_data->branch_id);

                        } else {
                            $branch = MasterBranch::orderBy('inquiry_counter', 'asc')->first();
                        }
                        $branch_id = $branch->branch_id;
                        $branch->update(['inquiry_counter' => ($branch->inquiry_counter + 1)]);

                        $inquiry_id = DB::table('inquiry')->insertGetId([
                            'inquiry_no' => "INQUIRY",  /// Please change this later [method]-[branch]-[id]-[year]
                            'branch_id' => $branch_id,
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquired_by_user_id' => $userid,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'inquiry_msg' => $inquiry_msg
                        ]);

                        $inquiry = Inquiry::find($inquiry_id);

                        $state = MasterState::find($request->transaction_state);

                        $inquiry->inquiry_no = RunnerRepository::generateAppNumber('INQUIRY', $inquiry->state->code, date('Y'), null, null, 'O');
                        $inquiry->save();
                    }
                } else {

                    if ($inquiry && $inquiry->opponent_user_extra_id) {

                        if ($opponent_name || $opponent_identification_no) {
                            $user_extra_update = UserExtra::find($inquiry->opponent_user_extra_id)->update([
                                'name' => $opponent_name,
                                'identification_no' => $opponent_identification_no,
                                'nationality_country_id' => $opponent_nationality,
                                'relationship_id' => $relationship_id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);

                            $user_extra_id = $inquiry->opponent_user_extra_id;
                        } else
                            $user_extra_id = NULL;

                    } else {
                        if ($opponent_name || $opponent_identification_no) {
                            $user_extra_id = DB::table('user_extra')->insertGetId([
                                'name' => $opponent_name,
                                'identification_no' => $opponent_identification_no,
                                'nationality_country_id' => $opponent_nationality,
                                'relationship_id' => $relationship_id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        } else
                            $user_extra_id = NULL;
                    }


                    if ($is_filed_on_court == 1) {

                        if ($inquiry && $inquiry->form1_id && $inquiry->form1->court_case_id) {
                            if ($case_name) {
                                $court_case_update = CourtCase::find($inquiry->form1->court_case_id)->update([
                                    'court_case_name' => $case_name,
                                    'court_case_status' => $case_status,
                                    'court_case_location' => $case_place,
                                    'filing_date' => $case_created_at ? Carbon::createFromFormat('d/m/Y', $case_created_at)->toDateTimeString() : NULL,
                                    'updated_at' => Carbon::now()
                                ]);
                                $court_case_id = $inquiry->form1->court_case_id;
                            } else
                                $court_case_id = NULL;

                        } else {

                            if ($case_name) {
                                // Create courtcase
                                $court_case_id = DB::table('court_case')->insertGetId([
                                    'court_case_name' => $case_name,
                                    'court_case_status' => $case_status,
                                    'court_case_location' => $case_place,
                                    'filing_date' => $case_created_at ? Carbon::createFromFormat('d/m/Y', $case_created_at)->toDateTimeString() : NULL,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
                            } else
                                $court_case_id = NULL;

                        }
                    } else
                        $court_case_id = NULL;

                    if ($inquiry && $inquiry->form1_id) {
                        $form1_update = Form1::find($inquiry->form1_id)->update([
                            'is_online_purchased' => 0,
                            'purchased_date' => $transaction_date ? Carbon::createFromFormat('d/m/Y', $transaction_date)->toDateTimeString() : NULL,
                            'purchased_item_name' => $purchased_item,
                            'purchased_item_brand' => $purchased_brand,
                            'purchased_amount' => $paid_amount,
                            'claim_details' => $reason,
                            'claim_amount' => $claim_amount,
                            'court_case_id' => $court_case_id,
                            'filing_date' => Carbon::now(),
                            'matured_date' => Carbon::now()->addDays(14),               // Change this later
                            'form_status_id' => 61, // New claim
                            'updated_at' => Carbon::now()
                        ]);
                        $form1_id = $inquiry->form1_id;
                    } else {
                        $form1_id = DB::table('form1')->insertGetId([
                            'is_online_purchased' => 0,
                            'purchased_date' => $transaction_date ? Carbon::createFromFormat('d/m/Y', $transaction_date)->toDateTimeString() : NULL,
                            'purchased_item_name' => $purchased_item,
                            'purchased_item_brand' => $purchased_brand,
                            'purchased_amount' => $paid_amount,
                            'claim_details' => $reason,
                            'claim_amount' => $claim_amount,
                            'court_case_id' => $court_case_id,
                            'filing_date' => Carbon::now(),
                            'matured_date' => Carbon::now()->addDays(14),               // Change this later
                            'form_status_id' => 61, // New claim
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }


                    if ($inquiry) {
                        $inquiry_update = Inquiry::find($inquiry->inquiry_id)->update([
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquired_by_user_id' => $userid,
                            'transaction_address' => $request->transaction_address,
                            'transaction_postcode' => $request->transaction_postcode,
                            'transaction_state' => $request->transaction_state,
                            'transaction_district' => $request->transaction_district,
                            // 'phone_no' => $phone_no,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'form1_id' => $form1_id,
                            'opponent_user_extra_id' => $user_extra_id
                        ]);
                    } else {
                        if (Auth::user()->user_type_id != 3) {
                            $branch = MasterBranch::find(Auth::user()->ttpm_data->branch_id);

                        } else {
                            $branch = MasterBranch::orderBy('inquiry_counter', 'asc')->first();
                        }
                        $branch_id = $branch->branch_id;
                        $branch->update(['inquiry_counter' => ($branch->inquiry_counter + 1)]);

                        $inquiry_id = DB::table('inquiry')->insertGetId([
                            'inquiry_no' => "INQUIRY",  /// Please change this later [method]-[branch]-[id]-[year]
                            'branch_id' => $branch_id,
                            'inquiry_type_id' => 2,
                            'created_by_user_id' => $userid,
                            'inquired_by_user_id' => $userid,
                            'transaction_address' => $request->transaction_address,
                            'transaction_postcode' => $request->transaction_postcode,
                            'transaction_state' => $request->transaction_state,
                            'transaction_district' => $request->transaction_district,
                            // 'phone_no' => $phone_no,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'form1_id' => $form1_id,
                            'opponent_user_extra_id' => $user_extra_id
                        ]);

                        $inquiry = Inquiry::find($inquiry_id);

                        $state = MasterState::find($request->transaction_state);

                        $inquiry->inquiry_no = RunnerRepository::generateAppNumber('INQUIRY', $inquiry->state->code, date('Y'), null, null, 'O');
                        $inquiry->save();
                    }
                }
            }
        }

        ///////////////////////////// ATTACHMENT part //////////////////////////////
        $form_no = 0;

        //$deleteOldAttachments = Attachment::where('form_no', 1)->where('form_id', $form1_id)->delete();

        $oldAttachments = Attachment::where('form_no', $form_no)->where('form_id', $inquiry_id)->get();

        if ($inquiry_id) {
            array_push($log, "Inquiry ID: " . $inquiry_id);

            if ($request->hasFile('attachment_1')) {
                if ($request->file('attachment_1')->isValid()) {
                    array_push($log, "attachment_1: ok");

                    if ($oldAttachments->get(0)) {
                        if ($request->file1_info == 2) {
                            // Replace
                            array_push($log, "attachment_1: replace");
                            $oldAttachments->get(0)->delete();

                            $attachment = new Attachment;
                            $attachment->form_no = $form_no;
                            $attachment->form_id = $inquiry_id;
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
                            array_push($log, "attachment_1: add");
                            $attachment = new Attachment;
                            $attachment->form_no = $form_no;
                            $attachment->form_id = $inquiry_id;
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
                    $audit->add($request, 4, "InquiryController", json_encode($request->input()), null, "Inquiry " . $request->file('attachment_1')->getClientOriginalName() . " - Upload attachement");
                }
            } else {
                if ($oldAttachments->get(0)) {
                    if ($request->file1_info == 2) {
                        array_push($log, "attachment_1: delete");
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
                            $attachment->form_id = $inquiry_id;
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
                            $attachment->form_id = $inquiry_id;
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
                    $audit->add($request, 4, "InquiryController", json_encode($request->input()), null, "Inquiry " . $request->file('attachment_2')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $inquiry_id;
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
                            $attachment->form_id = $inquiry_id;
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
                    $audit->add($request, 4, "InquiryController", json_encode($request->input()), null, "Inquiry " . $request->file('attachment_3')->getClientOriginalName() . " - Upload attachement");

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
                            $attachment->form_id = $inquiry_id;
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
                            $attachment->form_id = $inquiry_id;
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
                    $audit->add($request, 4, "InquiryController", json_encode($request->input()), null, "Inquiry " . $request->file('attachment_4')->getClientOriginalName() . " - Upload attachement");
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
                            $attachment->form_id = $inquiry_id;
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
                            $attachment->form_id = $inquiry_id;
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
                    $audit->add($request, 4, "InquiryController", json_encode($request->input()), null, "Inquiry " . $request->file('attachment_5')->getClientOriginalName() . " - Upload attachement");

                }
            } else {
                if ($oldAttachments->get(4)) {
                    if ($request->file5_info == 2) {
                        $oldAttachments->get(4)->delete();
                    }
                }
            }
        }

        if ($inquiry->inquiry_method_id == 7 && !$inquiry->inquiry_no) { // SMS
            $branch = Auth::user()->ttpm_data->branch;
            $inquiry->inquiry_no = RunnerRepository::generateAppNumber('INQUIRY', $branch->branch_code, date('Y'), null, null, 'S');
            $inquiry->save();
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 4, "InquiryController", json_encode($request->input()), null, "Inquiry " . $inquiry_id . " - Create inquiry");

        return response()->json(['status' => 'ok', 'log' => $log, 'inquiry_no' => $inquiry->inquiry_no]);

    }

    /**
     * Process inquiry
     *
     * @param $inquiry_id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function process($inquiry_id)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $is_process = 1;
        $is_staff = $user->user_type_id != 3 ? true : false;
        $inquiry = Inquiry::find($inquiry_id);
        $inquiry_methods = MasterInquiryMethod::all();
        $inquiry_types = MasterInquiryType::all();
        $countries = MasterCountry::all();
        $states = MasterState::all();
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();
        $inquiry_feedbacks = MasterInquiryFeedback::all();
        $organizations = MasterOrganization::where('is_active', 1)->get();
        $attachments = Attachment::where('form_no', 0)
            ->where('form_id', $inquiry_id)
            ->get();
        $branches = MasterBranch::where('is_active', 1)->get();

        return view("inquiry.create", compact('is_staff', 'inquiry_methods', 'inquiry_types', 'countries',
            'states', 'categories', 'classifications', 'inquiry_feedbacks', 'organizations', 'attachments', 'inquiry',
            'is_process', 'branches'));
    }

    protected function rules_process($request)
    {

        $rules = [];
        $rules['feedback_type'] = 'required';
        $rules['inquiry_feedback_msg'] = 'required';

        if ($request->feedback_type == 2 && $request->is_process == 1) {
            $rules['feedback_cannot_filed_reason'] = 'required|integer';

            if ($request->feedback_cannot_filed_reason == 1)
                $rules['feedback_cannot_filed_agencies'] = 'required|integer';
        }

        return $rules;
    }

    /**
     * Update processed inquiry
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateprocess(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules_process($request));

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        $userid = Auth::id();
        $user = User::find($userid);
        $feedback_type = $request->feedback_type;
        $inquiry_type = $request->inquiry_type;

        $inquiry_id = $request->inquiry_id;
        $inquiry = Inquiry::find($inquiry_id);

        if ($feedback_type == 4) {
            $inquiry_form_status_id = 10;
        } else {
            if (RoleUser::where('user_id', $userid)->where('role_id', 6)->get()->count() > 0) {
                $inquiry_form_status_id = 12;
            } else {
                $inquiry_form_status_id = 11;
            }
        }

        if ($inquiry_type == 1) {
            $inquiry_update = $inquiry->update([
                'inquiry_feedback_id' => $request->feedback_type,
                'inquiry_feedback_msg' => $request->inquiry_feedback_msg,
                'inquiry_form_status_id' => $inquiry_form_status_id,
                'feedback_cannot_filed_reason' => $request->feedback_cannot_filed_reason,
                'jurisdiction_organization_id' => $request->feedback_cannot_filed_agencies,
                'processed_by_user_id' => $userid,
                'processed_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $inquiry_update = $inquiry->update([
                'inquiry_feedback_id' => $request->feedback_type,
                'inquiry_feedback_msg' => $request->inquiry_feedback_msg,
                'inquiry_form_status_id' => $inquiry_form_status_id,
                'feedback_cannot_filed_reason' => $request->feedback_cannot_filed_reason,
                'jurisdiction_organization_id' => $request->feedback_cannot_filed_agencies,
                'processed_by_user_id' => $userid,
                'processed_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($inquiry->form1_id)
                $form1_update = Form1::find($inquiry->form1_id)->update([
                    'claim_classification_id' => $request->claim_classification,
                    'updated_at' => Carbon::now()
                ]);

        }


        if ($feedback_type == 4) {
            // $secretary = RoleUser::where('role_id', 6)->get()->filter(function($query){
            //     return $query->user->user_status_id == 1;
            // });
            $secretary = RoleUser::whereIn('role_id', [6])
                ->whereHas('user', function ($user) {
                    return $user->where('user_status_id', 1);
                })
                ->get();

            foreach ($secretary as $sec) {
                if ($sec->user->user_status_id == 1) // Active
                    Mail::to($sec->user->email)->send(new InquirySecretaryAlertMail($inquiry, App::getLocale() == "en" ? 1 : 2));
            }

        }

        // if($inquiry->inquiry_method_id == 7 && !$inquiry->inquiry_no) { // SMS
        //     $branch = Auth::user()->ttpm_data->branch;
        //     $inquiry->inquiry_no = "S-".$branch->branch_code."-".$branch->state->next_inquiry_no."-".date("Y");
        //     $inquiry->save();
        // }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 5, "InquiryController", null, null, "Edit Inquiry Feedback " . $inquiry->inquiry_no);
        return response()->json(['status' => 'ok', 'inquiry_no' => $inquiry->inquiry_no]);
    }
}
