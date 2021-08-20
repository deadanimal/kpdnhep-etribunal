<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

 
class SettingsController extends Controller {

	public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index (Request $request) {

		//$this->changeEnv('APP_URL', 'welcome to bleh 2');
		
		return view('admin.settings');
	}

	public function changeEnv($key, $value) {
		$key = strtoupper($key);

		$path = base_path('.env');

		if (file_exists($path)) {
			file_put_contents($path, str_replace(
				$key.'="'.$_ENV[$key].'"', $key.'="'.$value.'"', file_get_contents($path)
			));
		}
	}

	public function storeEnv (Request $request) {

		//dd($request->input());

		foreach ($request->input() as $key => $value) {
			$this->changeEnv($key, $value);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,18,"SettingsController",null,null,"Update setting ");
        return response()->json(['status' => 'ok', 'message' => __('new.update_success')]);
	}

	
}
