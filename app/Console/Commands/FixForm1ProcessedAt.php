<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixForm1ProcessedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixform1processedat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix form1 processed at to all ttpm number that not same with form1 processed at data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($i = 0; $i <= 148000; $i += 100) {
            echo 'i: ' . $i . ' - ' . ($i + 100) . PHP_EOL;
            $data = ClaimCase::select([
                'case_no',
                DB::raw('SUBSTR(claim_case.case_no, -4) case_no_year'),
                DB::raw('year(form1.processed_at) processed_at_year'),
                DB::raw('month(form1.processed_at) processed_at_month'),
                'form1.processed_at',
                'payment.paid_at',
                DB::raw('year(payment.paid_at) paid_at_year'),
                DB::raw('month(payment.paid_at) paid_at_month'),
                'form1.form1_id',
            ])
                ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
                ->join('payment', 'payment.payment_id', '=', 'form1.payment_id')
                ->where(function ($q) {
                    $q->where(DB::raw('month(payment.paid_at)'), '!=', DB::raw('month(form1.processed_at)'))
                        ->orWhere(DB::raw('SUBSTR(claim_case.case_no,-4)'), '!=', DB::raw('year(form1.processed_at)'));
                })
                ->whereNotNull('form1.processed_at')
//                ->where(DB::raw('SUBSTR(claim_case.case_no, -4)'), '>=', 2010)
                ->limit(100)
                ->offset($i)
                ->get();


            if ($data) {
                foreach ($data as $datum) {
                    if ($datum->paid_at != '0000-00-00') {
                        if (!in_array($datum->case_no, ['TTPM-J-(P)-454-2017', 'TTPM-WPPJ-(P)-625-2018'])) {  // blacklist
                            if ($datum->case_no_year != $datum->processed_at_year) {
                                echo 'A ' . $datum->case_no . ' - ' . $datum->case_no_year . ' - ' . $datum->processed_at_year . ' - ' . $datum->paid_at_year . PHP_EOL;
                                $form1 = Form1::findOrFail($datum->form1_id);
                                $form1->processed_at = $datum->paid_at . ' 21:00:00';
                                $form1->save();
                                echo '[*]';
                            } else if (
                                ($datum->case_no_year == $datum->processed_at_year)
                                && ($datum->paid_at_year == $datum->processed_at_year)
                                && ($datum->paid_at_month != $datum->processed_at_month)
                                && ($datum->paid_at_month < $datum->processed_at_month)
                            ) {
//                            $form1 = Form1::findOrFail($datum->form1_id);
//                            $form1->processed_at = $datum->paid_at . ' 21:00:00';
//                            $form1->save();
                                echo 'B ' . $datum->paid_at_month . ' - ' . $datum->processed_at_month . PHP_EOL;
                                echo '[*]';
                            } else {
                                echo '[!]';
                            }
                        } else {
                            echo '[B]';
                        }
                    } else {
                        echo '[0]';
                    }
                }
            }
            echo 'END';
        }
    }
}
