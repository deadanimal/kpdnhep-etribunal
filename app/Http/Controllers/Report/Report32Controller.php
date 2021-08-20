<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\CaseModel\Form3;
use App\CaseModel\Form4;

use Auth;
use DB;
use App;
use PDF;

class Report32Controller extends Controller
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

    public function filter (){

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        return view('report/report32/modalFind', compact('years','months'));
        
    }
    public function view (Request $request){

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null; 
        $states = MasterState::orderBy('state_id', 'asc')->get();
        if( $request->month == 12){
            $next_month = 1;
            $next_year = $year+1;
        }
        else{
            $next_month = $request->month + 1;
            $next_year = $year;
        } 

        if($month) {
           
            $cases = Claimcase::whereDate('created_at', '>=', $request->year.'-'.$request->month.'-01')->whereDate('created_at', '<', $next_year.'-'.$next_month.'-01')->where('case_status_id', '>', 1);
        }
        else {
            $cases = Claimcase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1);
        }


        return view('report/report32/view', compact('states', 'year', 'month', 'cases'));
        
    }

    public function export(Request $request){

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null; 
        $states = MasterState::orderBy('state_id', 'asc')->get();
        if( $request->month == 12){
            $next_month = 1;
            $next_year = $year+1;
        }
        else{
            $next_month = $request->month + 1;
            $next_year = $year;
        } 

        if($month) {
           
            $cases = Claimcase::whereDate('created_at', '>=', $request->year.'-'.$request->month.'-01')->whereDate('created_at', '<', $next_year.'-'.$next_month.'-01')->where('case_status_id', '>', 1);
        }
        else {
            $cases = Claimcase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1);
        }

        if($request->format == 'pdf') {
            $this->data['month'] = $month;
            $this->data['states'] = $states;
            $this->data['year'] = $year;
            $this->data['next_month'] = $next_month;
            $this->data['next_year'] = $next_year;
            $this->data['cases'] = $cases;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report32/printreport32', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan32.pdf');
        }

    }


}
