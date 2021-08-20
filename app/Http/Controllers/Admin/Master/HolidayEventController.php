<?php

namespace App\Http\Controllers\Admin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\MasterModel\MasterHolidayEvent;
use App;
use DB;
use Auth;
use Carbon\Carbon;

class HolidayEventController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
//DB
	protected function rules_insert(){

		$rules = [ 
			'holiday_event_name_en' => 'required',
			'holiday_event_name_my' => 'required',
			'holiday_date' => 'required'
		];

		return $rules;
	}

	protected function rules_update(){

		$rules = [ 
			'holiday_event_name_en' => 'required',
			'holiday_event_name_my' => 'required',
			'holiday_date' => 'required'
		];

		return $rules;
	}

	public function index(Request $request){

		if ($request->ajax()) {

			$holiday_event = MasterHolidayEvent::orderBy('is_active', 'desc')->get();

			$datatables = Datatables::of($holiday_event);

			return $datatables
			->editColumn('holiday_event_name', function ($holiday_event) {
				$locale = App::getLocale();
				$holiday_event_name = 'holiday_event_name_'.$locale;
				return $holiday_event->$holiday_event_name;
			})->editColumn('holiday_date', function ($holiday_event) {
				return date('d/m/Y', strtotime($holiday_event->holiday_date));
			})->editColumn('created_at', function ($holiday_event) {
				return date('d/m/Y', strtotime($holiday_event->created_at));
			})->editColumn('action', function ($holiday_event) {
				$button = "";

				if($holiday_event->is_active) {
					$button .= '<a value="' . route('master.holiday_event.view', $holiday_event->holiday_event_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

					$button .= actionButton('green-meadow', __('button.edit'), route('master.holiday_event.edit', ['id'=>$holiday_event->holiday_event_id]), false, 'fa-edit', false);

					$button .= '<a class="btn btn-xs dark" rel="tooltip" data-original-title="'.__('button.deactivate').'" onclick="deleteHoliday('. $holiday_event->holiday_event_id .')"><i class="fa fa-times"></i></a>';
				}
				else {
					$button .= '<a class="btn btn-xs default" rel="tooltip" data-original-title="'.__('button.activate').'" onclick="activateHoliday('. $holiday_event->holiday_event_id .')"><i class="fa fa-check"></i></a>';
				}

				return $button;
			})->make(true);
		}

		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"HolidayEventController",null,null,"Datatables load master holiday event");

		return view("admin.master.holiday_event.list", compact('holiday_event'));
	}

	public function create(){
		$holiday_event = new MasterHolidayEvent;
		$holiday_date = date('d/m/Y');
// $categories = MasterHearingEvent::all();

		return view("admin.master.holiday_event.create", compact('holiday_event', 'holiday_date'));
	}

	public function edit($id){
		if($id){
			$holiday_event = MasterHolidayEvent::find($id);
			$holiday_date = date('d/m/Y', strtotime($holiday_event->holiday_date));
// $categories = MasterHearingEvent::all();

			return view("admin.master.holiday_event.create", compact('holiday_event', 'holiday_date'));
		}
	}

	public function view(Request $request, $id){
		if($id){
			$holiday_event = MasterHolidayEvent::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,3,"HolidayEventController",null,null,"View master holiday event ".$id);
			return view('admin.master.holiday_event.viewModal',compact('holiday_event'), ['id' => $id])->render();
		}	
	}

	public function delete(Request $request, $id){
		if($id){
			$holiday_event = MasterHolidayEvent::find($id);
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"HolidayEventController",null,null,"Delete master holiday event ".$id);
			$holiday_event->is_active = 0;
			$holiday_event->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function activate(Request $request, $id){
		if($id){
			$holiday_event = MasterHolidayEvent::find($id);
			$holiday_event->is_active = 1;
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,5,"HolidayEventController",null,null,"Edit master holiday event ".$id);
			$holiday_event->save();

			return Response::json(['status' => 'ok']);
		}
		return Response::json(['status' => 'fail']);
	}

	public function store(Request $request){

		$validator = Validator::make($request->all(), $this->rules_insert());

		if($request->holiday_event_id == NULL){

			if($validator->passes()){

				$holiday_event = DB::table('master_holiday_event')->insertGetId([
					'holiday_event_name_my' => $request->holiday_event_name_my,
					'holiday_event_name_en' => $request->holiday_event_name_en,
					'holiday_date' => Carbon::createFromFormat('d/m/Y', $request->holiday_date)->toDateTimeString(),
					'created_by_user_id' => Auth::id()
				]);
				$audit = new \App\Http\Controllers\Admin\AuditController;
                $audit->add($request,4,"HolidayEventController",json_encode($request->input()),null,"Master Holiday Event ".$holiday_event." - Create holiday event");

				return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			} else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);               
			}
		}
	}

	public function update(Request $request){

		$validator = Validator::make($request->all(), $this->rules_update());

		if($request->holiday_event_id != NULL){

			if($validator->passes()){

				$holiday_event = MasterHolidayEvent::find($request->holiday_event_id)->update([
					'holiday_event_name_my' => $request->holiday_event_name_my,
					'holiday_event_name_en' => $request->holiday_event_name_en,
					'holiday_date' => Carbon::createFromFormat('d/m/Y', $request->holiday_date)->toDateTimeString(),
				]);
				$audit = new \App\Http\Controllers\Admin\AuditController;
            	$audit->add($request,5,"HolidayEventController",null,null,"Edit master holiday event ".$request->holiday_event_id);
				return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
			}else{
				return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
			}
		}
	}
}
