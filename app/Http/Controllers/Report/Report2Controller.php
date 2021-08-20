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
use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\CaseModel\Form3;
use App\CaseModel\Form4;

use App\ViewModel\ViewReport2;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report2Controller extends Controller
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

        return view('report/report2/modalFind', compact('years', 'months'));
    }

    public function listSolution(Request $request)
    {
        $state_id = $request->state_id;
        $year = $request->year;
        $month = $request->month;
        $solution = $request->solution;

        return view('report/report2/modalListSolution', compact('state_id', 'year', 'month', 'solution'));
    }

    public function dataSolution(Request $request)
    {
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $request->year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }

        if ($request->month && $request->month != 0) {
            $case = ClaimCase::whereDate('created_at', '>=', $request->year . '-' . $request->month . '-01')->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01')->where('case_status_id', '>', 1);
        } else {
            $case = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1);
        }

        $case->whereHas('branch', function ($branch) use ($request) {
            return $branch->where('branch_state_id', $request->state_id);
        });

        if ($request->solution == 'stop_notice') {
            $case->whereHas('stop_notice', function ($stop_notice) use ($request) {
                return $stop_notice->where('form_status_id', 27);
            });
        } elseif ($request->solution == 'revoked') {
            $case->whereHas('form4_latest' . form4, function ($form4_latest) use ($request) {
                $case->whereHas('form4_latest.form4', function ($form4_latest) use ($request) {
                    return $form4_latest->where('hearing_position_id', 6);
                });
            });
        } elseif ($request->solution == 'canceled') {
            $case->whereHas('form4_latest.form4', function ($form4_latest) use ($request) {
                return $form4_latest->where('hearing_position_id', 4);
            });
        } elseif ($request->solution == 'f6') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('award_type', 6);
            });
        } elseif ($request->solution == 'f9') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('award_type', 9);
            });
        } elseif ($request->solution == 'f5') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('award_type', 5);
            });
        } elseif ($request->solution == 'f7') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('award_type', 7);
            });
        } elseif ($request->solution == 'f8') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('award_type', 8);
            });
        } elseif ($request->solution == 'f10') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('f10_type_id', 2);
            });
        } elseif ($request->solution == 'f10t') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('f10_type_id', 3);
            });
        } elseif ($request->solution == 'f10k') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('f10_type_id', 1);
            });
        } elseif ($request->solution == 'f10b') {
            $case->whereHas('form4_latest.form4.award', function ($award) use ($request) {
                return $award->where('f10_type_id', 4);
            });
        }

        $datatables = Datatables::of($case);

        return $datatables
            ->editColumn('case_no', function ($case) {
                return "<a class='btn btn-sm btn-primary' href='" . route('claimcase-view', [$case->claim_case_id]) . "'><i class='fa fa-search'></i> " . $case->case_no . "</a>";
            })->make(true);

    }

    public function list(Request $request)
    {
        $state_id = $request->state_id;
        $year = $request->year;
        $month = $request->month;

        return view('report/report2/modalListBalance', compact('state_id', 'year', 'month'));
    }

    public function data(Request $request)
    {

        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $request->year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }

        if ($request->month && $request->month != 0) {
            $case = ClaimCase::whereDate('created_at', '>=', $request->year . '-' . $request->month . '-01')->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01')->where('case_status_id', '<', 8);
        } else {
            $case = ClaimCase::whereYear('created_at', $request->year)->whereBetween('case_status_id', [2, 7]);
        }


        $case->whereHas('branch', function ($branch) use ($request) {
            return $branch->where('branch_state_id', $request->state_id);
        });


        $datatables = Datatables::of($case);

        return $datatables
            ->editColumn('case_no', function ($case) {
                return "<a class='btn btn-sm btn-primary' href='" . route('claimcase-view', [$case->claim_case_id]) . "'><i class='fa fa-search'></i> " . $case->case_no . "</a>";
            })->make(true);

    }

    public function view(Request $request)
    {

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $states = MasterState::orderBy('state_id', 'asc')->get();

        if ($month)
            $report2 = ViewReport2::where('year', $year)->where('month', $month->month_id)->get();
        else
            $report2 = ViewReport2::where('year', $year)->get();

        // dd($report2);

        return view('report/report2/view', compact('states', 'year', 'month', 'report2'));

    }

    protected function calcPercentage($total, $val)
    {
        if ($total == 0)
            return "0.0%";

        else {
            return (string)number_format($val / $total * 100, 1, '.', '') . "%";
        }
    }

    public function export(Request $request)
    {

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $states = MasterState::orderBy('state_id', 'asc')->get();

        if ($month)
            $report2 = ViewReport2::where('year', $year)->where('month', $month->month_id)->get();
        else
            $report2 = ViewReport2::where('year', $year)->get();

        if ($request->format == 'pdf') {
            $this->data['report2'] = $report2;
            $this->data['states'] = $states;
            $this->data['month'] = $month;
            $this->data['year'] = $year;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report2/printreport2', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan1.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report2_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.report2_1')) . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.year')) . ' ' . $year . ' ' . strtoupper(__('new.report2_2')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $index => $state) {

                // $report = null;
                // foreach($report2 as $rep) {
                //     if($rep->state_id == $state->state_id) {
                //         $report = $rep;
                //         break;
                //     }
                // }

                $report = (clone $report2)->where('state_id', $state->state_id);

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    $report ? (string)$report->sum('register') : '0',
                    $report ? (string)$report->sum('b') : '0',
                    $report ? (string)$report->sum('p') : '0',
                    $report ? (string)$report->sum('f2') : '0',
                    $report ? (string)$report->sum('f3') : '0',
                    $report ? (string)$report->sum('f11') : '0',
                    $report ? (string)$report->sum('f12') : '0',
                    $report ? (string)$report->sum('stop_notice') : '0',
                    $report ? (string)$report->sum('revoked') : '0',
                    $report ? (string)$report->sum('canceled') : '0',
                    $report ? (string)$report->sum('f6') : '0',
                    $report ? (string)$report->sum('f9') : '0',
                    $report ? (string)$report->sum('f5') : '0',
                    $report ? (string)$report->sum('f7') : '0',
                    $report ? (string)$report->sum('f8') : '0',
                    $report ? (string)$report->sum('f10') : '0',
                    $report ? (string)$report->sum('f10k') : '0',
                    $report ? (string)$report->sum('f10t') : '0',
                    $report ? (string)$report->sum('f10b') : '0',
                    $report ? (string)$report->sum('complete') : '0',
                    $report ? (string)$report->sum('balance') : '0'
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = [
                '',
                '',
                (string)$report2->sum('register'),
                (string)$report2->sum('b'),
                (string)$report2->sum('p'),
                (string)$report2->sum('f2'),
                (string)$report2->sum('f3'),
                (string)$report2->sum('f11'),
                (string)$report2->sum('f12'),
                (string)$report2->sum('stop_notice'),
                (string)$report2->sum('revoked'),
                (string)$report2->sum('canceled'),
                (string)$report2->sum('f6'),
                (string)$report2->sum('f9'),
                (string)$report2->sum('f5'),
                (string)$report2->sum('f7'),
                (string)$report2->sum('f8'),
                (string)$report2->sum('f10'),
                (string)$report2->sum('f10k'),
                (string)$report2->sum('f10t'),
                (string)$report2->sum('f10b'),
                (string)$report2->sum('complete'),
                (string)$report2->sum('balance')
            ];

            $percentage = [
                '',
                '',
                '100%',
                $this->calcPercentage($report2->sum('register'), $report2->sum('b')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('p')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f2')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f3')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f11')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f12')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('stop_notice')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('revoked')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('canceled')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f6')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f9')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f5')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f7')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f8')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f10')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f10k')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f10t')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('f10b')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('complete')),
                $this->calcPercentage($report2->sum('register'), $report2->sum('balance'))
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;
            $row_percent = $num_rows + $total_row + 2;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);
            $objPHPExcel->getActiveSheet()->fromArray($percentage, NULL, 'A' . $row_percent);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_percent . ':B' . $row_percent);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_percent, strtoupper(__('new.percentage')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report2_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}

