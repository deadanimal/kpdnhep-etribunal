<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\StopNotice;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\ViewModel\ViewReport25;
use Auth;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;
use Yajra\Datatables\Datatables;

class Report25Controller extends Controller
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

        return view('report/report25/modalFind', compact('years', 'months', 'states'));
    }

    public function list(Request $request)
    {
        $state_id = $request->state_id;
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month ? $request->month : null;

        return view('report/report25/modalList', compact('state_id', 'year', 'month'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @throws \Exception
     */
    public function data(Request $request)
    {
        if ($request->month && $request->month != 0) {
            $stop_notice = StopNotice::with(['case'])->whereHas('case.form1', function ($form1) use ($request) {
                return $form1->whereYear('filing_date', $request->year)->whereMonth('filing_date', $request->month);
                // return $case->whereDate('created_at', '>=', $request->year.'-'.$request->month.'-01')->whereDate('created_at', '<', $next_year.'-'.$next_month.'-01');
            });
        } else {
            $stop_notice = StopNotice::with(['case'])->whereHas('case.form1', function ($form1) use ($request) {
                return $form1->whereYear('filing_date', $request->year);
            });
        }

        $stop_notice->whereHas('case.branch', function ($branch) use ($request) {
            return $branch->where('branch_state_id', $request->state_id);
        });

        $datatables = Datatables::of($stop_notice->groupBy('claim_case_id'));

        return $datatables
            ->editColumn('case_no', function ($stop_notice) {
                return "<a class='btn btn-sm btn-primary' href='" . route('stopnotice-view', [$stop_notice->stop_notice_id]) . "'><i class='fa fa-search'></i> " . $stop_notice->case->case_no . "</a>";
            })->make(true);

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request)
    {
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $states = MasterState::all();

        $report25 = self::query($month, $year);

        return view('report/report25/view', compact('year', 'month', 'states', 'report25'));

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|void
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function export(Request $request)
    {
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $states = MasterState::all();

        $report25 = self::query($month, $year);

        if ($request->format == 'pdf') {
            $this->data['report25'] = $report25;
            $this->data['month'] = $month;
            $this->data['states'] = $states;
            $this->data['year'] = $year;
            $this->data['request'] = $request;

            $pdf = PDF::loadView('report/report25/printreport25', $this->data)->setOrientation('landscape');
            $pdf->setOption('enable-javascript', true);

            return $pdf->download('Laporan25.pdf');
        } else if ($request->format == 'excel') {
            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report25_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal'))
                . ' ' . strtoupper(__('new.report2_1')) . ' ' . ($month ? strtoupper(__('new.month'))
                    . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.year'))
                . ' ' . $year . ' ' . strtoupper(__('new.report25')) . ' ' . '( ' . strtoupper(__('new.until'))
                . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);


            /////////// Data
            foreach ($states as $index => $state) {
                $report = null;

                foreach ($report25 as $rep) {
                    if (strtolower($rep->state) == strtolower($state->state)) {
                        $report = $rep;
                        break;
                    }
                }

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)$report ? $report->register : '0',
                    (string)$report ? $report->revoked_stopnotice : '0',
                    (string)$report ? $report->award5 : '0',
                    (string)$report ? $report->award6 : '0',
                    (string)$report ? $report->award7 : '0',
                    (string)$report ? $report->award8 : '0',
                    (string)$report ? $report->award9 : '0',
                    (string)$report ? $report->award10 : '0',
                    (string)$report ? $report->total : '0',
                    (string)$report ? $report->balance : '0'
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $total = [
                '',
                '',
                (string)$report25->sum('register'),
                (string)$report25->sum('revoked_stopnotice'),
                (string)$report25->sum('award5'),
                (string)$report25->sum('award6'),
                (string)$report25->sum('award7'),
                (string)$report25->sum('award8'),
                (string)$report25->sum('award9'),
                (string)$report25->sum('award10'),
                (string)$report25->sum('total'),
                (string)$report25->sum('balance')
            ];

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'L' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report25_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }
        return;
    }

    /**
     * @param $month
     * @param $year
     * @return \App\ViewModel\ViewReport25[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query($month, $year)
    {
        if ($month) {
            return ViewReport25::where('year', $year)
                ->where('month', $month->month_id)
                ->get();
        }

        return ViewReport25::where('year', $year)
            ->get();
    }

}
