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
use Yajra\Datatables\Datatables;
use App\MasterModel\MasterHoliday;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\MasterModel\MasterBranch;
use App\HearingModel\Hearing;
use App\HearingModel\PresidentSchedule;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class HearingController extends Controller
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

    public function allevents(Request $request)
    {

    }

    public function createevent(Request $request)
    {

    }

    public function destroyevent($id)
    {

    }

    // public function tablehearing(Request $request) {

    // 	if ($request->ajax()) {
    // 		$schedule = Hearing::orderBy('hearing_date','desc')->get();

    // 		$datatables = Datatables::of($schedule);

    // 		return $datatables
    // 			->editColumn('id', function ($schedule) {
    // 				return $schedule->hearing_id;
    // 			})
    // 			->editColumn('president_name', function ($schedule) {
    // 				if(!empty($schedule->president->name))
    // 					return $schedule->president->name;
    // 				else
    // 					return '-';
    // 			})
    // 			->editColumn('branch_id', function ($schedule) {
    // 				if(!empty($schedule->branch->branch_name))
    // 					return $schedule->branch->branch_name;
    // 				else
    // 					return '-';
    // 			})
    // 			->editColumn('hearing_venue', function ($schedule) {
    // 				if(!empty($schedule->hearing_room_id))
    // 					return $schedule->hearing_room->venue->hearing_venue;
    // 				else
    // 					return '-';
    // 			})
    // 			->editColumn('hearing_date', function ($schedule) {
    // 				return date('d/m/Y', strtotime(strtr($schedule->hearing_date, '-', '/')));
    // 			})
    // 			->editColumn('hearing_time', function ($schedule) {
    // 				return date('h:i a', strtotime(strtr($schedule->hearing_time, '-', '/')));

    // 			})
    // 			->addColumn('tindakan', function ($schedule) {

    // 				$button =
    // 				actionButton('blue btnModalView', trans('button.view'), route('hearing.viewhearing', ['id'=>$schedule->hearing_id]), false, 'fa-search', false).
    // 				actionButton('green-meadow ajaxUpdateSchedule', trans('button.edit'), route('hearing.edithearing', ['id'=>$schedule->hearing_id]), false, 'fa-edit', false).
    //                 actionButton('btn-danger disabled ajaxDeleteSchedules', trans('button.delete'), route('hearing.destroyhearing', ['id'=>$schedule->hearing_id]), false, 'fa-trash-o', false);
    // 				return $button;
    // 			})->rawColumns(['name','description', 'tindakan'])
    // 			->make(true);
    // 	}
    // }

    public function listhearing(Request $request)
    {
        $schedule = Hearing::with(['president', 'branch', 'hearing_room.venue'])
            ->orderBy('hearing_date', 'desc')
            ->orderBy('hearing_time', 'desc');

        if (!Auth::user()->hasRole('user') && !$request->has('branch')) {
            return redirect()->route('hearing.listhearing', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

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

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq'))
            $branches = MasterBranch::where('is_active', 1)
                ->where('branch_id', Auth::user()->ttpm_data->branch_id)
                ->orderBy('branch_id', 'desc')
                ->get();
        else
            $branches = MasterBranch::where('is_active', 1)
                ->orderBy('branch_id', 'desc')
                ->get();

        if ($request->ajax()) {
            /*if(Auth::user()->hasRole('PSU (HQ)') || Auth::user()->hasRole('admin') && Auth::user()->hasRole('ketua-seksyen'))
                $schedule = PresidentSchedule::all();
            elseif(Auth::user()->hasRole('presiden'))
                $schedule = PresidentSchedule::where('president_user_id','=',Auth::user()->user_id)->get();
            else
                $schedule = PresidentSchedule::all();*/

            // Check for filteration
            if ($request->has('president') || $request->has('year') || $request->has('month') || $request->has('branch')) {

                if ($request->has('president') && !empty($request->president))
                    $schedule->where('president_user_id', $request->president);
                // $schedule = $schedule->filter(function ($value) use ($request) {
                //     return $value->president_user_id == $request->president;
                // });

                if ($request->has('branch') && !empty($request->branch))
                    $schedule->where('branch_id', $request->branch);
                // $schedule = $schedule->filter(function ($value) use ($request) {
                //     return $value->branch_id == $request->branch;
                // });

                if ($request->has('year') && !empty($request->year))
                    $schedule->whereYear('hearing_date', $request->year);
                // $schedule = $schedule->filter(function ($value) use ($request) {
                //     return date('Y', strtotime($value->hearing_date)) == $request->year;
                // });

                if ($request->has('month') && !empty($request->month))
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
                    if (!empty($schedule->president->name))
                        return $schedule->president->name;
                    else
                        return '-';
                })
                ->editColumn('branch_id', function ($schedule) {
                    if (!empty($schedule->branch->branch_name))
                        return $schedule->branch->branch_name;
                    else
                        return '-';
                })
                ->editColumn('hearing_venue', function ($schedule) {
                    if (!empty($schedule->hearing_room_id))
                        return $schedule->hearing_room->venue->hearing_venue;
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

                    $button = actionButton('blue btnModalView', trans('button.view'), route('hearing.viewhearing', ['id' => $schedule->hearing_id]), false, 'fa-search', false);

                    $button .= actionButton('green-meadow ajaxUpdateSchedule', trans('button.edit'), route('hearing.edithearing', ['id' => $schedule->hearing_id]), false, 'fa-edit', false);

                    if ($schedule->form4->count() == 0)
                        $button .= actionButton('btn-danger ajaxDeleteSchedules', trans('button.delete'), route('hearing.destroyhearing', ['id' => $schedule->hearing_id]), false, 'fa-trash-o', false);

                    return $button;

                })
                ->rawColumns(['name', 'description', 'tindakan'])
                ->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "HearingController", null, null, "Datatables load hearing schedule");
        return view('hearing_module.index', compact('schedule', 'presidents', 'branches', 'years', 'months'));
    }

    public function calendarhearing(Request $request)
    {
        $holiday = MasterHoliday::all();
        return view('hearing_module.calendar', compact('holiday_event', 'holiday'));
    }

    public function createhearing($date)
    {

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq'))
            $masterState = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->get();
        else
            $masterState = MasterState::get();

        $masterBranch = MasterBranch::get();

        $data = PresidentSchedule::whereDate('suggest_date', '=', $date)->pluck('president_user_id');
        //       $psus = RoleUser::wherein('user_id', $data)->get()->filter(function($query){
        // 	return $query->user->user_status_id == 1;
        // });
        $psus = RoleUser::whereIn('role_id', $data)
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();
        return view('hearing_module.create', compact('masterState', 'masterBranch', 'psus', 'date'));
    }

    public function storehearing(Request $request)
    {

        $rules = [
            //'president_id' => 'required|integer',
            'state_id' => 'required|integer',
            'branch_id' => 'required|integer',
            //'venue_id' => 'required|integer',
            //'hearing_room_id' => 'required|integer',
            'hearing_time' => 'required',
            'hearing_date' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        $hearing_date = strtr($request->hearing_date, '/', '-');
        $schedule = new Hearing;
        if ($request->president_id)
            $schedule->president_user_id = $request->president_id;
        $schedule->state_id = $request->state_id ? $request->state_id : null;
        $schedule->branch_id = $request->branch_id ? $request->branch_id : null;
        $schedule->district_id = $request->district_id;

        if ($request->hearing_room_id)
        {
            $schedule->hearing_room_id = $request->hearing_room_id;
        }

        $schedule->hearing_date = date("Y-m-d", strtotime($hearing_date));
        $schedule->hearing_time = date("H:i:s", strtotime($request->hearing_time));
        $schedule->save();
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 4, "HearingController", json_encode($request->input()), null, "Hearing " . strtr($request->hearing_date, '/', '-') . " - Create hearing schedule");
        return Response::json(['status' => 'ok']);
    }

    /**
     * show edit hearing form
     *
     * @param integer $id
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function edithearing($id)
    {
        $schedule = Hearing::findOrFail($id);

        if (auth()->user()->hasRole('psu') || auth()->user()->hasRole('psu-hq')) {
            $masterState = MasterState::where('state_id', auth()->user()->ttpm_data->branch->branch_state_id)->get();
        } else {
            $masterState = MasterState::get();
        }

        $masterBranch = MasterBranch::where('branch_id', '!=', $schedule->branch_id)->get();

        $psus = RoleUser::whereHas('user', function ($user) {
            return $user->where('user_status_id', 1);
        })
            ->whereIn('role_id', [4])
            ->get();

        return view('hearing_module.edit', compact('schedule', 'masterState', 'masterBranch', 'psus'));
    }

    public function viewhearing(Request $request, $id)
    {
        $schedule = Hearing::findOrFail($id);

        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('psu-hq'))
            $masterState = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->get();
        else
            $masterState = MasterState::get();

        $masterBranch = MasterBranch::get();
        //       $psus = RoleUser::where('role_id', 4)->get()->filter(function($query){
        // 	return $query->user->user_status_id == 1;
        // });
        $psus = RoleUser::whereIn('role_id', [4])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 3, "HearingController", null, null, "View hearing " . $id);
        return view('hearing_module.view', compact('schedule', 'masterState', 'masterBranch', 'psus'));
    }

    /**
     * Update hearing data
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return mixed
     */
    public function updatehearing(Request $request, $id)
    {
        $rules = [
            'hearing_time' => 'required',
            'hearing_date' => 'required',
            'hearing_remark' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->passes()) {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

        $hearing_date = strtr($request->hearing_date, '/', '-');
        $hearing_old = $hearing = Hearing::findOrFail($id);
        $hearing->update([
            "president_user_id" => $request->president_id ? $request->president_id : null,
            "state_id" => $request->state_id ? $request->state_id : null,
            "branch_id" => $request->branch_id ? $request->branch_id : null,
            "district_id" => $request->district_id,
            "hearing_room_id" => $request->hearing_room_id ? $request->hearing_room_id : null,
            "hearing_date" => date("Y-m-d", strtotime($hearing_date)),
            "hearing_time" => date("H:i:s", strtotime($request->hearing_time)),
        ]);

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 5, "HearingController",
            json_encode($hearing_old->toArray()),
            json_encode($hearing->toArray()),
            "Update hearing " . $hearing_date . " from " . $hearing_old->hearing_date . "with remark " . $request->hearing_remark);

        return Response::json(['status' => 'ok']);
    }

    public function destroyhearing(Request $request, $id)
    {
        $schedule = Hearing::findOrFail($id);
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 6, "HearingController", null, null, "Delete hearing " . $id);
        $schedule->delete();
        return Response::json(['status' => 'ok']);
    }
}
