<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\CaseModel\ClaimCase;
use App\ViewModel\ViewReport17;
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

class Report17Controller extends Controller
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
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report17/modalFind', compact('years', 'states'));
    }

    public function view(Request $request)
    {
        $states = MasterState::all();
        $state_list = MasterState::pluck('state_name', 'state_id');
        $months = MasterMonth::all();
        $years = range(date('Y'), 2000);

        $state_id = $request->state_id ?? '';
//        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
//        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');
        $year = $request->year ?: date('Y'); // currect year as fallback

        $report17 = ViewReport17::select([
            'year', 'month',
//            DB::raw('month(processed_at) as month'),
            'state_id',
            DB::raw('sum(b) b'),
            DB::raw('sum(p) p'),
        ])
            ->where('year', $year)
            ->groupBy('year', 'month', 'state_id');

        if ($state_id != '') {
            $report17->where('state_id', $state_id);
        }

        $report17 = $report17->get();

        $template_data = ['p' => 0, 'b' => 0, 'total' => 0];

        $template_states = array_merge(range(0, 16));
        unset($template_states[0]);

        foreach ($template_states as $k => $template_state) {
            $template_states[$k] = $template_data;
        }

        $template_states['total'] = $template_data;

        $template_months = array_merge(range(0, 12));
        unset($template_months[0]);

        foreach ($template_months as $k => $template_month) {
            $template_months[$k] = $template_states;
        }

        $template_months['total'] = $template_states;

        foreach ($report17 as $datum) {
            $template_months[$datum->month][$datum->state_id]['p'] = $datum->p ?? 0;
            $template_months[$datum->month][$datum->state_id]['b'] = $datum->b ?? 0;

            $total = $template_months[$datum->month][$datum->state_id]['p'] + $template_months[$datum->month][$datum->state_id]['b'];

            $template_months[$datum->month][$datum->state_id]['total'] = $total;

            $template_months[$datum->month]['total']['p'] += $datum->p ?? 0;
            $template_months[$datum->month]['total']['b'] += $datum->b ?? 0;
            $template_months[$datum->month]['total']['total'] += $total;

            $template_months['total'][$datum->state_id]['p'] += $datum->p ?? 0;
            $template_months['total'][$datum->state_id]['b'] += $datum->b ?? 0;
            $template_months['total'][$datum->state_id]['total'] += $total;

            $template_months['total']['total']['p'] += $datum->p ?? 0;
            $template_months['total']['total']['b'] += $datum->b ?? 0;
            $template_months['total']['total']['total'] += $total;
        }

        return view('report/report17/view', compact('states', 'case', 'months', 'report17',
            'date_start', 'date_end', 'state_id', 'state_list', 'template_months', 'years','year'));
    }

    public function export(Request $request)
    {

        $states = MasterState::all();
        $year = $request->year ? $request->year : date('Y');
        $months = MasterMonth::all();
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;

        if ($month)
            $report17 = ViewReport17::where('year', $year)->where('month', $month->month_id)->get();
        else
            $report17 = ViewReport17::where('year', $year)->get();


        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['month'] = $month;
            $this->data['months'] = $months;
            $this->data['year'] = $year;
            $this->data['report17'] = $report17;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report17/printreport17', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan17.pdf');
        } else if ($request->format == 'excel') {

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report17_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.classification_filed') . ' ' . __('new.on_year') . ' ' . $year) . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->month_lang) : '') . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $i => $state) {

                $report = (clone $report17)->where('state_id', $state->state_id);

                $data = array(($i + 1) . '. ', $state->state_name);

                foreach ($months as $index => $month) {
                    $report_month = (clone $report)->where('month', $month->month_id);

                    array_push($data, (string)$report_month->sum('b'), (string)$report_month->sum('p'));
                }

                array_push($data, (string)$report->sum('b'), (string)$report->sum('p'));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $i + 1));
            }

            $total = array('', '');

            foreach ($months as $index => $month) {
                $report_month = (clone $report17)->where('month', $month->month_id);

                array_push($total, (string)$report_month->sum('b'), (string)$report_month->sum('p'));
            }
            array_push($total, (string)$report17->sum('b'), (string)$report17->sum('p'));

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'AB' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report17_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }

    public function ddModal(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $solution = $request->solution;
        $classification_id = $request->classification_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        return view('report/report16/ddModal', compact('state_id', 'month', 'solution',
            'date_start', 'date_end', 'classification_id'));
    }

    public function dd(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $solution = $request->solution;
        $classification_id = $request->classification_id ?? '';
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $case = ClaimCase::whereBetween('created_at', [$date_start, $date_end])
            ->where('case_status_id', '>', 1);

        if ($state_id != '') {
            $case->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });
        }

        if ($classification_id != '') {
            $case->whereHas('form1', function ($q) use ($classification_id) {
                $q->where('claim_classification_id', $classification_id);
            });
        }

        $datatables = Datatables::of($case);

        return $datatables
            ->editColumn('case_no', function ($case) {
                return "<a class='btn btn-sm btn-primary' href='" . route('claimcase-view', [$case->claim_case_id]) . "' target='_blank'><i class='fa fa-search'></i> " . $case->case_no . "</a>";
            })
            ->make(true);
    }
}
