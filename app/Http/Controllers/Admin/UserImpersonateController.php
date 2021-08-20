<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Flash;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class UserImpersonateController
 * @package App\Http\Controllers
 */
class UserImpersonateController extends Controller
{
    /**
     * UserImpersonateController constructor.
     * @param \App\Repositories\UserRepository $userRepo
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function impersonate($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        Auth::user()->impersonate($user);
        return redirect(route('home'));
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function leave()
    {
        Auth::user()->leaveImpersonation();
        return redirect(route('home'));
    }
}
