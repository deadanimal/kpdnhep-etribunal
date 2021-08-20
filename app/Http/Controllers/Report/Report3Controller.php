<?php

namespace App\Http\Controllers\Report;

use App\MasterModel\MasterBranch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\CaseModel\Form3;
use App\CaseModel\Form12;
use App\CaseModel\ClaimCase;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;

use Auth;
use DB;
use App;
use PDF;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report3Controller extends Controller
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

        return view('report/report3/modalFind', compact('years', 'months', 'states'));

    }

    public function list1(Request $request)
    {

        $state_id = $request->state_id;
        $year = $request->year;
        $month = $request->month;
        $date_start = $request->date_start
            ? $request->date_start
            : date('Y-m-d');
        $date_end = $request->date_end
            ? $request->date_end
            : date('Y-m-d');
        return view('report/report3/modalList', compact('state_id', 'year', 'month', 'date_start', 'date_end'));

    }

    public function data1(Request $request)
    {
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $request->year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        // if ($request->month && $request->month != 0) {
        //     $form1 = Form1::whereDate('filing_date', '>=', $request->year . '-' . $request->month . '-01')->whereDate('filing_date', '<', $next_year . '-' . $next_month . '-01')->where('form_status_id', 17)->get();
        if ($date_start && $date_end) {
            $form1 = Form1::
            whereBetween('created_at', [$date_start, $date_end])
                ->where('form_status_id', 17)
                ->get();
        } else {
            $form1 = Form1::
            // whereYear('filing_date', $request->year)->
            where('form_status_id', 17)
                ->get();
        }

        $form1 = $form1->where('state_id', $request->state_id);

        $datatables = Datatables::of($form1);

        return $datatables
            ->editColumn('case_no', function ($form1) {
                return "<a class='btn btn-sm btn-primary' href='" . route('form1-view', [$form1->form1_id]) . "' target='_blank'><i class='fa fa-search'></i> " . $form1->case->case_no . "</a>";
            })->make(true);

    }

    public function list2(Request $request)
    {
        $state_id = $request->state_id;
        $year = $request->year;
        $month = $request->month;
        $date_start = $request->date_start
            ? $request->date_start
            : date('Y-m-d');
        $date_end = $request->date_end
            ? $request->date_end
            : date('Y-m-d');
        return view('report/report3/modalList2', compact('state_id', 'year', 'month', 'date_start', 'date_end'));

    }

    public function data2(Request $request)
    {
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $request->year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        // if ($request->month && $request->month != 0) {
        //     $form2 = Form2::whereDate('filing_date', '>=', $request->year . '-' . $request->month . '-01')->whereDate('filing_date', '<', $next_year . '-' . $next_month . '-01')->where('form_status_id', 22)->get();
        if ($date_start && $date_end) {
            $form2 = Form2::
            whereBetween('created_at', [$date_start, $date_end])
                ->where('form_status_id', 22)
                ->get();
        } else {
            $form2 = Form2::
            // whereYear('filing_date', $request->year)->
            where('form_status_id', 22)
                ->get();
        }

        $form2 = $form2->where('state_id', $request->state_id);

        $datatables = Datatables::of($form2);

        return $datatables
            ->editColumn('case_no', function ($form2) {
                return "<a class='btn btn-sm btn-primary' href='" . route('form2-view', [$form2->form2_id]) . "' target='_blank'><i class='fa fa-search'></i> " . $form2->form1->case->case_no . "</a>";
            })->make(true);

    }

    public function list3(Request $request)
    {

        $state_id = $request->state_id;
        $year = $request->year;
        $month = $request->month;
        $date_start = $request->date_start
            ? $request->date_start
            : date('Y-m-d');
        $date_end = $request->date_end
            ? $request->date_end
            : date('Y-m-d');
        return view('report/report3/modalList3', compact('state_id', 'year', 'month', 'date_start', 'date_end'));

    }

    public function data3(Request $request)
    {
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $request->year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        // if ($request->month && $request->month != 0) {
        //     $form3 = Form3::whereDate('filing_date', '>=', $request->year . '-' . $request->month . '-01')->whereDate('filing_date', '<', $next_year . '-' . $next_month . '-01')->where('form_status_id', 46)->get();
        if ($date_start && $date_end) {
            $form3 = Form3::
            whereBetween('created_at', [$date_start, $date_end])
                ->where('form_status_id', 46)
                ->get();
        } else {
            $form3 = Form3::
            // whereYear('filing_date', $request->year)->
            where('form_status_id', 46)
                ->get();
        }


        $form3 = $form3->where('state_id', $request->state_id);

        $datatables = Datatables::of($form3);

        return $datatables
            ->editColumn('case_no', function ($form3) {
                return "<a class='btn btn-sm btn-primary' href='" . route('form3-view', [$form3->form3_id]) . "' target='_blank'><i class='fa fa-search'></i> " . $form3->form2->form1->case->case_no . "</a>";
            })->make(true);

    }

    public function list12(Request $request)
    {

        $state_id = $request->state_id;
        $year = $request->year;
        $month = $request->month;
        $date_start = $request->date_start
            ? $request->date_start
            : date('Y-m-d');
        $date_end = $request->date_end
            ? $request->date_end
            : date('Y-m-d');
        return view('report/report3/modalList12', compact('state_id', 'year', 'month', 'date_start', 'date_end'));

    }

    public function data12(Request $request)
    {

        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $request->year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        // if ($request->month && $request->month != 0) {
        //     $form12 = Form12::whereDate('filing_date', '>=', $request->year . '-' . $request->month . '-01')->whereDate('filing_date', '<', $next_year . '-' . $next_month . '-01')->get();
        if ($date_start && $date_end) {
            $form12 = Form12::
            whereBetween('created_at', [$date_start, $date_end])
                ->get();
        } else {
            $form12 = Form12::
            // whereYear('filing_date', $request->year)->
            get();
        }


        $form12 = $form12->where('state_id', $request->state_id);

        $datatables = Datatables::of($form12);

        return $datatables
            ->editColumn('case_no', function ($form12) {
                return "<a class='btn btn-sm btn-primary' href='" . route('form12-view', [$form12->form12_id]) . "' target='_blank'><i class='fa fa-search'></i> " . $form12->form4->case->case_no . "</a>";
            })->make(true);

    }

    public function view(Request $request)
    {
        $states = MasterState::all();

        $state_id = $request->state_id ?? '';
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $form1 = ClaimCase::with(['form1'])
            ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->whereBetween('form1.filing_date', [$date_start, $date_end])
            ->where('case_status_id', '>', 1)
            ->orderBy('case_year', 'asc')
            ->orderBy('case_sequence', 'desc');
//            ->orderBy('form1.filing_date', 'asc');
//        whereHas('form1', function ($form1) use ($date_start, $date_end) {
//            $form1->whereBetween('filing_date', [$date_start, $date_end])
//                ->where('form_status_id', 17);
//        });

        $form2 = Form2::whereBetween('filing_date', [$date_start, $date_end])
            ->where('form_status_id', 22);

        $form3 = Form3::whereBetween('filing_date', [$date_start, $date_end])
            ->where('form_status_id', 46);

        $form12 = Form12::whereBetween('filing_date', [$date_start, $date_end]);

        if ($state_id != '') {
            $form1->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });

            $form2->whereHas('form1', function ($f1) use ($state_id) {
                $f1->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });

            $form3->whereHas('form2', function ($f2) use ($state_id) {
                $f2->whereHas('form1', function ($f1) use ($state_id) {
                    $f1->whereHas('case', function ($cc) use ($state_id) {
                        $cc->whereHas('branch', function ($q) use ($state_id) {
                            $q->where('branch_state_id', $state_id);
                        });
                    });
                });
            });

            $form12->whereHas('form4', function ($f4) use ($state_id) {
                $f4->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $form1 = $form1->get();
        $form2 = $form2->get();
        $form3 = $form3->get();
        $form12 = $form12->get();

        $case = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1)->get();

        return view('report/report3/view', compact('states', 'year', 'month', 'form1', 'form2', 'form3', 'case', 'form12', 'state_id'));
    }

    public function export(Request $request)
    {
        $states = MasterState::all();

        $state_id = $request->state_id ?? '';
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $form1 = ClaimCase::whereHas('form1', function ($form1) use ($date_start, $date_end) {
            $form1->whereBetween('filing_date', [$date_start, $date_end])
                ->where('form_status_id', 17);
        });

        $form2 = Form2::whereBetween('filing_date', [$date_start, $date_end])
            ->where('form_status_id', 22);

        $form3 = Form3::whereBetween('filing_date', [$date_start, $date_end])
            ->where('form_status_id', 46);

        $form12 = Form12::whereBetween('filing_date', [$date_start, $date_end]);

        if ($state_id != '') {
            $form1->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });

            $form2->whereHas('form1', function ($f1) use ($state_id) {
                $f1->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });

            $form3->whereHas('form2', function ($f2) use ($state_id) {
                $f2->whereHas('form1', function ($f1) use ($state_id) {
                    $f1->whereHas('case', function ($cc) use ($state_id) {
                        $cc->whereHas('branch', function ($q) use ($state_id) {
                            $q->where('branch_state_id', $state_id);
                        });
                    });
                });
            });

            $form12->whereHas('form4', function ($f4) use ($state_id) {
                $f4->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $form1 = $form1->get();
        $form2 = $form2->get();
        $form3 = $form3->get();
        $form12 = $form12->get();

        $case = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1)->get();

        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['month'] = $month;
            $this->data['year'] = $year;
            $this->data['form1'] = $form1;
            $this->data['form2'] = $form2;
            $this->data['form3'] = $form3;
            $this->data['form12'] = $form12;
            $this->data['case'] = $case;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report3/printreport3', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan3.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report3_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.claim_filing')) . ' ' . $year . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.at_2')) . ' ' . strtoupper(__('new.at_hq')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('G2', strtoupper(__('new.filing_year') . ' ' . $year));
            $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $index => $state) {

                $form1_state = (clone $form1)->where('state_id', $state->state_id);
                $form2_state = (clone $form2)->where('state_id', $state->state_id);
                $form3_state = (clone $form3)->where('state_id', $state->state_id);
                $form12_state = (clone $form12)->where('state_id', $state->state_id);
                $case_state = (clone $case)->where('state_id', $state->state_id);

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)count($form1_state),
                    (string)count($form2_state),
                    (string)count($form3_state),
                    (string)count($form12_state),
                    (string)count($case_state),
                    (string)(count($case) > 0 ? (number_format(count($case_state) / count($case) * 100, 2, '.', '')) : 0.00)
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = [
                '',
                '',
                (string)count($form1),
                (string)count($form2),
                (string)count($form3),
                (string)count($form12),
                (string)count($case),
                (string)(count($case) > 0 ? 100.00 : 0.00)
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'H' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report3_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
