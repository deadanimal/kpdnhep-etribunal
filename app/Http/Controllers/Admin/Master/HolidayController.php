<?php

namespace App\Http\Controllers\Admin\Master;

use App;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\MasterModel\MasterUserType;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use App\MasterModel\MasterHoliday;
use App\MasterModel\MasterHolidayEvent;
use App\MasterModel\MasterState;
use Carbon\Carbon;

class HolidayController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */

    public function index(Request $request)
    {
        if (Auth::user()->hasRole('psu') || Auth::user()->hasRole('ks')) {
            $states = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->get();
        } else {
            $states = MasterState::all();
        }


        $years = range(date('Y'), 2000);

        $userid = Auth::id();
        $user = User::find($userid);

        if ($request->ajax()) {
            if ($request->table == 1) {
                $holidays = MasterHoliday::where('is_federal_holiday', $request->table)->where('year', $request->year ? $request->year : date('Y'))->orderBy('holiday_date');
            } else {
                $holidays = MasterHoliday::where('is_federal_holiday', $request->table)->where('year', $request->year ? $request->year : date('Y'))->where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('holiday_date');
            }

            $datatables = Datatables::of($holidays);

            return $datatables
                ->editColumn('holiday', function ($holidays) {
                    $locale = App::getLocale();
                    $holiday_lang = "holiday_event_name_" . $locale;
                    if ($holidays->holiday_event)
                        return $holidays->holiday_event->$holiday_lang;
                    else return $holidays->event;
                })->editColumn('date', function ($holidays) {
                    return date('d/m/Y', strtotime($holidays->holiday_date));
                })->editColumn('day', function ($holidays) {
                    return localeDay(date('l', strtotime($holidays->holiday_date)));
                })->editColumn('action', function ($holidays) use ($request) {
                    $button = "";

                    if ($request->table == 1 && !Auth::user()->hasRole('admin'))
                        return "";

                    if ($request->table == 1)
                        $button .= '<a class="btn btn-xs green-meadow" rel="tooltip" data-original-title="' . __('button.update') . '" onclick="updateFederal(' . $holidays->holiday_id . ')"><i class="fa fa-edit"></i></a>';
                    else
                        $button .= '<a class="btn btn-xs green-meadow" rel="tooltip" data-original-title="' . __('button.update') . '" onclick="updateAdditional(' . $holidays->holiday_id . ')"><i class="fa fa-edit"></i></a>';

                    $button .= '<a class="btn btn-xs red" rel="tooltip" data-original-title="' . __('button.delete') . '" onclick="deleteHoliday(' . $holidays->holiday_id . ')"><i class="fa fa-trash"></i></a>';

                    return $button;
                })->make(true);
        }

        $audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request, 12, "HolidayController", null, null, "Datatables load master holiday");

        return view("admin.master.holiday.list", compact('holidays', 'states', 'user', 'years'));
    }

    public function delete(Request $request, $id)
    {

        if ($id) {
            $holiday = MasterHoliday::find($id)->delete();
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 6, "HolidayController", null, null, "Delete master holiday " . $id);
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function updateweekend(Request $request)
    {

        $rules = [
            'is_friday_weekend' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $state = MasterState::find($request->state)->update([

                'is_friday_weekend' => $request->is_friday_weekend,
            ]);
            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "HolidayController", null, null, "Update master holiday (Weekend) " . $request->state);
            return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

    }

    //////////////////////////////////// Federal Holiday ///////////////////////////////////////////////////

    public function federal_create()
    {

        $holiday = new MasterHoliday;
        $events = MasterHolidayEvent::where('is_active', 1)->get();
        $holiday_date = date('d/m/Y');

        $userid = Auth::id();
        $user = User::find($userid);

        return view("admin/master/holiday/modalCreateFederal", compact('holiday', 'events', 'holiday_date', 'user'));

    }

    public function federal_edit($id)
    {

        if ($id) {
            $holiday = MasterHoliday::find($id);
            $events = MasterHolidayEvent::where('is_active', 1)->get();
            $holiday_date = date('d/m/Y', strtotime($holiday->holiday_date));
            $userid = Auth::id();
            $user = User::find($userid);

            return view("admin/master/holiday/modalCreateFederal", compact('holiday', 'events', 'holiday_date', 'user'));
        }
    }

    public function federal_update(Request $request)
    {

        $rules = [
            'event' => 'required|int',
            'holiday_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $holiday = MasterHoliday::find($request->holiday_id)->update([

                'holiday_event_id' => $request->event,
                'holiday_date' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->toDateTimeString() : NULL,
                'day_in_week' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->dayOfWeek : NULL,
            ]);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "HolidayController", null, null, "Update master holiday (Federal) " . $request->event);

            return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

    }

    public function federal_store(Request $request)
    {

        $rules = [
            'event' => 'required|int',
            'holiday_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($request->holiday_id == NULL) {

            if ($validator->passes()) {

                $holiday = DB::table('master_holiday')->insertGetId([
                    'holiday_event_id' => $request->event,
                    'holiday_date' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->toDateTimeString() : NULL,
                    'day_in_week' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->dayOfWeek : NULL,
                    'is_federal_holiday' => 1,
                    'state_id' => $request->branch_state_id,
                    'year' => date('Y'),
                    'event' => MasterHolidayEvent::find($request->event)->holiday_event_name_en,
                    'created_by_user_id' => Auth::id()
                ]);
                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 4, "HolidayController", json_encode($request->input()), null, "Master Holiday " . $holiday . " - Create federal holiday");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }

    }


    //////////////////////////////////// Additional Holiday ///////////////////////////////////////////////////

    public function additional_create()
    {

        $holiday = new MasterHoliday;
        $holiday_date = date('d/m/Y');

        $userid = Auth::id();
        $user = User::find($userid);

        return view("admin/master/holiday/modalCreateAdditional", compact('holiday', 'holiday_date', 'user'));

    }

    public function additional_edit($id)
    {

        if ($id) {
            $holiday = MasterHoliday::find($id);
            $holiday_date = date('d/m/Y', strtotime($holiday->holiday_date));
            $userid = Auth::id();
            $user = User::find($userid);

            return view("admin/master/holiday/modalCreateAdditional", compact('holiday', 'holiday_date', 'user'));
        }
    }

    public function additional_update(Request $request)
    {

        $rules = [
            'event' => 'required',
            'holiday_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $holiday = MasterHoliday::find($request->holiday_id)->update([

                'event' => $request->event,
                'holiday_date' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->toDateTimeString() : NULL,
                'day_in_week' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->dayOfWeek : NULL,
            ]);

            $audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request, 5, "HolidayController", null, null, "Update master holiday (Additional) " . $request->event);

            return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
        } else {
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }

    }

    public function additional_store(Request $request)
    {

        $rules = [
            'event' => 'required',
            'holiday_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($request->holiday_id == NULL) {

            if ($validator->passes()) {

                $holiday = DB::table('master_holiday')->insertGetId([
                    'event' => $request->event,
                    'holiday_date' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->toDateTimeString() : NULL,
                    'day_in_week' => $request->holiday_date ? Carbon::createFromFormat('d/m/Y', $request->holiday_date)->dayOfWeek : NULL,
                    'is_federal_holiday' => 0,
                    'state_id' => $request->branch_state_id,
                    'year' => date('Y'),
                    'created_by_user_id' => Auth::id()
                ]);

                $audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request, 4, "HolidayController", json_encode($request->input()), null, "Master Holiday " . $holiday . " - Create additional holiday");

                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }

    }

}
