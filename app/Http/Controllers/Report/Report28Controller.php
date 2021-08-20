<?php

namespace App\Http\Controllers\Report;

use App;
use App\CaseModel\Inquiry;
use App\Http\Controllers\Controller;
use App\Repositories\MasterStateRepository;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;

class Report28Controller extends Controller
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
        $locale = App::getLocale();
        $state_list = MasterStateRepository::getAllByBranch()
            ->mapWithKeys(function ($datum) {
                return [$datum->branches[0]->branch_id => $datum->state_name];
            });
        $inquiry_methods_list = App\Repositories\MasterInquiryMethodRepository::getAll()
            ->pluck('method_' . $locale, 'inquiry_method_id');
        $is_search = count($input) > 0;
        $data_final = [];
        $gen = isset($input['gen']) ? $input['gen'] : 'w';

        $input['date_start'] = $request->date_start
            ? Carbon::createFromFormat('d/m/Y', $request->date_start)->toDateString()
            : date('Y-m-d');
        $input['date_end'] = $request->date_end
            ? Carbon::createFromFormat('d/m/Y', $request->date_end)->toDateString()
            : date('Y-m-d');
        $input['state_id'] = $request->state_id ?: '';

        if ($is_search) {
            $data_final = self::prepTemplate($inquiry_methods_list, $state_list);
            $data_raw = self::query($input);

            foreach ($data_raw as $datum) {
                $data_final[$datum->branch_id][$datum->inquiry_method_id] = $datum->total;
                $data_final[$datum->branch_id]['total'] += $datum->total;

                $data_final['total'][$datum->inquiry_method_id] += $datum->total;
                $data_final['total']['total'] += $datum->total;
            }
        }

        switch ($gen) {
            case 'p':
//                return $this->generatePdf($data_final, $input, $param);
                break;
            case 'e':
                return $this->generateXML($data_final, $input, $locale, $state_list, $inquiry_methods_list);
                break;
            case 'c':
//                return $this->generateXML('csv', $data_final, $input, $param);
                break;
            case 'w':
            default:
                return view('report.report28.index')
                    ->with(compact('input', 'is_search', 'data_final', 'locale', 'state_list', 'inquiry_methods_list'));
                break;
        }

    }

    /**
     * fetch data using query
     * @param $input
     * @return \App\CaseModel\Inquiry[]|\Illuminate\Database\Eloquent\Collection
     */
    protected static function query($input)
    {
        $data = Inquiry::select([
            DB::raw('count(inquiry_id) as total'),
            'inquiry_method_id',
            'branch_id'
        ])
            ->whereBetween('created_at', [$input['date_start'], $input['date_end']]);

        if ($input['state_id'] != null) {
            $data->where('branch_id', $input['state_id']);
        }

        return $data->groupBy(['branch_id', 'inquiry_method_id'])
            ->get();
    }

    protected static function prepTemplate($inquiry_methods_list, $state_list)
    {
        /**
         * state_1
         * |_ method_1
         * |_ ...
         * |_ total
         * ...
         * total
         * |_ method_1
         * |_ ...
         * |_ total
         */

        return self::prepStateTemplate($state_list, $inquiry_methods_list);
    }

    protected static function prepStateTemplate($state_list, $inquiry_methods_list)
    {
        $method_template = self::prepMethodTemplate($inquiry_methods_list);

        $template = [];

        foreach ($state_list as $i => $data) {
            $template[$i] = $method_template;
        }

        $template['total'] = $method_template;

        return $template;
    }

    protected static function prepMethodTemplate($inquiry_methods_list)
    {
        $inquiry_methods_list_clone = clone $inquiry_methods_list;
        $inquiry_methods_list_clone = $inquiry_methods_list_clone->toArray();
        foreach ($inquiry_methods_list_clone as $i => $data) {
            $inquiry_methods_list_clone[$i] = 0;
        }

        $inquiry_methods_list_clone['total'] = 0;

        return $inquiry_methods_list_clone;
    }

    protected function generateXML($data_final, $input, $locale, $state_list, $inquiry_methods_list)
    {
        $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report28_' . $locale . '.xlsx'));
        $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

        $col = 'A';
        foreach ($inquiry_methods_list as $im) {
            $col++;
            $objPHPExcel->getActiveSheet()->SetCellValue($col . '3', strtoupper($im));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->mergeCells('B2:' . $col . '2');
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', strtoupper(__('new.method')));
        $objPHPExcel->getActiveSheet()->getStyle($col . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //Total column
        $col++;
        $objPHPExcel->getActiveSheet()->mergeCells($col . '2:' . $col . '3');
        $objPHPExcel->getActiveSheet()->SetCellValue($col . '2', strtoupper(__('new.total')));
        //$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);


        /////////// Title
        $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $col . '1');
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')) . '
' . strtoupper(__('new.inquiry_method_for')) . ' ' . ($month ? strtoupper(__('new.month')) . ' ' . strtoupper($month->$month_lang) : '') . ' ' . strtoupper(__('new.year')) . ' ' . $year . '
' . '( ' . strtoupper(__('new.until')) . ' ' . date('d/m/Y') . ' )');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        /////////// Data
        foreach ($states as $index => $state) {

            $inquiry = (clone $inquiries)->where('state_id', $state->state_id);

            $data = array($state->state_name);

            foreach ($inquirymethods as $im) {
                $inq = (clone $inquiry)->where('inquiry_method_id', $im->inquiry_method_id);
                array_push($data, (string)count($inq));
            }
            array_push($data, (string)count($inquiry));

            $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $index + 1));
        }

        //

        $total = array(strtoupper(__('new.total')));
        foreach ($inquirymethods as $im) {
            $inq = (clone $inquiries)->where('inquiry_method_id', $im->inquiry_method_id);
            array_push($total, (string)count($inq));
        }
        array_push($total, (string)count($inquiries));

        //dd($total);

        $row_total = $num_rows + $total_row + 1;

        $objPHPExcel->getActiveSheet()->fromArray($total, NULL, 'A' . $row_total);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row_total)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

        $tmp_file = storage_path('tmp/report28_' . uniqid() . '.xlsx');
        $objWriter->save($tmp_file);

        return response()->download($tmp_file)->deleteFileAfterSend(true);
    }
}
