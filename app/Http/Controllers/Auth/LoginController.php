<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\LogAuditRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon\Carbon;
use Cookie;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials($request)
    {
        return [
            'username' => $request->{$this->username()},
            'password' => md5($request->password)
        ];
    }


    public function username()
    {
        return 'username';
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        try {
            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        } catch (Exception $e) {

        }
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 2, "LoginController", null, null, "User " . Auth::user()->username . " logged out");

            Auth::logout();
        }

        return redirect()->route('home');
    }


    protected function authenticated($request, $user)
    {
        switch (true) {
            case (!config('auth.user_loggable')): // all user login ability is false
            case ($user->user_type_id == 3 && !config('auth.public_loggable')): // public user & public user login ability is false
                Auth::logout();
                return redirect()->route('login', ['status' => 'closed']);
                break;
            case ($user->user_status_id == 2): // account is inactive
                Auth::logout();
                return redirect()->route('login', ['status' => 'inactive']);
                break;
            case ($user->user_status_id == 5): // account is suspended
                Auth::logout();
                return redirect()->route('login', ['status' => 'suspended']);
                break;
            default:
                LogAuditRepository::store($request, 1, "LoginController", null, null, "User {$user->username} logged in");

                return redirect()
                    ->route('home')
                    ->withCookie(Cookie::forget('failed_' . $user->username));
                break;
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $trans
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse($request, $trans = 'auth.failed')
    {
        $errors = [$this->username() => trans($trans)];
        $minutes = 60;
        $username = preg_replace("/[^[:alnum:]]/u", '', $request->username);

        if (!$request->cookie('failed_' . $username)) {
            $cookie_failed_at = cookie('failed_' . $username, json_encode([
                'failed_at' => Carbon::now()->toDateTimeString(),
                'counter' => 1,
                'username' => $request->username
            ]), $minutes);
        } else {
            $cookie_data = json_decode($request->cookie('failed_' . $username), true);
            $cookie_data['counter'] = $cookie_data['counter'] + 1;

            $cookie_failed_at = cookie('failed_' . $username, json_encode([
                'failed_at' => Carbon::now()->toDateTimeString(),
                'counter' => $cookie_data['counter'],
                'username' => $request->username
            ]), $minutes);

            if ($cookie_data['counter'] == 5) {
                $failed_at = new Carbon($cookie_data['failed_at']);
                $now = Carbon::now();

                // if user is failed 5 times within in an hour
                // then suspend them.
//                if ($failed_at->diffInHours($now) < 1) {
//                    User::where('username', $request->username)->first()->update(['user_status_id' => 5]);
//                    $errors = [$this->username() => trans('auth.suspended')];
//                }
            }
        }


        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()
            ->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors)
            ->cookie($cookie_failed_at);
    }

    public function instantLogin(Request $request)
    {

        $user = User::where('user_id', $request->user_id)
            ->where('username', $request->username)
            ->get();

        if (count($user) == 0)
            abort(404);

        Auth::login($user->first());

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 1, "LoginController", null, null, "User " . Auth::user()->username . " instant log in");

        return redirect()->route('home');
    }

}
