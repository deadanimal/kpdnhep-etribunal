<?php

namespace App\Http\Controllers;

use App\MasterModel\MasterSubdistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\MasterModel\MasterBranch;
use App\MasterModel\MasterState;
use App\MasterModel\MasterDistrict;
use App\MasterModel\MasterHoliday;
use App\MasterModel\MasterDesignationType;
use App\UserTTPM;
use App\HearingModel\Hearing;
use App\SupportModel\Attachment;
use Carbon\Carbon;
use DB;
use ZipArchive;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PHPExcel_Style_Border;
use PHPExcel_Style_NumberFormat;

class GeneralController extends Controller
{
    public function getDistricts($state_id)
    {
        if ($state_id) {
            $state_districts = [];
            $state = MasterState::find($state_id);

            if ($state->districts) {
                $state_districts = $state->districts;
            }

            return response()->json(['state_districts' => $state_districts]);
        }
    }

    public function getSubdistricts($state_id, $district_id)
    {
        if ($state_id) {
            $state_subdistricts = MasterSubdistrict::where('district_id', $district_id)
//                ->where('level',1)
                ->pluck('name','id');

            return response()->json(['state_subdistricts' => $state_subdistricts]);
        }
    }

    public function getDesignation($designation_type_id)
    {
        if ($designation_type_id) {
            $designations = MasterDesignationType::find($designation_type_id)->designations;
            return Response::json(['designation' => $designations]);
        }
    }

    public function getSignatureImage($ttpm_user_id)
    {
        if ($ttpm_user_id) {
            $ttpm_user = UserTTPM::where('user_id', $ttpm_user_id)->first();

            $filename = $ttpm_user->signature_filename;

            $file_path = "/data/signatures/" . $filename;

            if ($ttpm_user->signature_blob) {
                return response($ttpm_user->signature_blob)->header('Content-Type', 'image/png');
            } else if (file_exists($file_path)) {
                // Send Download
                return response()->download($file_path, $filename, [
                    'Content-Length: ' . filesize($file_path)
                ]);
            } else {
                // Error
                // exit('Requested file does not exist on our server!');
                abort(404);
            }
        }
    }

    public function getAttachment($attachment_id)
    {
        if ($attachment_id) {
            $attachment = Attachment::find($attachment_id);

            if ($attachment->file_blob) {
                return response($attachment->file_blob, 200)->header('Content-Type', $attachment->mime);
            } else {
                $filename = $attachment->v1_id . "_" . $attachment->attachment_name;
                $file_path = "/data/uploads/" . $filename;

                if (file_exists($file_path)) {
                    return response()->download($file_path, $filename, [
                        'Content-Length: ' . filesize($file_path)
                    ]);
                } else {
                    abort(404);
                }
            }
        } else abort(404);
    }

    public function getAttachmentList($form_no, $form_id)
    {
        if ($form_no && $form_id) {
            $attachment = Attachment::select('attachment_id', 'attachment_name', DB::raw('length(file_blob) AS size'))->get();

            for ($i = 0; $i < $attachment->count(); $i++) {
                $attachment[$i]->url = route("general-getattachment", ['attachment_id' => $attachment[$i]->attachment_id, 'filename' => $attachment[$i]->attachment_name]);
            }

            return response()->json($attachment);
        }
    }

    public function getHearingsFromFilter(Request $request)
    {
        $hearings = Hearing::with('hearing_room.venue')->orderBy('hearing_date', 'desc');

        if ($request->has('branch_id') && !empty($request->branch_id))
            $hearings->where('branch_id', $request->branch_id);

        if ($request->has('year') && !empty($request->year))
            $hearings->whereYear('hearing_date', $request->year);

        if ($request->has('month') && !empty($request->month))
            $hearings->whereMonth('hearing_date', $request->month);

        return response()->json(['hearings' => $hearings->get()]);
    }


    public function getHearingFromBranch(Request $request, $branch_id)
    {
        $data = $request->all();
        $branch = MasterBranch::with('hearings', 'hearings.hearing_room.venue');

        if ($branch_id) {
            $branch->where('branch_id', $branch_id);
        }

        $branchs = $branch->get();
        $data_hearings = [];
        if (isset($branchs[0])) {
            $hearings_q = $branchs[0]->hearings();

            if (isset($data['year']) && $data['year'] != 'null') {
                $hearings_q->whereBetween('hearing_date', [$data['year'] . '-01-01', $data['year'] . '-12-31']);
            }

            if (isset($data['month']) && $data['month'] != 'null') {
                $hearings_q->whereBetween('hearing_date', [
                    Carbon::createFromFormat('Y-m-d', $data['year'] . '-' . $data['month'] . '-1')
                        ->startOfMonth()->toDateString(),
                    Carbon::createFromFormat('Y-m-d', $data['year'] . '-' . $data['month'] . '-1')
                        ->endOfMonth()->toDateString()
                ]);
            }

            if (isset($data['date']) && $data['date'] != 'null') {
                $hearings_q->where('hearing_date', '>=', Carbon::createFromFormat('d/m/Y', $data['date'])
                    ->subYears(2)->toDateString());
            }

            $hearings = $hearings_q->orderBy('hearing_date', 'desc')->get();

            // $data_hearings = [];
            foreach ($hearings as $key => $hearing) {
                $data_hearings[$key] = [
                    'hearing_id' => $hearing->hearing_id,
                    'hearing_date' => $hearing->hearing_date,
                    'hearing_time' => $hearing->hearing_time,
                    'hearing_venue' => $hearing->hearing_room->venue->hearing_venue ?? '-',
                    'hearing_room' => $hearing->hearing_room->hearing_room ?? '-',
                ];
            }
        }

        return response()->json(['hearings' => $data_hearings]);
    }

    public function getHearingFromState($state_id)
    {
        if ($state_id) {
            $state = MasterState::with('branches.venues.rooms.hearings')->where('state_id', $state_id)->get();

            foreach ($state->first()->branches as $branch) {
                # code...
                foreach ($branch->venues as $venue) {
                    # code...
                    foreach ($venue->rooms as $room) {
                        # code...
                        foreach ($room->hearings as $hearing) {
                            # code...
                            $hearing->hearing_date = date("d/m/Y", strtotime($hearing->hearing_date));
                            $hearing->hearing_time = date("h:i A", strtotime($hearing->hearing_time));
                        }
                    }
                }
            }

            return response()->json(['branches' => $state->first()->branches]);
        }
    }

    public function getVenueFromBranch($branch_id)
    {
        if ($branch_id) {
            $branch = MasterBranch::with(['venues.rooms'])->where('branch_id', $branch_id)->get();

            return response()->json(['venues' => $branch->first() ? $branch->first()->venues : []]);
        }
    }

    public function getPSUFromBranch($branch_id)
    {
        if ($branch_id) {
            $branch = MasterBranch::where('branch_id', $branch_id)->first();
            $psus = [];

            if (!empty($branch) && $branch->psus) {
                $psus = $branch->psus;
            }

            return response()->json(['psus' => $psus]);
        }
    }

    public function getDateExcludeHolidaysByState($start_date, $days, $state_id)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date = (clone $start_date)->addDays($days)->toDateString();
        $current_date = (clone $start_date)->subDay();

        $state = MasterState::find($state_id);

        if ($state->is_friday_weekend == 1)
            $holidays = MasterHoliday::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('state_id', $state_id)->whereIn('day_in_week', [0, 1, 2, 3, 4])->get();
        else
            $holidays = MasterHoliday::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('state_id', $state_id)->whereIn('day_in_week', [1, 2, 3, 4, 5])->get();

        $i = 0;
        while ($i <= $holidays->count() + $days) {
            $current_date->addDay();

            if ($state->is_friday_weekend == 1) {
                if ($current_date->dayOfWeek == 5 || $current_date->dayOfWeek == 6)
                    continue;
            } else {
                if ($current_date->dayOfWeek == 6 || $current_date->dayOfWeek == 0)
                    continue;
            }

            $i++;

        }

        return $current_date->toDateString();

        //return response()->json(['date' => $current_date->toDateString(), 'day' => localeDay(date('l', strtotime($current_date->toDateTimeString())))]);
    }

    public function getDateExcludeHolidaysByBranch($start_date, $days, $branch_id)
    {

        //dd(Carbon::createFromFormat('Y-m-d', $start_date)->dayOfWeek);

        $start_date = Carbon::createFromFormat('Y-m-d', $start_date);
        $end_date = (clone $start_date)->addDays($days)->toDateString();
        $current_date = (clone $start_date)->subDay();

        $state = MasterBranch::find($branch_id)->state;

        if ($state->is_friday_weekend == 1)
            $holidays = MasterHoliday::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('state_id', $state->state_id)->whereIn('day_in_week', [0, 1, 2, 3, 4])->get();
        else
            $holidays = MasterHoliday::whereDate('holiday_date', '>=', $start_date)->whereDate('holiday_date', '<=', $end_date)->where('state_id', $state->state_id)->whereIn('day_in_week', [1, 2, 3, 4, 5])->get();

        $i = 0;
        while ($i <= $holidays->count() + $days) {
            $current_date->addDay();

            if ($state->is_friday_weekend == 1) {
                if ($current_date->dayOfWeek == 5 || $current_date->dayOfWeek == 6)
                    continue;
            } else {
                if ($current_date->dayOfWeek == 6 || $current_date->dayOfWeek == 0)
                    continue;
            }

            $i++;

        }

        return $current_date->toDateString();

        //return response()->json(['date' => $current_date->toDateString(), 'day' => localeDay(date('l', strtotime($current_date->toDateTimeString())))]);
    }

    public function integrateDocTemplate($template, $parameters)
    {
        $temp_id = uniqid();
        $real_file = storage_path('templates/' . $template . '.docx');
        $temp_file = storage_path('tmp/' . $temp_id . '.docx');

        if (!file_exists(storage_path('tmp'))) {
            mkdir(storage_path('tmp'));
        }

        if (!copy($real_file, $temp_file)) {
            dd("Failed to copy " . $real_file);
        }

        $zip = new ZipArchive;
        $fileToModify = 'word/document.xml';
        if ($zip->open($temp_file) === TRUE) {
            //Read contents into memory
            $oldContents = $zip->getFromName($fileToModify);
            //Modify contents:
            foreach ($parameters as $key => $value) {
                $oldContents = str_replace($key, $value, $oldContents);
            }
            //Delete the old...
            $zip->deleteName($fileToModify);
            //Write the new...
            $zip->addFromString($fileToModify, $oldContents);
            //And write back to the filesystem.
            $zip->close();

            //chmod($temp_file, 0777);

            return $temp_file;
        } else {
            dd('Failed opening the file');
        }


    }


    public function integrateExcelTemplate()
    {

        $data = ['1. ', 'KEDAH', '10', '6', '4', '5', '2', '5', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '9'];
        $data2 = ['2. ', 'WILAYAH PERSEKUTUAN PUTRAJAYA', '10', '66468468468456', '4', '5', '2', '5', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '9'];

        $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/test.xlsx'));
        $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();
        //echo $num_rows;

        /**autosize*/
        /**autosize*/
        // for ($col = 'A'; $col != 'W'; $col++) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        // }
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        /**format*/
        $objPHPExcel->getActiveSheet()
            ->getStyle('D' . $num_rows . ':D' . ($num_rows + 1 + 16))
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'TRIBUNAL TUNTUTAN PENGGUNA MALAYSIA
JUMLAH PEMFAILAN TUNTUTAN TAHUN 2017 MENGIKUT NEGERI DAN CARA PENYELESAIAN
( SEHINGGA 03/11/2017 )');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        for ($i = 0; $i < 16; $i += 2) {
            $objPHPExcel->getActiveSheet()->fromArray($data, NULL, 'A' . ($num_rows + $i + 1));
            $objPHPExcel->getActiveSheet()->fromArray($data2, NULL, 'A' . ($num_rows + $i + 2));
        }

        /** Borders for all data */
        $objPHPExcel->getActiveSheet()->getStyle(
            'A0:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(storage_path('templates/test2.xlsx'));

        return response()->download(storage_path('templates/test2.xlsx'))->deleteFileAfterSend(true);

    }
}
