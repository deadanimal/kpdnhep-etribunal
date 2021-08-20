<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCaseOpponent;
use App\CaseModel\Form4;
use App\CaseModel\StopNotice;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixMoForm4Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixmoform4data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix multi oppo form4 data';

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
        for ($i = 1; $i <= 131000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $data = Form4::with('case', 'case.multiOpponents')
                ->whereBetween('form4_id', [$i, ($i + 50)])
                ->whereNull('claim_case_opponent_id')
                ->get();

            foreach ($data as $datum) {
                $cmo = ClaimCaseOpponent::where('claim_case_id', $datum->claim_case_id)
                    ->withTrashed()
                    ->first();

                if($cmo) {
                    $datum->claim_case_opponent_id = $cmo->id;
                    $datum->opponent_user_id = $cmo->opponent_user_id;
                    $datum->save();
                    echo '.';
                } else {
                    echo '-'.$i;
                }
            }
        }
    }
}
