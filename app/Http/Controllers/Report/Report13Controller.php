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
use App\MasterModel\MasterState;
use App\SupportModel\RecordSeminar;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report13Controller extends Controller
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

        $states = MasterState::all();
        $record_seminar = RecordSeminar::with('state')->where('year', $request->year ? $request->year : date('Y'));
        $years = range(date('Y'), 2000);
        $year = $request->year ? $request->year : date('Y');
        
        return view("report.report13.view", compact ('states', 'record_seminar', 'years', 'year'));
    }


    public function update(Request $request) {

        //dd($request->input());

        $states = MasterState::all();

        foreach($states as $state) {
        if($request->has("seminar_".$state->state_id) || "participant_".$state->state_id ) {
        
            $state_id = $state->state_id;
            $seminar = "seminar_".$state->state_id;
            $participant = "participant_".$state->state_id;

                RecordSeminar::updateOrCreate(
                    ['year' => $request->year, 'state_id' => $state->state_id],
                    ['total_seminar' =>$request->$seminar, 'total_participant' => $request->$participant, 'modified_by_user_id' => Auth::id()]
                );
            }
        }
        

        return Response::json(['status' => 'ok']);
        
    }

    public function export(Request $request){

        $states = MasterState::all();
        $record_seminar = RecordSeminar::with('state')->where('year', $request->year ? $request->year : date('Y'));
        $years = range(date('Y'), 2000);
        $year = $request->year ? $request->year : date('Y');

        if($request->format == 'pdf') {
            $this->data['record_seminar'] = $record_seminar;
            $this->data['states'] = $states;
            $this->data['years'] = $years;
            $this->data['year'] = $year;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report13/printreport13', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan13.pdf');
        }
        else if($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_'.$locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report13_'.App::getLocale().'.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')).'
'.strtoupper(__('new.record_seminar')).' '.strtoupper(__('new.year')).' '.$year);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach( $states as $index => $state ) {

                $val = (clone $record_seminar)->where('state_id', $state->state_id);

                $data = [
                    $state->state_name,
                    (string) $val->get()->count() > 0 ?  $val->first()->total_seminar : '0',
                    (string) $val->get()->count() > 0 ?  $val->first()->total_participant : '0'
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A'.($num_rows + $index + 1));
            }

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' . 
                'C' . 
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report13_'.uniqid().'.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
            
        }

    }


}
