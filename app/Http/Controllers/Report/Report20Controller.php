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

use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;

use Auth;
use DB;
use App;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Style_Alignment;

class Report20Controller extends Controller
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
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $claimcases = ClaimCase::whereBetween('created_at', [$date_start, $date_end])
            ->where('case_status_id', 8)
            ->whereHas('claimant_address', function($q) {
                $q->where('nationality_country_id', '!=', 129);
            })
            ->get();

        return view("report.report20.view", compact('date_start', 'date_end', 'claimcases'));
    }

    public function export(Request $request)
    {

        $years = range(date('Y'), 2000);
        $year = $request->year ? $request->year : date('Y');

        $claimcases = ClaimCase::whereYear('created_at', $year)->where('case_status_id', 8)->get();

        if ($request->format == 'excel') {

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report20_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.report20')) . ' ' . strtoupper(__('new.on_year')) . ' ' . $year);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);


            /////////// Data
            foreach ($claimcases as $index => $claimcase) {

                $data = [
                    ($index + 1) . '. ',
                    $claimcase->case_no,
                    $claimcase->claimant_address->name,
                    $claimcase->claimant_address->identification_no,
                    $claimcase->claimant_address->nationality->country,
                    $claimcase->form1->classification->classification_my,
                    (string)number_format($claimcase->form1->claim_amount, 2, '.', ',')
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'G' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report20_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
