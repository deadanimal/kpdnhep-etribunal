<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\ClaimCase;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterClaimClassification;
use App\SupportModel\Award;
use App\ViewModel\ViewReport18;
use App\ViewModel\ViewReport18Latest2019;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;

class Report18Controller extends Controller
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
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report18/modalFind', compact('categories', 'classifications', 'states'));
    }

    public function view(Request $request)
    {
        $states = MasterState::all();
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y').'-01-01';
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $report18 = self::query($request, $state_id, $date_start, $date_end);

//        dump($report18->toArray());

        return view('report/report18/view', compact('states', 'report18', 'categories',
            'classifications', 'date_start', 'date_end', 'state_id'));
    }

    public function export(Request $request)
    {
        $states = MasterState::all();
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();

        $report18 = ViewReport18::where('year', $year);

        if ($month)
            $report18->where('month', $month->month_id);

        if ($request->has('category') && $request->category != 0)
            $report18->where('category_id', $request->category);

        if ($request->has('classification') && $request->classification != 0)
            $report18->where('classification_id', $request->classification);

        $report18 = $report18->get();

        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['classifications'] = $classifications;
            $this->data['categories'] = $categories;
            $this->data['year'] = $year;
            $this->data['month'] = $month;
            $this->data['report18'] = $report18;
            $this->data['request'] = $request;

            $pdf = PDF::loadView('report/report18/printreport18', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan18.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report18_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal'))
                . ' ' . strtoupper(__('new.claim_value_award')) . ' ' . strtoupper(__('new.throughout_year'))
                . ' ' . $year . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '')
                . ' ' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $all_claim = 0;
            $all_award = 0;

            /////////// Data
            foreach ($states as $index => $state) {

                $report = (clone $report18)->where('state_id', $state->state_id);

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)number_format($report->sum('claim_amount'), 2, '.', ','),
                    (string)number_format($report->sum('award_value'), 2, '.', ',')
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = [
                '',
                '',
                (string)number_format($report18->sum('claim_amount'), 2, '.', ','),
                (string)number_format($report18->sum('award_value'), 2, '.', ',')
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'D' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report18_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
        }
    }

    /**
     * @param $request
     * @param $state_id
     * @param $date_start
     * @param $date_end
     * @return \App\CaseModel\ClaimCase|\App\CaseModel\ClaimCase[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query($request, $state_id, $date_start, $date_end)
    {
        $data = ViewReport18Latest2019::select([
            'state_id',
            'category_id',
            'classification_id',
            DB::raw('SUM(claim_amount) claim_amount'),
            DB::raw('SUM(award_value) award_value'),
            DB::raw('count(1) as total'),
        ])
            ->whereBetween('filing_date', [$date_start, $date_end])
            ->groupBy([
                'state_id',
                'category_id',
                'classification_id'
            ]);

        if ($state_id != '') {
            $data->where('state_id', $state_id);
        }

        if ($request->has('category') && $request->category != 0) {
            $data->where('category_id', $request->category);
        }

        if ($request->has('classification') && $request->classification != 0) {
            $data->where('classification_id', $request->classification);
        }

//        dd($data->get());

        return $data->get();
    }
}
