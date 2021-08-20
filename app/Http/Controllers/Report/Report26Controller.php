<?php

namespace App\Http\Controllers\Report;

use App;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterMonth;
use App\ViewModel\ViewReport26;
use Auth;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;

class Report26Controller extends Controller
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


    public function view(Request $request)
    {
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month ? MasterMonth::find($request->month) : null;

        $report26 = ViewReport26::select(['branch',DB::raw('sum(noncitizen) noncitizen')])
            ->where('year', $year);

        if ($month) {
            $report26->where('month', $month->month_id);
        }

        $report26 = $report26->groupBy('branch')->get();

        return view("report.report26.view", compact('years', 'months', 'year', 'month', 'report26'));
    }

    public function export(Request $request)
    {

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month ? MasterMonth::find($request->month) : null;


        if ($month) {
            $report26 = ViewReport26::where('year', $year)->where('month', $month->month_id)->get();
        } else {
            $report26 = ViewReport26::where('year', $year)->get();
        }


        if ($request->format == 'pdf') {
            $this->data['report26'] = $report26;
            $this->data['month'] = $month;
            $this->data['months'] = $months;
            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report26/printreport26', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan26.pdf');
        } else if ($request->format == 'excel') {

            $total_row = $report26->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report26_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.report26')) . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.year')) . ' ' . $year);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($report26 as $index => $report) {

                $data = [
                    $report->branch,
                    $report->country,
                    (string)$report->noncitizen
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $total = [
                '',
                '',
                (string)$report26->sum('noncitizen')
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

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

            $tmp_file = storage_path('tmp/report26_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
