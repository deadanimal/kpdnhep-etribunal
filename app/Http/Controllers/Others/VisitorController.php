<?php 

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Exception;
use Carbon\Carbon;
use App\SupportModel\Visitor;
use App\MasterModel\MasterBranch;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Datatables;
use URL;
use App;

/**
*  visitor controller
*  @author MJMZ <mjazli.unijaya@gmail.com>
*/
class VisitorController extends Controller {
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }

	public function index(Request $request) 
	{
		if( !Auth::user()->hasRole('user') && !$request->has('branch') ) {
            return redirect()->route('listing.visitor', ['branch' => Auth::user()->ttpm_data->branch_id]);
        }

		$branches = MasterBranch::where('is_active',1)->orderBy('branch_id','desc')->get();
		
		$visitor = Visitor::whereNull('deleted_at');

		if ($request->has('branch') || ($request->has('start_date') && $request->has('end_date'))) {

			if($request->has('start_date') && !empty($request->start_date) && $request->has('end_date') && !empty($request->end_date)) 
                $visitor = $visitor->whereDate('visitor_datetime', '>=', Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString())->whereDate('visitor_datetime', '<=', Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString());

            if($request->has('branch') && !empty($request->branch))
            	$visitor->whereHas('psu', function ($psu) use ($request) {
                    return $psu->whereHas('ttpm_data', function ($ttpm_data) use ($request) {
                        return $ttpm_data->where('branch_id', $request->branch);
                    });
                });
            	// $visitor = $visitor->filter(function ($value) use ($request) {
                //     return $value->psu->ttpm_data->branch_id == $request->branch;
                // });
        }


		$datatables = Datatables::of($visitor);
				
		if ($request->ajax()) {
		
			return $datatables
					->editColumn('visitor_datetime', function ($visitor) {
						return Carbon::parse($visitor->visitor_datetime)->format('d/m/Y H:i A');
					})
	                ->editColumn('visitor_name', function ($visitor) {
	                    return $visitor->visitor_name;
	                })
	                ->editColumn('visitor_reason_id', function ($visitor) {
	                    $locale = App::getLocale();
	                    $reason_lang = "reason_".$locale;
                    	return $visitor->reason->$reason_lang;
	                })
					->addColumn('action', function ($visitor) {

					$button = "";

                    $button .= '<a value="' . route('listing.visitor.view',$visitor->visitor_id) . '" rel="tooltip" data-original-title="'.__('button.view').'" data-toggle="modal" class="btn btn-xs blue btnModalPeranan" ><i class="fa fa-search"></i></a>';

                    $button .= actionButton('green-meadow', __('button.edit'), route('listing.visitor.edit', ['id'=>$visitor->visitor_id]), false, 'fa-edit', false);
                    
                    $button .= '<a class="btn btn-xs btn-danger" rel="tooltip" data-original-title="'.__('button.delete').'" onclick="deleteVisitor('. $visitor->visitor_id .')"><i class="fa fa-trash-o"></i></a>';


						return $button;
					})
					->make(true);
		}
		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,12,"VisitorController",null,null,"Datatables load visitor");
		return view('others.visitor.list', compact('branches'));
	}

	public function edit($id) {
		$visitor = Visitor::find($id);
		return view("others.visitor.edit", compact('visitor'));
	}

	public function view(Request $request, $id)
	{
		$visitor = Visitor::find($id);
		$audit = new \App\Http\Controllers\Admin\AuditController;
        $audit->add($request,3,"VisitorController",null,null,"View visitor ".$id);
		return view("others.visitor.viewModal", compact('visitor'));
	}

	public function create()
	{
		
		return view('others.visitor.create');
	}

	public function updateVisitor(Request $request) {

		$rules = [
					'identification_no' => 'required|string',
					'name' => 'required|string',
					'visit_reason_id' => 'required|integer',
					'visit_datetime' => 'required|string'
				];

		// if($request->identity_type == 2)
		// 	$rules['country_id'] = 'required|integer';

		$validator = Validator::make( $request->all(), $rules );
		if(!$validator->passes()){
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }
		
		DB::beginTransaction();

		try {

			// validation later
			
			$visitor = Visitor::find($request->visitor_id);
			// if($request->identity_type == 2)
			// 	$visitor->country_id = $request->input('country_id');
			// else
				$visitor->country_id = 129;

			$visitor->visitor_identification_no = $request->input('identification_no');
			$visitor->visitor_name = $request->input('name');
			$visitor->visitor_reason_id = $request->input('visit_reason_id');
			$visitor->visitor_remarks = $request->remarks ? $request->remarks : null;
			$visitor->visitor_datetime = $request->visit_datetime ? Carbon::createFromFormat('d/m/Y H:i A', $request->visit_datetime)->toDateTimeString() : Carbon::now();
			$visitor->psu_user_id = Auth::id();
			$visitor->save();
			$audit = new \App\Http\Controllers\Admin\AuditController;
        	$audit->add($request,5,"VisitorController",null,null,"Update visitor ".$request->visitor_id);
			DB::commit();
			//return Redirect()->action('VisitorController@index')->with('flash_success', 'success');
			return Response::json(['status' => 'ok', 'message' => __('new.update_success')]);

		} catch (Exception $e) {
			DB::rollback();
			//return Redirect()->back()->with('flash_error', $e->getMessage() )->withInput($request->all());
			return Response::json(['status' => 'fail', 'message' => $e->getMessage()]);
		}

	}

	public function store(Request $request) {

		$rules = [
					'identification_no' => 'required|string',
					'name' => 'required|string',
					'visit_reason_id' => 'required|integer',
					'visit_datetime' => 'required|string'
				];

		// if($request->identity_type == 2)
		// 	$rules['country_id'] = 'required|integer';

		$validator = Validator::make( $request->all(), $rules );
		if(!$validator->passes()){
            return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
        }


		DB::beginTransaction();

		try {		

			$visitor = new Visitor;

			// if($request->identity_type == 2)
			// 	$visitor->country_id = $request->input('country_id');
			// else
				$visitor->country_id = 129;

			$visitor->visitor_identification_no = $request->input('identification_no');
			$visitor->visitor_name = $request->input('name');
			$visitor->visitor_reason_id = $request->input('visit_reason_id');
			$visitor->visitor_remarks = $request->remarks ? $request->remarks : null;
			$visitor->visitor_datetime = $request->visit_datetime ? Carbon::createFromFormat('d/m/Y H:i A', $request->visit_datetime)->toDateTimeString() : Carbon::now();
			$visitor->psu_user_id = Auth::id();
			$visitor->save();
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,4,"VisitorController",json_encode($request->input()),null,"Visitor ".$visitor->visitor_id." - Create visitor");

			DB::commit();
			//return Redirect()->action('VisitorController@index')->with('flash_success', 'success');
			return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
			
		} catch (Exception $e) {
			DB::rollback();
			//return Redirect()->back()->with('flash_error', $e->getMessage() )->withInput($request->all());
			return Response::json(['status' => 'fail', 'message' => $e->getMessage()]);
		}

	}

	public function destroyVisitor(Request $request, $id) {
		
		DB::beginTransaction();

		try {

			Visitor::find($id)->delete();
			$audit = new \App\Http\Controllers\Admin\AuditController;
            $audit->add($request,6,"VisitorController",null,null,"Delete visitor ". $id);
			DB::commit();
			return Response::json(['status' => 'ok']);
			
		} catch (Exception $e) {
			DB::rollback();
			return Response::json(['status' => 'fail']);
		}
	}

}