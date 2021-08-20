<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\RoleUser;
use App\User;
use App\UserPublic;
use App\MasterModel\MasterMonth;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\CaseModel\Form4;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report21Controller extends Controller
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

        return view('report/report21/modalFind', compact('years', 'months'));
    }

    public function view(Request $request)
    {
        $presidents = RoleUser::with(['user'])
            ->where('role_id', 4)
            ->get()
            ->where('user.user_status_id', 1);

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;

        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $year;
        }

        if ($month) {
            $form4 = Form4::whereDate('created_at', '>=', $year . '-' . $request->month . '-01')
                ->where('hearing_position_reason_id', 4)
                ->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01');
        } else {
            $form4 = Form4::whereYear('created_at', $year)
                ->where('hearing_position_reason_id', 4);
        }

        return view('report/report21/view', compact('presidents', 'year', 'month', 'form4'));
    }

    public function export(Request $request)
    {
        $presidents = RoleUser::with(['user'])->where('role_id', 4)->get()->where('user.user_status_id', 1);

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $year;
        }

        if ($month)
            $form4 = Form4::whereDate('created_at', '>=', $year . '-' . $request->month . '-01')->where('hearing_position_reason_id', 4)->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01');
        else
            $form4 = Form4::whereYear('created_at', $year)->where('hearing_position_reason_id', 4);

        if ($request->format == 'pdf') {
            $this->data['presidents'] = $presidents;
            $this->data['form4'] = $form4;
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            $this->data['next_month'] = $next_month;
            $this->data['next_year'] = $next_year;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report21/printreport21', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan21.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = "month_" . $locale;

            $total_row = 0;

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report21_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.total_result_year')) . ' ' . strtoupper(__('new.year')) . ' ' . $year . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $total_prez = 0;

            /////////// Data
            foreach ($presidents as $index => $president) {

                $form4_prez = (clone $form4)->where('president_user_id', $president->user_id)->get();
                $total_prez += count($form4_prez);

                $data = [
                    ($total_row + 1) . '. ',
                    strtoupper($president->user->name),
                    (string)count($form4_prez)
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $total_row + 1));

                $total_row++;
            }

            $total = [
                '',
                '',
                (string)$total_prez
            ];

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

            $tmp_file = storage_path('tmp/report21_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
        }
    }
}
