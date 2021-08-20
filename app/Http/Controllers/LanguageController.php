<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App;
use Lang;
use Auth;
use App\User;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request){
    	if($request->ajax()){
    		$request->session()->put('locale', $request->locale);
    		$request->session()->flash('alert-success','app.Locale_Change_Success');

    		if(Auth::check()){
	    		$userid = Auth::id();

	    		if($request->locale == "en") // English
	    			$update = User::find($userid)->update(['language_id' => 1]);
	    		else // Malay
	    			$update = User::find($userid)->update(['language_id' => 2]);
    		}
    	}
    }
}
