<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\ClaimCase;
use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form2;
use App\CaseModel\Form3;
use App\Helpers\NumberFormatHelper;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterState;
use App\Models\ViewReport2Case2020;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;

class Report2v2Controller extends Controller
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

    public function index(Request $request)
    {
        $input = $request->all();

        $is_search = count($input) > 0 ? true : false;
        $states = MasterState::join('master_branch', 'master_state.state_id', '=', 'master_branch.branch_state_id')
            ->orderBy('branch_state_id')
            ->pluck('state_name', 'branch_state_id');
        $branches = MasterBranch::pluck('branch_id', 'branch_state_id');

        $input['date_start'] = isset($input['date_start']) && $input['date_start'] != ''
            ? Carbon::createFromFormat('d/m/Y', $input['date_start'])->startOfDay()->toDateString()
            : Carbon::parse()->startOfMonth()->toDateString();
        $input['date_end'] = isset($input['date_end']) && $input['date_end'] != ''
            ? Carbon::createFromFormat('d/m/Y', $input['date_end'])->endOfDay()->toDateString()
            : Carbon::parse()->endOfMonth()->toDateString();
        $input['state_id'] = $input['state_id'] ?? '';

        $gen = isset($input['gen']) ? $input['gen'] : 'w';

        if ($is_search) {
            $template_data = [
                'case' => 0,
                'type' => ['b' => 0, 'p' => 0],
                'form' => [2 => 0, 3 => 0, 11 => 0, 12 => 0,],
                'stop_notice' => 0,
                'pull_out' => 0,
                'canceled' => 0,
                'deal' => [6 => 0, 9 => 0],
                'hearing' => [5 => 0, 7 => 0, 8 => 0, 10 => 0, '10k' => 0, '10t' => 0, '10b' => 0,],
                'completed' => 0,
                'not_completed' => 0,
            ];
            $template_states = array_merge(range(0, 16));
            unset($template_states[0]);

            foreach ($template_states as $k => $template_state) {
                $template_states[$k] = $template_data;
            }

            $template_states['total'] = $template_data;

            $data_final = $template_states;

            $data_raw = self::query($input);
            $data_by_claim_types = self::queryByClaimType($input)->mapWithKeys(function ($datum) {
                return [$datum->state_state_id => ['p' => $datum->p, 'b' => $datum->b]];
            });

            $data_f2 = self::queryF2($input)->mapWithKeys(function ($datum) {
                return [$datum->state_state_id => $datum->total];
            });

            $data_f3 = self::queryF3($input)->mapWithKeys(function ($datum) {
                return [$datum->state_state_id => $datum->total];
            });

//            dd($data_raw);
            $state_calculated = [];

            foreach ($data_raw as $datum) {
                $data_final[$datum->state_id]['case'] += $datum->register;
                $data_final[$datum->state_id]['form']['11'] += $datum->f11;
                $data_final[$datum->state_id]['form']['12'] += $datum->f12;
                $data_final[$datum->state_id]['stop_notice'] += $datum->stop_notice;
                $data_final[$datum->state_id]['pull_out'] += $datum->revoked;
                $data_final[$datum->state_id]['canceled'] += $datum->canceled;
                $data_final[$datum->state_id]['deal']['6'] += $datum->f6;
                $data_final[$datum->state_id]['deal']['9'] += $datum->f9;
                $data_final[$datum->state_id]['hearing']['5'] += $datum->f5;
                $data_final[$datum->state_id]['hearing']['7'] += $datum->f7;
                $data_final[$datum->state_id]['hearing']['8'] += $datum->f8;
                $data_final[$datum->state_id]['hearing']['10'] += $datum->f10;
                $data_final[$datum->state_id]['hearing']['10k'] += $datum->f10k;
                $data_final[$datum->state_id]['hearing']['10t'] += $datum->f10t;
                $data_final[$datum->state_id]['hearing']['10b'] += $datum->f10b;
                $data_final[$datum->state_id]['completed'] += $datum->complete;
                $data_final[$datum->state_id]['not_completed'] += $datum->balance;

                $data_final['total']['case'] += $datum->register;
                $data_final['total']['form']['11'] += $datum->f11;
                $data_final['total']['form']['12'] += $datum->f12;
                $data_final['total']['stop_notice'] += $datum->stop_notice;
                $data_final['total']['pull_out'] += $datum->revoked;
                $data_final['total']['canceled'] += $datum->canceled;
                $data_final['total']['deal']['6'] += $datum->f6;
                $data_final['total']['deal']['9'] += $datum->f9;
                $data_final['total']['hearing']['5'] += $datum->f5;
                $data_final['total']['hearing']['7'] += $datum->f7;
                $data_final['total']['hearing']['8'] += $datum->f8;
                $data_final['total']['hearing']['10'] += $datum->f10;
                $data_final['total']['hearing']['10k'] += $datum->f10k;
                $data_final['total']['hearing']['10t'] += $datum->f10t;
                $data_final['total']['hearing']['10b'] += $datum->f10b;
                $data_final['total']['completed'] += $datum->complete;
                $data_final['total']['not_completed'] += $datum->balance;

                if (!isset($state_calculated[$datum->state_id])) {
                    $data_final[$datum->state_id]['type']['p'] += ($data_by_claim_types[$datum->state_id]['b'] ?? 0);
                    $data_final[$datum->state_id]['type']['b'] += ($data_by_claim_types[$datum->state_id]['p'] ?? 0);
                    $data_final[$datum->state_id]['form']['2'] += ($data_f2[$datum->state_id] ?? 0);
                    $data_final[$datum->state_id]['form']['3'] += ($data_f3[$datum->state_id] ?? 0);

                    $data_final['total']['type']['p'] += ($data_by_claim_types[$datum->state_id]['b'] ?? 0);
                    $data_final['total']['type']['b'] += ($data_by_claim_types[$datum->state_id]['p'] ?? 0);
                    $data_final['total']['form']['2'] += ($data_f2[$datum->state_id] ?? 0);
                    $data_final['total']['form']['3'] += ($data_f3[$datum->state_id] ?? 0);
                }

                $state_calculated[$datum->state_id] = '1';
            }
        }


        switch ($gen) {
            case 'p':
                return $this->generatePdf($input, $is_search, $states, $data_final, $branches);
                break;
            case 'e':
            case 'c':
                return $this->generateXML($states, $data_final);
                break;
            case 'w':
            default:
                return view('report.report2v2.index')
                    ->with(compact('input', 'is_search', 'states', 'data_final', 'branches'));
                break;
        }
    }

    public function query($input)
    {
        $data_final = ClaimCaseOpponent::select([
            DB::raw('date(form1.processed_at) filing_date'),
            DB::raw('master_state.state_name state'),
            DB::raw('master_state.state_id state_id'),
            DB::raw('count(distinct claim_case.case_no) register'),
//            DB::raw('count(case when master_claim_classification.category_id = 1 then 1 end) as p'),
//            DB::raw('count(case when master_claim_classification.category_id = 2 then 1 end) as b'),
//            DB::raw('count((case master_claim_classification.category_id when 1 then claim_case.case_no else NULL end)) p'),
//            DB::raw('count((case master_claim_classification.category_id when 2 then claim_case.case_no else NULL end)) b'),
//            DB::raw('count(case when form2.form2_id is not null then 1 end) as f2'),
            DB::raw('count((case when (form3.form3_id is not null) then claim_case.case_no else NULL end)) f3'),
            DB::raw('count((case when (award.award_type = 5) then claim_case.case_no else NULL end)) f5'),
            DB::raw('count((case when (award.award_type = 6) then claim_case.case_no else NULL end)) f6'),
            DB::raw('count((case when (award.award_type = 7) then claim_case.case_no else NULL end)) f7'),
            DB::raw('count((case when (award.award_type = 8) then claim_case.case_no else NULL end)) f8'),
            DB::raw('count((case when (award.award_type = 9) then claim_case.case_no else NULL end)) f9'),
            DB::raw('count((case when (award.f10_type_id = 1) then claim_case.case_no else NULL end)) f10k'),
            DB::raw('count((case when (award.f10_type_id = 2) then claim_case.case_no else NULL end)) f10'),
            DB::raw('count((case when (award.f10_type_id = 3) then claim_case.case_no else NULL end)) f10t'),
            DB::raw('count((case when (award.f10_type_id = 4) then claim_case.case_no else NULL end)) f10b'),
            DB::raw('count((case when (form11.form11_id is not null) then claim_case.case_no else NULL end)) f11'),
            DB::raw('count((case when (form4.form12_id is not null) then claim_case.case_no else NULL end)) f12'),
            DB::raw('count((case when (stop_notice.form_status_id = 27) then claim_case.case_no else NULL end)) stop_notice'),
            DB::raw('count((case when (form4.hearing_position_id = 6) then claim_case.case_no else NULL end)) revoked'),
            DB::raw('count((case when (form4.hearing_position_id = 4) then claim_case.case_no else NULL end)) canceled'),
            DB::raw('count((case claim_case.is_finished when 1 then claim_case.case_no else NULL end)) complete'),
            DB::raw('(count(claim_case.case_no) - count((case claim_case.case_status_id when 8 then claim_case.case_no else NULL end))) balance'),
        ])
            ->join('claim_case', 'claim_case_opponents.claim_case_id', '=', 'claim_case.claim_case_id')
            ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->leftJoin('form2', 'claim_case_opponents.id', '=', 'form2.claim_case_opponent_id')
            ->leftJoin('form3', 'form2.form3_id', '=', 'form3.form3_id')
            ->leftJoin(DB::raw('(select * from form4 where form4_id = (select max(f4_tmp.form4_id) from form4 f4_tmp 
                where f4_tmp.claim_case_opponent_id = form4.claim_case_opponent_id)) as form4'), function ($j) {
                $j->on('claim_case_opponents.id', '=', 'form4.claim_case_opponent_id');
            })
            ->leftJoin('form11', 'form11.form4_id', '=', 'form4.form4_id')
            ->leftJoin('form12', 'form12.form4_id', '=', 'form4.form4_id')
            ->leftJoin('award', 'form4.award_id', '=', 'award.award_id')
            ->leftJoin('stop_notice', 'stop_notice.claim_case_opponent_id', '=', 'claim_case_opponents.id')
            ->join('master_branch', 'claim_case.branch_id', '=', 'master_branch.branch_id')
            ->join('master_state', 'master_branch.branch_state_id', '=', 'master_state.state_id')
            ->join('master_claim_classification', 'form1.claim_classification_id', '=', 'master_claim_classification.claim_classification_id')
            ->whereBetween('form1.filing_date', [$input['date_start'], $input['date_end']])
            ->where('claim_case.case_status_id', '>', 1)
            ->whereNotNull('form1.processed_at')
            ->groupBy(['master_state.state', 'claim_case.claim_case_id']);

        if ($input['state_id']) {
            $data_final->where('state_id', $input['state_id']); // 1 = johor
        }

        return $data_final->get();
    }

    public function queryF2($input)
    {
        $data_final = Form2::select([
            DB::raw('master_state.state_id state_state_id'),
            DB::raw('count(form2.form2_id) as total'),
        ])
            ->join('form1', 'form2.form1_id', '=', 'form1.form1_id')
            ->join('claim_case', 'form1.form1_id', '=', 'claim_case.form1_id')
            ->join('master_branch', 'claim_case.branch_id', '=', 'master_branch.branch_id')
            ->join('master_state', 'master_branch.branch_state_id', '=', 'master_state.state_id')
            ->whereBetween('form2.filing_date', [$input['date_start'], $input['date_end']])
            ->groupBy(['master_state.state']);

        if ($input['state_id']) {
            $data_final->where('master_state.state_id', $input['state_id']); // 1 = johor
        }

        return $data_final->get();
    }

    public function queryF3($input)
    {
        $data_final = Form3::select([
            DB::raw('master_state.state_id state_state_id'),
            DB::raw('count(form3.form3_id) as total'),
        ])
            ->join('form2', 'form2.form3_id', '=', 'form3.form3_id')
            ->join('form1', 'form2.form1_id', '=', 'form1.form1_id')
            ->join('claim_case', 'form1.form1_id', '=', 'claim_case.form1_id')
            ->join('master_branch', 'claim_case.branch_id', '=', 'master_branch.branch_id')
            ->join('master_state', 'master_branch.branch_state_id', '=', 'master_state.state_id')
            ->whereBetween('form1.filing_date', [$input['date_start'], $input['date_end']])
            ->groupBy(['master_state.state']);

        if ($input['state_id']) {
            $data_final->where('master_state.state_id', $input['state_id']); // 1 = johor
        }

        return $data_final->get();
    }

    public function queryByClaimType($input)
    {
        $data_final = ClaimCase::select([
            DB::raw('master_state.state_id state_state_id'),
            DB::raw('count(case when master_claim_classification.category_id = 1 then 1 end) p'),
            DB::raw('count(case when master_claim_classification.category_id = 2 then 1 end) b'),
        ])
            ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->join('master_claim_classification', 'form1.claim_classification_id', '=', 'master_claim_classification.claim_classification_id')
            ->join('master_branch', 'claim_case.branch_id', '=', 'master_branch.branch_id')
            ->join('master_state', 'master_branch.branch_state_id', '=', 'master_state.state_id')
            ->whereBetween('form1.filing_date', [$input['date_start'], $input['date_end']])
            ->where('claim_case.case_status_id', '>', 1)
            ->whereNotNull('form1.processed_at')
            ->groupBy(['master_state.state_id']);

        if ($input['state_id']) {
            $data_final->where('master_state.state_id', $input['state_id']); // 1 = johor
        }

        return $data_final->get();
    }

    public function generateXml($states, $data_final)
    {
        $total_row = $states->count();

        $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report2_' . App::getLocale() . '.xlsx'));
        $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        /////////// Title
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . ' '
            . strtoupper(__('new.report2_1')) . ' ' . strtoupper(__('new.year')) . ' ' . strtoupper(__('new.report2_2')) . ' '
            . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        /////////// Data
        foreach ($states as $i => $state) {
            $data = [
                ($i) . '. ',
                $state,
                (string)$data_final[$i]['case'] ?? 0,
                (string)$data_final[$i]['type']['b'] ?? 0,
                (string)$data_final[$i]['type']['p'] ?? 0,
                (string)$data_final[$i]['form']['2'] ?? 0,
                (string)$data_final[$i]['form']['3'] ?? 0,
                (string)$data_final[$i]['form']['11'] ?? 0,
                (string)$data_final[$i]['form']['12'] ?? 0,
                (string)$data_final[$i]['stop_notice'] ?? 0,
                (string)$data_final[$i]['pull_out'] ?? 0,
                (string)$data_final[$i]['canceled'] ?? 0,
                (string)$data_final[$i]['deal']['6'] ?? 0,
                (string)$data_final[$i]['deal']['9'] ?? 0,
                (string)$data_final[$i]['hearing']['5'] ?? 0,
                (string)$data_final[$i]['hearing']['7'] ?? 0,
                (string)$data_final[$i]['hearing']['8'] ?? 0,
                (string)$data_final[$i]['hearing']['10'] ?? 0,
                (string)$data_final[$i]['hearing']['10k'] ?? 0,
                (string)$data_final[$i]['hearing']['10t'] ?? 0,
                (string)$data_final[$i]['hearing']['10b'] ?? 0,
                (string)$data_final[$i]['completed'] ?? 0,
                (string)$data_final[$i]['not_completed'] ?? 0,
            ];

            $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $i));
        }

        $total = [
            ($i) . '. ',
            $state,
            (string)$data_final['total']['case'] ?? 0,
            (string)$data_final['total']['type']['b'] ?? 0,
            (string)$data_final['total']['type']['p'] ?? 0,
            (string)$data_final['total']['form']['2'] ?? 0,
            (string)$data_final['total']['form']['3'] ?? 0,
            (string)$data_final['total']['form']['11'] ?? 0,
            (string)$data_final['total']['form']['12'] ?? 0,
            (string)$data_final['total']['stop_notice'] ?? 0,
            (string)$data_final['total']['pull_out'] ?? 0,
            (string)$data_final['total']['canceled'] ?? 0,
            (string)$data_final['total']['deal']['6'] ?? 0,
            (string)$data_final['total']['deal']['9'] ?? 0,
            (string)$data_final['total']['hearing']['5'] ?? 0,
            (string)$data_final['total']['hearing']['7'] ?? 0,
            (string)$data_final['total']['hearing']['8'] ?? 0,
            (string)$data_final['total']['hearing']['10'] ?? 0,
            (string)$data_final['total']['hearing']['10k'] ?? 0,
            (string)$data_final['total']['hearing']['10t'] ?? 0,
            (string)$data_final['total']['hearing']['10b'] ?? 0,
            (string)$data_final['total']['completed'] ?? 0,
            (string)$data_final['total']['not_completed'] ?? 0,
        ];

        $pct = [
            '',
            '',
            NumberFormatHelper::calculatePercentage($data_final['total']['case'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['type']['b'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['type']['p'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['form']['2'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['form']['3'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['form']['11'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['form']['12'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['stop_notice'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['pull_out'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['canceled'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['deal']['6'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['deal']['9'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['5'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['7'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['8'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10k'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10t'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['hearing']['10b'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['completed'], $data_final['total']['case'], 1, '%'),
            NumberFormatHelper::calculatePercentage($data_final['total']['not_completed'], $data_final['total']['case'], 1, '%'),
        ];

        $row_total = $num_rows + $total_row + 1;
        $row_percent = $num_rows + $total_row + 2;

        $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);
        $objPHPExcel->getActiveSheet()->fromArray($pct, NULL, 'A' . $row_percent);

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

    public function generatePdf($input, $is_search, $states, $data_final, $branches)
    {
        return PDF::loadView('report/report2v2/pdf', compact('input', 'is_search', 'states', 'data_final', 'branches'))
            ->setOrientation('landscape')
            ->setOption('enable-javascript', true)
            ->download('Laporan2v2.pdf');
    }
}
