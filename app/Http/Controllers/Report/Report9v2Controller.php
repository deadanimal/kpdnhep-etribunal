<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;

use App\Role;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\SupportModel\Visitor;

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

use Yajra\Datatables\Datatables;

class Report9v2Controller extends Controller
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
        $is_search = count($input) > 0;

        $months = MasterMonth::all();
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $state_list = MasterState::pluck('state_name', 'state_id');

        $input['date_start'] = isset($input['date_start']) && $input['date_start'] != ''
            ? Carbon::createFromFormat('d/m/Y', $input['date_start'])->startOfDay()->toDateTimeString()
            : Carbon::parse()->startOfMonth()->toDateTimeString();
        $input['date_end'] = isset($input['date_end']) && $input['date_end'] != ''
            ? Carbon::createFromFormat('d/m/Y', $input['date_end'])->endOfDay()->toDateTimeString()
            : Carbon::parse()->endOfMonth()->toDateTimeString();
        $input['state_id'] = $request->state_id ?? '';

        $gen = isset($input['gen']) ? $input['gen'] : 'w';

        if ($is_search) {
            $data_final = self::query($input);

            switch ($gen) {
                case 'p':
//                    return $this->generatePdf($data_final, $input, $param);
                    break;
                case 'e':
//                    return $this->generateXML('xlsx', $data_final, $input, $param);
                    break;
                case 'c':
//                    return $this->generateXML('csv', $data_final, $input, $param);
                    break;
                case 'w':
                default:
                    return view('report.report9v2.index')
                        ->with(compact('states', 'is_search', 'data_final', 'input', 'param',
                            'state_list', 'months'));
                    break;
            }
        }

        return view('report.report9v2.index')
            ->with(compact('states', 'is_search', 'input', 'param', 'state_list', 'months'));
    }

    public function query($input)
    {
        $data = Visitor::whereBetween('visitor_datetime', [
            $input['date_start'], $input['date_end']
        ]);

        if ($input['state_id'] != '') {
            $data = $data->whereHas('psu', function ($f4) use ($input) {
                $f4->whereHas('ttpm_data', function ($cc) use ($input) {
                    $cc->whereHas('branch', function ($q) use ($input) {
                        $q->where('branch_state_id', $input['state_id']);
                    });
                });
            });
        }

        return $data;
    }

    public function export(Request $request)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $months = MasterMonth::all();

        $years = range(date('Y'), 2000);
        $year = $request->year ? $request->year : date('Y');
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $visitor = Visitor::whereYear('visitor_datetime', '>=', $request->year ? $request->year : date('Y'));

        if ($request->format == 'pdf') {
            $this->data['states'] = $states;
            $this->data['months'] = $months;
            $this->data['year'] = $year;
            $this->data['years'] = $years;
            $this->data['visitor'] = $visitor;
            $this->data['user'] = $user;
            $this->data['userid'] = $userid;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report9/printreport9', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan9.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;
            $abbrev_lang = 'abbrev_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report9_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.attendance_vsitor')) . ' ' . $year . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $total_state = 0;

            /////////// Data
            foreach ($states as $index => $state) {

                $visitor_state = (clone $visitor)->get()->where('state_id', $state->state_id);
                $total_state += count($visitor_state);

                $data = array($state->state_name);

                foreach ($months as $month) {
                    $visitor_state_month = (clone $visitor)->whereMonth('visitor_datetime', $month->month_id)->get()->where('state_id', $state->state_id);
                    array_push($data, (string)count($visitor_state_month));
                }

                //dd($data);

                array_push($data, (string)count($visitor_state));

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            //

            $total = array(strtoupper(__('new.total')));

            foreach ($months as $month) {
                $visitor_month = (clone $visitor)->whereMonth('visitor_datetime', $month->month_id)->get();
                array_push($total, (string)count($visitor_month));
            }
            array_push($total, (string)$total_state);

            //dd($total);

            $row_total = $num_rows + $total_row + 1;
            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->getStyle('A' . $row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'N' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report9_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }

    public function showmodal(Request $request)
    {
        $date_start = $request->date_start ?? date('Y-m-d');
        $date_end = $request->date_end ?? date('Y-m-d');
        $state_id = $request->state_id ?? '';
        $month = $request->month ?? '';

        return view('report/report9/showmodal', compact('date_start', 'date_end', 'state_id', 'month'));
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
        $month = $request->month ?? '';

        $visitor = Visitor::whereBetween('visitor_datetime', [$date_start, $date_end]);

        if (!empty($month)) {
            $visitor->whereMonth('visitor_datetime', $month);
        }

        // if ($state_id != '') {
        if (!empty($state_id)) {
            $visitor->whereHas('psu', function ($f4) use ($state_id) {
                $f4->whereHas('ttpm_data', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $datatables = Datatables::of($visitor);

        return $datatables->make(true);
    }

}
