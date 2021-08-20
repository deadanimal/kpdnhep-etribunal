<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterCountry;
use App\MasterModel\MasterDesignation;
use App\MasterModel\MasterGender;
use App\MasterModel\MasterLanguage;
use App\MasterModel\MasterNotificationMethod;
use App\MasterModel\MasterOccupation;
use App\MasterModel\MasterRace;
use App\MasterModel\MasterState;
use App\User;
use App\UserPublic;
use App\UserPublicCompany;
use App\UserPublicIndividual;
use App\UserTTPM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Redirect;

class ProfileController extends Controller
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

    protected function rules_admin()
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255'
        ];

        return $rules;
    }

    protected function rules_staff()
    {

        $rules = [
            'name' => 'required',
            'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            'phone_office' => 'required|string|regex:/^.{9,15}$/',
            'email' => 'required|string|email|max:255',
            'signature_blob' => 'max:2000'
        ];

        return $rules;
    }

    protected function rules_user()
    {

        $rules = [
            'name' => 'required',
            'phone_mobile' => 'required|string|regex:/^.{9,15}$/',
            'email' => 'required|string|email|max:255',
            'address_street_1' => 'required|max:150',
            'address_postcode' => 'required|max:5|min:5',
            'address_state_id' => 'required',
            'address_district_id' => 'required',
            'address_mailing_street_1' => 'required|max:150',
            'address_mailing_postcode' => 'required|max:5|min:5',
            'address_mailing_state_id' => 'required',
            'gender_id' => 'required',
            'date_of_birth' => 'required',
            'race_id' => 'required',
            'occupation_id' => 'required'
        ];

        return $rules;
    }

    protected function rules_company()
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'address_street_1' => 'required|max:150',
            'address_postcode' => 'required|max:5|min:5',
            'address_state_id' => 'required',
            'address_district_id' => 'required',
            'address_mailing_street_1' => 'required|max:150',
            'address_mailing_postcode' => 'required|max:5|min:5',
            'address_mailing_state_id' => 'required',
            'representative_name' => 'required',
            'representative_identification_no' => 'required',
            'representative_nationality_country_id' => 'required',
            'representative_designation_id' => 'required',
            'representative_phone_mobile' => 'required|string|regex:/^.{9,15}$/'
        ];

        return $rules;
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
        $this->data['masterOccupation'] = MasterOccupation::all();
        $this->data['masterDesignation'] = MasterDesignation::all();
        $this->data['masterBranch'] = MasterBranch::where('is_active', 1)->orderBy('is_hq', 'desc')->get();

        return $this->data;
    }

    public function showProfileForm()
    {
        $this->masterModel('profile.view');
        // dd(Auth::user()->user_id);
        $this->data['user'] = User::find(Auth::user()->user_id);

        if ($this->data['user']->user_type_id == 1) {
            //die("test");

            return view('profile.admin', $this->data);
        }

        $this->data['userPublic'] = UserPublic::where('user_id', Auth::user()->user_id)->first();
        // dd(UserPublic::where('user_id', Auth::user()->user_id)->first());
        $this->data['userPublicIndividual'] = UserPublicIndividual::where('user_id', Auth::user()->user_id)->first();
        $this->data['userPublicCompany'] = UserPublicCompany::where('user_id', Auth::user()->user_id)->first();

        $this->data['userTTPM'] = UserTTPM::where('user_id', Auth::user()->user_id)->first();
        // dd(UserTTPM::where('user_id', Auth::user()->user_id)->first());

        if (User::find(Auth::user()->user_id)->user_type_id == 2) {
            return view('profile.staff', $this->data);
        } else {
            return view('profile.view', $this->data);
        }

    }

    public function updateprofile(Request $request, $id)
    {
        try {
            // dd(Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateString());

            $profile = User::findOrFail($id);
            if ($profile->user_type_id == 1) { //Admin edit account

                $validator = Validator::make($request->all(), $this->rules_admin());

                if ($validator->passes()) {

                    $profile->update([
                        "name" => $request->name,
                        "email" => $request->email,
                        "language_id" => $request->language_id,
                    ]);

                    if ($request->language_id == 1)
                        $request->session()->put('locale', "en");
                    else
                        $request->session()->put('locale', "my");
                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request, 5, "ProfileController", null, null, "Update admin profile " . $request->name);
                    return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
                    //return redirect()->route('profile', ['status' => 'ok', 'message' => __('new.update_success')]);

                } else return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
                //else redirect()->route('profile', ['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            } else {

                $profile2 = UserPublic::where('user_id', '=', $id)->first();
                $profile3 = UserPublicIndividual::where('user_id', '=', $id)->first();
                $profile4 = UserPublicCompany::where('user_id', '=', $id)->first();
                $profile5 = UserTTPM::where('user_id', '=', $id)->first();

                // dd($profile5);
                if ($profile->user_type_id != 2) {
                    if ($profile2->user_public_type_id != 2) {

                        $validator = Validator::make($request->all(), $this->rules_user());

                        if ($validator->passes()) {
                            $profile->name = $request->name;
                            $profile->language_id = $request->language_id; // optional
                            $profile->phone_office = $request->phone_office;
                            $profile->phone_fax = $request->phone_fax;
                            $profile->email = $request->email;

                            $notification_method = $request->notification_method_id;
                            $profile2->notification_method_id = 4;

                            if (!empty($notification_method)) {
                                if (count($notification_method) == 2) {
                                    $profile2->notification_method_id = 3; // 3:Both
                                } else if (count($notification_method) == 1) {
                                    $profile2->notification_method_id = $request->notification_method_id[0];
                                }
                            }

                            // NULL or 4:None
                            //die(json_encode($profile2->notification_method_id));

                            //$profile3->identification_no = $request->identification_no;
                            $profile3->phone_home = $request->phone_home;
                            $profile3->phone_mobile = $request->phone_mobile;

                            if ($profile3->nationality_country_id != 129) {
                                $profile3->nationality_country_id = $request->nationality_country_id;
                            }

                            if ($profile3->is_tourist != 1) {
                                $profile2->address_street_1 = $request->address_street_1;
                                $profile2->address_street_2 = $request->address_street_2;
                                $profile2->address_street_3 = $request->address_street_3;
                                $profile2->address_postcode = $request->address_postcode;
                                $profile2->address_district_id = $request->address_district_id;
                                $profile2->address_state_id = $request->address_state_id;
                                $profile2->address_mailing_street_1 = $request->address_mailing_street_1;
                                $profile2->address_mailing_street_2 = $request->address_mailing_street_2;
                                $profile2->address_mailing_street_3 = $request->address_mailing_street_3;
                                $profile2->address_mailing_postcode = $request->address_mailing_postcode;
                                $profile2->address_mailing_district_id = $request->address_mailing_district_id;
                                $profile2->address_mailing_state_id = $request->address_mailing_state_id;

                                // $profile3->nationality_country_id = $request->nationality_country_id;
                                $profile3->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->toDateString();
                                $profile3->occupation_id = $request->occupation_id;
                                $profile3->race_id = $request->race_id;
                                $profile3->gender_id = $request->gender_id;

                            }

                            $profile->save();
                            $profile2->save();
                            $profile3->save();

                            if ($request->language_id == 1)
                                $request->session()->put('locale', "en");
                            else
                                $request->session()->put('locale', "my");
                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request, 5, "ProfileController", null, null, "Update user individual profile " . $request->name);
                            return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
                        } else return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);


                    }
                    // dd($request->language_id);
                    if ($profile2->user_public_type_id == 2) {

                        $validator = Validator::make($request->all(), $this->rules_company());

                        if ($validator->passes()) {

                            $profile->name = $request->name;
                            $profile->language_id = $request->language_id;
                            $profile->phone_office = $request->phone_office;
                            $profile->phone_fax = $request->phone_fax;
                            $profile->email = $request->email;

                            $notification_method = $request->notification_method_id;
                            $profile2->notification_method_id = 3;

//                            if (count($notification_method) == 2) {
//                                $profile2->notification_method_id = 3; // 3:Both
//                            } else if (count($notification_method) == 1) {
//                                $profile2->notification_method_id = $request->notification_method_id[0];
//                            }
                            // NULL or 4:None

                            $profile2->address_street_1 = $request->address_street_1;
                            $profile2->address_street_2 = $request->address_street_2;
                            $profile2->address_street_3 = $request->address_street_3;
                            $profile2->address_postcode = $request->address_postcode;
                            $profile2->address_district_id = $request->address_district_id;
                            $profile2->address_state_id = $request->address_state_id;
                            $profile2->address_mailing_street_1 = $request->address_mailing_street_1;
                            $profile2->address_mailing_street_2 = $request->address_mailing_street_2;
                            $profile2->address_mailing_street_3 = $request->address_mailing_street_3;
                            $profile2->address_mailing_postcode = $request->address_mailing_postcode;
                            $profile2->address_mailing_district_id = $request->address_mailing_district_id;
                            $profile2->address_mailing_state_id = $request->address_mailing_state_id;

                            //$profile4->company_no = $request->company_no;
                            $profile4->representative_name = $request->representative_name;
                            $profile4->representative_nationality_country_id = $request->representative_identification_type == 1
                                ? 129
                                : $request->representative_nationality_country_id;
                            $profile4->representative_identification_no = $request->representative_identification_no;
                            $profile4->representative_designation_id = $request->representative_designation_id;
                            $profile4->representative_nationality_country_id = $request->representative_nationality_country_id;
                            $profile4->representative_phone_home = $request->representative_phone_home;
                            $profile4->representative_phone_mobile = $request->representative_phone_mobile;

                            $profile->save();
                            $profile2->save();
                            $profile4->save();

                            if ($request->language_id == 1)
                                $request->session()->put('locale', "en");
                            else
                                $request->session()->put('locale', "my");
                            $audit = new \App\Http\Controllers\Admin\AuditController;
                            $audit->add($request, 5, "ProfileController", null, null, "Update user company profile " . $request->name);
                            return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
                        } else return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);

                    }
                }

                // dd($profile->user_type_id);

                if ($profile->user_type_id == 2) {

                    $validator = Validator::make($request->all(), $this->rules_staff());

                    if ($validator->passes()) {

                        $profile->name = $request->name;
                        // $profile->username = $request->username;
                        $profile->language_id = $request->language_id;
                        $profile->phone_office = $request->phone_office;
                        $profile->phone_fax = $request->phone_fax;
                        $profile->email = $request->email;

                        $profile5->phone_mobile = $request->phone_mobile;
                        $profile5->identification_no = $request->identification_no;
                        // $profile5->branch_id = $request->branch_id;
                        // $profile5->designation_id = $request->designation_id;

                        if ($request->hasFile('signature_blob')) {
                            if ($request->file('signature_blob')->isValid()) {
                                $profile5->signature_blob = file_get_contents($request->signature_blob);
                            }
                        }

                        $profile->save();
                        $profile5->save();

                        if ($request->language_id == 1)
                            $request->session()->put('locale', "en");
                        else
                            $request->session()->put('locale', "my");
                        $audit = new \App\Http\Controllers\Admin\AuditController;
                        $audit->add($request, 5, "ProfileController", null, null, "Update TTPM staff profile " . $request->name);
                        return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
                    } else return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
                }

            }

        } catch (ValidationException $e) {
            return back()->withErrors($e->getErrors())->withInput();
        }
        return redirect(url('/profile'));
    }
}
