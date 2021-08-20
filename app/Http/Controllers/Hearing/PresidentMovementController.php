<?php

namespace App\Http\Controllers\Hearing;

use App;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\RoleUser;
use App\MasterModel\MasterUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Response;
use Yajra\Datatables\Datatables;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterHoliday;
use App\MasterModel\MasterState;
use App\MasterModel\MasterBranch;
use App\HearingModel\PresidentSchedule;
use App\HearingModel\Hearing;

class PresidentMovementController extends Controller {
 
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
	public function presidentmovement(Request $request) {

		$schedule = Hearing::with(['president', 'branch'])->orderBy('created_at', 'desc');
		// $presidents = RoleUser::where('role_id',4)->get()->filter(function($query){
		// 	return $query->user->user_status_id == 1;
		// });
		$presidents = RoleUser::whereIn('role_id', [4])
                    ->whereHas('user', function ($user) {
                        return $user->where('user_status_id', 1);
                    })
                    ->get();

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

		if ($request->ajax()) {
			/*if(Auth::user()->hasRole('PSU (HQ)') || Auth::user()->hasRole('admin') && Auth::user()->hasRole('ketua-seksyen'))
				$schedule = PresidentSchedule::all();
			elseif(Auth::user()->hasRole('presiden'))
				$schedule = PresidentSchedule::where('president_user_id','=',Auth::user()->user_id)->get();
			else
				$schedule = PresidentSchedule::all();*/

			// filter
            if ($request->has('president') || $request->has('year') || $request->has('month')) {

                if($request->has('president') && !empty($request->president)) 
                	$schedule->where('president_user_id', $request->president);
                    // $schedule = $schedule->filter(function ($value) use ($request) {
                    //     return $value->president_user_id == $request->president;
                    // });

                if($request->has('year') && !empty($request->year)) 
                	$schedule->whereYear('hearing_date', $request->year);
                    // $schedule = $schedule->filter(function ($value) use ($request) {
                    //     return date('Y', strtotime($value->hearing_date)) == $request->year;
                    // });

                if($request->has('month') && !empty($request->month)) 
                	$schedule->whereMonth('hearing_date', $request->month);
                    // $schedule = $schedule->filter(function ($value) use ($request) {
                    //     return date('m', strtotime($value->hearing_date)) == $request->month;
                    // });
            }


           $datatables = Datatables::of($schedule);

			return $datatables
				->editColumn('id', function ($schedule) {
					return $schedule->hearing_id;
				})
				->editColumn('president_name', function ($schedule) {
					if(!empty($schedule->president->name))
						return $schedule->president->name;
					else
						return '-';
				})
				->editColumn('branch_id', function ($schedule) {
					if(!empty($schedule->branch->branch_name))
						return $schedule->branch->branch_name;
					else
						return '-';
				})
				->editColumn('hearing_date', function ($schedule) {
					return date('d/m/Y', strtotime(strtr($schedule->hearing_date, '-', '/')));
				})
				->editColumn('hearing_time', function ($schedule) {
					return date('h:i a', strtotime(strtr($schedule->hearing_time, '-', '/')));
					
				})
				->addColumn('tindakan', function ($schedule) {

				if(empty($schedule->form4)) {
		          $button = 
		          actionButton('blue btnModalView', trans('button.view'), route('hearing.viewhearing', ['id'=>$schedule->hearing_id]), false, 'fa-search', false).
		          actionButton('green-meadow ajaxUpdateSchedule', trans('button.edit'), route('hearing.edithearing', ['id'=>$schedule->hearing_id]), false, 'fa-edit', false);
		          //         actionButton('btn-danger ajaxDeleteSchedules', trans('button.delete'), route('hearing.destroyhearing', ['id'=>$schedule->hearing_id]), false, 'fa-trash-o', false);
		          return $button;
		          } else {
		            $button = 
		            actionButton('blue btnModalView', trans('button.view'), route('hearing.viewhearing', ['id'=>$schedule->hearing_id]), false, 'fa-search', false).
		            actionButton('green-meadow ajaxUpdateSchedule', trans('button.edit'), route('hearing.edithearing', ['id'=>$schedule->hearing_id]), false, 'fa-edit', false);
		            //         actionButton('btn-danger disabled ajaxDeleteSchedules', trans('button.delete'), route('hearing.destroyhearing', ['id'=>$schedule->hearing_id]), false, 'fa-trash-o', false);
		            return $button;
		          }
				})->rawColumns(['name','description', 'tindakan'])
				->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"PresidentMovementController",null,null,"Datatables load president movements");
		return view('president_movement.index',compact('schedule', 'presidents', 'branches', 'years', 'months'));
	}
	
}
