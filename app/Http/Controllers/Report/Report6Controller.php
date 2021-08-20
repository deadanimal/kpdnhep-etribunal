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
use App\CaseModel\Form2;
use App\CaseModel\ClaimCase;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report6Controller extends Controller
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

        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report6/modalFind', compact('years', 'months', 'states'));
    }

    public function view(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $states = MasterState::all();

        $case = ClaimCase::whereBetween('created_at', [$date_start, $date_end])
            ->where('case_status_id', '>', 1);
        $form2 = Form2::whereBetween('filing_date', [$date_start, $date_end])
            ->where('form_status_id', 22);


        if ($state_id != '') {
            $case->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });

            $form2->whereHas('form1', function ($f1) use ($state_id) {
                $f1->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $case = $case->get();
        $form2 = $form2->get();

        return view('report/report6/view', compact('states', 'month', 'year', 'form2', 'case', 'date_start', 'date_end', 'state_id'));

    }

    public function export(Request $request)
    {

        $userid = Auth::id();
        $user = User::find($userid);
        $year = $request->year;
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $states = MasterState::all();
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $year;
        }

        if ($month) {
            $case = ClaimCase::whereYear('created_at', '>=', $request->year . '-' . $request->month . '-01')->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01')->where('case_status_id', '>', 1)->get();
            $form2 = Form2::whereYear('filing_date', '>=', $request->year)->whereDate('filing_date', '<', $next_year . '-' . $next_month . '-01')->where('form_status_id', 22)->get();
        } else {
            $case = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1)->get();
            $form2 = Form2::whereYear('filing_date', $request->year)->where('form_status_id', 22)->get();
        }
        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['month'] = $month;
            $this->data['year'] = $year;
            $this->data['userid'] = $userid;
            $this->data['user'] = $user;
            $this->data['case'] = $case;
            $this->data['form2'] = $form2;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report6/printreport6', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan6.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report6_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.total_f2_year')) . ' ' . $year . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $total_percentage = 0;

            /////////// Data
            foreach ($states as $index => $state) {

                $case_state = (clone $case)->where('state_id', $state->state_id);
                $form2_state = (clone $form2)->where('state_id', $state->state_id);
                if ((count($case) * 2 + count($form2)) != 0)
                    $percentage = number_format((count($case_state) * 2 + count($form2_state)) / (count($case) * 2 + count($form2)) * 100, 2, '.', '');
                else
                    $percentage = 0.00;

                $total_percentage += $percentage;

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)count($case_state),
                    (string)count($case_state),
                    (string)count($form2_state),
                    (string)$percentage
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = [
                '',
                '',
                (string)count($case),
                (string)count($case),
                (string)count($form2),
                (string)$total_percentage
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'F' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report6_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }

    public function show(Request $request)
    {
        $date_start = $request->date_start ?? date('Y-m-d');
        $date_end = $request->date_end ?? date('Y-m-d');
        $state_id = $request->state_id ?? '';
        return view('report/report6/modallist', compact('date_start', 'date_end', 'state_id'));
    }

    public function data(Request $request)
    {
        $date_start = $request->date_start
            ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString()
            : date('Y-m-d');
        $date_end = $request->date_end
            ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString()
            : date('Y-m-d');
        $state_id = $request->state_id ?? '';

        $case = ClaimCase::
            whereBetween('created_at', [$date_start, $date_end])
            ->where('case_status_id', '>', 1);
        if (!empty($state_id)) {
            $case->whereHas('branch', function ($branch) use ($state_id) {
                return $branch->where('branch_state_id', $state_id);
            });
        }

        $datatables = Datatables::of($case);

        return $datatables
            ->editColumn('case_no', function ($case) {
                return "<a class='btn btn-sm btn-primary' target='_blank'><i class='fa fa-search'></i> " . $case->case_no . "</a>";
            })
            ->make(true);
    }

}
