<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\SupportModel\RecordBrochure;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;

use Auth;
use DB;
use App;
use PDF;

class Report12Controller extends Controller
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
    
    public function view(Request $request){


        //$masterstates = MasterState::all();
        $recordbrochures = RecordBrochure::with('state')->where('year', $request->year ? $request->year : date('Y'));
        $years = range(date('Y'), 2000);
        $months = MasterMonth::orderBy('month_id')->get();
        $year = $request->year ? $request->year : date('Y');
        $state = $request->state ? $request->state : 0;

         if( !$request->has('state') ) {
            return redirect()->route('report12-view', ['state' => Auth::user()->ttpm_data->branch->branch_state_id]);
        }


        $states_list = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();

        if( $request->state && $request->state > 0 ){
            $states = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();
        }
        else {
            $states = MasterState::orderBy('state_id', 'asc')->get();
        }

        
        
        return view("report.report12.view", compact ('masterstates', 'recordbrochures', 'years', 'months', 'year', 'states_list', 'states'));
    }


    public function update(Request $request) {

        //dd($request->input());

        $months = MasterMonth::all();

        if($request->state == 0 )
            $states = MasterState::all();
        else
            $states = MasterState::where('state_id', $request->states);


            foreach($states as $index => $state) {

                $data = array();

                foreach($months as $index => $month) {
                    $x = 'record_'.$state->state_id.'_'.$index;
                    $data[ strtolower($month->month_en) ] = (int) $request->$x ;
                }
                //dd($data);

               RecordBrochure::updateOrCreate(
                    ['year' => $request->year, 'state_id' => $state->state_id],
                    $data
                );
                
            }
        

        return Response::json(['status' => 'ok']);
        
    }

    public function export(Request $request){

        
        $recordbrochures = RecordBrochure::with('state')->where('year', $request->year ? $request->year : date('Y'));
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $year = $request->year ? $request->year : date('Y');  
        if( $request->state && $request->state > 0 ){
            $states = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();
        }
        else {
            $states = MasterState::orderBy('state_id', 'asc')->get();
        }  

        if($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['recordbrochures'] = $recordbrochures;
            $this->data['months'] = $months;
            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report12/printreport12', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan12.pdf');
        }

    }

}
