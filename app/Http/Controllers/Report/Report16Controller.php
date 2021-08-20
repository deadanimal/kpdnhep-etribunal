<?php

namespace App\Http\Controllers\Report;

use App\Repositories\MasterClaimCategoryRepository;
use App\Repositories\MasterClaimClassificationRepository;
use App\Repositories\MasterStateRepository;
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
use App\CaseModel\ClaimCase;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterClaimClassification;
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
use PHPExcel_Style_Alignment;

class Report16Controller extends Controller
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
        $states = MasterState::all();
        $state_list = MasterState::pluck('state_name', 'state_id');
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $months = MasterMonth::all();
        $classifications = MasterClaimClassification::where('is_active', 1)->get();

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $case = ClaimCase::join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->whereBetween('form1.filing_date', [$date_start, $date_end])
            ->whereNotNull('form1.processed_at')
            ->where('case_status_id', '>', 1);

        if ($state_id != '') {
            $case->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });
        }

        $case = $case->get();

        if ($request->has('category') && ($request->category != 0)) {

            $classifications = (clone $classifications)->where('category_id', $request->category);

            $case = $case->filter(function ($value) use ($request) {
                if ($value->form1->classification)
                    return $value->form1->classification->category_id == $request->category;
            });
        }

        return view("report.report16.view", compact('states', 'classifications', 'categories',
            'categories_data', 'months', 'case', 'state_list', 'date_start', 'date_end', 'state_id'));
    }

    public function export(Request $request)
    {
        $states = MasterStateRepository::getAll();
        $categories = MasterClaimCategoryRepository::getAll();
        $years = range(date('Y'), 2000);
        $months = MasterMonth::all();

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        if ($request->month == 12) {
            $next_month = 1;
//            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
//            $next_year = $year;
        }

        $case = ClaimCase::whereBetween('created_at', [$date_start, $date_end])
            ->where('case_status_id', '>', 1);

        if ($state_id != '') {
            $case->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });
        }

        $case = $case->get();
        $classifications = MasterClaimClassificationRepository::getAll();
        
        if ($request->has('category') && ($request->category != 0)) {
            $classifications = (clone $classifications)->where('category_id', $request->category);

            $case = $case->filter(function ($value) use ($request) {
                if ($value->form1->classification)
                    return $value->form1->classification->category_id == $request->category;
            });
        }

        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['categories'] = $categories;
            $this->data['months'] = $months;
//            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['case'] = $case;
            $this->data['classifications'] = $classifications;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report16/printreport16', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan16.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = "month_" . $locale;
            $classification_lang = "classification_" . $locale;
            $category_lang = "category_" . $locale;

            $total = 0;
            $dualtotal = 0;
            $a = 1;

            ////////////////////////////////////////////////////////////////////////////////////////////////// TITLE


            $title = __('new.tribunal') . '
' . __('new.claim_category') . ' ';

            if ($request->category > 0) {
                $title .= "(" . (\App\MasterModel\MasterClaimCategory::find($request->category)->$category_lang) . ") ";
            }

            $title .= __('new.filed_each_state') . '
' . __('new.year') . ' ' . ($request->year ? $request->year : date('Y')) . ' ';

            if ($request->month > 0) {
                $title .= __('new.month') . ' ' . $request->month;
            }

            $title .= "
( " . __('new.until') . ' ' . date('d/m/Y') . " )";


            ////////////////////////////////////////////////////////////////////////////////////////////////////////


            $total_row = $classifications->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report16_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            //CompanyName column
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            //States column
            $col = 'C';
            foreach ($states as $state) {
                $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper($state->state_name));
                $objPHPExcel->getActiveSheet()->getStyle($col . '2')->getAlignment()->setTextRotation(90)->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }
            //Total column
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper(__('new.total')));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            //Percentage column
            $col++;
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', '%');
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);


            /////////// Title
            $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $col . '1');
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper($title));
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($classifications as $index => $classification) {

                $case_class = (clone $case)->where('classification_id', $classification->claim_classification_id);

                $data = array(
                    ($a++) . '. ',
                    strtoupper($classification->$classification_lang)
                );

                foreach ($states as $state) {
                    $class_state = (clone $case_class)->where('state_id', $state->state_id);
                    $total += count($class_state);
                    array_push($data, (string)count($class_state));
                }
                array_push($data, (string)count($case_class), (string)(count($case) > 0 ? number_format(count($case_class) / count($case) * 100, 2, '.', ',') : '0.00'));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $a - 1));
            }

            //

            $total = array('', '');
            foreach ($states as $state) {
                $state_count = (clone $case)->where('state_id', $state->state_id);
                array_push($total, (string)count($state_count));
            }
            array_push($total, (string)count($total), (string)'100.00');

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                $col .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objPHPExcel->getActiveSheet()
                ->getStyle('C3:' . $col . $objPHPExcel->getActiveSheet()->getHighestRow())
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report16_' . uniqid() . '.xlsx');
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
