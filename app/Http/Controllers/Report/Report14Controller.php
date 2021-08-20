<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\ViewModel\ViewReport14;

use App\MasterModel\MasterState;
use App\MasterModel\MasterClaimCategory;
use App\MasterModel\MasterClaimClassification;
use App\UserPublicCompany;
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
use PHPExcel_Style_Alignment;

class Report14Controller extends Controller
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
        $classifications = MasterClaimClassification::where('is_active', 1)->get();
        $categories = MasterClaimCategory::where('is_active', 1)->get();
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report14/modalFind', compact( 'categories', 'classifications', 'states'));

    }

    public function list(Request $request)
    {
        $company = $request->company;
        $year = $request->year;
        $claim_classification = $request->claim_classification;

        return view('report/report14/modalList', compact('company', 'year', 'claim_classification'));

    }

    public function data(Request $request)
    {

        $cases = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1)->where('opponent_user_id', $request->company);

        if ($request->has('claim_classification') && ($request->claim_classification != 0)) {
            $cases->whereHas('form1', function ($form1) use ($request) {
                return $form1->where('claim_classification_id', $request->claim_classification);
            });
        }

        $datatables = Datatables::of($cases);

        return $datatables
            ->editColumn('case_no', function ($cases) {
                return "<a class='btn btn-sm btn-primary' href='" . route('claimcase-view', [$cases->claim_case_id]) . "'><i class='fa fa-search'></i> " . $cases->case_no . "</a>";
            })->make(true);


    }

    public function view(Request $request)
    {
        $states = MasterState::all();
        $state_list = MasterState::pluck('state_name', 'state_id');

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $view_report14 = ViewReport14::whereBetween('created_at', [$date_start, $date_end]);

        if ($state_id != '') {
            $view_report14->where('state_id', $state_id);
        }

        if ($request->has('claim_classification') && ($request->claim_classification != 0)) {
            $view_report14->where('classification_id', $request->claim_classification);
        }

        $view_report14_full = (clone $view_report14)->get();
        $view_report14 = $view_report14->groupBy('user_id')->get();

        return view('report/report14/view', compact('year', 'view_report14', 'view_report14_full', 'states', 'state_id', 'state_list'));

    }

    public function export(Request $request)
    {

        $year = $request->year ? $request->year : date('Y');
        $states = MasterState::all();

        $view_report14 = ViewReport14::where('created_year', $year);

        if ($request->has('claim_classification') && ($request->claim_classification != 0)) {
            $view_report14->where('classification_id', $request->claim_classification);
        }

        $view_report14_full = (clone $view_report14)->get();
        $view_report14 = $view_report14->groupBy('user_id')->get();

        if ($request->format == 'pdf') {
            $this->data['view_report14_full'] = $view_report14_full;
            $this->data['states'] = $states;
            $this->data['view_report14'] = $view_report14;
            $this->data['year'] = $year;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report14/printreport14', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan14.pdf');
        } else if ($request->format == 'excel') {

            $total_row = $view_report14->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report14_' . App::getLocale() . '.xlsx'));
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


            /////////// Title
            $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $col . '1');
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.company_name_year') . ' ' . __('new.on_year')) . ' ' . $year . ' ' . strtoupper(__('new.based_state')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($view_report14 as $index => $report) {

                $data = array(
                    ($index + 1) . '. ',
                    $report->name
                );

                foreach ($states as $state) {
                    array_push($data, (string)count((clone $view_report14_full)->where('state_id', $state->state_id)->where('user_id', $report->user_id)));
                }
                array_push($data, (string)count((clone $view_report14_full)->where('user_id', $report->user_id)));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = array('', '');
            foreach ($states as $state) {
                array_push($total, (string)count((clone $view_report14_full)->where('state_id', $state->state_id)));
            }
            array_push($total, (string)count($view_report14_full));

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

            $tmp_file = storage_path('tmp/report14_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }


    }


}
