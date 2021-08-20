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
use App\CaseModel\ClaimCase;
use App\MasterModel\MasterMonth;

use App\ViewModel\ViewReport5;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report5Controller extends Controller
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

        $userid = Auth::id();
        $user = User::find($userid);
        $states = MasterState::pluck('state_name', 'state_id');

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        return view('report/report5/modalFind', compact('years', 'months', 'states'));

    }

    public function view(Request $request)
    {
        $states = MasterState::all();

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');
        $day = $request->day ?? '';

        $report5 = ViewReport5::whereBetween('filing_date', [$date_start, $date_end]);

        if ($state_id != '') {
            $report5->where('state_id', $state_id);
        }
        
        $report5 = $report5->get();

        return view('report/report5/view', compact('states', 'date_start', 'date_end', 'report5', 'day'));
    }

    public function export(Request $request)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $states = MasterState::all();
        $day = $request->day;
        $year = $request->year;
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;

        $report5 = ViewReport5::where('year', $year);

        if ($month)
            $report5->where('month', $request->month);

        $report5 = $report5->get();

        if ($request->format == 'pdf') {
            $this->data['report5'] = $report5;
            $this->data['states'] = $states;
            $this->data['month'] = $month;
            $this->data['year'] = $year;
            $this->data['day'] = $day;
            $this->data['user'] = $user;
            $this->data['userid'] = $userid;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report5/printreport5', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan5.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report5_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.total_claim_finish')) . ' ' . $day . ' ' . strtoupper(__('new.day')) . ' ' . strtoupper(__('new.from_start_hearing_date')) . ' ' . $year . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('D2', strtoupper(__('new.total_finish_before') . ' ' . $day . ' ' . __('new.day')));
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('E2', strtoupper(__('new.total_finish_after') . ' ' . $day . ' ' . __('new.day')));
            $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $index => $state) {

                $case_state = (clone $report5)->where('state_id', $state->state_id);
                $case_completed_before = (clone $case_state)->where('days_completed', '<=', $day);
                $case_completed_after = (clone $case_state)->where('days_completed', '>=', $day);

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)$case_state->count(),
                    (string)count($case_completed_before),
                    (string)count($case_completed_after)
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $case_completed_before = (clone $report5)->where('days_completed', '<=', $day);
            $case_completed_after = (clone $report5)->where('days_completed', '>=', $day);

            //

            $total = [
                '',
                '',
                (string)count($report5),
                (string)count($case_completed_before),
                (string)count($case_completed_after)
            ];

            $percentage = [
                '',
                '',
                '100.00%',
                (string)(count($report5) > 0 ? number_format(count($case_completed_before) / count($report5) * 100, 2, '.', '') : '0.00') . '%',
                (string)(count($report5) != 0 ? number_format(count($case_completed_after) / count($report5) * 100, 2, '.', '') : '0.00') . '%'
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;
            $row_percentage = $num_rows + $total_row + 2;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);
            $objPHPExcel->getActiveSheet()->fromArray($percentage, NULL, 'A' . $row_percentage);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_percentage . ':B' . $row_percentage);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_percentage, strtoupper(__('new.percentage')));

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

            $tmp_file = storage_path('tmp/report5_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }


    }

}
