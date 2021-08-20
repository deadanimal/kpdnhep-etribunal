<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Integration\MySMSController;
use App\Repositories\LogAuditRepository;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterLanguage;
use App\MasterModel\MasterNotificationMethod;
use App\MasterModel\MasterState;
use App\MasterModel\MasterGender;
use App\MasterModel\MasterRace;
use App\MasterModel\MasterOccupation;
use App\MasterModel\MasterUserStatus;
use App\MasterModel\MasterDesignation;
use App\SupportModel\UserClaimCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Mail;
use App;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function masterModel($route)
    {
        $this->data['route'] = $route;
        $this->data['masterCountry'] = MasterCountry::all();
        $this->data['masterLanguage'] = MasterLanguage::all();
        $this->data['masterNotificationMethod'] = MasterNotificationMethod::where('notification_method_id', '=', 2)->get();
        $this->data['masterState'] = MasterState::all();
        $this->data['masterGender'] = MasterGender::whereIn('gender_id', [1, 2])->get();
        $this->data['masterRace'] = MasterRace::all();
        $this->data['masterOccupation'] = MasterOccupation::where('is_active', 1)->get();
        $this->data['masterUserStatus'] = MasterUserStatus::where('user_status_id', '!=', 6)->get();

        return $this->data;
    }

    protected function userModel($update, $id = NULL, $type = NULL)
    {
        if ($update == TRUE) {
            $this->data['user'] = $user = User::find($id);
            $this->data['userPublic'] = UserPublic::where('user_id', $user->user_id)->first();
            $this->data['userPublicIndividual'] = UserPublicIndividual::where('user_id', $user->user_id)->first();
            $this->data['userPublicCompany'] = UserPublicCompany::where('user_id', $user->user_id)->first();
            $this->data['type'] = $type;
        } else {
            $this->data['user'] = NULL;
            $this->data['userPublic'] = NULL;
            $this->data['userPublicCompany'] = NULL;
            $this->data['userPublicIndividual'] = NULL;
            $this->data['type'] = NULL;
        }

        return $this->data;
    }

    protected function regexPhone()
    {
        return 'regex:/(0)[0-9]{9}/';
    }

    protected function rules($passport_rules = NULL, $update = FALSE, $id = NULL)
    {
        if ($update == TRUE) {
            $passport_unique = 'unique:user_public_individual,identification_no,' . $id . ',user_id';
            $email_unique = 'unique:users,email,' . $id . ',user_id';
            $password_rules = 'nullable';
        } else {
            $passport_unique = 'unique:user_public_individual';
            $email_unique = 'unique:users';
            $password_rules = 'required|string|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[0-9])(?=.*[\d\X])(?=.*[@!$#%]).*$/|min:6|max:50|confirmed';
        }

        if ($passport_rules == NULL) {
            $passport_rules = ['required', 'min:12', 'max:12', '' . $passport_unique . '', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];
        }

        $rules = [
            'nationality_country_id' => 'required_if:citizenship,0|nullable|integer',
            'identification_no' => $passport_rules,
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|integer',
            'phone_home' => 'nullable|string|regex:/^.{9,15}$/',
            'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            'phone_office' => 'nullable|string|regex:/^.{9,15}$/',
            'phone_fax' => 'nullable|string|regex:/^.{9,15}$/',
            'email' => 'required|string|email|max:255|' . $email_unique,
            'notification_method_id' => 'nullable',
            'address_street_1' => 'required|string|max:150',
            'address_street_2' => 'nullable|string|max:150',
            'address_street_3' => 'nullable|string|max:150',
            'address_postcode' => 'required|string|max:5|min:5',
            'address_state_id' => 'required|integer',
            'address_district_id' => 'required|integer',
            'address_mailing_street_1' => 'required_with:copy_address|nullable|string|max:150',
            'address_mailing_street_2' => 'nullable|string|max:150',
            'address_mailing_street_3' => 'nullable|string|max:150',
            'address_mailing_postcode' => 'required_with:copy_address|nullable|string|max:5',
            'address_mailing_state_id' => 'required_with:copy_address|nullable|integer',
            'address_mailing_district_id' => 'required_with:copy_address|nullable|integer',
            'gender_id' => 'required|integer',
            'date_of_birth' => 'required',
            'race_id' => 'required|integer',
            'occupation_id' => 'required|integer',
            'user_status_id' => 'required|integer',
            'password' => $password_rules
        ];

        return $rules;
    }

    private function sendSMS($receiver, $language)
    {
        $sms = new MySMSController;
        if ($language == 1) // English
            $sms->sendSMS($receiver, 'Congratulation! You have successfully been registred with e-Tribunal V2 system. Please go to https://etribunalv2.kpdnkk.gov.my to login.');
        else
            $sms->sendSMS($receiver, 'Tahniah! Anda telah berjaya mendaftar dengan sistem e-Tribunal V2. Sila ke https://etribunalv2.kpdnkk.gov.my untuk log masuk.');
    }

    protected function sendEmail($identification_no, $name, $email, $password, $language)
    {
        $data = [
            'identification_no' => $identification_no,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'language' => $language,
        ];

        $sendEmail = Mail::send('email.email', $data, function ($mail) use ($data) {
            $mail->from(env('MAIL_USERNAME'));
            $mail->to($data['email'], $data['name']);
            $mail->subject(env('APP_NAME'));
        });

        return $sendEmail;
    }

    public function index(Request $request)
    {
        $status = MasterUserStatus::get();

        if ($request->ajax()) {
            $user = User::join('user_public', 'users.user_id', '=', 'user_public.user_id')
                ->select([
                    'users.user_id',
                    'users.name',
                    'users.username',
                    'users.created_at',
                    'user_public.user_public_type_id',
                    'users.user_status_id',
                ])
                ->whereIn('user_status_id', [1, 2, 5, 6])->where('user_type_id', 3)->orderBy('name', 'user_status_id');

            // $user = User::with(['public_data.user_public_type','user_status'])->where('user_type_id', 3)->get();


            if ($request->has('status') && !empty($request->status))
                $user->where('user_status_id', $request->status);

            $datatables = Datatables::of($user);

            return $datatables
                ->editColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('d/m/Y');
                })
                ->editColumn('user_public_type_id', function ($user) {
                    if ($user->public_data->user_public_type_id == 2) {
                        return __('new.company');
                    } else if ($user->public_data->individual->nationality_country_id == 129) {
                        return __('new.individual') . ' (' . __('new.citizen') . ')';
                    } else {
                        return __('new.individual') . ' (' . __('new.non_citizen') . ')';
                    }

                })
                ->editColumn('user_status', function ($user) {
                    $locale = App::getLocale();
                    $status_lang = "status_" . $locale;
                    return $user->user_status->$status_lang;
                })
                ->editColumn('action', function ($user) {
                    $button = '';

                    if ($user->user_status_id != 2) {

                        if ($user->public_data->user_public_type_id == 2) {
                            $type = 'company';
                        } else if ($user->public_data->individual->nationality_country_id == 129) {
                            $type = 'citizen';
                        } else {
                            $type = 'noncitizen';
                        }

                        if ($user->user_status_id != 6) {
                            $button .= '<a class="btn btn-xs red" rel="tooltip" 
                                        data-original-title="' . __('button.impersonate') . '" 
                                        href="' . route('admin.users.impersonate', $user->user_id) . '">
                                        <i class="fa fa-play"></i>
                                        </a>';
                            $button .= actionButton('blue btnModalUser', __('button.view'), route('public.view', ['id' => $user->user_id]), false, 'fa-search', false);
                        }

                        if ($user->user_status_id != 6) {
                            $button .= actionButton('green-meadow', __('button.edit'), route('public.edit', ['id' => $user->user_id, 'type' => $type]), false, 'fa-edit', false);

                            $button .= '<a class="btn btn-xs purple" rel="tooltip" data-original-title="' . __('button.change_pass') . '" onclick="changePasswordUser(' . $user->user_id . ')"><i class="fa fa-key"></i></a>';
                        }

                        $button .= actionButton('dark ajaxDeleteButton', __('button.deactivate'), route('public.delete', ['id' => $user->user_id]), false, 'fa-times', false);

                    } else {
                        $button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="' . __('button.activate') . '" onclick="activateUser(' . $user->user_id . ')"><i class="fa fa-check"></i></a>';
                    }

                    return $button;

                })
                ->make(true);
        }
        $audit = new AuditController;
        $audit->add($request, 12, "UserController", null, null, "Datatables load public users");
        return view('admin.user.public.list', compact('status'));
    }

    public function view(Request $request, $id)
    {
        $user = User::where([['user_id', $id], ['user_type_id', 3]])->first();
        $audit = new AuditController;
        $audit->add($request, 3, "UserController", null, null, "view Public user " . $user->username);
        return view('admin.user.public.view_modal', compact('user'), ['id' => $id])->render();
    }

    public function createCitizen()
    {
        $this->masterModel('public.store.citizen');
        $this->userModel(FALSE);
        return view('admin.user.public.create', $this->data);
    }

    public function storeCitizen(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if ($validator->passes()) {
            $user_input = $request->only(
                'name',
                'username',
                'password',
                'language_id',
                'phone_office',
                'phone_fax',
                'email',
                'user_status_id'
            );

            $user_input['username'] = $request->identification_no;
            $user_input['password'] = bcrypt(md5($user_input['password']));
            $user_input['user_type_id'] = 3;
            $user_input['user_status_id'] = 1;
            $user = User::create($user_input);

            $user_public_input = $request->only(
                'address_street_1',
                'address_street_2',
                'address_street_3',
                'address_postcode',
                'address_district_id',
                'address_state_id',
                'address_mailing_street_1',
                'address_mailing_street_2',
                'address_mailing_street_3',
                'address_mailing_postcode',
                'address_mailing_district_id',
                'address_mailing_state_id'
            );

            if ($request->copy_address == 0) {
                $user_public_input['address_mailing_street_1'] = $request->address_street_1;
                $user_public_input['address_mailing_street_2'] = $request->address_street_2;
                $user_public_input['address_mailing_street_3'] = $request->address_street_3;
                $user_public_input['address_mailing_postcode'] = $request->address_postcode;
                $user_public_input['address_mailing_district_id'] = $request->address_district_id;
                $user_public_input['address_mailing_state_id'] = $request->address_state_id;
            }

            // Notification modules
            $notification_method = $request->notification_method_id;
            $user_public_input['notification_method_id'] = 2;

//            if (count($notification_method) == 2) {
//                $user_public_input['notification_method_id'] = 3; // 3:Both
//            } else if (count($notification_method) == 1) {
//                $user_public_input['notification_method_id'] = $request->notification_method_id[0];
//            }
            // NULL or 4:None

            $user_public_input['user_id'] = $user->user_id;
            $user_public_input['user_public_type_id'] = 1;
            $user_public = UserPublic::create($user_public_input);

            $user_public_individual_input = $request->only(
                'nationality_country_id',
                'identification_no',
                'gender_id',
                'date_of_birth',
                'race_id',
                'occupation_id',
                'phone_home',
                'phone_mobile'
            );

            $user_public_individual_input['user_id'] = $user->user_id;
            $user_public_individual_input['nationality_country_id'] = 129; // Malaysia
            $user_public_individual_input['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateString();
            $user_public_individual = UserPublicIndividual::create($user_public_individual_input);
            $user->attachRole(3);

            if ($user_public_input['notification_method_id'] == 2 || $user_public_input['notification_method_id'] == 3) { // Send Email
                $this->sendEmail($request->identification_no, $request->name, $request->email, $request->password, $request->language_id);
            }

            if ($user_public_input['notification_method_id'] == 1 || $user_public_input['notification_method_id'] == 3) { // Send SMS
                $this->sendSMS($request->phone_mobile, $request->language_id);
            }
            $audit = new AuditController;
            $audit->add($request, 4, "UserController", json_encode($request->input()), null, "Public User " . $request->username . " - Create public user account (citizen)");
            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function createNonCitizen()
    {
        $this->masterModel('public.store.noncitizen');
        $this->userModel(FALSE);
        return view('admin.user.public.create', $this->data);
    }

    public function storeNonCitizen(Request $request)
    {
        $passport_rules = ['required', 'unique:user_public_individual'];
        $validator = Validator::make($request->all(), $this->rules($passport_rules));

        if ($validator->passes()) {
            $user_input = $request->only(
                'name',
                'username',
                'password',
                'language_id',
                'phone_office',
                'phone_fax',
                'email',
                'user_status_id'
            );

            $user_input['username'] = $request->identification_no;
            $user_input['password'] = bcrypt(md5($user_input['password']));
            $user_input['user_type_id'] = 3;
            $user_input['user_status_id'] = 1;
            $user = User::create($user_input);

            $user_public_input = $request->only(
                'address_street_1',
                'address_street_2',
                'address_street_3',
                'address_postcode',
                'address_district_id',
                'address_state_id',
                'address_mailing_street_1',
                'address_mailing_street_2',
                'address_mailing_street_3',
                'address_mailing_postcode',
                'address_mailing_district_id',
                'address_mailing_state_id'
            );

            if ($request->copy_address == 0) {
                $user_public_input['address_mailing_street_1'] = $request->address_street_1;
                $user_public_input['address_mailing_street_2'] = $request->address_street_2;
                $user_public_input['address_mailing_street_3'] = $request->address_street_3;
                $user_public_input['address_mailing_postcode'] = $request->address_postcode;
                $user_public_input['address_mailing_district_id'] = $request->address_district_id;
                $user_public_input['address_mailing_state_id'] = $request->address_state_id;
            }

            // Notification modules
            $notification_method = $request->notification_method_id;
            $user_public_input['notification_method_id'] = 4;

            if (count($notification_method) == 2) {
                $user_public_input['notification_method_id'] = 3; // 3:Both
            } else if (count($notification_method) == 1) {
                $user_public_input['notification_method_id'] = $request->notification_method_id[0];
            }
            // NULL or 4:None

            $user_public_input['user_id'] = $user->user_id;
            $user_public_input['user_public_type_id'] = 1;
            $user_public = UserPublic::create($user_public_input);

            $user_public_individual_input = $request->only(
                'nationality_country_id',
                'identification_no',
                'gender_id',
                'date_of_birth',
                'race_id',
                'occupation_id',
                'phone_home',
                'phone_mobile'
            );

            $user_public_individual_input['user_id'] = $user->user_id;
            $user_public_individual_input['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateString();
            $user_public_individual = UserPublicIndividual::create($user_public_individual_input);
            $user->attachRole(3);

            if ($user_public_input['notification_method_id'] == 2 || $user_public_input['notification_method_id'] == 3) { // Send Email
                $this->sendEmail($request->identification_no, $request->name, $request->email, $request->password, $request->language_id);
            }

            if ($user_public_input['notification_method_id'] == 1 || $user_public_input['notification_method_id'] == 3) { // Send SMS
                $this->sendSMS($request->phone_mobile, $request->language_id);
            }
            $audit = new AuditController;
            $audit->add($request, 4, "UserController", json_encode($request->input()), null, "Public User " . $request->username . " - Create public user account (non-citizen)");
            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function createCompany()
    {
        $this->masterModel('public.store.company');
        $this->data['masterDesignation'] = MasterDesignation::all();
        $this->userModel(FALSE);
        return view('admin.user.public.create', $this->data);
    }

    public function storeCompany(Request $request)
    {
        // $request->representative_identification_type = (int)$request->representative_identification_type;
        if ($request->representative_identification_type == 1) {
            $passport_rules = ['required', 'min:12', 'max:12', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];
        } else {
            $passport_rules = ['required'];
        }

        $rules = [
            'company_no' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|integer',
            'phone_office' => 'nullable|string|regex:/^.{9,15}$/',
            'phone_fax' => 'nullable|string|regex:/^.{9,15}$/',
            'email' => 'required|string|email|max:255|unique:users',
            'notification_method_id' => 'nullable',
            'address_street_1' => 'required|string|max:150',
            'address_street_2' => 'nullable|string|max:150',
            'address_street_3' => 'nullable|string|max:150',
            'address_postcode' => 'required|string|max:5|min:5',
            'address_state_id' => 'required|integer',
            'address_district_id' => 'required|integer',
            'address_mailing_street_1' => 'required_with:copy_address|nullable|string|max:150',
            'address_mailing_street_2' => 'nullable|string|max:150',
            'address_mailing_street_3' => 'nullable|string|max:150',
            'address_mailing_postcode' => 'required_with:copy_address|nullable|string|max:5|min:5',
            'address_mailing_state_id' => 'required_with:copy_address|nullable|integer',
            'address_mailing_district_id' => 'required_with:copy_address|nullable|integer',
            'representative_name' => 'required|string|max:50',
            'representative_nationality_country_id' => 'required_if:representative_identification_type,2|nullable|integer',
            'representative_identification_type' => 'required|integer',
            'representative_identification_no' => $passport_rules,
            'representative_designation_id' => 'required|integer',
            'representative_phone_home' => 'nullable|string|regex:/^.{9,15}$/',
            'representative_phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            'password' => 'required|string|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[0-9])(?=.*[\d\X])(?=.*[@!$#%]).*$/|min:6|max:50|confirmed'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $user_input = $request->only(
                'name',
                'username',
                'password',
                'language_id',
                'phone_office',
                'phone_fax',
                'email',
                'user_status_id'
            );

            $user_input['username'] = $request->company_no;
            $user_input['password'] = bcrypt(md5($user_input['password']));
            $user_input['user_type_id'] = 3;
            $user_input['user_status_id'] = 1;
            $user = User::create($user_input);

            $user_public_input = $request->only(
                'address_street_1',
                'address_street_2',
                'address_street_3',
                'address_postcode',
                'address_district_id',
                'address_state_id',
                'address_mailing_street_1',
                'address_mailing_street_2',
                'address_mailing_street_3',
                'address_mailing_postcode',
                'address_mailing_district_id',
                'address_mailing_state_id'
            );

            if ($request->copy_address == 0) {
                $user_public_input['address_mailing_street_1'] = $request->address_street_1;
                $user_public_input['address_mailing_street_2'] = $request->address_street_2;
                $user_public_input['address_mailing_street_3'] = $request->address_street_3;
                $user_public_input['address_mailing_postcode'] = $request->address_postcode;
                $user_public_input['address_mailing_district_id'] = $request->address_district_id;
                $user_public_input['address_mailing_state_id'] = $request->address_state_id;
            }

            // Notification modules
            $notification_method = $request->notification_method_id;
            $user_public_input['notification_method_id'] = 4;

            if (count($notification_method) == 2) {
                $user_public_input['notification_method_id'] = 3; // 3:Both
            } else if (count($notification_method) == 1) {
                $user_public_input['notification_method_id'] = $request->notification_method_id[0];
            }
            // NULL or 4:None

            $user_public_input['user_id'] = $user->user_id;
            $user_public_input['user_public_type_id'] = 2;
            $user_public = UserPublic::create($user_public_input);

            $user_public_company_input = $request->only(
                'company_no',
                'representative_name',
                'representative_nationality_country_id',
                'representative_identification_no',
                'representative_designation_id',
                'representative_phone_home',
                'representative_phone_mobile'
            );

            if ($request->representative_identification_type == 1) {
                $user_public_company_input['representative_nationality_country_id'] = 129; // Malaysia
            }

            $user_public_company_input['user_id'] = $user->user_id;
            $user_public_company = UserPublicCompany::create($user_public_company_input);
            $user->attachRole(3);

            if ($user_public_input['notification_method_id'] == 2 || $user_public_input['notification_method_id'] == 3) { // Send Email
                $this->sendEmail($request->identification_no, $request->name, $request->email, $request->password, $request->language_id);
            }

            if ($user_public_input['notification_method_id'] == 1 || $user_public_input['notification_method_id'] == 3) { // Send SMS
                $this->sendSMS($request->representative_phone_mobile, $request->language_id);
            }
            $audit = new AuditController;
            $audit->add($request, 4, "UserController", json_encode($request->input()), null, "Public User " . $request->username . " - Create public user account (company)");
            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function edit(Request $request, $id, $type)
    {
        $this->masterModel(['public.update', $id, $type]);
        $this->data['masterDesignation'] = MasterDesignation::all();
        $this->userModel(TRUE, $id, $type);
        return view('admin.user.public.create', $this->data);
    }

    public function update(Request $request, $id, $type)
    {
        if ($type == 'citizen') {
            $validator = Validator::make($request->all(), $this->rules(NULL, TRUE, $id));

            if ($validator->passes()) {
                $user_input = $request->only(
                    'name',
                    'password',
                    'language_id',
                    'phone_office',
                    'phone_fax',
                    'email',
                    'user_status_id'
                );

                $user_input['username'] = $request->identification_no;

                $user = User::find($id)->update($user_input);

                $user_public_input = $request->only(
                    'address_street_1',
                    'address_street_2',
                    'address_street_3',
                    'address_postcode',
                    'address_district_id',
                    'address_state_id',
                    'address_mailing_street_1',
                    'address_mailing_street_2',
                    'address_mailing_street_3',
                    'address_mailing_postcode',
                    'address_mailing_district_id',
                    'address_mailing_state_id'
                );

                if ($request->copy_address == 0) {
                    $user_public_input['address_mailing_street_1'] = $request->address_street_1;
                    $user_public_input['address_mailing_street_2'] = $request->address_street_2;
                    $user_public_input['address_mailing_street_3'] = $request->address_street_3;
                    $user_public_input['address_mailing_postcode'] = $request->address_postcode;
                    $user_public_input['address_mailing_district_id'] = $request->address_district_id;
                    $user_public_input['address_mailing_state_id'] = $request->address_state_id;
                }

                // Notification modules
                $user_public_input['notification_method_id'] = 3; // 3:Both

                UserPublic::where('user_id', $id)->update($user_public_input);

                $user_public_individual_input = $request->only(
                    'identification_no',
                    'gender_id',
                    'date_of_birth',
                    'race_id',
                    'occupation_id',
                    'phone_home',
                    'phone_mobile'
                );

                $user_public_individual_input['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateString();
                UserPublicIndividual::where('user_id', $id)->update($user_public_individual_input);

                LogAuditRepository::store($request, 5, "UserController", null, null, "Public User " . $request->identification_no . " - Update public user account (citizen)");

                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        } elseif ($type == 'noncitizen') {
            $passport_rules = ['required', 'unique:user_public_individual,identification_no,' . $id . ',user_id',];
            $validator = Validator::make($request->all(), $this->rules($passport_rules, TRUE, $id));

            if ($validator->passes()) {
                $user_input = $request->only(
                    'name',
                    'password',
                    'language_id',
                    'phone_office',
                    'phone_fax',
                    'email',
                    'user_status_id'
                );

                $user_input['username'] = $request->identification_no;

                $user = User::find($id)->update($user_input);

                $user_public_input = $request->only(
                    'address_street_1',
                    'address_street_2',
                    'address_street_3',
                    'address_postcode',
                    'address_district_id',
                    'address_state_id',
                    'address_mailing_street_1',
                    'address_mailing_street_2',
                    'address_mailing_street_3',
                    'address_mailing_postcode',
                    'address_mailing_district_id',
                    'address_mailing_state_id'
                );

                // Notification modules
                $notification_method = $request->notification_method_id;
                $user_public_input['notification_method_id'] = 4;

                if (count($notification_method) == 2) {
                    $user_public_input['notification_method_id'] = 3; // 3:Both
                } else if (count($notification_method) == 1) {
                    $user_public_input['notification_method_id'] = $request->notification_method_id[0];
                }
                // NULL or 4:None

                $user_public = UserPublic::where('user_id', $id)->update($user_public_input);

                $user_public_individual_input = $request->only(
                    'nationality_country_id',
                    'identification_no',
                    'gender_id',
                    'date_of_birth',
                    'race_id',
                    'occupation_id',
                    'phone_home',
                    'phone_mobile'
                );

                $user_public_individual_input['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateString();
                $user_public_individual = UserPublicIndividual::where('user_id', $id)->update($user_public_individual_input);
                $audit = new AuditController;
                $audit->add($request, 5, "UserController", null, null, "Public User " . $request->identification_no . " - Update public user account (non-citizen)");
                return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        } elseif ($type == 'company') {
            if ($request->representative_identification_type == 1) {
                $passport_rules = ['required', 'min:12', 'max:12', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];
            } else {
                $passport_rules = ['required'];
            }

            $rules = [
                'company_no' => 'required|string|max:50',
                'name' => 'required|string|max:255',
                'language_id' => 'nullable|integer',
                'phone_office' => 'nullable|string|regex:/^.{9,15}$/',
                'phone_fax' => 'nullable|string|regex:/^.{9,15}$/',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',user_id',
                'notification_method_id' => 'nullable',
                'address_street_1' => 'required|string|max:150',
                'address_street_2' => 'nullable|string|max:150',
                'address_street_3' => 'nullable|string|max:150',
                'address_postcode' => 'required|string|max:5|min:5',
                'address_state_id' => 'required|integer',
                'user_status_id' => 'required|integer',
                'address_district_id' => 'required|integer',
                'address_mailing_street_1' => 'required_with:copy_address|nullable|string|max:150',
                'address_mailing_street_2' => 'nullable|string|max:150',
                'address_mailing_street_3' => 'nullable|string|max:150',
                'address_mailing_postcode' => 'required_with:copy_address|nullable|string|max:5',
                'address_mailing_state_id' => 'required_with:copy_address|nullable|integer',
                'address_mailing_district_id' => 'required_with:copy_address|nullable|integer',
                'representative_name' => 'required|string|max:50',
                'representative_nationality_country_id' => 'required_if:representative_identification_type,2|nullable|integer',
                'representative_identification_type' => 'required|integer',
                'representative_identification_no' => $passport_rules,
                'representative_designation_id' => 'required|integer',
                'representative_phone_home' => 'nullable|string|regex:/^.{9,15}$/',
                'representative_phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->passes()) {
                $user_input = $request->only(
                    'name',
                    'username',
                    'language_id',
                    'phone_office',
                    'phone_fax',
                    'email',
                    'user_status_id'
                );

                $user_input['username'] = $request->company_no;
                $user = User::find($id)->update($user_input);

                $user_public_input = $request->only(
                    'address_street_1',
                    'address_street_2',
                    'address_street_3',
                    'address_postcode',
                    'address_district_id',
                    'address_state_id',
                    'address_mailing_street_1',
                    'address_mailing_street_2',
                    'address_mailing_street_3',
                    'address_mailing_postcode',
                    'address_mailing_district_id',
                    'address_mailing_state_id'
                );

                if ($request->copy_address == 0) {
                    $user_public_input['address_mailing_street_1'] = $request->address_street_1;
                    $user_public_input['address_mailing_street_2'] = $request->address_street_2;
                    $user_public_input['address_mailing_street_3'] = $request->address_street_3;
                    $user_public_input['address_mailing_postcode'] = $request->address_postcode;
                    $user_public_input['address_mailing_district_id'] = $request->address_district_id;
                    $user_public_input['address_mailing_state_id'] = $request->address_state_id;
                }

                // Notification modules
//                $notification_method = $request->notification_method_id;
                $user_public_input['notification_method_id'] = 4;

//                if (count($notification_method) == 2) {
//                    $user_public_input['notification_method_id'] = 3; // 3:Both
//                } else if (count($notification_method) == 1) {
//                    $user_public_input['notification_method_id'] = $request->notification_method_id[0];
//                }
                // NULL or 4:None

                $user_public = UserPublic::where('user_id', $id)->update($user_public_input);

                $user_public_company_input = $request->only(
                    'company_no',
                    'representative_name',
                    'representative_nationality_country_id',
                    'representative_identification_no',
                    'representative_designation_id',
                    'representative_phone_home',
                    'representative_phone_mobile'
                );

                if ($request->representative_identification_type == 1) {
                    $user_public_company_input['representative_nationality_country_id'] = 129; // Malaysia
                }

                $user_public_company = UserPublicCompany::where('user_id', $id)->update($user_public_company_input);
                $audit = new AuditController;
                $audit->add($request, 5, "UserController", null, null, "Public User " . $request->company_no . " - Update public user account (company)");
                return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax()) {
            User::find($id)->update(['user_status_id' => 2]);
            $audit = new AuditController;
            $audit->add($request, 6, "UserController", null, null, "Status Public user to inactive " . $id);
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function activate(Request $request, $id)
    {
        if ($request->ajax()) {
            User::find($id)->update(['user_status_id' => 1]);
            $audit = new AuditController;
            $audit->add($request, 5, "UserController", null, null, "Status Public user to active " . $id);
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function viewChangePassword(Request $request, $id)
    {
        $user = User::find($id);
        $audit = new AuditController;
        $audit->add($request, 3, "UserController", null, null, "View Public user " . $user->username);
        return view('admin.user.public.passwords.change', compact('user'));
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        $rules = ['password' => 'required|string|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[0-9])(?=.*[\d\X])(?=.*[@!$#%]).*$/|min:6|max:50|confirmed'];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $input = $request->only('password');

            if (!empty($input['password'])) {
                $input['password'] = bcrypt(md5($input['password']));
            } else {
                $input = array_except($input, ['password']);
            }

            $user->update($input);
            $audit = new AuditController;
            $audit->add($request, 5, "UserController", null, null, "Change password user " . $user->username);
            return Response::json(['status' => 'ok', 'message' => __('new.password_change_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    /**
     * To fix company user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function fixCompany(Request $request)
    {
        $user = User::where('username', $request->company_no);

        if ($user->count() == 0) {
            return response()->json(['status' => 'error', 'title' => __('new.error'), 'message' => __('new.company_not_found')]);
        }

        $user = $user->first();

        $user_public_individual = UserPublicIndividual::where('user_id', $user->user_id);

        if ($user_public_individual->count() == 0) {
            return response()->json(['status' => 'error', 'title' => __('new.error'), 'message' => __('new.company_not_found')]);
        }

        $user_public_individual = $user_public_individual->first();

        $user_public_company = new UserPublicCompany;
        $user_public_company->user_id = $user->user_id;
        $user_public_company->company_no = $user->username;
        $user_public_company->representative_phone_mobile = $user_public_individual->phone_mobile;
        $user_public_company->created_at = $user_public_individual->created_at;
        $user_public_company->updated_at = $user_public_individual->updated_at;
        $user_public_company->save();

        $user_public = UserPublic::where('user_id', $user->user_id);
        if ($user_public_individual->count() == 0) {
            return response()->json(['status' => 'error', 'title' => __('new.error'), 'message' => __('new.company_not_found')]);
        }
        $user_public = $user_public->first();
        $user_public->user_public_type_id = 2;
        $user_public->save();

        $user_public_individual->delete();

        $user_claimcase = UserClaimCase::where('user_id', $user->user_id)
            ->update(['is_company' => 1]);

        return response()->json(['status' => 'success', 'title' => __('new.successful'), 'message' => __('new.update_success')]);
    }
}