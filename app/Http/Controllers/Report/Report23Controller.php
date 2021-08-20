<?php

namespace App\Http\Controllers\Report;

use App\ViewModel\ViewReport232019;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\ViewModel\ViewReport23;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
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

class Report23Controller extends Controller
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

    public function filter()
    {
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report23/modalFind', compact('states', 'years', 'months'));
    }

    public function view(Request $request)
    {
        $states = MasterState::orderBy('state_id', 'asc')
            ->get();
        $months = MasterMonth::all();
        $years = range(date('Y'), 2000);

        $state_id = $request->state_id ?? '';
        $year = $request->year ?? date('Y');
        $month = $request->month ?? null;
//        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
//        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $report23 = ViewReport23::where('year', $year)
            ->groupBy('year', 'month', 'state_id');

        if ($month != null) {
            $report23->where('month', $month);
        }

        if ($state_id != '') {
            $report23->where('state_id', $state_id);
        }

        $report23 = $report23->get();

//        dd($report23);

        $final_data = [];
        $template = [
            1 => ['d' => 0, 's' => 0, 't' => 0],
            2 => ['d' => 0, 's' => 0, 't' => 0],
            3 => ['d' => 0, 's' => 0, 't' => 0],
            4 => ['d' => 0, 's' => 0, 't' => 0],
            5 => ['d' => 0, 's' => 0, 't' => 0],
            6 => ['d' => 0, 's' => 0, 't' => 0],
            7 => ['d' => 0, 's' => 0, 't' => 0],
            8 => ['d' => 0, 's' => 0, 't' => 0],
            9 => ['d' => 0, 's' => 0, 't' => 0],
            10 => ['d' => 0, 's' => 0, 't' => 0],
            11 => ['d' => 0, 's' => 0, 't' => 0],
            12 => ['d' => 0, 's' => 0, 't' => 0],
            13 => ['d' => 0, 's' => 0, 't' => 0],
        ];

        $template_state = [];
//        $final_data = $template;
//        $final_data_month = $template;


        foreach ($states as $i => $state) {
            $template_state[$state->state_id] = [];
            $final_data[$state->state_id] = $template;
        }

        $final_data['17'] = $template;

        foreach ($report23 as $report) {
//            dd($report);
            if (!isset($final_data[$report->state_id])) {
                $final_data[$report->state_id] = $template;
            }

            $final_data[$report->state_id][$report->month]['d'] += $report->total_filed;
            $final_data[$report->state_id][13]['d'] += $report->total_filed;
            $final_data[$report->state_id][$report->month]['s'] += $report->total_completed;
            $final_data[$report->state_id][13]['s'] += $report->total_completed;
//            $final_data[$report->state_id][$report->month]['t'] += $report->total_unfinished;
//            $final_data[$report->state_id][13]['t'] += $report->total_unfinished;

            $final_data[17][$report->month]['d'] += $report->total_filed;
            $final_data[17][13]['d'] += $report->total_filed;
            $final_data[17][$report->month]['s'] += $report->total_completed;
            $final_data[17][13]['s'] += $report->total_completed;

        }

        ksort($final_data);

//        dd($final_data);

        return view("report.report23.view", compact('states', 'report23', 'date_start', 'date_end',
            'state_id', 'final_data', 'final_data_month', 'months', 'year', 'month'));
    }


    public function export(Request $request)
    {

        $months = MasterMonth::orderBy('month_id', 'asc')->get();
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $report23 = ViewReport23::where('year', $year);

        if ($month)
            $report23 = $report23->where('month', $month->month_id);

        $report23 = $report23->get();

        if ($request->format == 'pdf') {
            $this->data['months'] = $months;
            $this->data['month'] = $month;
            $this->data['states'] = $states;
            $this->data['year'] = $year;
            $this->data['report23'] = $report23;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report23/printreport23', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan23.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = "month_" . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report23_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.report23') . ' ' . __('new.on')) . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.year')) . ' ' . $year . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $i => $state) {

                $claimcase_filed = (clone $report23)->where('state_id', $state->state_id);

                $data = array($state->state_name);

                foreach ($months as $index => $month) {
                    $claimcase_filed_month = (clone $claimcase_filed)->where('month', $month->month_id);

                    array_push($data, (string)$claimcase_filed_month->sum('total_filed'), (string)$claimcase_filed_month->sum('total_completed'));
                }

                array_push($data, (string)$claimcase_filed->sum('total_filed'), (string)$claimcase_filed->sum('total_completed'));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $i + 1));
            }

            $total = array(__('new.total'));

            foreach ($months as $index => $month) {
                $claimcase_filed = (clone $report23)->where('month', $month->month_id);

                array_push($total, (string)$claimcase_filed->sum('total_filed'), (string)$claimcase_filed->sum('total_completed'));
            }
            array_push($total, (string)$report23->sum('total_filed'), (string)$report23->sum('total_completed'));

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'AA' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report23_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }


    }


}
