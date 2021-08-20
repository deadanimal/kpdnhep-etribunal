<?php

namespace App\Http\Controllers\Auth;

use App\Libraries\NotificationLibrary;
use App\Repositories\LogAuditRepository;
use Carbon\Carbon;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterCitizenController
 * @package App\Http\Controllers\Auth
 */
class RegisterNonCitizenController extends RegisterController
{
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
        parent::__construct();
    }

    public function create(Request $request)
    {
        $this->masterModel('register.citizen');
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 9, "RegisterController", null, null, "View citizen registration form");
        return view('auth.register_individual-noncitizen', $this->data);
    }

    /**
     * Register Citizen
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if ($request->partial_register == 1) {
            $passport_rules = ['required', 'min:12', 'max:12', 'regex:/^.*([0-9][0-9])((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))([0-9][0-9])([0-9][0-9][0-9][0-9]).*$/'];
            $email_rules = ['required', 'string', 'email', 'max:255'];
            $validator = Validator::make($request->all(), $this->rules($passport_rules, $email_rules));
        } else {
            $validator = Validator::make($request->all(), $this->rules());
        }

        if ($validator->passes()) {

            $user = self::createUser($request);
            $user->attachRole(3);

            $user_public_notification_method_id = self::createUserPublic($request, $user);

            self::createUserPublicIndividual($request, $user);

            // Send notification to user
            NotificationLibrary::send($user_public_notification_method_id, $request, 'email.email');

            LogAuditRepository::store($request, 4, "RegisterController", json_encode($request->input()), null, "Public User " . $request->username . " - Create public user (citizen) account");

            return Response::json(['status' => 'ok', 'message' => __('new.register_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    /**
     * Create user data
     * @param $request
     * @return \App\User|bool|\Illuminate\Database\Eloquent\Model|null
     */
    public function createUser($request)
    {
        $user_input = $request->only([
            'name',
            'username',
            'password',
            'language_id',
            'phone_office',
            'phone_fax',
            'email',
        ]);

        $user_input['username'] = $request->identification_no;
        $user_input['password'] = bcrypt(md5($user_input['password']));
        $user_input['user_type_id'] = 3;
        $user_input['user_status_id'] = 1;

        // cannot use updateOrCreate() because username is not unique
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

        return $user;
    }

    /**
     * Create user public data
     * @param $request
     * @param $user
     * @return int
     */
    public function createUserPublic($request, $user)
    {
        $user_public_input = $request->only([
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
            'address_mailing_state_id',
        ]);

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

        $user_public_input['user_id'] = $user->user_id;
        $user_public_input['user_public_type_id'] = 1;

        UserPublic::updateOrCreate(['user_id' => $user->user_id], $user_public_input);

        return $user_public_input['notification_method_id'];
    }

    /**
     * Create user public individual data
     * @param $request
     * @param $user
     */
    public function createUserPublicIndividual($request, $user)
    {
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

        UserPublicIndividual::updateOrCreate(['user_id' => $user->user_id], $user_public_individual_input);
    }
}
