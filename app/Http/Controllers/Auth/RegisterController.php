<?php

namespace App\Http\Controllers\Auth;

use App\Libraries\MailLibrary;
use App\Libraries\NotificationLibrary;
use App\Libraries\SmsLibrary;
use App\Repositories\LogAuditRepository;
use Carbon\Carbon;
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
use App\MasterModel\MasterDesignation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Http\Controllers\Integration\MySMSController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return redirect()->route('login');
    }

    //King Codex
    public function checkicpassport(Request $request)
    {
        $user = User::join('user_public', 'users.user_id', '=', 'user_public.user_id')
            ->join('user_public_individual', 'users.user_id', '=', 'user_public_individual.user_id')
            ->where([
                ['users.user_status_id', '=', 6],
                ['user_public_individual.identification_no', '=', $request->identification_no]
            ]);
        if ($user->first()) {
            return Response::json(['status' => 'ok', 'data' => $user->first(), 'partial_register' => 1]);
        }
        return Response::json(['status' => 'fail', 'partial_register' => 0]);
    }

    public function checkcompanyno(Request $request)
    {
        $company = User::join('user_public', 'users.user_id', '=', 'user_public.user_id')
            ->join('user_public_company', 'users.user_id', '=', 'user_public_company.user_id')
            ->where([
                ['users.user_status_id', '=', 6],
                ['users.username', '=', $request->company_no]
            ]);

        if ($company->first()) {
            return Response::json(['status' => 'ok', 'data' => $company->first(), 'partial_register' => 1]);
        }

        return Response::json(['status' => 'fail', 'partial_register' => 0]);
    }


    protected function masterModel($route)
    {
        $this->data['route'] = $route;
        $this->data['masterCountry'] = MasterCountry::all();
        $this->data['masterLanguage'] = MasterLanguage::all();
        $this->data['masterNotificationMethod'] = MasterNotificationMethod::where('notification_method_id', '=', 2)->get();
        $this->data['masterState'] = MasterState::all();
        $this->data['masterGender'] = MasterGender::whereIn('gender_id', [1, 2])->get();
        $this->data['masterRace'] = MasterRace::get();
        $this->data['masterOccupation'] = MasterOccupation::where('is_active', 1)->get();

        return $this->data;
    }

    protected function regexPhone()
    {
        return 'regex:/(0)[0-9]{9}/';
    }

    protected function rules($passport_rules = NULL, $email_rules = NULL)
    {
        if ($passport_rules == NULL) {
            $passport_rules = ['required', 'min:12', 'max:12', 'unique:user_public_individual', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];
        }
        if ($email_rules == NULL) {
            $email_rules = ['required', 'string', 'email', 'max:255', 'unique:users'];
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
            'email' => $email_rules,
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
            'password' => 'required|string|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[\d])(?=.*[\W]).*$/|min:8|max:50|confirmed'
        ];

        return $rules;
    }

    /**
     * @deprecated use \App\Libraries\MailLibrary
     * @param $identification_no
     * @param $name
     * @param $email
     * @param $password
     * @param $language
     * @return mixed
     */
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
            $mail->from(config('mail.from.address'), config('mail.from.name'));
            $mail->to($data['email'], $data['name']);
            $mail->subject(env('APP_NAME'));
        });

        return $sendEmail;
    }

    public function showNonCitizenForm(Request $request)
    {
        $this->masterModel('register.noncitizen');
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 9, "RegisterController", null, null, "View non-citizen registration form");
        return view('auth.register_individual-noncitizen', $this->data);
    }

    public function registerNonCitizen(Request $request)
    {
        if ($request->partial_register == 1) {
            $passport_rules = ['required'];
            $email_rules = ['required', 'string', 'email', 'max:255'];
            $validator = Validator::make($request->all(), $this->rules($passport_rules, $email_rules));
        } else {
            $passport_rules = ['required', 'unique:user_public_individual'];
            $validator = Validator::make($request->all(), $this->rules($passport_rules));
        }

        if ($validator->passes()) {
            $user_input = $request->only(
                'name',
                'username',
                'password',
                'language_id',
                'phone_office',
                'phone_fax',
                'email'
            );

            $user_input['username'] = $request->identification_no;
            $user_input['password'] = bcrypt(md5($user_input['password']));
            $user_input['user_type_id'] = 3;
            $user_input['user_status_id'] = 1;
            if ($request->partial_register == 1) {
                User::where('username', $request->identification_no)->update($user_input);
                $user = User::where('username', $request->identification_no)->first();
            } else {
                // check if there is duplicate in username and user is partial
                $user = User::where('username', $request->identification_no)
                    ->where('user_status_id', 6)
                    ->first();

                if ($user) {
                    $user = $user->update($user_input);
                } else {
                    $user = User::create($user_input);
                }
            }

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
            if ($request->partial_register == 1) {
                $user_public = UserPublic::where('user_id', $user->user_id)->update($user_public_input);
            } else {
                $user_public = UserPublic::create($user_public_input);
            }

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
            if ($request->partial_register == 1) {
                $user_public_individual = UserPublicIndividual::where('user_id', $user->user_id)->update($user_public_individual_input);
            } else {
                $user_public_individual = UserPublicIndividual::create($user_public_individual_input);
            }
            $user->attachRole(3);

            if ($user_public_input['notification_method_id'] == 2 || $user_public_input['notification_method_id'] == 3) { // Send Email
                $this->sendEmail($request->identification_no, $request->name, $request->email, $request->password, $request->language_id);
            }

            if ($user_public_input['notification_method_id'] == 1 || $user_public_input['notification_method_id'] == 3) { // Send SMS
                $this->sendSMS($request->phone_mobile, $request->language_id);
            }
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 4, "RegisterController", json_encode($request->input()), null, "Public User " . $request->username . " - Create public user (non-citizen) account");
            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function showTouristForm(Request $request)
    {
        $this->masterModel('register.tourist');
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 9, "RegisterController", null, null, "View tourist registration form");
        return view('auth.register_individual-noncitizen', $this->data);
    }

    public function registerTourist(Request $request)
    {
        if ($request->partial_register == 1) {
            $rules = [
                'nationality_country_id' => 'required_if:citizenship,0|nullable|integer',
                'identification_no' => ['required', 'min:8', 'max:10', 'regex:/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/'],
                'name' => 'required|string|max:255',
                'language_id' => 'nullable|integer',
                'phone_home' => 'nullable|string|regex:/^.{9,15}$/',
                'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
                'phone_office' => 'nullable|string|regex:/^.{9,15}$/',
                'phone_fax' => 'nullable|string|regex:/^.{9,15}$/',
                'email' => 'required|string|email|max:255',
                'notification_method_id' => 'nullable',
                'password' => 'required|string|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[\d])(?=.*[\W]).*$/|min:8|max:50|confirmed'
            ];
            $validator = Validator::make($request->all(), $rules);
        } else {
            $rules = [
                'nationality_country_id' => 'required_if:citizenship,0|nullable|integer',
                'identification_no' => ['required', 'min:8', 'max:10', 'unique:user_public_individual', 'regex:/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/'],
                'name' => 'required|string|max:255',
                'language_id' => 'nullable|integer',
                'phone_home' => 'nullable|string|regex:/^.{9,15}$/',
                'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
                'phone_office' => 'nullable|string|regex:/^.{9,15}$/',
                'phone_fax' => 'nullable|string|regex:/^.{9,15}$/',
                'email' => 'required|string|email|max:255|unique:users',
                'notification_method_id' => 'nullable',
                'password' => 'required|string|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[\d])(?=.*[\W]).*$/|min:8|max:50|confirmed'
            ];
            $validator = Validator::make($request->all(), $rules);
        }

        if ($validator->passes()) {
            $user_input = $request->only(
                'name',
                'username',
                'password',
                'language_id',
                'phone_office',
                'phone_fax',
                'email'
            );

            $user_input['username'] = $request->identification_no;
            $user_input['password'] = bcrypt(md5($user_input['password']));
            $user_input['user_type_id'] = 3;
            $user_input['user_status_id'] = 1;
            if ($request->partial_register == 1) {
                User::where('username', $request->identification_no)->update($user_input);
                $user = User::where('username', $request->identification_no)->first();
            } else {
                // check if there is duplicate in username and user is partial
                $user = User::where('username', $request->identification_no)
                    ->where('user_status_id', 6)
                    ->first();

                if ($user) {
                    $user = $user->update($user_input);
                } else {
                    $user = User::create($user_input);
                }
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
            if ($request->partial_register == 1) {
                $user_public = UserPublic::where('user_id', $user->user_id)->update($user_public_input);
            } else {
                $user_public = UserPublic::create($user_public_input);
            }

            $user_public_individual_input = $request->only(
                'nationality_country_id',
                'identification_no',
                'phone_home',
                'phone_mobile'
            );

            $user_public_individual_input['user_id'] = $user->user_id;
            $user_public_individual_input['is_tourist'] = 1;
            if ($request->partial_register == 1) {
                $user_public_individual = UserPublicIndividual::where('user_id', $user->user_id)->update($user_public_individual_input);
            } else {
                $user_public_individual = UserPublicIndividual::create($user_public_individual_input);
            }
            $user->attachRole(3);

            if ($user_public_input['notification_method_id'] == 2 || $user_public_input['notification_method_id'] == 3) { // Send Email
                $this->sendEmail($request->identification_no, $request->name, $request->email, $request->password, $request->language_id);
            }

            if ($user_public_input['notification_method_id'] == 1 || $user_public_input['notification_method_id'] == 3) { // Send SMS
                $this->sendSMS($request->phone_mobile, $request->language_id);
            }

            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    public function showCompanyForm(Request $request)
    {
        $this->masterModel('register.company');
        $this->data['masterDesignation'] = MasterDesignation::where('is_active', '=', 1)->get();
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 9, "RegisterController", null, null, "View company registration form");
        return view('auth.register_company', $this->data);
    }

    public function registerCompany(Request $request)
    {
        if ($request->partial_register == 1) {
            $comp_rules = ['required', 'string', 'max:50'];
            $email_rules = 'required|string|email|max:255';
        } else {
            $comp_rules = ['required', 'string', 'max:50', 'unique:user_public_company'];
            $email_rules = 'required|string|email|max:255|unique:users';
        }

        if ($request->representative_identification_type == 1) {
            $passport_rules = ['required', 'min:12', 'max:12', 'unique:user_public_company', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];
        } else {
            $passport_rules = ['required', 'min:8', 'max:10', 'unique:user_public_company', 'regex:/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/'];
        }

        $rules = [
            'company_no' => $comp_rules,
            'name' => 'required|string|max:255',
            'language_id' => 'nullable|integer',
            'phone_office' => 'nullable|string|regex:/^.{9,15}$/',
            'phone_fax' => 'nullable|string|regex:/^.{9,15}$/',
            'email' => $email_rules,
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
            'password' => 'required|string|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[\d])(?=.*[\W]).*$/|min:6|max:50|confirmed'
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
                'email'
            );

            $user_input['username'] = $request->company_no;
            $user_input['password'] = bcrypt(md5($user_input['password']));
            $user_input['user_type_id'] = 3;
            $user_input['user_status_id'] = 1;
            if ($request->partial_register == 1) {
                User::where('username', $request->company_no)->update($user_input);
                $user = User::where('username', $request->company_no)->first();
            } else {
                // check if there is duplicate in username and user is partial
                $user = User::where('username', $request->company_no)
                    ->where('user_status_id', 6)
                    ->first();

                if ($user) {
                    $user = $user->update($user_input);
                } else {
                    $user = User::create($user_input);
                }
            }

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
            if ($request->partial_register == 1) {
                $user_public = UserPublic::where('user_id', $user->user_id)->update($user_public_input);
            } else {
                $user_public = UserPublic::create($user_public_input);
            }

            $user_public_company_input = $request->only(
                'company_no',
                'representative_name',
                'representative_nationality_country_id',
                'representative_identification_no',
                'representative_designation_id',
                'representative_phone_home',
                'representative_phone_mobile'
            );

            $user_public_company_input['user_id'] = $user->user_id;
            if ($request->partial_register == 1) {
                $user_public_company = UserPublicCompany::where('user_id', $user->user_id)->update($user_public_company_input);
            } else {
                $user_public_company = UserPublicCompany::create($user_public_company_input);
            }
            $user->attachRole(3);

            if ($user_public_input['notification_method_id'] == 2 || $user_public_input['notification_method_id'] == 3) { // Send Email
                $this->sendEmail($request->company_no, $request->name, $request->email, $request->password, $request->language_id);
            }

            if ($user_public_input['notification_method_id'] == 1 || $user_public_input['notification_method_id'] == 3) { // Send SMS
                $this->sendSMS($request->representative_phone_mobile, $request->language_id);
            }
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 4, "RegisterController", json_encode($request->input()), null, "Public User " . $request->company_no . " - Create public user (non-citizen) account");
            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    /**
     * @deprecated use \App\Libraries\SmsLibrary
     * @param $receiver
     * @param $language
     */
    private function sendSMS($receiver, $language)
    {
        $sms = new MySMSController;
        if ($language == 1) // English
            $sms->sendSMS($receiver, 'Congratulation! You have successfully been registred with e-Tribunal V2 system. Please go to https://etribunalv2.kpdnkk.gov.my to login.');
        else
            $sms->sendSMS($receiver, 'Tahniah! Anda telah berjaya mendaftar dengan sistem e-Tribunal V2. Sila ke https://etribunalv2.kpdnkk.gov.my untuk log masuk.');
    }
}
