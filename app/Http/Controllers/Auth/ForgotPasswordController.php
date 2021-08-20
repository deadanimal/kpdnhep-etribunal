<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);

        if($validator->passes()){
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            if($response == Password::RESET_LINK_SENT){
                Session::put('email', $request->email);
                return Response::json(['status' => 'ok', 'message' => trans($response)]);
            } else {
                $response = ['email' => [trans($response)]];
                return Response::json(['status' => 'fail', 'message' => $response]);
            }

        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
    }
}
