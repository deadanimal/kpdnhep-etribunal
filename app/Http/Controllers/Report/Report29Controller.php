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

class Report29Controller extends Controller
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
        $years = range(date('Y'), 2000);
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $districts = MasterDistrict::orderBy('district_id', 'asc')->get();

        $year = $request->year ? $request->year : date('Y');

        $masterclaimcategories = MasterClaimCategory::where('is_active', 1)->get();

        $claimcases = ClaimCase::join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
            ->whereYear('form1.processed_at', $year)
            ->where('case_status_id', 8)
            ->get();


        if ($request->has('state') && !empty($request->state)) {
            $claimcases = $claimcases->filter(function ($value) use ($request) {
                return $value->branch->branch_state_id == $request->state;
            });

            $districts = $districts->filter(function ($value) use ($request) {
                return $value->state_id == $request->state;
            });
        }

        return view("report.report29.view", compact('years', 'months', 'states',
            'masterclaimcategories', 'districts', 'claimcases'));
    }

    public function export(Request $request)
    {
        $years = range(date('Y'), 2000);
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $districts = MasterDistrict::orderBy('district_id', 'asc')->get();

        $year = $request->year ? $request->year : date('Y');

        $masterclaimcategories = MasterClaimCategory::where('is_active', 1)->get();

        $claimcases = ClaimCase::whereYear('created_at', $year)->where('case_status_id', 8)->get();

        if ($request->has('state') && !empty($request->state)) {
            $claimcases = $claimcases->filter(function ($value) use ($request) {
                return $value->branch->branch_state_id == $request->state;
            });

            $districts = $districts->filter(function ($value) use ($request) {
                return $value->state_id == $request->state;
            });
        }

        if ($request->format == 'excel') {

            $total_row = $districts->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report29_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.report29')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($districts as $index => $district) {

                $claimcase = (clone $claimcases)->where('district_id', $district->district_id);

                $data = array(strtoupper($district->district));

                foreach ($masterclaimcategories as $i => $mce) {
                    $case = (clone $claimcases)->where('district_id', $district->district_id)->where('category_id', $mce->claim_category_id);

                    array_push($data, (string)count($case));

                }

                array_push($data, (string)count($claimcase));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $total = array(strtoupper(__('new.total')));
            foreach ($masterclaimcategories as $i => $mce) {
                $claimcase = (clone $claimcases)->where('category_id', $mce->claim_category_id);
                array_push($total, (string)count($claimcase));
            }
            array_push($total, (string)count($claimcases));

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->getStyle('A' . $row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

            $tmp_file = storage_path('tmp/report29_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
