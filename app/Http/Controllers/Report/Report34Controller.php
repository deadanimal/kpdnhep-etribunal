<?php

namespace App\Http\Controllers\Report;

use App;
use App\Http\Controllers\Controller;
use App\SupportModel\Suggestion;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PHPExcel_Writer_Excel2007;



class Report34Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $input = $request->all();
        $is_search = count($input) > 0 ? true : false;
        $input['year'] = $request->year;
        $gen = isset($input['gen']) ? $input['gen'] : 'w';


        $param = $input;
        $param['year'] = $request->year;
       
       
    
        if ($is_search) {
         
             $suggestions = self::query($input);
             switch ($gen) {
                case 'p':
                    return $this->generatePdf($suggestions, $input, $param);
                    break;
                case 'e':
                    return $this->generateXML('xlsx', $suggestions, $input, $param);
                    break;
                case 'c':
                    return $this->generateXML('csv', $suggestions, $input, $param);
                    break;
                case 'w':
                default:
                    return view('report.report34.index')
                        ->with(compact('suggestions','is_search','input','param'));
                    break;
            }
        }
 
        return view('report.report34.index',compact('is_search','input','param'));
    }

    public function query($input)
    {
        
        $date = Carbon::createFromFormat('Y',$input['year']);
        $suggestions = Suggestion::with('created_by')
            ->whereBetween('created_at', [
                $date->startOfYear()->toDateTimeString(),
                $date->endOfYear()->toDateTimeString(),

            ])
            ->orderBy('created_at','asc');
        return $suggestions->get();
    }

    public function generatePdf($suggestions, $input , $param)
    {
        $pdf = PDF::loadView('report/report34/pdf', compact('suggestions', 'input','param'))
            ->setOrientation('landscape')
            ->setPaper('A3')
            ->setOption('enable-javascript', true);

        return $pdf->stream('R34' . date("_Ymd_His") . '.pdf');
    }

    public function generateXml($type,$suggestions, $input , $param)
    {
        $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report34_' . App::getLocale() . '.xlsx'));
        $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        // title
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal'))
            . "\n" . strtoupper(__('new.report34'))
            . "\n" . $param['year']);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        //data loop

        if (count($suggestions) > 0) {
            foreach ($suggestions as $key => $datum)
            {
                $data = [
                    $key + 1,
                    $datum->suggestion_id,
                    $datum->subject,
                    $datum->suggestion,
                    $datum->responded_by_user_id,
                    $datum->created_by_user_id,
                    $datum->created_at->todatestring()
                ];

                $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $key + 3)); 
            }
        }

       // borders
       $objPHPExcel->getActiveSheet()
       ->getStyle(
           'A0:' .
           'E' .
           $objPHPExcel->getActiveSheet()->getHighestRow()
       )
       ->getBorders()
       ->getAllBorders()
       ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        if (!file_exists(storage_path('tmp'))) {
            mkdir(storage_path('tmp'));
}

        $tmp_file = storage_path('tmp/report5_' . uniqid() . '.xlsx');
        $objWriter->save($tmp_file);

        return response()->download($tmp_file)->deleteFileAfterSend(true);
        
    
    }
}
    



    