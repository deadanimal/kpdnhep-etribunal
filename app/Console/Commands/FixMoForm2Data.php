<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form2;
use App\CaseModel\Form4;
use App\CaseModel\StopNotice;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixMoForm2Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixmoform2data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix multi oppo form2 data';

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
        for ($i = 1; $i <= 35000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $data = Form2::with('form1.case.multiOpponents')
                ->whereBetween('form2_id', [$i, ($i + 50)])
                ->whereNotNull('form1_id')
                ->whereNull('opponent_user_id')
                ->get();

            foreach ($data as $datum) {
                if (isset($datum->form1->case->multiOpponents[0])) {
                    $cmo = ClaimCaseOpponent::where('claim_case_id', $datum->form1->case->claim_case_id)
                        ->where('opponent_user_id', $datum->form1->case->multiOpponents[0]->opponent_user_id)
                        ->first();

                    if ($cmo) {
                        $datum->claim_case_opponent_id = $cmo->id;
                        $datum->opponent_user_id = $cmo->opponent_user_id;
                        $datum->save();
                        echo '.';
                    } else {
                        echo '-';
                    }
                } else {
                    echo 'X';
                }
            }
        }
    }
}
