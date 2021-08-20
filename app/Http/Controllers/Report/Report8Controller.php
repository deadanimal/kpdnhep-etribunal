<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\RoleUser;

use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\MasterModel\MasterState;
use App\CaseModel\AwardDisobey;

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

class Report8Controller extends Controller
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

        return view('report/report8/modalFind', compact('years', 'states'));

    }

    public function view(Request $request)
    {
        $states = MasterState::all();
        $year = $request->year ? $request->year : date('Y');

        $presidents = RoleUser::where('role_id', 4)->get()->filter(function ($query) {
            return $query->user->user_status_id == 1;
        });

        $award_disobey = AwardDisobey::whereYear('complaint_at', date('Y'));
        $case_completed = (clone $award_disobey)->get();

        $case_completed = $case_completed->filter(function ($value) {
            return $value->form4->case->case_status_id == 8;
        });

        return view('report/report8/view', compact('year', 'presidents', 'states', 'award_disobey', 'case_completed'));

    }

    public function export(Request $request)
    {

        $states = MasterState::all();
        $year = $request->year ? $request->year : date('Y');

        $presidents = RoleUser::where('role_id', 4)->get()->filter(function ($query) {
            return $query->user->user_status_id == 1;
        });

        $award_disobey = AwardDisobey::whereYear('complaint_at', date('Y'));
        $case_completed = (clone $award_disobey)->get();

        $case_completed = $case_completed->filter(function ($value) {
            return $value->form4->case->case_status_id == 8;
        });

        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['presidents'] = $presidents;
            $this->data['year'] = $year;
            $this->data['award_disobey'] = $award_disobey;
            $this->data['case_completed'] = $case_completed;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report8/printreport8', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan8.pdf');
        } else if ($request->format == 'excel') {

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report8_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            //CompanyName column
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

            //States column
            $col = 'B';
            foreach ($presidents as $prez) {
                if ($prez->user->ttpm_data->president->is_appointed != 0) {
                    $col++;
                    $objPHPExcel->getActiveSheet()->mergeCells($col . '3:' . $col . '4');
                    $objPHPExcel->getActiveSheet()->SetCellValue($col . '3', strtoupper($prez->user->ttpm_data->president->president_code));
                }
            }
            $start_appointed = $col;
            $start_appointed++;
            foreach ($presidents as $prez) {
                if ($prez->user->ttpm_data->president->is_appointed == 0) {
                    $col++;
                    $objPHPExcel->getActiveSheet()->SetCellValue($col . '4', strtoupper($prez->user->ttpm_data->president->president_code));
                }
            }
            $objPHPExcel->getActiveSheet()->mergeCells($start_appointed . '3:' . $col . '3');
            $objPHPExcel->getActiveSheet()->SetCellValue($start_appointed . '3', strtoupper(__('new.body')));

            $objPHPExcel->getActiveSheet()->mergeCells('C2:' . $col . '2');
            $objPHPExcel->getActiveSheet()->SetCellValue('C2', strtoupper(__('new.president')));

            //Total column
            $col++;
            $end_appointed = $col;
            $objPHPExcel->getActiveSheet()->mergeCells($col . '2:' . $col . '4');
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper(str_replace('<br>', '
', __('new.total_disobey'))));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(15);

            $col++;
            $objPHPExcel->getActiveSheet()->mergeCells($col . '2:' . $col . '4');
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper(str_replace('<br>', '
', __('new.percentage'))));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle($col . '5:' . $col . ($num_rows + $total_row + 1))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $col++;
            $objPHPExcel->getActiveSheet()->mergeCells($col . '2:' . $col . '4');
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper(str_replace('<br>', '
', __('new.total_filed_completed'))));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(15);

            $col++;
            $objPHPExcel->getActiveSheet()->mergeCells($col . '2:' . $col . '4');
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper(str_replace('<br>', '
', __('new.claim_remainder'))));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(15);

            $objPHPExcel->getActiveSheet()
                ->getStyle($end_appointed . '2:' . $col . '2')
                ->getAlignment()->setWrapText(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $col . '1');
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.award_disobey_for') . ' ' . __('new.year')) . ' ' . $year . ' ' . strtoupper(__('new.by_prez')) . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $index => $state) {

                $award_state = (clone $award_disobey)->with(['form4'])->get()->where('form4.state_id', $state->state_id);

                $case_state = (clone $case_completed)->filter(function ($value) use ($state) {
                    return $value->form4->case->branch->branch_state_id == $state->state_id;
                });

                $data = array(
                    ($index + 1) . '. ',
                    $state->state_name
                );

                foreach ($presidents as $prez) {
                    if ($prez->user->ttpm_data->president->is_appointed != 0) {
                        $award_prez = (clone $award_state)->where('president_user_id', $prez->user_id);
                        array_push($data, (string)count($award_prez));
                    }
                }

                foreach ($presidents as $prez) {
                    if ($prez->user->ttpm_data->president->is_appointed == 0) {
                        $award_prez = (clone $award_state)->where('president_user_id', $prez->user_id);
                        array_push($data, (string)count($award_prez));
                    }
                }
                array_push(
                    $data,
                    (string)count($award_state),
                    (string)(count($award_disobey->get()) > 0 ? number_format((count($award_state) / count($award_disobey->get())) * 100, 2, '.', ',') : '0.00'),
                    (string)count($case_state),
                    (string)(count($award_state) - count($case_state))
                );

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = array('', '');
            foreach ($presidents as $prez) {
                if ($prez->user->ttpm_data->president->is_appointed != 0) {
                    $prez = (clone $award_disobey)->get()->where('president_user_id', $prez->user_id);
                    array_push($total, (string)count($prez));
                }
            }
            foreach ($presidents as $prez) {
                if ($prez->user->ttpm_data->president->is_appointed == 0) {
                    $prez = (clone $award_disobey)->get()->where('president_user_id', $prez->user_id);
                    array_push($total, (string)count($prez));
                }
            }
            array_push($total,
                (string)count($award_disobey->get()),
                (string)100.00,
                (string)count($case_completed),
                (string)(count($award_disobey->get()) - count($case_completed))
            );

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

            $tmp_file = storage_path('tmp/report8_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }

}
