<?php

namespace App\Console\Commands;

use App\CaseModel\ClaimCaseOpponent;
use App\PaymentModel\Payment;
use App\UserPublic;
use App\UserPublicCompany;
use Illuminate\Console\Command;

class FixPaymentCcoidPatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tribunal:fixpaymentccoidpatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fix cco payment data data';

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
        for ($i = 1; $i <= 110000; $i += 50) {
            echo 'i: ' . $i . ' - ' . ($i + 50) . PHP_EOL;
            $data = Payment::whereNull('claim_case_opponent_id')
                ->where('form_no', 2)
                ->whereYear('created_at', 2020)
                ->get();

            foreach ($data as $datum) {
                echo $datum.'-';
                if ($datum->created_at->format('Y') == 2020) {
                    $datum->claim_case_opponent_id = $datum->claim_case_id;
                    $datum->claim_case_id = ClaimCaseOpponent::find($datum->claim_case_id)->claim_case_id;
                } else {
                    $datum->claim_case_opponent_id = ClaimCaseOpponent::where('claim_case_id', $datum->claim_case_id)->first()->id;
                }
                $datum->save();
                echo '.';
            }
        }
    }
}
