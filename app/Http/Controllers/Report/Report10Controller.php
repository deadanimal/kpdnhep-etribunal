<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

//use App\SupportModel\Recordcall;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterInquiryMethod;
use App\CaseModel\Inquiry;

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

class Report10Controller extends Controller
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

    public function list ( Request $request ){

        $state_id = $request->state_id;
        $year = $request->year;
        $month_id = $request->month_id;

        return view('report/report10/modalList', compact('state_id', 'year', 'month_id'));
        
    }

    public function data ( Request $request ){ 

       
        $inquiries = Inquiry::whereYear('created_at', $request->year)->whereMonth('created_at', $request->month_id)->where('inquiry_method_id', 5)->get()->where('state_id', $request->state_id);

        $datatables = Datatables::of($inquiries);

        return $datatables
        ->editColumn('inquiry_no', function ($inquiries) {
            return '<a value="' . route('inquiry.view', $inquiries->inquiry_id) . '" data-toggle="modal" class="btn btn-sm blue btnModalPeranan" ><i class="fa fa-search"></i> '.$inquiries->inquiry_no.'</a>';

        })->make(true);
        
    }
    
    public function view(Request $request){

        $years = range(date('Y'), 2000);
        $months = MasterMonth::orderBy('month_id')->get();
        $year = $request->year ? $request->year : date('Y');
        $state = $request->state ? $request->state : 0;


        if( !$request->has('state') ) {
            return redirect()->route('report10-view', ['state' => Auth::user()->ttpm_data->branch->branch_state_id]);
        }


        $states_list = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();

        if( $request->state && $request->state > 0 ){
            $states = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();
        }
        else {
            $states = MasterState::orderBy('state_id', 'asc')->get();
        }
       
        $inquiries = Inquiry::whereYear('created_at', $year)->where('inquiry_method_id', 5);
        //dd($inquiries);
        //dd($year);

        return view("report.report10.view", compact ('states','state', 'inquiries', 'years', 'months', 'year', 'states_list'));
    }

    public function export(Request $request){

        $years = range(date('Y'), 2000);
        $months = MasterMonth::orderBy('month_id')->get();
        $year = $request->year ? $request->year : date('Y');
        $state = $request->state ? $request->state : 0;

        if( !$request->has('state') ) {
            return redirect()->route('report10-view', ['state' => Auth::user()->ttpm_data->branch->branch_state_id]);
        }

        $states_list = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();

        if( $request->state && $request->state > 0 ){
            $states = MasterState::where('state_id', Auth::user()->ttpm_data->branch->branch_state_id)->orderBy('state_id', 'asc')->get();
        }
        else {
            $states = MasterState::orderBy('state_id', 'asc')->get();
        }
       
        $inquiries = Inquiry::whereYear('created_at', $year)->where('inquiry_method_id', 5);

        if($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['state'] = $state;
            $this->data['months'] = $months;
            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['states_list'] = $states_list;
            $this->data['inquiries'] = $inquiries;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report10/printreport10', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan10.pdf');
        }

        else if($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_'.$locale;

            $total_row = $months->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report10_'.App::getLocale().'.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            //CompanyName column
            //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            //States column
            $col = 'A';
            foreach($states as $state) {
                $col++;
                $objPHPExcel->getActiveSheet()->SetCellValue($col.'2', strtoupper($state->state_name));
                if(request()->state == 0) {
                    $objPHPExcel->getActiveSheet()->getStyle($col.'2')->getAlignment()->setTextRotation(90)->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }
                
            }
            if(request()->state == 0) {
                //Total column
                $col++;
                $objPHPExcel->getActiveSheet()->SetCellValue($col.'2', strtoupper(__('new.total')));
                $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }


            /////////// Title
            $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$col.'1');
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')).'
'.strtoupper(__('new.record_entry_call').' '.__('new.year')).' '.$year.'
'.'( '.strtoupper(__('new.until')).' '.date('d/m/Y').' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $total_state = 0;

            /////////// Data
            foreach( $months as $index => $month ) {

                $inquiry_month = (clone $inquiries)->whereMonth('created_at', $month->month_id)->get();

                $data = array(
                    $month->$month_lang
                );

                foreach ($states as $state) {
                    $inquiry_state = (clone $inquiry_month)->where('state_id', $state->state_id);
                    $total_state += count($inquiry_state);
                    array_push($data, (string) count($inquiry_state));
                }

                if(request()->state == 0)
                    array_push($data, (string) count($inquiry_month));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A'.($num_rows + $index + 1));
            }

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' . 
                $col . 
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objPHPExcel->getActiveSheet()
                ->getStyle('B3:'.$col.$objPHPExcel->getActiveSheet()->getHighestRow())
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report10_'.uniqid().'.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
            
        }

    }

}
