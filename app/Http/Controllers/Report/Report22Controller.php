<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\MasterModel\MasterState;
use App\MasterModel\MasterAgeRange;
use App\User;
use App\UserPublic;
use App\UserPublicIndividual;
use App\UserPublicCompany;
use App\CaseModel\ClaimCase;

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

class Report22Controller extends Controller
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

    public function filter (){

        $years = range(date('Y'), 2000);

        return view('report/report22/modalFind', compact('years'));
        
    }

    public function view (Request $request){

        $year = $request->year ? $request->year : date('Y');
        $states = MasterState::all();
        $users = UserPublicIndividual::whereYear('created_at', $year)->whereNotNull('gender_id');

        $ages = MasterAgeRange::where('is_active', 1)->get();
        return view('report/report22/view', compact('year', 'states', 'users', 'ages'));
        
    }

    public function export(Request $request){

        $year = $request->year ? $request->year : date('Y');
        $states = MasterState::all();
        $users = UserPublicIndividual::whereYear('created_at', $year)->whereNotNull('gender_id');

        if($request->format == 'pdf') {
            $this->data['users'] = $users;
            $this->data['states'] = $states;
            $this->data['year'] = $year;
            $this->data['request'] = $request;

            //return view('report/report10/printreport10', $this->data);

            //dd($this->data['report2']);
            $pdf = PDF::loadView('report/report22/printreport22', $this->data)->setOrientation('landscape');

            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Laporan22.pdf');
        }

        else if($request->format == 'excel') {

            $total_row = 17;

            $objPHPExcel = PHPExcel_IOFactory::load(storage_path('templates/report22_'.App::getLocale().'.xlsx'));
            $num_rows = $objPHPExcel->getActiveSheet()->getHighestRow();

            $user_male = (clone $users)->where('gender_id', 1)->get();
            $user_female = (clone $users)->where('gender_id', 2)->get();

            $user_male = $user_male->filter(function ($value) use ($request) {
                $case = ClaimCase::where('claim_case_id', $value->user_id)->get()->count();
                return $case > 0;
            });

            $user_female = $user_female->filter(function ($value) use ($request) {
                $case = ClaimCase::where('claim_case_id', $value->user_id)->get()->count();
                return $case > 0;
            });

            //States column
            $col = 'C';
            foreach($states as $state) {
                $col_current = $col++;

                $objPHPExcel->getActiveSheet()->mergeCells($col_current.'2:'.$col.'2');
                $objPHPExcel->getActiveSheet()->SetCellValue($col_current.'2', strtoupper($state->state_name));

                $objPHPExcel->getActiveSheet()->SetCellValue($col_current.'3', strtoupper(__('new.m')));
                $objPHPExcel->getActiveSheet()->SetCellValue($col.'3', strtoupper(__('new.f')));

                for($i=0; $i<=17; $i++) {
                    if($i == 0) {
                        $user_state_m = (clone $user_male)->where('age','<=',20);
                        $user_state_f = (clone $user_female)->where('age','<=',20);
                    }
                    else if($i == 1) {
                        $user_state_m = (clone $user_male)->where('age','>=',21)->where('age','<=', 25);
                        $user_state_f = (clone $user_female)->where('age','>=',21)->where('age','<=', 25);
                    }
                    else if($i == 2) {
                        $user_state_m = (clone $user_male)->where('age','>=',26)->where('age','<=', 30);
                        $user_state_f = (clone $user_female)->where('age','>=',26)->where('age','<=', 30);
                    }
                    else if($i == 3) {
                        $user_state_m = (clone $user_male)->where('age','>=',31)->where('age','<=', 35);
                        $user_state_f = (clone $user_female)->where('age','>=',31)->where('age','<=', 35);
                    }
                    else if($i == 4) {
                        $user_state_m = (clone $user_male)->where('age','>=',36)->where('age','<=', 40);
                        $user_state_f = (clone $user_female)->where('age','>=',36)->where('age','<=', 40);
                    }
                    else if($i == 5) {
                        $user_state_m = (clone $user_male)->where('age','>=',41)->where('age','<=', 45);
                        $user_state_f = (clone $user_female)->where('age','>=',41)->where('age','<=', 45);
                    }
                    else if($i == 6) {
                        $user_state_m = (clone $user_male)->where('age','>=',46)->where('age','<=', 50);
                        $user_state_f = (clone $user_female)->where('age','>=',46)->where('age','<=', 50);
                    }
                    else if($i == 7) {
                        $user_state_m = (clone $user_male)->where('age','>=',51)->where('age','<=', 55);
                        $user_state_f = (clone $user_female)->where('age','>=',51)->where('age','<=', 55);
                    }
                    else if($i == 8) {
                        $user_state_m = (clone $user_male)->where('age','>=',56)->where('age','<=', 60);
                        $user_state_f = (clone $user_female)->where('age','>=',56)->where('age','<=', 60);
                    }
                    else if($i == 9) {
                        $user_state_m = (clone $user_male)->where('age','>=',61)->where('age','<=', 65);
                        $user_state_f = (clone $user_female)->where('age','>=',61)->where('age','<=', 65);
                    }
                    else if($i == 10) {
                        $user_state_m = (clone $user_male)->where('age','>=',66)->where('age','<=', 70);
                        $user_state_f = (clone $user_female)->where('age','>=',66)->where('age','<=', 70);
                    }
                    else if($i == 11) {
                        $user_state_m = (clone $user_male)->where('age','>=',71)->where('age','<=', 75);
                        $user_state_f = (clone $user_female)->where('age','>=',71)->where('age','<=', 75);
                    }
                    else if($i == 12) {
                        $user_state_m = (clone $user_male)->where('age','>=',76)->where('age','<=', 80);
                        $user_state_f = (clone $user_female)->where('age','>=',76)->where('age','<=', 80);
                    }
                    else if($i == 13) {
                        $user_state_m = (clone $user_male)->where('age','>=',81)->where('age','<=', 85);
                        $user_state_f = (clone $user_female)->where('age','>=',81)->where('age','<=', 85);
                    }
                    else if($i == 14) {
                        $user_state_m = (clone $user_male)->where('age','>=',86)->where('age','<=', 90);
                        $user_state_f = (clone $user_female)->where('age','>=',86)->where('age','<=', 90);
                    }
                    else if($i == 15) {
                        $user_state_m = (clone $user_male)->where('age','>=',91)->where('age','<=', 95);
                        $user_state_f = (clone $user_female)->where('age','>=',91)->where('age','<=', 95);
                    }
                    else {
                        $user_state_m = (clone $user_male)->where('age', 0);
                        $user_state_f = (clone $user_female)->where('age',0);
                    }

                    if($i < 17) {
                        $male_state = (clone $user_state_m)->where('user_public.address_state_id', $state->state_id);
                        $female_state = (clone $user_state_f)->where('user_public.address_state_id', $state->state_id);

                        $objPHPExcel->getActiveSheet()->SetCellValue($col_current.(4 + $i), (string) count($male_state));
                        $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) count($female_state));
                    }
                    else {
                        $total_male_state = (clone $user_male)->where('user_public.address_state_id', $state->state_id);
                        $total_female_state = (clone $user_female)->where('user_public.address_state_id', $state->state_id);

                        $objPHPExcel->getActiveSheet()->SetCellValue($col_current.(4 + $i), (string) count($total_male_state));
                        $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) count($total_female_state));
                    }

                    
                }


                    // $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) (count($user_state_m)+count($user_state_f)));
                    // $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) (count($users->get()) > 0 ? number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') : '0.00' ));

                $col++;
            }
            //Total column
            $col_current = $col++;
            $objPHPExcel->getActiveSheet()->mergeCells($col_current.'2:'.$col.'2');
            $objPHPExcel->getActiveSheet()->SetCellValue($col_current.'2', strtoupper(__('new.total')));
            $objPHPExcel->getActiveSheet()->SetCellValue($col_current.'3', strtoupper(__('new.m')));
            $objPHPExcel->getActiveSheet()->SetCellValue($col.'3', strtoupper(__('new.f')));

            for($i=0; $i<=17; $i++) {
                if($i == 0) {
                    $user_state_m = (clone $user_male)->where('age','<=',20);
                    $user_state_f = (clone $user_female)->where('age','<=',20);
                }
                else if($i == 1) {
                    $user_state_m = (clone $user_male)->where('age','>=',21)->where('age','<=', 25);
                    $user_state_f = (clone $user_female)->where('age','>=',21)->where('age','<=', 25);
                }
                else if($i == 2) {
                    $user_state_m = (clone $user_male)->where('age','>=',26)->where('age','<=', 30);
                    $user_state_f = (clone $user_female)->where('age','>=',26)->where('age','<=', 30);
                }
                else if($i == 3) {
                    $user_state_m = (clone $user_male)->where('age','>=',31)->where('age','<=', 35);
                    $user_state_f = (clone $user_female)->where('age','>=',31)->where('age','<=', 35);
                }
                else if($i == 4) {
                    $user_state_m = (clone $user_male)->where('age','>=',36)->where('age','<=', 40);
                    $user_state_f = (clone $user_female)->where('age','>=',36)->where('age','<=', 40);
                }
                else if($i == 5) {
                    $user_state_m = (clone $user_male)->where('age','>=',41)->where('age','<=', 45);
                    $user_state_f = (clone $user_female)->where('age','>=',41)->where('age','<=', 45);
                }
                else if($i == 6) {
                    $user_state_m = (clone $user_male)->where('age','>=',46)->where('age','<=', 50);
                    $user_state_f = (clone $user_female)->where('age','>=',46)->where('age','<=', 50);
                }
                else if($i == 7) {
                    $user_state_m = (clone $user_male)->where('age','>=',51)->where('age','<=', 55);
                    $user_state_f = (clone $user_female)->where('age','>=',51)->where('age','<=', 55);
                }
                else if($i == 8) {
                    $user_state_m = (clone $user_male)->where('age','>=',56)->where('age','<=', 60);
                    $user_state_f = (clone $user_female)->where('age','>=',56)->where('age','<=', 60);
                }
                else if($i == 9) {
                    $user_state_m = (clone $user_male)->where('age','>=',61)->where('age','<=', 65);
                    $user_state_f = (clone $user_female)->where('age','>=',61)->where('age','<=', 65);
                }
                else if($i == 10) {
                    $user_state_m = (clone $user_male)->where('age','>=',66)->where('age','<=', 70);
                    $user_state_f = (clone $user_female)->where('age','>=',66)->where('age','<=', 70);
                }
                else if($i == 11) {
                    $user_state_m = (clone $user_male)->where('age','>=',71)->where('age','<=', 75);
                    $user_state_f = (clone $user_female)->where('age','>=',71)->where('age','<=', 75);
                }
                else if($i == 12) {
                    $user_state_m = (clone $user_male)->where('age','>=',76)->where('age','<=', 80);
                    $user_state_f = (clone $user_female)->where('age','>=',76)->where('age','<=', 80);
                }
                else if($i == 13) {
                    $user_state_m = (clone $user_male)->where('age','>=',81)->where('age','<=', 85);
                    $user_state_f = (clone $user_female)->where('age','>=',81)->where('age','<=', 85);
                }
                else if($i == 14) {
                    $user_state_m = (clone $user_male)->where('age','>=',86)->where('age','<=', 90);
                    $user_state_f = (clone $user_female)->where('age','>=',86)->where('age','<=', 90);
                }
                else if($i == 15) {
                    $user_state_m = (clone $user_male)->where('age','>=',91)->where('age','<=', 95);
                    $user_state_f = (clone $user_female)->where('age','>=',91)->where('age','<=', 95);
                }
                else {
                    $user_state_m = (clone $user_male)->where('age', 0);
                    $user_state_f = (clone $user_female)->where('age',0);
                }

                if($i < 17) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($col_current.(4 + $i), (string) count($user_state_m));
                    $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) count($user_state_f));
                }
                else {
                    $objPHPExcel->getActiveSheet()->SetCellValue($col_current.(4 + $i), (string) count($user_male));
                    $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) count($user_female));
                }

            }

            //Total overall
            $col++;
            $objPHPExcel->getActiveSheet()->mergeCells($col.'2:'.$col.'3');
            $objPHPExcel->getActiveSheet()->SetCellValue($col.'2', strtoupper(__('new.overall')));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(12);

            for($i=0; $i<=17; $i++) {
                if($i == 0) {
                    $user_state_m = (clone $user_male)->where('age','<=',20);
                    $user_state_f = (clone $user_female)->where('age','<=',20);
                }
                else if($i == 1) {
                    $user_state_m = (clone $user_male)->where('age','>=',21)->where('age','<=', 25);
                    $user_state_f = (clone $user_female)->where('age','>=',21)->where('age','<=', 25);
                }
                else if($i == 2) {
                    $user_state_m = (clone $user_male)->where('age','>=',26)->where('age','<=', 30);
                    $user_state_f = (clone $user_female)->where('age','>=',26)->where('age','<=', 30);
                }
                else if($i == 3) {
                    $user_state_m = (clone $user_male)->where('age','>=',31)->where('age','<=', 35);
                    $user_state_f = (clone $user_female)->where('age','>=',31)->where('age','<=', 35);
                }
                else if($i == 4) {
                    $user_state_m = (clone $user_male)->where('age','>=',36)->where('age','<=', 40);
                    $user_state_f = (clone $user_female)->where('age','>=',36)->where('age','<=', 40);
                }
                else if($i == 5) {
                    $user_state_m = (clone $user_male)->where('age','>=',41)->where('age','<=', 45);
                    $user_state_f = (clone $user_female)->where('age','>=',41)->where('age','<=', 45);
                }
                else if($i == 6) {
                    $user_state_m = (clone $user_male)->where('age','>=',46)->where('age','<=', 50);
                    $user_state_f = (clone $user_female)->where('age','>=',46)->where('age','<=', 50);
                }
                else if($i == 7) {
                    $user_state_m = (clone $user_male)->where('age','>=',51)->where('age','<=', 55);
                    $user_state_f = (clone $user_female)->where('age','>=',51)->where('age','<=', 55);
                }
                else if($i == 8) {
                    $user_state_m = (clone $user_male)->where('age','>=',56)->where('age','<=', 60);
                    $user_state_f = (clone $user_female)->where('age','>=',56)->where('age','<=', 60);
                }
                else if($i == 9) {
                    $user_state_m = (clone $user_male)->where('age','>=',61)->where('age','<=', 65);
                    $user_state_f = (clone $user_female)->where('age','>=',61)->where('age','<=', 65);
                }
                else if($i == 10) {
                    $user_state_m = (clone $user_male)->where('age','>=',66)->where('age','<=', 70);
                    $user_state_f = (clone $user_female)->where('age','>=',66)->where('age','<=', 70);
                }
                else if($i == 11) {
                    $user_state_m = (clone $user_male)->where('age','>=',71)->where('age','<=', 75);
                    $user_state_f = (clone $user_female)->where('age','>=',71)->where('age','<=', 75);
                }
                else if($i == 12) {
                    $user_state_m = (clone $user_male)->where('age','>=',76)->where('age','<=', 80);
                    $user_state_f = (clone $user_female)->where('age','>=',76)->where('age','<=', 80);
                }
                else if($i == 13) {
                    $user_state_m = (clone $user_male)->where('age','>=',81)->where('age','<=', 85);
                    $user_state_f = (clone $user_female)->where('age','>=',81)->where('age','<=', 85);
                }
                else if($i == 14) {
                    $user_state_m = (clone $user_male)->where('age','>=',86)->where('age','<=', 90);
                    $user_state_f = (clone $user_female)->where('age','>=',86)->where('age','<=', 90);
                }
                else if($i == 15) {
                    $user_state_m = (clone $user_male)->where('age','>=',91)->where('age','<=', 95);
                    $user_state_f = (clone $user_female)->where('age','>=',91)->where('age','<=', 95);
                }
                else {
                    $user_state_m = (clone $user_male)->where('age', 0);
                    $user_state_f = (clone $user_female)->where('age',0);
                }

                if($i < 17) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) (count($user_state_m)+count($user_state_f)));
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) (count($user_male)+count($user_female)));
                }
            }

            //Total percentage
            $col++;
            $objPHPExcel->getActiveSheet()->mergeCells($col.'2:'.$col.'3');
            $objPHPExcel->getActiveSheet()->SetCellValue($col.'2', strtoupper(__('new.percentage')));
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(12);
            $objPHPExcel->getActiveSheet()->getStyle($col.'4:'.$col.$objPHPExcel->getActiveSheet()->getHighestRow())->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            for($i=0; $i<=17; $i++) {
                if($i == 0) {
                    $user_state_m = (clone $user_male)->where('age','<=',20);
                    $user_state_f = (clone $user_female)->where('age','<=',20);
                }
                else if($i == 1) {
                    $user_state_m = (clone $user_male)->where('age','>=',21)->where('age','<=', 25);
                    $user_state_f = (clone $user_female)->where('age','>=',21)->where('age','<=', 25);
                }
                else if($i == 2) {
                    $user_state_m = (clone $user_male)->where('age','>=',26)->where('age','<=', 30);
                    $user_state_f = (clone $user_female)->where('age','>=',26)->where('age','<=', 30);
                }
                else if($i == 3) {
                    $user_state_m = (clone $user_male)->where('age','>=',31)->where('age','<=', 35);
                    $user_state_f = (clone $user_female)->where('age','>=',31)->where('age','<=', 35);
                }
                else if($i == 4) {
                    $user_state_m = (clone $user_male)->where('age','>=',36)->where('age','<=', 40);
                    $user_state_f = (clone $user_female)->where('age','>=',36)->where('age','<=', 40);
                }
                else if($i == 5) {
                    $user_state_m = (clone $user_male)->where('age','>=',41)->where('age','<=', 45);
                    $user_state_f = (clone $user_female)->where('age','>=',41)->where('age','<=', 45);
                }
                else if($i == 6) {
                    $user_state_m = (clone $user_male)->where('age','>=',46)->where('age','<=', 50);
                    $user_state_f = (clone $user_female)->where('age','>=',46)->where('age','<=', 50);
                }
                else if($i == 7) {
                    $user_state_m = (clone $user_male)->where('age','>=',51)->where('age','<=', 55);
                    $user_state_f = (clone $user_female)->where('age','>=',51)->where('age','<=', 55);
                }
                else if($i == 8) {
                    $user_state_m = (clone $user_male)->where('age','>=',56)->where('age','<=', 60);
                    $user_state_f = (clone $user_female)->where('age','>=',56)->where('age','<=', 60);
                }
                else if($i == 9) {
                    $user_state_m = (clone $user_male)->where('age','>=',61)->where('age','<=', 65);
                    $user_state_f = (clone $user_female)->where('age','>=',61)->where('age','<=', 65);
                }
                else if($i == 10) {
                    $user_state_m = (clone $user_male)->where('age','>=',66)->where('age','<=', 70);
                    $user_state_f = (clone $user_female)->where('age','>=',66)->where('age','<=', 70);
                }
                else if($i == 11) {
                    $user_state_m = (clone $user_male)->where('age','>=',71)->where('age','<=', 75);
                    $user_state_f = (clone $user_female)->where('age','>=',71)->where('age','<=', 75);
                }
                else if($i == 12) {
                    $user_state_m = (clone $user_male)->where('age','>=',76)->where('age','<=', 80);
                    $user_state_f = (clone $user_female)->where('age','>=',76)->where('age','<=', 80);
                }
                else if($i == 13) {
                    $user_state_m = (clone $user_male)->where('age','>=',81)->where('age','<=', 85);
                    $user_state_f = (clone $user_female)->where('age','>=',81)->where('age','<=', 85);
                }
                else if($i == 14) {
                    $user_state_m = (clone $user_male)->where('age','>=',86)->where('age','<=', 90);
                    $user_state_f = (clone $user_female)->where('age','>=',86)->where('age','<=', 90);
                }
                else if($i == 15) {
                    $user_state_m = (clone $user_male)->where('age','>=',91)->where('age','<=', 95);
                    $user_state_f = (clone $user_female)->where('age','>=',91)->where('age','<=', 95);
                }
                else {
                    $user_state_m = (clone $user_male)->where('age', 0);
                    $user_state_f = (clone $user_female)->where('age',0);
                }

                if($i < 17)
                    $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) (count($users->get()) > 0 ? number_format( (count($user_state_m)+count($user_state_f)) / count($users->get())*100, 2,'.','') : '0.00'));
                else
                    $objPHPExcel->getActiveSheet()->SetCellValue($col.(4 + $i), (string) '100.00');
            }

            /////////// Title
            $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$col.'1');
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', strtoupper(__('new.tribunal')).'
'.strtoupper(__('new.profile_claimant_year')).' '.$year.'
'.'( '.strtoupper(__('new.until')).' '.date('d/m/Y').' )');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);


            /////////// Borders
            $objPHPExcel->getActiveSheet()->getStyle(
                'A0:' . 
                $col . 
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objPHPExcel->getActiveSheet()
                ->getStyle('C3:'.$col.$objPHPExcel->getActiveSheet()->getHighestRow())
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!file_exists(storage_path('tmp'))) {
                mkdir(storage_path('tmp'));
            }

            $tmp_file = storage_path('tmp/report22_'.uniqid().'.xlsx');
            $objWriter->save($tmp_file);

            return response()->download($tmp_file)->deleteFileAfterSend(true);
            
        }



    }


}
