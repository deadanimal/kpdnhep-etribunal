<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterInquiryMethod;
use App\MasterModel\MasterClaimClassification;
use App\CaseModel\Inquiry;
use App\MasterModel\MasterClaimCategory;
use App\CaseModel\ClaimCase;

use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Style_Alignment;

class Report30Controller extends Controller
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
         $states = MasterState::pluck('state_name', 'state_id');


         return view('report/report30/modalFind', compact('years','months','states'));
        
    }
    
    public function view(Request $request){

        $years = range(date('Y'), 2000);
        $months = MasterMonth::orderBy('month_id', 'asc')->get();
        $states = MasterState::orderBy('state_id', 'asc')->get();

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        if( $request->month == 12){
            $next_month = 1;
            $next_year = $year+1;
        }
        else{
            $next_month = $request->month + 1;
            $next_year = $year;
        }
        
        if ($month)
            $claimcases = ClaimCase::whereDate('created_at', '>=', $request->year.'-'.$request->month.'-01')->whereDate('created_at', '<', $next_year.'-'.$next_month.'-01')->where('case_status_id', '>', 1);
        else
            $claimcases = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1);

        return view("report.report30.view", compact ('years', 'months', 'states', 'claimcases', 'year', 'month'));
    }

    public function export(Request $request){

        $years = range(date('Y'), 2000);
        $months = MasterMonth::orderBy('month_id', 'asc')->get();
        $states = MasterState::orderBy('state_id', 'asc')->get();

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        if( $request->month == 12){
            $next_month = 1;
            $next_year = $year+1;
        }
        else{
            $next_month = $request->month + 1;
            $next_year = $year;
        }
        
        if ($month)
            $claimcases = ClaimCase::whereDate('created_at', '>=', $request->year.'-'.$request->month.'-01')->whereDate('created_at', '<', $next_year.'-'.$next_month.'-01')->where('case_status_id', '>', 1);
        else
            $claimcases = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1);

        if($request->format == 'pdf') {
            $this->data['months'] = $months;
            $this->data['month'] = $month;
            $this->data['states'] = $states;
            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['next_month'] = $next_month;
            $this->data['next_year'] = $next_year;
            $this->data['claimcases'] = $claimcases;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report30/printreport30', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan30.pdf');
        }

        else if($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = "month_".$locale;
            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report30_'.App::getLocale().'.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')).'
'.strtoupper(__('new.report30')).' '.strtoupper(__('new.on')).' '.( $month ? strtoupper(__('new.month')).' '.strtoupper($month->$month_lang) : '' ).' '.strtoupper(__('new.year')).' '.$year.'
'.strtoupper(__('new.at_2').' '.__('new.at_hq')).'
'.'( '.strtoupper(__('new.until')).' '.date('d/m/Y').' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);



            /////////// Data
            foreach( $states as $index => $state ) {

                $case_state =(clone $claimcases)->get()->where('state_id', $state->state_id);
                $online_counter_state = (clone $claimcases)->whereRaw('claim_case.created_by_user_id = claim_case.claimant_user_id')->get()->where('state_id', $state->state_id);
                $online_notcounter_state = (clone $claimcases)->whereRaw('claim_case.created_by_user_id != claim_case.claimant_user_id')->get()->where('state_id', $state->state_id);

                $online_counter = (clone $claimcases)->whereRaw('claim_case.created_by_user_id = claim_case.claimant_user_id')->get();
                $online_notcounter = (clone $claimcases)->whereRaw('claim_case.created_by_user_id != claim_case.claimant_user_id')->get();

                $data = [
                    ($index+1).'. ',
                    $state->state_name,
                    (string) count($case_state),
                    (string) count($online_counter_state),
                    (string) count($online_notcounter_state)
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A'.($num_rows + $index + 1));
            }

            $total = [
                '',
                '',
                (string) count($claimcases->get()),
                (string) count($online_counter),
                (string) count($online_notcounter)
            ];

            $percentage = [
                '',
                '',
                (string) (count($claimcases->get()) != 0 ? 100.00 : 0.00)."%",
                (string) (count($claimcases->get()) != 0 ? number_format ( count($online_counter)/count($claimcases->get())*100, 2,'.','') : 0.00).'%' ,
                (string) (count($claimcases->get()) != 0 ? number_format ( count($online_notcounter)/count($claimcases->get())*100, 2,'.','') : 0.00).'%'
            ];

            //dd($total);

            $row_total = $num_rows+$total_row+1;
            $row_percentage = $num_rows+$total_row+2;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A'.$row_total);
            $objPHPExcel->getActiveSheet()->fromArray($percentage, NULL, 'A'.$row_percentage);

            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row_total.':B'.$row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_total, strtoupper(__('new.total')));

            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row_percentage.':B'.$row_percentage);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_percentage, strtoupper(__('new.percentage')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' . 
                'E' . 
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report30_'.uniqid().'.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
            
        }

    }


}
