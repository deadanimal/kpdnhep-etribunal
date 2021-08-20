<?php

namespace App\Http\Controllers\Report;

use App\MasterModel\MasterState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\RoleUser;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterHearingRoom;
use App\HearingModel\Hearing;

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

class Report19Controller extends Controller
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

        return view('report/report19/modalFind', compact('years','months','states'));
        
    }

    public function view (Request $request){
        $branches = MasterBranch::where('is_active', 1)->get();
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

        $rooms = MasterHearingRoom::whereNotNull('hearing_venue_id')->where('is_active', 1)->get();
        $presidents = RoleUser::where('role_id',4)->get()->filter(function($query){
            return $query->user->user_status_id == 1;
        });

        if($month)
            $hearing = Hearing::whereDate('hearing_date', '>=' ,$year.'-'.$request->$month.'-01')->whereDate('hearing_date', '<', $next_year.'-'.$next_month.'-01')->get();
        else
            $hearing = Hearing::whereYear('hearing_date', $year)->get();

        if($request->has('branch') && !empty($request->branch))
            $rooms = $rooms->filter(function ($value) use ($request) {
                return $value->venue->branch_id == $request->branch;
            });

        return view('report/report19/view', compact('year', 'month', 'rooms', 'presidents', 'hearing', 'branches'));
        
    }

    public function export(Request $request){

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

        $rooms = MasterHearingRoom::whereNotNull('hearing_venue_id')->where('is_active', 1)->get();
        $presidents = RoleUser::where('role_id',4)->get()->filter(function($query){
            return $query->user->user_status_id == 1;
        });

        if($month)
            $hearing = Hearing::whereDate('hearing_date', '>=' ,$year.'-'.$request->$month.'-01')->whereDate('hearing_date', '<', $next_year.'-'.$next_month.'-01')->get();
        else
            $hearing = Hearing::whereYear('hearing_date', $year)->get();


        if($request->format == 'pdf') {
            $this->data['rooms'] = $rooms;
            $this->data['presidents'] = $presidents;
            $this->data['hearing'] = $hearing;
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            $this->data['next_month'] = $next_month;
            $this->data['next_year'] = $next_year;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report19/printreport19', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan19.pdf');
        }

        else if($request->format == 'excel') {

            $total_row = $rooms->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report19_'.App::getLocale().'.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            //CompanyName column
            //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            //States column
            $col = 'C';
            foreach ($presidents as $prez) {
                if( $prez->user->ttpm_data )
                    if( $prez->user->ttpm_data->president )
                        if( $prez->user->ttpm_data->president->president_code ) {
                            $objPHPExcel->getActiveSheet()->SetCellValue($col.'2', strtoupper($prez->user->ttpm_data->president->president_code));
                            //$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                            $col++;
                        }
            }
            //Total column
            $objPHPExcel->getActiveSheet()->SetCellValue($col.'2', strtoupper(__('new.total')));
            //$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);


            /////////// Title
            $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$col.'1');
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')).'
'.strtoupper(__('new.ttpm_assmbly')).' '.( $month ? strtoupper(__('new.month')).' '.strtoupper($month->$month_lang) : '' ).' '.strtoupper(__('new.year')).' '.$year.'
'.'( '.strtoupper(__('new.until')).' '.date('d/m/Y').' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach( $rooms as $index => $room ) {

                $data = array(
                    ($index+1).'. ',
                    $room->venue->hearing_venue.' - '.$room->hearing_room
                );

                foreach ($presidents as $prez) {
                    $hearing_room = (clone $hearing)->where('hearing_room_id', $room->hearing_room_id);
                    $hearing_prez = (clone $hearing_room)->where('president_user_id', $prez->user_id);
                    array_push($data, (string) count($hearing_prez));
                }
                array_push($data, (string) count($hearing_room));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A'.($num_rows + $index + 1));
            }

            //

            $total = array('','');
            foreach ($presidents as $prez) {
                $prez = (clone $hearing)->where('president_user_id', $prez->user_id);
                array_push($total, (string) count($prez));
            }
            array_push($total, (string) count($hearing));

            //dd($total);

            $row_total = $num_rows+$total_row+1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A'.$row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row_total.':B'.$row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' . 
                $col . 
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objPHPExcel->getActiveSheet()
                ->getStyle('C3:'.$col.$objPHPExcel->getActiveSheet()->getHighestRow())
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report19_'.uniqid().'.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
            
        }

    }

}
