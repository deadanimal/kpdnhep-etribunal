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

class PresidentScheduleViewController extends Controller {
 
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
	public function allevents(Request $request) {
	}
 
    public function createevent(Request $request){
    }

    public function destroyevent($id){
    }

	public function tableschedule(Request $request) {
		if ($request->ajax()) {
			$schedule = PresidentSchedule::orderBy('created_at', 'desc');

			$datatables = Datatables::of($schedule);

			return $datatables
				->editColumn('id', function ($schedule) {
					return $schedule->president_schedule_id;
				})
				->editColumn('schedule_name', function ($schedule) {
					return $schedule->president->name;
				})
				->editColumn('hearing_date', function ($schedule) {
					return date('d/m/Y', strtotime(strtr($schedule->suggest_date, '-', '/')));
				})
				->addColumn('tindakan', function ($schedule) {
					$button = 
					actionButton('blue btnModalView', trans('button.view'), route('president_schedule.viewschedule', ['id'=>$schedule->president_schedule_id]), false, 'fa-search', false).
					actionButton('green-meadow ajaxUpdateSchedule', trans('button.edit'), route('president_schedule.editschedule', ['id'=>$schedule->president_schedule_id]), false, 'fa-edit', false);
	                // actionButton('btn-danger ajaxDeleteSchedules', trans('button.delete'), route('president_schedule.destroyschedule', ['id'=>$schedule->president_schedule_id]), false, 'fa-trash-o', false);
					return $button;
				})->rawColumns(['name','description', 'tindakan'])
				->make(true);
		}
	}

	public function listscheduleview(Request $request) {
        $schedule = Hearing::orderBy('created_at', 'desc')
            ->whereYear('hearing_date', '>', date('Y') - 1);
        if (Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('admin') && Auth::user()->hasRole('ks-hq')) {
            $schedule = $schedule->whereNotNull('president_user_id');
        } else if (Auth::user()->hasRole('presiden')) {
            $schedule = $schedule->where('president_user_id', '=', Auth::user()->user_id);
        } else {
            $schedule = $schedule->whereNotNull('president_user_id');
        }
        $schedule = $schedule->get();

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"PresidentScheduleViewController",null,null,"Datatables load president schedule view");
		return view('president_schedule_view.index',compact('schedule'));
	}

	
	public function calendarschedule(Request $request) {
		$holiday = MasterHoliday::all();
		return view('president_schedule_view.calendar',compact('holiday'));
	}

	public function createschedule() {
		$masterState = MasterState::where('state_id','!=',17)->get();
		$masterBranch = MasterBranch::get();
  //       $psus = RoleUser::where('role_id', 4)->get()->filter(function($query){
		// 	return $query->user->user_status_id == 1;
		// });
		$psus = RoleUser::whereIn('role_id', [4])
                    ->whereHas('user', function ($user) {
                        return $user->where('user_status_id', 1);
                    })
                    ->get();
		return view('president_schedule_view.create',compact('masterState','masterBranch','psus'));
	}

    public function storeschedule(Request $request){
    	$suggest_date = strtr($request->suggest_date, '/', '-');
    	$schedule = new PresidentSchedule;
		$schedule->president_id=$request->president_id;
		$schedule->state_id=$request->state_id;
		$schedule->branch_id=$request->branch_id;
		$schedule->district_id=$request->district_id;
		$schedule->hearing_room_id=$request->hearing_room_id;
		$schedule->suggest_date=date("Y-m-d", strtotime($suggest_date));
		$schedule->suggest_time=date( "H:i:s", strtotime( $request->suggest_time ) );
		$schedule->save();
		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,4,"PresidentScheduleController",json_encode($request->input()),null,"President Schedule ".strtr($request->suggest_date, '/', '-')." - Create president schedule");
        return Response::json(['status' => 'ok']);
    }

	public function editschedule($id) {
		$schedule = PresidentSchedule::findOrFail($id);
		$masterState = MasterState::where('state_id','!=',17)->get();
		$masterBranch = MasterBranch::where('branch_id','!=',$schedule->branch_id)->get();
  //       $psus = RoleUser::where('role_id', 4)->get()->filter(function($query){
		// 	return $query->user->user_status_id == 1;
		// });
		$psus = RoleUser::whereIn('role_id', [4])
                    ->whereHas('user', function ($user) {
                        return $user->where('user_status_id', 1);
                    })
                    ->get();
		return view('president_schedule_view.edit',compact('schedule','masterState','masterBranch','psus'));
	}

	public function viewschedule($id) {
		$schedule = PresidentSchedule::findOrFail($id);
		$masterState = MasterState::where('state_id','!=',17)->get();
		$masterBranch = MasterBranch::get();
  //       $psus = RoleUser::where('role_id', 4)->get()->filter(function($query){
		// 	return $query->user->user_status_id == 1;
		// });
		$psus = RoleUser::whereIn('role_id', [4])
                    ->whereHas('user', function ($user) {
                        return $user->where('user_status_id', 1);
                    })
                    ->get();
		return view('president_schedule_view.view',compact('schedule','masterState','masterBranch','psus'));
	}


    public function updateschedule(Request $request, $id){
		$holiday = MasterHoliday::findOrFail($id);
        $holiday->update([
            "holiday_name" => $request->holiday_name,
            "holiday_date_start" => date("Y-m-d", strtotime($request->holiday_date_start)),
            "holiday_date_end" => date("Y-m-d", strtotime($request->holiday_date_end)),
        ]);

		$state = $request->state;
		if(!empty($state)){
			foreach($state as $p){
				$ownerperm = new MasterHolidayState;
				$ownerperm->holiday_id=$id;
				$ownerperm->state_id=$p;
				$ownerperm->save();
			}
		}

        return Response::json(['status' => 'ok']);
    }

    public function destroyschedule($id){
        $schedule = PresidentSchedule::findOrFail($id);
        $schedule->delete();
        return Response::json(['status' => 'ok']);
    }

    public function scheduledatelist($date) {
		$hearings = Hearing::where('hearing_date', '=', $date);

        if(auth()->user()->hasRole('presiden')) {
            $hearings->where('hearing.president_user_id', auth()->user()->user_id);
        }

        $hearings = $hearings->get();
		
		return view('president_schedule_view.list',compact('hearings'));
	}

	
}
