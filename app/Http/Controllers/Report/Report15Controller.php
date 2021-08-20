<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\JudicialReview;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterMonth;
use App\MasterModel\MasterState;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;
use Yajra\Datatables\Datatables;

class Report15Controller extends Controller
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
        $states = MasterState::pluck('state_name', 'state_id');

        return view('report/report15/modalFind', compact('states'));
    }

    public function list(Request $request)
    {
        $state_id = $request->state_id;
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        return view('report/report15/modalList', compact('state_id', 'year', 'month'));
    }

    public function data(Request $request)
    {
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $request->year;
        }

        if ($request->month && $request->month != 0) {
            $judicial_review = JudicialReview::whereDate('created_at', '>=', $request->year . '-' . $request->month . '-01')->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01')->where('form_status_id', 53)->get();
        } else {
            $judicial_review = JudicialReview::whereYear('created_at', $request->year)->where('form_status_id', 53)->get();
        }

        $judicial_review = $judicial_review->where('state_id', $request->state_id);

        $datatables = Datatables::of($judicial_review);

        return $datatables
            ->editColumn('case_no', function ($judicial_review) {
                return "<a class='btn btn-sm btn-primary' href='" . route('judicialreview.view', [$judicial_review->judicial_review_id]) . "'><i class='fa fa-search'></i> " . $judicial_review->form4->case->case_no . "</a>";
            })->make(true);
    }

    public function view(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $date_start = $request->date_start ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString() : date('Y-m-d');
        $date_end = $request->date_end ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString() : date('Y-m-d');

        $states = MasterState::all();
        $state_list = MasterState::pluck('state_name', 'state_id');

        $judicial_review = JudicialReview::whereBetween('created_at', [$date_start, $date_end])
            ->where('form_status_id', 53); // semakan kehakiman telah diproses

        if ($state_id != '') {
            $judicial_review->whereHas('form4', function ($f4) use ($state_id) {
                $f4->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $judicial_review = $judicial_review->get();

        return view('report/report15/view', compact('states', 'state_id', 'date_start', 'date_end', 'judicial_review', 'state_list'));
    }

    public function export(Request $request)
    {
        $userid = Auth::id();
        $user = User::find($userid);
        $year = $request->year ? $request->year : date('Y');
        $month = $request->month && $request->month != 0 ? MasterMonth::find($request->month) : null;
        if ($request->month == 12) {
            $next_month = 1;
            $next_year = $year + 1;
        } else {
            $next_month = $request->month + 1;
            $next_year = $year;
        }
        $states = MasterState::all();

        if ($month) {
            $judicial_review = JudicialReview::whereDate('created_at', '>=', $request->year . '-' . $request->month . '-01')->whereDate('created_at', '<', $next_year . '-' . $next_month . '-01')->where('form_status_id', 53)->get();
        } else {
            $judicial_review = JudicialReview::whereYear('created_at', $request->year)->where('form_status_id', 53)->get();

        }

        if ($request->format == 'pdf') {
            $this->data['userid'] = $userid;
            $this->data['user'] = $user;
            $this->data['states'] = $states;
            $this->data['judicial_review'] = $judicial_review;
            $this->data['next_month'] = $next_month;
            $this->data['next_year'] = $next_year;
            $this->data['month'] = $month;
            $this->data['year'] = $year;
            $this->data['request'] = $request;

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report15/printreport15', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan15.pdf');
        } else if ($request->format == 'excel') {

            $locale = App::getLocale();
            $month_lang = 'month_' . $locale;

            $total_row = $states->count();

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report15_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.judicial_review_award')) . ' ' . $year . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            /////////// Data
            foreach ($states as $index => $state) {

                $juriview_state = (clone $judicial_review)->where('state_id', $state->state_id);

                $data = [
                    ($index + 1) . '. ',
                    $state->state_name,
                    (string)count($juriview_state)
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $total = [
                '',
                '',
                (string)count($judicial_review)
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':B' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'C' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report15_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }


}
