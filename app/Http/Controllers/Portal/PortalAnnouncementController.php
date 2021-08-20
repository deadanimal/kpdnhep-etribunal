<?php

namespace App\Http\Controllers\Portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\PortalModel\PortalAnnouncement;
use App;
use Auth;
use DB;
use Carbon\Carbon;

class PortalAnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    protected function rules_insert(){

        $rules = [ 
                    'title_en' => 'required',
                    'title_my' => 'required',
                    'description_en' => 'required',
                    'description_my' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required'
                   
                ];

        return $rules;
    }

    protected function rules_update(){

        $rules = [ 
                    'title_en' => 'required',
                    'title_my' => 'required',
                    'description_en' => 'required',
                    'description_my' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required'
                ];

        return $rules;
    }

    public function index(Request $request){

        $status = [
            '1' => __('new.active'),
            '2' => __('new.inactive')
        ];

        $years = range(date('Y'), 2000);
        $months = cal_info(0)['abbrevmonths'];

    	if ($request->ajax()) {

    		$announcement = PortalAnnouncement::orderBy('created_at', 'desc');
            if($request->has('status') && !empty($request->status)) {
                    
                if($request->status == 1) { //Active
                    $announcement = $announcement->whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today()->subDay());
                } else {
                    $announcement = $announcement->whereDate('start_date', '>', Carbon::today())->orWhereDate('end_date', '<', Carbon::today()->subDay());
                }
            }
            
            // $announcement = $announcement->get();

            if ($request->has('status') || $request->has('year') || $request->has('month')) {

                // if($request->has('status') && !empty($request->status)) 
                //     $announcement = $announcement->filter(function ($value) use ($request) {
                //         return $value->status == $request->status;
                //     });

                if($request->has('year') && !empty($request->year)) 
                    $announcement->whereYear('created_at', $request->year);
                    // $announcement = $announcement->filter(function ($value) use ($request) {
                    //     return date('Y', strtotime($value->created_at)) == $request->year;
                    // });

                if($request->has('month') && !empty($request->month)) 
                    $announcement->whereMonth('created_at', $request->month);
                    // $announcement = $announcement->filter(function ($value) use ($request) {
                    //     return date('m', strtotime($value->created_at)) == $request->month;
                    // });
            }

            $datatables = Datatables::of($announcement);

            return $datatables
                ->editColumn('title', function ($announcement) {
                    $locale = App::getLocale();
                    $title_lang = 'title_'.$locale;
                    return $announcement->$title_lang;
                })->editColumn('created_by', function ($announcement) {
                    return $announcement->created_by->name;
                })->editColumn('created_at', function ($announcement) {
                    return Carbon::parse($announcement->created_at)->format('d/m/Y');
                })->editColumn('start_date', function ($announcement) {
                    return Carbon::parse($announcement->start_date)->format('d/m/Y');
                })->editColumn('end_date', function ($announcement) {
                    return $announcement->end_date == "2100-12-31" ? "-" : Carbon::parse($announcement->end_date)->format('d/m/Y');
                })->editColumn('action', function ($announcement) {
                    $button = "";

                    $button .= '<a value="' . route('cms.announcement.view', $announcement->portal_announcement_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    $button .= actionButton('green-meadow', __('button.edit'), route('cms.announcement.edit', ['id'=>$announcement->portal_announcement_id]), false, 'fa-edit', false);

                    $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="'.__('button.delete').'" onclick="deleteAnnouncement('. $announcement->portal_announcement_id .')"><i class="fa fa-trash-o"></i></a>';

                    return $button;
                })->make(true);
        }
    	return view("portal.announcement.list", compact('status', 'years', 'months'));
    }

    public function create(){
        $announcement = new PortalAnnouncement;
        $start_date = date('d/m/Y');
        $end_date = date('d/m/Y'); 
    	return view("portal.announcement.create", compact('announcement', 'start_date', 'end_date'));
    }

    public function edit($id){
    	if($id){
	    	$announcement = PortalAnnouncement::find($id);
            $start_date = date('d/m/Y', strtotime($announcement->start_date));
            $end_date = date('d/m/Y', strtotime($announcement->end_date));
	    	return view("portal.announcement.create", compact('announcement', 'start_date', 'end_date'));
    	}
    }

    public function view(Request $request, $id){
    	if($id){
    		$announcement = PortalAnnouncement::find($id);
    		return view('portal.announcement.viewModal',compact('announcement'), ['id' => $id])->render();
        }	
    }

    public function delete(Request $request, $id){
        if($id){
        	$announcement = PortalAnnouncement::find($id)->delete();
            return Response::json(['status' => 'ok']);
        }
        return Response::json(['status' => 'fail']);
    }

    public function store(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_insert());

    	if($request->portal_announcement_id == NULL){

    		if($validator->passes()){

                $portal_announcement_id = DB::table('portal_announcement')->insertGetId([
                        'title_en' => $request->title_en,
                        'description_en' => $request->description_en,
                        'title_my' => $request->title_my,
                        'description_my' => $request->description_my,
                        'start_date' => $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : NULL,
                        'end_date' => $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString() : NULL,
                        'created_by_user_id' => Auth::id()
                    ]);

    			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }

    public function update(Request $request){

    	$validator = Validator::make($request->all(), $this->rules_update());

    	if($request->portal_announcement_id != NULL){

    		if($validator->passes()){

                $announcement = PortalAnnouncement::find($request->portal_announcement_id)->update([
                        'title_en' => $request->title_en,
                        'description_en' => $request->description_en,
                        'title_my' => $request->title_my,
                        'description_my' => $request->description_my,
                        'announcement_type_id' => $request->announcement_type_id,
                        'start_date' => $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateTimeString() : NULL,
                        'end_date' => $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateTimeString() : NULL
                    ]);
    			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);
    		}else{
    			return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
    		}
    	}
    }
}
