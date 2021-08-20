<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\ClaimCase;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterState;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;
use Redirect;
use Yajra\Datatables\Datatables;

class Report4Controller extends Controller
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

        return view('report/report4/modalFind', compact('years', 'states'));

    }

    public function view(Request $request)
    {
        $start_year = $request->start_year ? $request->start_year : date('Y');
        $end_year = $request->end_year ? $request->end_year : date('Y');

        if ($start_year == $end_year) {
            return Response::json(['status' => 'fail']);
        }

        $states = MasterState::all();
        $branches = MasterBranch::pluck('branch_name', 'branch_id');

        $case1 = self::query($start_year);
        $case2 = self::query($end_year);

        $template_states = array_merge(range(0, 16));
        unset($template_states[0]);

        foreach ($template_states as $k => $template_state) {
            $template_states[$k] = ['old' => 0, 'new' => 0, 'diff' => 0, 'pct' => 0];
        }

        $template_states['total'] = ['old' => 0, 'new' => 0, 'diff' => 0, 'pct' => 0];

        for ($i = 1; $i < 17; $i++) {
            $template_states[$i] = [
                'old' => $case1[$i] ?? 0,
                'new' => $case2[$i] ?? 0,
                'diff' => 0,
                'pct' => 0,
            ];

            $total = $template_states[$i]['old'] + $template_states[$i]['new'];
            $template_states[$i]['diff'] += $template_states[$i]['old'] - $template_states[$i]['new'];
            $template_states[$i]['pct'] += $total != 0 ? number_format(($template_states[$i]['diff']) / ($total) * 100, 2, '.', '') : 0;
            $template_states['total']['old'] += $template_states[$i]['old'];
            $template_states['total']['new'] += $template_states[$i]['new'];
            $template_states['total']['diff'] += $template_states[$i]['diff'];
        }

        return view('report/report4/view', compact('end_year', 'start_year', 'states', 'template_states',
            'branches'));

    }

    public function query($year)
    {
        return ClaimCase::select([
            DB::raw('count(1) as total'),
            DB::raw('master_branch.branch_state_id state_id'),
        ])
            ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->join('master_branch', 'claim_case.branch_id', '=', 'master_branch.branch_id')
            ->whereBetween('form1.filing_date', [$year . '-01-01', $year . '-12-31'])
            ->where('case_status_id', '>', 1)
            ->groupBy('master_branch.branch_state_id')
            ->pluck('total', 'state_id');
    }

    public function export(Request $request)
    {
        $start_year = $request->start_year ? $request->start_year : date('Y');
        $end_year = $request->end_year ? $request->end_year : date('Y');

        if ($start_year == $end_year) {
            return Response::json(['status' => 'fail']);
        }

        $states = MasterState::all();
        $case1 = ClaimCase::whereYear('created_at', $start_year)->where('case_status_id', '>', 1)->get();
        $case2 = ClaimCase::whereYear('created_at', $end_year)->where('case_status_id', '>', 1)->get();

        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['start_year'] = $start_year;
            $this->data['end_year'] = $end_year;
            $this->data['case1'] = $case1;
            $this->data['case2'] = $case2;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report4/printreport4', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan4.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report4_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.differences_year')) . ' ' . strtoupper(__('new.between_year')) . ' ' . $start_year . ' ' . strtoupper(__('new.and')) . ' ' . $end_year . ' ' . strtoupper(__('new.at_2')) . ' ' . strtoupper(__('new.at_hq')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('C2', strtoupper(__('new.filing_year') . ' ' . $start_year));
            $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('D2', strtoupper(__('new.filing_year') . ' ' . $end_year));
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

            $total_diff = 0;
            $total_percentage = 0;

            /////////// Data
            foreach ($states as $index => $state) {

                $case1_state = (clone $case1)->where('state_id', $state->state_id);
                $case2_state = (clone $case2)->where('state_id', $state->state_id);
                $total_diff += (count($case2_state) - count($case1_state));
                if (count($case1) + count($case2))
                    $percentage = number_format((count($case2_state) + count($case1_state)) / (count($case1) + count($case2)) * 100, 2, '.', '');
                else
                    $percentage = 0.00;

                $total_percentage += $percentage;

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)count($case1_state),
                    (string)count($case2_state),
                    (string)(count($case2_state) - count($case1_state)),
                    (string)$percentage
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = [
                '',
                '',
                (string)count($case1),
                (string)count($case2),
                (string)$total_diff,
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

            $tmp_file = storage_path('tmp/report4_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }

    public function show(Request $request)
    {
        $start_year = $request->start_year ? $request->start_year : date('Y');
        $end_year = $request->end_year ? $request->end_year : date('Y');
        $year = $request->year;
        $state_id = $request->state_id;
        return view('report/report4/modallist', compact('start_year', 'end_year', 'year', 'state_id'));
    }

    public function data(Request $request)
    {
        $start_year = $request->start_year ? $request->start_year : date('Y');
        $end_year = $request->end_year ? $request->end_year : date('Y');
        $year = $request->year;
        $state_id = $request->state_id;

        $case = ClaimCase::
        whereYear('created_at', $year)
            ->where('case_status_id', '>', 1);
        $case->whereHas('branch', function ($branch) use ($request) {
            return $branch->where('branch_state_id', $request->state_id);
        });

        $datatables = Datatables::of($case);

        return $datatables
            ->editColumn('case_no', function ($case) {
                return "<a class='btn btn-sm btn-primary' target='_blank'><i class='fa fa-search'></i> " . $case->case_no . "</a>";
            })->make(true);
    }
}
