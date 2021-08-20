<?php

namespace App\Http\Controllers\Report;

use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
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

use Auth;
use DB;
use App;
use PDF;
use App\CaseModel\AwardDisobey;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class Report7Controller extends Controller
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

        return view('report/report7/modalFind', compact('years', 'states'));

    }

    public function list(Request $request)
    {
        $year = $request->year;
        $award_type = $request->award_type;
        $date_start = $request->date_start ?? date('Y-m-d');
        $date_end = $request->date_end ?? date('Y-m-d');
        $state_id = $request->state_id ?? '';
        return view('report/report7/modalList', compact('year', 'award_type', 'date_start', 'date_end', 'state_id'));
    }

    public function data(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start
            ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString()
            : date('Y-m-d');
        $date_end = $request->date_end
            ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString()
            : date('Y-m-d');
        $award_type = $request->award_type ?? '';

        // $award_disobey = AwardDisobey::whereYear('complaint_at', $request->year)->get()->where('award_type', $request->award_type);
        $award_disobey = AwardDisobey::whereBetween('complaint_at', [$date_start, $date_end]);

        $award_disobey->whereHas('form4', function ($f4) use ($state_id, $award_type) {
            $f4->whereHas('case', function ($cc) use ($state_id) {
                $cc->whereHas('branch', function ($q) use ($state_id) {
                    if (!empty($state_id)) {
                        $q->where('branch_state_id', $state_id);
                    }
                });
            });
            $f4->whereHas('award', function ($q) use ($award_type) {
                if (!empty($award_type)) {
                    $q->where('award_type', $award_type);
                }
            });
        });

        $datatables = Datatables::of($award_disobey);

        return $datatables
            ->editColumn('case_no', function ($award_disobey) {
                return "<a class='btn btn-sm btn-primary' href='" . route('awarddisobey.view', [$award_disobey->award_disobey_id]) . "'><i class='fa fa-search'></i> " . $award_disobey->form4->case->case_no . "</a>";
            })
            ->make(true);

    }

    public function view(Request $request)
    {
        $states = MasterState::pluck('state_name', 'state_id');

        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $award_disobey = AwardDisobey::whereBetween('complaint_at', [$date_start, $date_end]);

        if ($state_id != '') {
            $award_disobey->whereHas('form4', function ($f4) use ($state_id) {
                $f4->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $award_disobey = $award_disobey->get();

        return view('report/report7/view', compact('award_disobey', 'state_id', 'date_start', 'date_end', 'states'));

    }

    public function export(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start
            ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString()
            : date('Y-m-d');
        $date_end = $request->date_end
            ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString()
            : date('Y-m-d');

        $award_disobey = AwardDisobey::whereBetween('complaint_at', [$date_start, $date_end]);

        if ($state_id != '') {
            $award_disobey->whereHas('form4', function ($f4) use ($state_id) {
                $f4->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $award_disobey = $award_disobey->get();

        if ($request->format == 'pdf') {
            $this->data['award_disobey'] = $award_disobey;
            $this->data['date_start'] = $date_start;
            $this->data['date_end'] = $date_end;
            $this->data['request'] = $request;

            $pdf = PDF::loadView('report/report7/printreport7', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan7.pdf');
        } else if ($request->format == 'excel') {
            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report7_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
                ' . strtoupper(__('new.award_type_year')) . ' ' . $date_start . ' - ' . $date_end . '
                ' . '( ' . strtoupper(__('new.until')) . ' ' . date('d / m / Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $form5 = (clone $award_disobey)->where('award_type', 5);
            $form6 = (clone $award_disobey)->where('award_type', 6);
            $form7 = (clone $award_disobey)->where('award_type', 7);
            $form8 = (clone $award_disobey)->where('award_type', 8);
            $form9 = (clone $award_disobey)->where('award_type', 9);
            $form10 = (clone $award_disobey)->where('award_type', 10);

            $objPHPExcel->getActiveSheet()->SetCellValue('C3', count($form5));
            $objPHPExcel->getActiveSheet()->SetCellValue('C4', count($form6));
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', count($form7));
            $objPHPExcel->getActiveSheet()->SetCellValue('C6', count($form8));
            $objPHPExcel->getActiveSheet()->SetCellValue('C7', count($form9));
            $objPHPExcel->getActiveSheet()->SetCellValue('C8', count($form10));

            $objPHPExcel->getActiveSheet()->SetCellValue('D3', (string)(count($award_disobey) != 0 ? number_format(count($form5) / count($award_disobey) * 100, 2, ' . ', '') : '0.00'));
            $objPHPExcel->getActiveSheet()->SetCellValue('D4', (string)(count($award_disobey) != 0 ? number_format(count($form6) / count($award_disobey) * 100, 2, ' . ', '') : '0.00'));
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', (string)(count($award_disobey) != 0 ? number_format(count($form7) / count($award_disobey) * 100, 2, ' . ', '') : '0.00'));
            $objPHPExcel->getActiveSheet()->SetCellValue('D6', (string)(count($award_disobey) != 0 ? number_format(count($form8) / count($award_disobey) * 100, 2, ' . ', '') : '0.00'));
            $objPHPExcel->getActiveSheet()->SetCellValue('D7', (string)(count($award_disobey) != 0 ? number_format(count($form9) / count($award_disobey) * 100, 2, ' . ', '') : '0.00'));
            $objPHPExcel->getActiveSheet()->SetCellValue('D8', (string)(count($award_disobey) != 0 ? number_format(count($form10) / count($award_disobey) * 100, 2, ' . ', '') : '0.00'));

            $objPHPExcel->getActiveSheet()->SetCellValue('C9', count($award_disobey));
            $objPHPExcel->getActiveSheet()->SetCellValue('D9', '100.00');

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report7_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
