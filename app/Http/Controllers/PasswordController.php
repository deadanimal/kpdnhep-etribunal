<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Hash;

class PasswordController extends Controller
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
    
    public function viewModalProfile(){
    	return view("password/viewModalProfile");
    }

    public function viewModalUser($userid){
        return view("password/viewModalUser", compact('userid'));
    }

    public function changePasswordProfile(Request $request){
        //return response()->json(['result' => 'Error', 'error_msg' => 'User not authorized!']);
        if (Auth::check()) {
            // The user is logged in...
            
            // Check for new password and old password
            if ($request->oldpass != "" && $request->newpass != "") {

                $oldpass = md5($request->oldpass);
                $newpass = md5($request->newpass);

                // Check for current user id
                $userid = Auth::id();

                $user = User::find($userid);

                // Verify old password with DB
                if (Hash::check($oldpass, $user->password)) {
                    // The passwords match... Update the password
                    $user->update(['password' => Hash::make($newpass)]);

                    // Return success!
                    $audit = new \App\Http\Controllers\Admin\AuditController;
                    $audit->add($request,5,"PasswordController",null,null,"Update password profile".$userid);
                    return response()->json(['result' => 'Success']);

                } else {
                    // Passwords not match...
                    return response()->json(['result' => 'Error', 'error_msg' =>  trans('swal.old_password_not_matched')  ]);
                }

            }
            else {
                // Return no parameters sent
                return response()->json(['result' => 'Error', 'error_msg' =>  trans('swal.no_parameter') ]);
            }

        }
        else {
            // Return not authenticated
            return response()->json(['result' => 'Error', 'error_msg' =>  trans('swal.user_not_authorized') ]);
        }
    }

    public function changePasswordUser(Request $request){
        //return response()->json(['result' => 'Error', 'error_msg' => 'User not authorized!']);
        if (Auth::check()) {
            // The user is logged in...
            
            // Check for new password and old password
            if ($request->newpass != "" && $request->userid != "") {

                $newpass = md5($request->newpass);

                // Check for current user id
                $userid = $request->userid;

                $user = User::find($userid);

                $user->update(['password' => Hash::make($newpass)]);

                // Return success!
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,5,"PasswordController",null,null,"Update password user".$userid);
                return response()->json(['result' => 'Success']);

            }
            else {
                // Return no parameters sent
                return response()->json(['result' => 'Error', 'error_msg' =>  trans('swal.no_parameter') ]);
            }

        }
        else {
            // Return not authenticated
            return response()->json(['result' => 'Error', 'error_msg' =>  trans('swal.user_not_authorized') ]);
        }
    }
}
