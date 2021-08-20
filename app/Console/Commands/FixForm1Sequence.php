<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixForm1Sequence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixform1sequence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix form1 sequence';

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
        for ($i = 1; $i <= 135000; $i += 100) {
            $data = ClaimCase::select([
                'claim_case.form1_id',
                'claim_case.case_no',
                DB::raw("CAST(SUBSTRING_INDEX(`claim_case`.`case_no`,'-',-(1)) AS SIGNED) `cc_case_year`"),
                DB::raw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`claim_case`.`case_no`,'-',-(2)),'-',1) AS SIGNED) `case_sequence`"),
            ])
                ->join('form1', 'claim_case.form1_id', '=', 'form1.form1_id')
                ->whereBetween('claim_case_id', [$i, ($i + 100)])
                ->whereNull('form1.case_year')
                ->orderBy('claim_case_id')
                ->get();

            foreach ($data as $datum) {
                $form1 = Form1::find($datum->form1_id);

                $form1->case_year = $datum->cc_case_year;
                $form1->case_sequence = $datum->case_sequence;
                $form1->save();

                echo '.';
            }
        }

        echo 'end';
    }
}
