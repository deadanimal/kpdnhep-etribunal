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
use App\MasterModel\MasterHoliday;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\MasterModel\MasterBranch;
use App\HearingModel\PresidentSchedule;
use Carbon\Carbon;

class PresidentScheduleController extends Controller
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
        $holiday_event = MasterHolidayEvent::all();
        return response()->json($holiday_event);
    }

    public function createevent(Request $request)
    {
        $events = MasterHolidayEvent::where('holiday_event_name', '=', $request->holiday_event_name)->first();
        if ($events === null) {
            $event = new MasterHolidayEvent;
            $event->holiday_event_name = $request->holiday_event_name;
            $event->save();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 4, "PresidentScheduleController", json_encode($request->input()), null, "Holiday event " . $request->holiday_event_name . " - Create holiday event");
            return Response::json(['status' => 'ok', 'id' => $event->holiday_event_id, 'name' => $event->holiday_event_name, 'route' => route('holiday.destroyevent', $event->holiday_event_id)]);
        } else
            return Response::json(['status' => 'fail']);
    }

    public function add(Request $request)
    {
        $checkexist = PresidentSchedule::where('president_user_id', '=', $request->add_president_id)
            ->whereDate('suggest_date', '=', Carbon::createFromFormat('d/m/Y', $request->add_date)->toDateString())
            ->count();

        if ($checkexist == 0) {
            PresidentSchedule::create([
                'president_user_id' => $request->add_president_id,
                'suggest_date' => Carbon::createFromFormat('d/m/Y', $request->add_date)->toDateString(),
                'created_by_user_id' => Auth::id()
            ]);

            return Response::json(['result' => 'success']);
        }
    }

    public function destroyevent($id)
    {
        $event = MasterHolidayEvent::findOrFail($id);
        $event->delete();
        return Response::json(['status' => 'ok']);
    }

    //psu/ks and presiden
    public function tableschedule(Request $request)
    {

    }

    public function listschedule(Request $request)
    {
        $schedule = PresidentSchedule::orderBy('created_at', 'desc');
        $presidents = RoleUser::whereIn('role_id', [4])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        if ($request->ajax()) {
            $schedule = PresidentSchedule::orderBy('created_at', 'desc');
            if (Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('admin') && Auth::user()->hasRole('ks-hq')) {
                $schedule = $schedule->whereNotNull('president_user_id');
            } else if (Auth::user()->hasRole('presiden')) {
                $schedule = $schedule->where('president_user_id', '=', Auth::user()->user_id);
            } else {
                $schedule = $schedule->whereNotNull('president_user_id');
            }

            // Check for filteration
            if ($request->has('president') || $request->has('year') || $request->has('month')) {
                if ($request->has('president') && !empty($request->president)) {
                    $schedule->where('president_user_id', $request->president);
                }

                if ($request->has('year') && !empty($request->year)) {
                    $schedule->whereYear('suggest_date', $request->year);
                }

                if ($request->has('month') && !empty($request->month)) {
                    $schedule->whereMonth('suggest_date', $request->month);
                }
            }


            $datatables = Datatables::of($schedule);

            return $datatables
                ->editColumn('id', function ($schedule) {
                    return $schedule->president_schedule_id;
                })
                ->editColumn('president_name', function ($schedule) {
                    return $schedule->president->name;
                })
                ->editColumn('suggest_date', function ($schedule) {
                    return date('d/m/Y', strtotime(strtr($schedule->suggest_date, '-', '/')));
                })
                ->addColumn('tindakan', function ($schedule) {
                    $button =
                        actionButton('blue btnModalView', trans('button.view'), route('president_schedule.viewschedule', ['id' => $schedule->president_schedule_id]), false, 'fa-search', false) .
                        actionButton('green-meadow ajaxUpdateSchedule', trans('button.edit'), route('president_schedule.editschedule', ['id' => $schedule->president_schedule_id]), false, 'fa-edit', false);
                    return $button;
                })
                ->rawColumns(['name', 'description', 'tindakan'])
                ->make(true);
        }
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "PresidentScheduleController", null, null, "Datatables load president schedule");
        return view('president_schedule.index', compact('schedule', 'presidents', 'branches', 'years', 'months'));
    }

    public function calendarschedule(Request $request)
    {
        $psus = RoleUser::whereIn('role_id', [4])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();

        if (Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('ks-hq')) {
            $schedule = PresidentSchedule::whereNotNull('president_user_id');
        } else if (Auth::user()->hasRole('presiden')) {
            $schedule = PresidentSchedule::whereNotNull('president_user_id')
                ->where('president_user_id', '=', Auth::user()->user_id);
        } else {
            $schedule = PresidentSchedule::whereNotNull('president_user_id');
        }

        $schedule = $schedule->get();

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 3, "PresidentScheduleController", null, null, "View President Schedule Calendar");
        return view('president_schedule.calendar', compact('schedule', 'psus'));
    }

    public function createschedule()
    {
        $masterState = MasterState::where('state_id', '!=', 17)->get();
        $masterBranch = MasterBranch::get();
        //       $psus = RoleUser::where('role_id', 4)->get()->filter(function($query){
        // 	return $query->user->user_status_id == 1;
        // });
        $psus = RoleUser::whereIn('role_id', [4])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();
        return view('president_schedule.create', compact('masterState', 'masterBranch', 'psus'));
    }

    public function storeschedule(Request $request)
    {
        $suggest_date = strtr($request->suggest_date, '/', '-');
        $schedule = new PresidentSchedule;
        $schedule->president_user_id = $request->president_id;
        $schedule->state_id = $request->state_id;
        $schedule->branch_id = $request->branch_id;
        $schedule->district_id = $request->district_id;
        $schedule->hearing_room_id = $request->hearing_room_id;
        $schedule->suggest_date = date("Y-m-d", strtotime($suggest_date));
        $schedule->suggest_time = date("H:i:s", strtotime($request->suggest_time));
        $schedule->created_by_user_id = Auth::id();
        $schedule->save();
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 4, "PresidentScheduleController", json_encode($request->input()), null, "President Schedule " . strtr($request->suggest_date, '/', '-') . " - Create president schedule");
        return Response::json(['status' => 'ok']);
    }

    public function editschedule($id)
    {
        $schedule = PresidentSchedule::findOrFail($id);
        $masterState = MasterState::where('state_id', '!=', 17)->get();
        // $masterBranch = MasterBranch::where('branch_id','!=',$schedule->branch_id)->get();
        //       $psus = RoleUser::where('role_id', 4)->get()->filter(function($query){
        // 	return $query->user->user_status_id == 1;
        // });
        $psus = RoleUser::whereIn('role_id', [4])
            ->whereHas('user', function ($user) {
                return $user->where('user_status_id', 1);
            })
            ->get();
        return view('president_schedule.edit', compact('schedule', 'masterState', 'masterBranch', 'psus'));
    }

    public function viewschedule(Request $request, $id)
    {
        $schedule = PresidentSchedule::findOrFail($id);
        $masterState = MasterState::where('state_id', '!=', 17)->get();
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
        $audit->add($request, 3, "PresidentScheduleController", null, null, "View President Schedule " . $schedule->president->name);
        return view('president_schedule.view', compact('schedule', 'masterState', 'masterBranch', 'psus'));
    }


    public function updateschedule(Request $request, $id)
    {
        $suggest_date = strtr($request->hearing_date, '/', '-');
        $schedule = PresidentSchedule::findOrFail($id);
        $schedule->update([
            "president_user_id" => $request->president_id,
            "suggest_date" => date("Y-m-d", strtotime($suggest_date)),
        ]);
        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 5, "PresidentScheduleController", null, null, "Update President Schedule " . $schedule->president->name);
        return Response::json(['status' => 'ok']);
    }

    public function destroyschedule($id)
    {
        $schedule = PresidentSchedule::findOrFail($id);
        $schedule->delete();
        return Response::json(['status' => 'ok']);
    }

    public function sentdate(Request $request)
    {
        $listdate = $request->sentlist;
        $user = $request->user;

        $month = date("m", strtotime($listdate[0]));
        $checkschedule = PresidentSchedule::where('president_user_id', '=', $user)->whereMonth('suggest_date', '=', $month)->first();
        // dd($checkschedule);
        if (empty($checkschedule)) {
            foreach ($listdate as $key => $ll) {
                $schedule = new PresidentSchedule;
                $schedule->president_user_id = $user;
                $schedule->suggest_date = $ll;
                $schedule->save();
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 4, "PresidentScheduleController", json_encode($request->input()), null, "Create President Schedule");
            }
        } else {
            return Response::json(['status' => 'fail', 'name' => $checkschedule->president->name]);
        }

        return Response::json(['status' => 'ok']);
    }

    public function president(Request $request)
    {
        $suggest_date = strtr($request->data, '/', '-');
        $schedule = PresidentSchedule::join('users', 'president_schedule.president_user_id', '=', 'users.user_id')->where('suggest_date', '=', date("Y-m-d", strtotime($suggest_date)))->select('users.user_id as user_id', 'users.name as name')->get();

        return response()->json($schedule);
    }

}
