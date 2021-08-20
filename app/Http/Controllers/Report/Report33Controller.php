<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\ClaimCase;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterState;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;

class Report33Controller extends Controller
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

        $input['state_id'] = $request->state_id ?? '';
        $input['date_start'] = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $input['date_end'] = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');
        $gen = isset($input['gen']) ? $input['gen'] : 'w';
        $input['locale'] = App::getLocale();

        $states = MasterState::join('master_branch', 'master_state.state_id', '=', 'master_branch.branch_state_id')
            ->pluck('state_name', 'branch_id');

        $param = $input;
        $param['start_date'] = $request->start_date;
        $param['end_date'] = $request->end_date;

        if ($is_search) {
            $data_final = self::query($input);

            switch ($gen) {
                case 'p':
                    return $this->generatePdf($data_final, $input, $param);
                    break;
                case 'e':
                    return $this->generateXML('xlsx', $data_final, $input, $param);
                    break;
                case 'c':
                    return $this->generateXML('csv', $data_final, $input, $param);
                    break;
                case 'w':
                default:
                    return view('report.report33.index')
                        ->with(compact('states', 'is_search', 'data_final', 'input', 'param'));
                    break;
            }
        }

        return view('report.report33.index')
            ->with(compact('states', 'is_search', 'input', 'param'));
    }

    public function query($input)
    {
        $data = ClaimCase::with('form1.classification', 'form4.hearing', 'form4.award', 'stop_notice')
            ->join('form1', 'form1.form1_id', '=', 'claim_case.form1_id')
//            ->orderBy('form1.processed_at', 'asc')
//            ->orderBy('form1.filing_date', 'asc')
            ->orderBy('case_year', 'asc')
            ->orderBy('case_sequence', 'asc')
            ->whereNotNull('form1.processed_at')
            ->whereNotNull('form1.claim_classification_id')
            ->whereBetween('form1.filing_date', [$input['date_start'], $input['date_end']]);

        if ($input['state_id'] != '') {
            $data = $data->where('branch_id', $input['state_id']);
        }

        return $data->get();
    }

    public function generatePdf($data_final, $input, $param)
    {
        $pdf = PDF::loadView('report/report33/pdf', compact('data_final', 'input', 'param'))
            ->setOrientation('landscape')
            ->setPaper('A3')
            ->setOption('enable-javascript', true);

        return $pdf->stream('R33' . date("_Ymd_His") . '.pdf');
    }

    public function generateXml($type, $data_final, $input, $param)
    {
        $locale = App::getLocale();

        $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report33_' . App::getLocale() . '.xlsx'));
        $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        // title
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal'))
            . "\r" . strtoupper(__('new.report33'))
            . "\r" . $param['date_start'] . ' - ' . $param['date_end']);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        // data
        if (count($data_final) > 0) {
            foreach ($data_final as $key => $datum) {
                $data_loop = [
                    'b12_status' => false,
                    'tb_status' => false,
                    'nh_status' => $datum->stop_notice ? true : false,
                    'b_status' => false,
                    'award_b5_date' => '',
                    'award_b6_date' => '',
                    'award_b7_date' => '',
                    'award_b8_date' => '',
                    'award_b9_date' => '',
                    'award_b10_date' => '',
                    'award_b10k_date' => '',
                    'award_b10t_date' => '',
                    'award_b10b_date' => '',
                    'award_value' => '',
                    'kpi' => '',
                    'hearing_date' => [1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => ''],
                ];

                $data_loop = self::awardData($datum, $data_loop);
                $b12_hearings = self::getB12HearingDate($datum);

                $data = [
                    $key + 1,
                    $datum->case_no,
                    $datum->claimant_address->name,
                    self::opponentsName($datum),
                    $datum->form1->classification ? ($datum->form1->classification->category_id == 1 ? 'B' : 'P') : '-',
                    $input['locale'] == 'en' ? $datum->form1->classification->classification_en : $datum->form1->classification->classification_my,
                    \Carbon\Carbon::parse($datum->form1->filing_date)->format('d/m/Y'),
                    self::filingDateForm2($datum),
                    self::filingDateForm3($datum),
                    self::filingDateForm4($datum),
                    $data_loop['hearing_date'][1],
                    $data_loop['hearing_date'][2],
                    $data_loop['hearing_date'][3],
                    $data_loop['hearing_date'][4],
                    $data_loop['hearing_date'][5],
                    $data_loop['hearing_date'][6],
                    $data_loop['hearing_date'][7],
                    $data_loop['hearing_date'][8],
                    $data_loop['award_b5_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b5_date'])->format('d/m/Y') : '',
                    $data_loop['award_b6_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b6_date'])->format('d/m/Y') : '',
                    $data_loop['award_b7_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b7_date'])->format('d/m/Y') : '',
                    $data_loop['award_b8_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b8_date'])->format('d/m/Y') : '',
                    $data_loop['award_b9_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b9_date'])->format('d/m/Y') : '',
                    $data_loop['award_b10_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b10_date'])->format('d/m/Y') : '',
                    $data_loop['award_b10k_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b10k_date'])->format('d/m/Y') : '',
                    $data_loop['award_b10t_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b10t_date'])->format('d/m/Y') : '',
                    $data_loop['award_b10b_date'] != '' ? \Carbon\Carbon::parse($data_loop['award_b10b_date'])->format('d/m/Y') : '',
                    $datum->form1->claim_amount,
                    $data_loop['award_value'],
                    self::lastPresident($datum),
                    $data_loop['kpi'],
                    (is_integer($data_loop['kpi']) ? (60 - $data_loop['kpi']) : ''),
                    $data_loop['b12_status'] ? __('new.s_yes') : __('new.s_no'),
                    isset($b12_hearings[1]) ? $b12_hearings[1] : '',
                    isset($b12_hearings[2]) ? $b12_hearings[2] : '',
                    isset($b12_hearings[3]) ? $b12_hearings[3] : '',
                    isset($b12_hearings[4]) ? $b12_hearings[4] : '',
                    ($data_loop['nh_status'] || $data_loop['tb_status']) ? __('new.s_yes') : __('new.s_no'),
                    $data_loop['b_status'] ? __('new.s_yes') : __('new.s_no'),
                    '',
                    '',
                    '',
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $key + 1));
            }
        }

        // borders
        $objPHPExcel->getActiveSheet()
            ->getStyle(
                'A0:' .
                'E' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        if (!file_exists(storage_path('tmp'))) {
            mkdir(storage_path('tmp'));
        }

        $tmp_file = storage_path('tmp/report5_' . uniqid() . '.xlsx');
        $objWriter->save($tmp_file);

        return response()->download($tmp_file)->deleteFileAfterSend(true);
    }

    protected static function opponentsName($datum)
    {
        $opponents = '';

        foreach ($datum->multiOpponents as $i => $cco) {
            $opponents .= ($i == 0 ? '' : "\r") . ($i + 1) . ' ' . $cco->opponent_address->name;
        }

        return $opponents;
    }

    protected static function filingDateForm2($datum)
    {
        $dates = '';

        foreach ($datum->multiOpponents as $i => $cco) {
            $dates .= ($i == 0 ? '' : "\r") . ($i + 1) . ' ' . ($cco->form2 ? $cco->form2->created_at->format('d/m/Y') : '-');
        }

        return $dates;
    }

    protected static function filingDateForm3($datum)
    {
        $dates = '';

        foreach ($datum->multiOpponents as $i => $cco) {
            $dates .= ($i == 0 ? '' : "\r") . ($i + 1) . ' ' . (($cco->form2 && $cco->form2->form3) ? $cco->form2->form3->created_at->format('d/m/Y') : '-');
        }

        return $dates;
    }

    protected static function filingDateForm4($datum)
    {
        foreach ($datum->multiOpponents as $i => $cco) {
            if (count($cco->form4) > 0) {
                return $cco->form4[0]->hearing->hearing_date;
            }
        }
    }

    protected static function awardData($datum, $data_loop)
    {
        for ($i = 0; $i < 8; $i++) {
            $data_loop['hearing_date'][$i + 1] = isset($datum->form4[$i])
                ? \Carbon\Carbon::parse($datum->form4[$i]->hearing->hearing_date)->format('d/m/Y')
                : '';

            if (isset($datum->form4[$i])) {
                $data_loop['b12_status'] = $data_loop['b12_status'] == true || $datum->form4[$i]->form12_id != null;
                $data_loop['tb_status'] = $data_loop['tb_status'] == true || $datum->form4[$i]->hearing_position_id == 6;
                $data_loop['b_status'] = $data_loop['b_status'] == true || $datum->form4[$i]->hearing_position_id == 4;
                $data_loop['award_b5_date'] = ($data_loop['award_b5_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 5)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b5_date']);
                $data_loop['award_b6_date'] = ($data_loop['award_b6_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 6)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b6_date']);
                $data_loop['award_b7_date'] = ($data_loop['award_b7_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 7)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b7_date']);
                $data_loop['award_b8_date'] = ($data_loop['award_b8_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 8)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b8_date']);
                $data_loop['award_b9_date'] = ($data_loop['award_b9_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 9)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b9_date']);
                $data_loop['award_b10_date'] = ($data_loop['award_b10_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 10)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b10_date']);
                $data_loop['award_b10k_date'] = ($data_loop['award_b10k_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 10 && $datum->form4[$i]->award->f10_type_id == 1)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b10k_date']);
                $data_loop['award_b10t_date'] = ($data_loop['award_b10t_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 10 && $datum->form4[$i]->award->f10_type_id == 3)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b10t_date']);
                $data_loop['award_b10b_date'] = ($data_loop['award_b10b_date'] == '' && ($datum->form4[$i]->award_id != null && $datum->form4[$i]->award->award_type == 10 && $datum->form4[$i]->award->f10_type_id == 4)
                    ? $datum->form4[$i]->award->award_date
                    : $data_loop['award_b10b_date']);
                $data_loop['award_value'] = ($data_loop['award_value'] == '' && ($datum->form4[$i]->award_id != null)
                    ? $datum->form4[$i]->award->award_value
                    : $data_loop['award_value']);
                $data_loop['kpi'] = ($data_loop['kpi'] == '' && ($datum->form4[$i]->award_id != null)
                    ? (\Carbon\Carbon::parse($datum->form4[$i]->award->award_date)->diffInDays(\Carbon\Carbon::parse($datum->form1->filing_date)))
                    : $data_loop['kpi']);
            }
        }

        return $data_loop;
    }

    protected static function lastPresident($datum)
    {
        $last_president = '-';
        $f4_cco = 0;
        foreach ($datum->multiOpponents as $i => $cco) {

            if ($f4_cco == 0) {
                $last_f4 = $cco->form4()
                    ->where('hearing_status_id', 1)
                    ->orderBy('form4_id', 'desc')
                    ->first();
                if ($last_f4) {
                    $last_president = $last_f4->president_user_id != null
                        ? $last_f4->president->name
                        : (
                        $last_f4->hearing->president_user_id != null
                            ? $last_f4->hearing->president->name
                            : '-'
                        );
                    $f4_cco = 1;
                }
            }
        }

        return $last_president;
    }


    protected static function getB12HearingDate($datum)
    {
        $b12_hearings = [];
        $b12 = $datum->form4()->whereNotNull('form12_id')->limit(3)->get();
        for ($i = 0; $i < 4; $i++) {
            isset($b12_hearings[$i]) ? \Carbon\Carbon::parse($b12[$i]->hearing->hearing_date)->format('d/m/Y') : '';
        }

        return $b12_hearings;
    }
}
