<?php

namespace App\Http\Controllers\Report;

use App;
use App\Http\Controllers\Controller;
use App\MasterModel\MasterState;
use App\PaymentModel\PaymentFPX;
use App\PaymentModel\Payment;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;

class Report24Controller extends Controller
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

    /**
     * Show report 24 view
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function view(Request $request)
    {
        $state_id = $request->state_id ?? '';
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $state_list = MasterState::pluck('state_name', 'state_id');

        $start_date = $request->has('start_date')
            ? Carbon::createFromFormat('d/m/Y', $request->start_date)
            : Carbon::parse()->startOfYear();
        $end_date = $request->has('end_date')
            ? Carbon::createFromFormat('d/m/Y', $request->end_date)
            : Carbon::parse()->endOfYear();

        $payments = PaymentFPX::has('payment')
            ->where('fpx_status_id', '00')
            ->whereBetween('paid_at', [$start_date->startOfDay(), $end_date->endOfDay()]);

        if ($state_id != '') {
            $payments->whereHas('payment', function ($f1) use ($state_id) {
                $f1->whereHas('case', function ($cc) use ($state_id) {
                    $cc->whereHas('branch', function ($q) use ($state_id) {
                        $q->where('branch_state_id', $state_id);
                    });
                });
            });
        }

        $start_date = $start_date->format('d/m/Y');
        $end_date = $end_date->format('d/m/Y');

        $payments = $payments->orderBy('paid_at', 'desc')->get();

        return view('report.report24.view', compact('years', 'months', 'states', 'payments', 'start_date', 'end_date', 'state_list', 'state_id'));
    }

    public function edit($id)
    {
        if ($id) {
            $fpx = PaymentFPX::find($id);

            return view("report.report24.modalUpdate", compact('fpx'));
        }
    }

    public function update(Request $request)
    {
        if ($request->fpx_id != NULL) {
            if ($validator->passes()) {
                $payment = Payment::find($request->fpx_id)->update([
                    'receipt_no' => $request->receipt_no,
                ]);
                return Response::json(['status' => 'ok', 'message' => __('new.create_success')]);
            } else {
                return Response::json(['status' => 'fail', 'message' => $validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function export(Request $request)
    {
        $states = MasterState::orderBy('state_id', 'asc')->get();
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString() : date('Y-m-d');
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString() : date('Y-m-d');
        $payments = PaymentFPX::where('fpx_status_id', '00');

        if (($request->has('start_date') && $request->has('end_date'))) {
            if ($request->has('start_date') && !empty($request->start_date) && $request->has('end_date') && !empty($request->end_date)) {
                $payments = $payments->whereDate('paid_at', '>=', Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString())->whereDate('paid_at', '<=', Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString());
            }
        }

        $start_date = date('d/m/Y', strtotime($start_date));
        $end_date = date('d/m/Y', strtotime($end_date));
        $payments = $payments->orderBy('paid_at', 'desc')->get();

        if ($request->format == 'excel') {
            $locale = App::getLocale();
            $month_lang = "month_" . $locale;
            $total_row = $payments->count();
            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report24_' . App::getLocale() . '.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

            /////////// Title
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.bussiness_report')) . '
' . strtoupper(__('new.fee_paid_online')) . ' ' . ($request->start_date && $request->end_date ? strtoupper(__('new.from_date')) . ' ' . $start_date . ' ' . strtoupper(__('new.until')) . ' ' . $end_date : ''));
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $totalcommision = '0.00';

            /////////// Data
            foreach ($payments as $index => $fpx) {
                if ($fpx->paid_at < '2018-06-01') {
                    $commision = '0.53';
                } else {
                    $commision = '0.50';
                }
                $totalcommision = $totalcommision + $commision;

                $data = [
                    $fpx->paid_at ? date('d/m/Y h:i A', strtotime($fpx->paid_at)) : '-',
                    $fpx->payment->receipt_no ? $fpx->payment->receipt_no : '-',
                    $fpx->fpx_transaction_no ? '`'.$fpx->fpx_transaction_no : '-',
                    $fpx->payment->case ? $fpx->payment->case->form1_no : '-',
                    $fpx->payment->case ? $fpx->payment->case->case_no : '-',
                    $fpx->payment->case ? 'B' . $fpx->payment->form_no : '-',
                    $fpx->paid_by,
                    $fpx->bank->name,
                    (string)$fpx->paid_amount ? $fpx->paid_amount : '-',
                    (string)$commision,
                    (string)number_format($fpx->paid_amount - $commision, 2, '.', ',')
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
            }

            $total = [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                (string)number_format($payments->sum('paid_amount'), 2, '.', ','),
                (string)number_format($totalcommision, 2, '.', ','),
                (string)number_format(($payments->sum('paid_amount') - $totalcommision), 2, '.', ',')
            ];

            //dd($total);

            $row_total = $num_rows + $total_row + 1;

            $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);

            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row_total . ':H' . $row_total);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_total, strtoupper(__('new.total')));

            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' .
                'K' .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report24_' . uniqid() . '.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);

        }

    }

}
