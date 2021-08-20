<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\MasterModel\MasterState;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterInquiryMethod;
use App\MasterModel\MasterClaimClassification;
use App\CaseModel\Inquiry;
use App\MasterModel\MasterClaimCategory;
use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;

use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;

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

class Report27Controller extends Controller
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
        $months = MasterMonth::all();
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report27/modalFind', compact('years', 'months', 'states'));
    }

    public function view(Request $request)
    {
        $months = MasterMonth::orderBy('month_id', 'asc')->get();
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $state_list = MasterState::pluck('state_name', 'state_id');

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $claimcases = ClaimCase::join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->whereBetween('form1.filing_date', [$date_start, $date_end])
            ->where('case_status_id', '>', 1);

        if ($state_id != '') {
            $claimcases->whereHas('branch', function ($q) use ($state_id) {
                $q->where('branch_state_id', $state_id);
            });
        }

        $claimcases = $claimcases->get();

        return view("report.report27.view", compact('months', 'states', 'claimcases', 'date_start', 'date_end', 'state_id', 'state_list'));
    }

    public function export(Request $request)
    {

        $years = range(date('Y'), 2000);
        $months = MasterMonth::orderBy('month_id', 'asc')->get();
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $districts = MasterDistrict::orderBy('district_id', 'asc')->get();
        //$districts = MasterDistrict::where('state_id', $request->state_id)->get();

        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $year;
        }

        if ($month)
            $claimcases = ClaimCase::whereYear('created_at', $request->year)->whereMonth('created_at', $request->month)->where('case_status_id', '>', 1)->get();

        else
            $claimcases = ClaimCase::whereYear('created_at', $request->year)->where('case_status_id', '>', 1)->get();


        if ($request->format == 'pdf') {
            $this->data['months'] = $months;
            $this->data['month'] = $month;
            $this->data['states'] = $states;
            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['next_month'] = $next_month;
            $this->data['next_year'] = $next_year;
            $this->data['districts'] = $districts;
            $this->data['claimcases'] = $claimcases;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report27/printreport27', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan27.pdf');
        } else if ($request->format == 'excel') {

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report27_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.filed_online_transaction')) . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.year')) . ' ' . $year . ' ' . strtoupper(__('new.at_hq')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $total_online = 0;
            $total_offline = 0;

            /////////// Data
            foreach ($states as $index => $state) {

                $claimcase = (clone $claimcases)->where('state_id', $state->state_id);
                $case_online = (clone $claimcase)->where('is_online_purchased', 1);
                $case_offline = (clone $claimcase)->where('is_online_purchased', 0);

                $total_online += count($case_online);
                $total_offline += count($case_offline);

                $data = [
                    $state->state_name,
                    (string)count($claimcase),
                    (string)count($case_online),
                    (string)count($case_offline)
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $total = [
                strtoupper(__('new.total')),
                (string)count($claimcases),
                (string)$total_online,
                (string)$total_offline
            ];

            $percentage = [
                strtoupper(__('new.percentage')),
                (string)(count($claimcases) > 0 ? 100.00 : 0.00) . "%",
                (string)(count($claimcases) > 0 ? round($total_online / count($claimcases) * 100, 2) : 0.00) . '%',
                (string)(count($claimcases) > 0 ? round($total_offline / count($claimcases) * 100, 2) : 0.00) . '%'
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;
            $row_percentage = $num_rows + $total_row + 2;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);
            $objPHPExcel->getActiveSheet()->fromArray($percentage, NULL, 'A' . $row_percentage);

            $objPHPExcel->getActiveSheet()->getStyle('A' . $row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row_percentage)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

            $tmp_file = storage_path('tmp/report27_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
