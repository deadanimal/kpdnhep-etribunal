<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules());

        if($validator->passes()){
            $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
                    $this->resetPassword($user, $password);
                }
            );

            if($response==Password::PASSWORD_RESET){
                Session::forget('email');
                return Response::json(['status' => 'ok', 'message' => trans($response)]);
            } else {
                $response = ['password' => [trans($response)]];
                return Response::json(['status' => 'fail', 'message' => trans($response)]);
            }

        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt(md5($password)),
            'remember_token' => Str::random(60),
        ])->save();
    }
}
